<?php include_once "inc/sidebar.php";?>
<head>
    <script src="http://code.jquery.com/jquery.js"></script>
</head>
<section id="content_wrapper">
	<section id="content">
	<?php
		if(isset($_SESSION['aba'])){
			if($_SESSION['aba'] == 'aba1'){
				$abaaaa1 = 'ativo';
				$abaaaa2 = 'hidden';
				$abaaaa3 = 'hidden';
				$abaaaa4 = 'hidden';
			}elseif($_SESSION['aba'] == 'aba2'){
				$abaaaa2 = 'ativo';
				$abaaaa1 = 'hidden';
				$abaaaa3 = 'hidden';
				$abaaaa4 = 'hidden';
			}elseif($_SESSION['aba'] == 'aba3'){
				$abaaaa3 = 'ativo';
				$abaaaa1 = 'hidden';
				$abaaaa2 = 'hidden';
				$abaaaa4 = 'hidden';
			}
			}elseif($_SESSION['aba'] == 'aba4'){
				$abaaaa4 = 'ativo';
				$abaaaa1 = 'hidden';
				$abaaaa2 = 'hidden';
				$abaaaa3 = 'hidden';
		}else{
			$abaaaa1 = 'ativo';
			$abaaaa2 = 'hidden';
			$abaaaa3 = 'hidden';
			$abaaaa4 = 'hidden';
		}
	?>
	<span class="button_aba <?php echo $abaaaa1;?>" id="aba1">Geral</span>
	<span class="button_aba <?php echo $abaaaa2;?>" id="aba2">Fazer Pergunta</span>
	<span class="button_aba <?php echo $abaaaa3;?>" id="aba3">Criar Enquete</span>
	<span class="button_aba <?php echo $abaaaa4;?>" id="aba4">Perguntas Resolvidas</span>
	

	<div class="aba1 aba <?php echo $abaaaa1;?>">
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
		<a href="#" class="topico_p_a">
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
    <div class="aba2 aba <?php echo $abaaaa2;?>">
    <center><h1 class="title-page">Fazer Perguntas</h1></center>
	<a href="#"><div class="botao_f">Fazer Pergunta</div></a>
    </div>
	<div class="aba3 aba <?php echo $abaaaa3;?>">
	<center><h1 class="title-page">Criar Enquetes</h1></center>
	<a href="#"><div class="botao_c">Criar Enquete</div></a>
	</div>
	<div class="aba4 aba <?php echo $abaaaa4;?>">
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