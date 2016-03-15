<?php include_once "inc/sidebar.php";?>
<?php 
	ini_set('default_charset', 'UTF-8');

	function __autoload($classe){
		require 'classes/'.$classe.'.class.php';
	}

	$mysql = new MysqlBase('localhost','u365417210_mini','1234567i','u365417210_mini');
?>
<head>
    <script src="http://code.jquery.com/jquery.js"></script>
</head>
<?php
	$id_post = (int)strip_tags($_GET['per']);
	$str = sprintf("SELECT * FROM `per` WHERE id = '%s'", $id_post);
	$execute = $mysql->execute($str);
	while($linha = $execute->fetchObject()){
?>
<section id="content_wrapper">
	<section id="content">
	<?php
		if(isset($_SESSION['aba'])){
			if($_SESSION['aba'] == 'aba1'){
				$abaa1 = 'ativo';
				$abaa2 = 'hidden';
				$abaa3 = 'hidden';
				$abaa4 = 'hidden';
				$abaa5 = 'hidden';
			}elseif($_SESSION['aba'] == 'aba2'){
				$abaa2 = 'ativo';
				$abaa1 = 'hidden';
				$abaa3 = 'hidden';
				$abaa4 = 'hidden';
				$abaa5 = 'hidden';
			}elseif($_SESSION['aba'] == 'aba3'){
				$abaa3 = 'ativo';
				$abaa1 = 'hidden';
				$abaa2 = 'hidden';
				$abaa4 = 'hidden';
				$abaa5 = 'hidden';
			}
			}elseif($_SESSION['aba'] == 'aba4'){
				$abaa4 = 'ativo';
				$abaa1 = 'hidden';
				$abaa2 = 'hidden';
				$abaa3 = 'hidden';
				$abaa5 = 'hidden';
			}elseif($_SESSION['aba'] == 'aba5'){
				$abaa5 = 'ativo';
				$abaa1 = 'hidden';
				$abaa2 = 'hidden';
				$abaa3 = 'hidden';
				$abaa4 = 'hidden';
		}else{
			$abaa1 = 'ativo';
			$abaa2 = 'hidden';
			$abaa3 = 'hidden';
			$abaa4 = 'hidden';
			$abaa5 = 'hidden';
		}
	?>
	<span class="button_aba <?php echo $abaaa1;?>" id="aba1">Pergunta</span>
	<span class="button_aba <?php echo $abaaa2;?>" id="aba2">Geral</span>
	<span class="button_aba <?php echo $abaaa3;?>" id="aba3">Fazer Pergunta</span>
	<span class="button_aba <?php echo $abaaa4;?>" id="aba4">Criar Enquete</span>
	<span class="button_aba <?php echo $abaaa5;?>" id="aba5">Perguntas Resolvidas</span>
	
    <div class="aba1 aba <?php echo $abaa1;?>">
        <?php
		$pegarppo = $pdo->prepare("SELECT * FROM `per` WHERE `id`='$id_post' AND `id_user` ORDER BY `id`");
		$pegarppo->execute();
		$_SESSION['ids_carregados'] = array();

		while($pegappo = $pegarppo->fetchObject()){
			$user_p = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_p->execute(array($pegappo->id_user));
			$user_dados = $user_p->fetchObject();

			$_SESSION['ids_carregados'][] = $pegappo->id;
		?>
		<div class="pertotal">
		<div class="user_dados">
		    <div class="img_pergun">
			<img src="uploads/<?php echo $user_dados->foto;?>">
			</div>
			<a href="<?php echo BASE.'/'.$user_dados->nickname;?>"><div class="nome_p"><b><?php echo $user_dados->nome;?></b></div></a>
		</div>
		<div class="perguntat">
			<div class="titulo">
			<?php echo $linha->titulo;?>
			</div>
			<div class="verp">
			<?php echo $linha->pergunta;?>
			</div>
		</div>
		</div>
		<br>
		<?php }?>
        <?php
		$pegarppc = $pdo->prepare("SELECT * FROM `coment_p` WHERE `status`='2' AND `id_per`='$id_post' AND `id_u_p` ORDER BY `id`");
		$pegarppc->execute();
		$_SESSION['ids_carregados'] = array();

		while($pegappc = $pegarppc->fetchObject()){
			$user_p = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_p->execute(array($pegappc->id_u_p));
			$user_dados = $user_p->fetchObject();

			$_SESSION['ids_carregados'][] = $pegappc->id;
		?>
		<div class="restotal">
			<div class="user_dadosp">
			    <div class="img_pergunp">
				<img src="uploads/<?php echo $user_dados->foto;?>">
				</div>
				<a href="<?php echo BASE.'/'.$user_dados->nickname;?>"><div class="nome_pp"><b><?php echo $user_dados->nome;?></b></div></a>
			</div>
			<div class="resposta_m">
				<div class="verr">
				<?php echo $pegappc->resposta;?>
				</div>
			</div>
		</div>
		<?php }?>
        <?php
		$pegarppc = $pdo->prepare("SELECT * FROM `coment_p` WHERE `status`='1' AND `id_per`='$id_post' AND `id_u_p` ORDER BY `id`");
		$pegarppc->execute();
		$_SESSION['ids_carregados'] = array();

		while($pegappc = $pegarppc->fetchObject()){
			$user_p = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_p->execute(array($pegappc->id_u_p));
			$user_dados = $user_p->fetchObject();

			$_SESSION['ids_carregados'][] = $pegappc->id;
		?>
		<div class="restotal">
			<div class="user_dadosp">
			    <div class="img_pergunp">
				<img src="uploads/<?php echo $user_dados->foto;?>">
				</div>
				<a href="<?php echo BASE.'/'.$user_dados->nickname;?>"><div class="nome_pp"><b><?php echo $user_dados->nome;?></b></div></a>
			</div>
			<div class="resposta">
				<div class="verr">
				<?php echo $pegappc->resposta;?>
				</div>
			</div>
		</div>
		<?php }?>
		<script>
		$(document).ready(function(){
		    $(".send_resposta").click(function(){
		        $(this).button("loading").delay(3000).queue(function(){
		            $(this).button("reset");
		            $(this).dequeue();
		        }); 
		    });   
		});
		</script>
		<section id="contentt_wrapper">
		<div class="restotal">
			<div class="user_dadosp">
			    <div class="img_pergunp">
				<img src="uploads/<?php echo $logado->foto;?>">
				</div>
				<a href="<?php echo BASE.'/'.$user_dados->nickname;?>"><div class="nome_pp"><b><?php echo $user_dados->nome;?></b></div></a>
			</div>
			<div class="resposta_f">
				<div class="verrf">
					<section id="envio_resposta">
							<form action="" class="perguntar" id="perguntar" method="post" enctype="multipart/form-data">
								<label>
								    <span class="title">Ajudar com uma Resposta</span>
									<textarea name="resposta" class="msg"></textarea>
									<input type="hidden" id="id_per" name="id_per" value="<?php echo $id_post;">"?>">
									<span class="counter">140 restantes</span>
									<button class="send_resposta" data-loading-text="Enviando...">Enviar</button>
									<br>
								</label>
							</form>
					</section>
				</div>
			</div>
		</div>
		</section>
	</div>

	<div class="aba2 aba <?php echo $abaa2;?>">
	    <center><h1 class="title-page">Perguntas & Respostas</h1></center>
        <br><br><br>
        <?php
		include_once "config.php";

		@mysql_connect("localhost", "u365417210_mini", "1234567i");
		@mysql_select_db("u365417210_mini");

		$pegarp = $pdo->prepare("SELECT * FROM `per` WHERE `status`='1' AND `id_user` ORDER BY `id` DESC");
		$pegarp->execute();
		$_SESSION['ids_carregados'] = array();

		while($pegap = $pegarp->fetchObject()){
			$user_p = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_p->execute(array($pegap->id_user));
			$user_dados = $user_p->fetchObject();

			$_SESSION['ids_carregados'][] = $pegap->id;
		?>
		<a href="perguntasver?per=<?php echo $pegapp->id;?>" class="topico_p_a">
		<div class="topico_p">
			<div class="img_t"><img src="uploads/<?php echo $user_dados->foto;?>"></div>
			<div class="pergunta">
			<?php echo $pegap->titulo;?>
			</div>
			<div class="status_p">
			Pergunta feita por <b><?php echo $user_dados->nome;?></b> em <?php echo date('d/m/Y', strtotime($pegap->data));?> ás <?php echo date('H:i', strtotime($pegap->data));?>
		    </div>
		</div>
		</a>
        <?php }
		$pegarpp = $pdo->prepare("SELECT * FROM `per` WHERE `status`='2' AND `id_user` ORDER BY `id` DESC");
		$pegarpp->execute();
		$_SESSION['ids_carregados'] = array();

		while($pegapp = $pegarpp->fetchObject()){
			$user_p = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_p->execute(array($pegapp->id_user));
			$user_dados = $user_p->fetchObject();

			$_SESSION['ids_carregados'][] = $pegapp->id;
		?>
		<a href="perguntasver?per=<?php echo $pegapp->id;?>" class="topico_p_a">
		<div class="topico_p_c">
			<div class="img_t"><img src="uploads/<?php echo $user_dados->foto;?>"></div>
			<div class="pergunta">
			<?php echo $pegapp->titulo;?>
			</div>
			<div class="status_p">
			Pergunta feita por <b><?php echo $user_dados->nome;?></b> em <?php echo date('d/m/Y', strtotime($pegapp->data));?> ás <?php echo date('H:i', strtotime($pegapp->data));?>
		    </div>
		</div>
		</a>
        <?php }
		$pegarppp = $pdo->prepare("SELECT * FROM `per` WHERE `status`='3' AND `id_user` ORDER BY `id` DESC");
		$pegarppp->execute();
		$_SESSION['ids_carregados'] = array();

		while($pegappp = $pegarppp->fetchObject()){
			$user_p = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_p->execute(array($pegappp->id_user));
			$user_dados = $user_p->fetchObject();

			$_SESSION['ids_carregados'][] = $pegappp->id;
		?>
		<a href="#" class="topico_p_a">
		<div class="topico_p_b">
			<div class="img_t"><img src="uploads/<?php echo $user_dados->foto;?>"></div>
			<div class="pergunta">
			<?php echo $pegappp->titulo;?>
			</div>
			<div class="status_p">
			Pergunta feita por <b><?php echo $user_dados->nome;?></b> em <?php echo date('d/m/Y', strtotime($pegappp->data));?> ás <?php echo date('H:i', strtotime($pegappp->data));?>
		    </div>
		</div>
		</a>
		<?php }?>
	</div>
    <div class="aba3 aba <?php echo $abaa3;?>">
    <center><h1 class="title-page">Fazer Perguntas</h1></center>
	<a href="#"><div class="botao_f">Fazer Pergunta</div></a>
    </div>
	<div class="aba4 aba <?php echo $abaa4;?>">
	<center><h1 class="title-page">Criar Enquetes</h1></center>
	<a href="#"><div class="botao_c">Criar Enquete</div></a>
	</div>
	<div class="aba5 aba <?php echo $abaa5;?>">
    <center><h1 class="title-page">Perguntas Resolvidas</h1></center>
    <br><br><br>
        <?php
		include_once "config.php";

		@mysql_connect("localhost", "u365417210_mini", "1234567i");
		@mysql_select_db("u365417210_mini");

		$pegarp = $pdo->prepare("SELECT * FROM `per` WHERE `status`='2' AND `id_user` ORDER BY `id` DESC");
		$pegarp->execute();
		$_SESSION['ids_carregados'] = array();

		while($pegap = $pegarp->fetchObject()){
			$user_p = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_p->execute(array($pegap->id_user));
			$user_dados = $user_p->fetchObject();

			$_SESSION['ids_carregados'][] = $pegap->id;
		?>
		<a href="#" class="topico_p_a">
		<div class="topico_p_c">
			<div class="img_t"><img src="uploads/<?php echo $user_dados->foto;?>"></div>
			<div class="pergunta">
			<?php echo $pegap->titulo;?>
			</div>
			<div class="status_p">
			Pergunta feita por <b><?php echo $user_dados->nome;?></b> em <?php echo date('d/m/Y', strtotime($pegap->data));?> ás <?php echo date('H:i', strtotime($pegap->data));?>
		    </div>
		</div>
		</a>
        <?php }?>
	</div>
	</section>
</section>
<?php }?>