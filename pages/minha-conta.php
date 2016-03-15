<?php include_once "inc/sidebar.php";?>
<section id="content_wrapper">
	<section id="content">
	<h1 class="title-page">Minha conta</h1>
	<?php
		if(isset($_SESSION['aba'])){
			if($_SESSION['aba'] == 'aba1'){
				$aba1 = 'ativo';
				$aba2 = 'hidden';
				$aba3 = 'hidden';
			}elseif($_SESSION['aba'] == 'aba2'){
				$aba2 = 'ativo';
				$aba1 = 'hidden';
				$aba3 = 'hidden';
			}elseif($_SESSION['aba'] == 'aba3'){
				$aba3 = 'ativo';
				$aba1 = 'hidden';
				$aba2 = 'hidden';
			}
		}else{
			$aba1 = 'ativo';
			$aba2 = 'hidden';
			$aba3 = 'hidden';
		}
	?>
	<span class="button_aba <?php echo $aba1;?>" id="aba1">Meus dados</span>
	<span class="button_aba <?php echo $aba2;?>" id="aba2">Mudar Foto</span>
	<span class="button_aba <?php echo $aba3;?>" id="aba3">Notificações</span>
	

	<div class="aba1 aba edicao_perfil <?php echo $aba1;?>">
		<div class="retorno_cadastro"></div>
		<form action="" method="post" enctype="multipart/form-data">
			<label>
				<span>Nome</span>
				<input class="input-block-level" placeholder=".input-block-level" type="text" name="nome" id="nome" value="<?php echo $logado->nome;?>"/>
			</label>
			<label>
				<span>Email</span>
				<input type="email" required class="input-block-level" placeholder=".input-block-level" name="email" id="email" value="<?php echo $logado->email;?>"/>
			</label>
			<label>
				<span>Nickname</span>
				<input class="input-block-level" placeholder=".input-block-level" type="text" name="nickname" id="nickname" value="<?php echo $logado->nickname;?>"/>
			</label>
			<label>
				<span>Senha</span>
				<input class="input-block-level" placeholder=".input-block-level" type="password" name="senha_cad" id="senha" value="<?php echo $logado->senha;?>"/>
			</label>
			<label>
				<span>Descrição</span>
				<textarea name="descricao" id="descricao" class="desc_limit"><?php echo $logado->descricao;?></textarea>
				<span class="desccount"></span>
			</label>

			<input type="submit" value="Editar" id="editar_perfil" class="btn_submit"/>
		</form>
	</div>
	<div class="aba2 aba <?php echo $aba2;?>">
		<?php
		include_once "config.php";

@mysql_connect("localhost", "u365417210_mini", "1234567i");
@mysql_select_db("u365417210_mini");
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if(isset($_POST['w'])){
					$x = (int)$_POST['x'];
					$y = (int)$_POST['y'];
					$w = (int)$_POST['w'];
					$h = (int)$_POST['h'];
					$img = $_POST['img'];
					
					$crop = crop($img, $x, $y, $w, $h);
					if($crop){
						if($logado->foto != ''){
							unlink('uploads/'.$logado->foto);
							$query = mysql_query("UPDATE usuarios SET `tf` = 1 WHERE `id` = $logado->id") or die(mysql_error());
							$upd_foto = $pdo->prepare("UPDATE `usuarios` SET `foto` = ? WHERE `id` = ?");
							if($upd_foto->execute(array($crop, $logado->id))){
								echo '<div class="aviso green">Imagem cortada com sucesso</div>';
							}
						}else{
							$upd_foto = $pdo->prepare("UPDATE `usuarios` SET `foto` = ? WHERE `id` = ?");
							if($upd_foto->execute(array($crop, $logado->id))){
								echo '<div class="aviso green">Imagem cortada com sucesso</div>';
							}
						}
						unlink('uploads/'.$_SESSION['temp_img']);
						unset($_SESSION['temp_img']);
					}else{
						echo '<div class="aviso yellow">Não foi possível fazer o crop</div>';
						unlink('uploads/'.$_SESSION['temp_img']);
						unset($_SESSION['temp_img']);
					}
				}elseif(isset($_POST['upl_foto'])){
					include_once "inc/lib/WideImage.php";
					$tamanhos = getimagesize($_FILES['foto']['tmp_name']);
					if($tamanhos[0] < 500){
						echo '<div class="aviso yellow">A imagem precisa ter no mínimo 500px de largura!</div>';
					}else{
						$wide = WideImage::load($_FILES['foto']['tmp_name']);
						$resized = $wide->resize(500);
						$resize = $resized->saveToFile("uploads/temp_".$logado->id.".jpg");
						if(is_object($resized)){
							$_SESSION['temp_img'] = 'temp_'.$logado->id.'.jpg';
						}
					}					
				}
			}
		?>

		<?php if(isset($_SESSION['temp_img'])):?>
		<div class="img_crop">
			<img src="<?php echo BASE.'/uploads/'.$_SESSION['temp_img'];?>"  id="target" />
		</div>

		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" id="x" name="x" value="0" class="coord"/>
			<input type="hidden" id="y" name="y" value="0" class="coord"/>
			<input type="hidden" id="w" name="w" value="160" class="coord" />
			<input type="hidden" id="h" name="h" value="160" class="coord"/>
			<input type="hidden" name="img" value="<?php echo BASE;?>/uploads/<?php echo $_SESSION['temp_img'];?>"/>
			<input type="submit" name="crop" value="Cortar Imagem" class="button" />
		</form>
		<?php else:?>
			<form action="" method="post" enctype="multipart/form-data">
				<input type="file" name="foto" />
				<input type="submit" class="button" name="upl_foto" value="Enviar imagem" />
			</form>
		<?php endif;?>
	</div>
	<div class="aba3 aba <?php echo $aba3;?>">
<?php
include_once "config.php";

@mysql_connect("localhost", "u365417210_mini", "1234567i");
@mysql_select_db("u365417210_mini");

    $pegarno=mysql_query("SELECT * FROM noti WHERE id_quem='$logado->id'");
    while($noti=mysql_fetch_array($pegarno)){
?>
<div class="box_sidebarr noti">
	<div class="img_perfill">
		<img src="<?php echo $noti['img'];?>">
	</div>
	<div class="dados_userr"> 
		<span class="nome_perfill"><?php echo $noti['notifica'];?></span>
	</div>
</div>

<?php }?>
	</div>
	</section>
</section>