<?php include_once "inc/sidebar.php";?>
<head>
    <script src="http://code.jquery.com/jquery.js"></script>
</head>
<section id="content_wrapper">
	<section id="content">
	<h1 class="title-page">Site Funções</h1>
	<?php
		if(isset($_SESSION['aba'])){
			if($_SESSION['aba'] == 'aba1'){
				$abaaa1 = 'ativo';
				$abaaa2 = 'hidden';
				$abaaa3 = 'hidden';
			}elseif($_SESSION['aba'] == 'aba2'){
				$abaaa2 = 'ativo';
				$abaaa1 = 'hidden';
				$abaaa3 = 'hidden';
			}elseif($_SESSION['aba'] == 'aba3'){
				$abaaa3 = 'ativo';
				$abaaa1 = 'hidden';
				$abaaa2 = 'hidden';
			}
		}else{
			$abaaa1 = 'ativo';
			$abaaa2 = 'hidden';
			$abaaa3 = 'hidden';
		}
	?>
	<span class="button_aba <?php echo $abaaa1;?>" id="aba1">Tarefas</span>
	<span class="button_aba <?php echo $abaaa2;?>" id="aba2"></span>
	<span class="button_aba <?php echo $abaaa3;?>" id="aba3">Contato</span>
	

	<div class="aba1 aba <?php echo $abaaa1;?>">
	<div class="tarefas">
	<h5>Tarefa Iniciante</h5>
		<?php
		include_once "config.php";

		@mysql_connect("localhost", "u365417210_mini", "1234567i");
		@mysql_select_db("u365417210_mini");

		    $pegarno=mysql_query("SELECT * FROM usuarios WHERE tf='1' AND id='$logado->id'");
		    $noti = (mysql_fetch_array($pegarno))
		?>
		<?php
		    $pegarnoi=mysql_query("SELECT * FROM marca WHERE marca='@TFMEventos' AND id_m='$logado->id' LIMIT 1");
		    $notio = (mysql_fetch_array($pegarnoi))
		?>
		<?php
		    $pegarnooo=mysql_query("SELECT * FROM hast WHERE hashtag='#FazendoTarefa' AND id_h='$logado->id' LIMIT 1");
		    $notiii = (mysql_fetch_array($pegarnooo))
		?>
		<?php
		    $pegarnoo=mysql_query("SELECT * FROM follows WHERE seguidor='$logado->id'");
		    $notii = mysql_num_rows($pegarnoo);
		?>
		<?php
		    $pegarnoooo=mysql_query("SELECT * FROM follows WHERE usuario='$logado->id'");
		    $notiiii = mysql_num_rows($pegarnoooo);
		?>

		<?php if($noti){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block1c.png">
			<a class="t01"><button class="btn btn-success btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t01').popover({title: "<strong>Tarefa 01</strong>", content: "Parabéns você completou <br> a <strong>Tarefa 01</strong>!", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }else{?>
        <div class="bloco">
			<img style="width:100%;" src="img/block1.png">
			<a class="t01f"><button class="btn btn-warning btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t01f').popover({title: "<strong>Tarefa 01</strong>", content: "Atualizar sua foto <br> de <strong>Perfil</strong>! <br> <a href='minha_conta'>Mudar</a>", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }?>

		<?php if($notiii){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block2c.png">
			<a class="t02"><button class="btn btn-success btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t02').popover({title: "<strong>Tarefa 02</strong>", content: "Parabéns você completou <br> a <strong>Tarefa 02</strong>!", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }else if($noti){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block2.png">
			<a class="t02f"><button class="btn btn-warning btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t02f').popover({title: "<strong>Tarefa 02</strong>", content: "Fazer uma Postagem <br> usando <strong>#FazendoTarefa</strong>", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }else{?>
			<div class="bloco">
			<img style="width:100%;" src="img/block0.png">
		</div>
		<?php }?>

		<?php if($notii >= 5){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block4c.png">
			<a class="t04"><button class="btn btn-success btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t04').popover({title: "<strong>Tarefa 04</strong>", content: "Parabéns você completou <br> a <strong>Tarefa 04</strong>!", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }else if($notio){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block4.png">
			<a class="t04f"><button class="btn btn-warning btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t04f').popover({title: "<strong>Tarefa 04</strong>", content: "Seguir mais de <br> <strong>5</strong> pessoas!", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }else{?>
		<div class="bloco">
			<img style="width:100%;" src="img/block0.png">
		</div>
		<?php }?>

		<?php if($notio){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block3c.png">
			<a class="t03"><button class="btn btn-success btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t03').popover({title: "<strong>Tarefa 03</strong>", content: "Parabéns você completou <br> a <strong>Tarefa 03</strong>!", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }else if($notiii){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block3.png">
			<a class="t03f"><button class="btn btn-warning btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t03f').popover({title: "<strong>Tarefa 03</strong>", content: "Fazer uma Postagem <br> usando <strong>@TFM_Eventos</strong>", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }else{?>
		<div class="bloco">
			<img style="width:100%;" src="img/block0.png">
		</div>
		<?php }?>

		<?php if($notiiii >= 5){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block5c.png">
			<a class="t05"><button class="btn btn-success btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t05').popover({title: "<strong>Tarefa 05</strong>", content: "Parabéns você completou <br> a <strong>Tarefa 05</strong>!", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }else if($notii >= 5){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block5.png">
			<a class="t05f"><button class="btn btn-warning btn-md">?</button></a>
		</div>
		<script>
		$(document).ready(function(){
		    $('.t05f').popover({title: "<strong>Tarefa 05</strong>", content: "Ser seguido por mais <br> de <strong>5</strong> pessoas!", html: true, trigger: "hover", placement: "right"}); 
		});
		</script>
		<?php }else if($notii <= 4){?>
		<div class="bloco">
			<img style="width:100%;" src="img/block0.png">
		</div>
		<?php }?>

		<?php if($noti){?>
		<?php if($notiii){?>
		<?php if($notio){?>
		<?php if($notii >= 5){?>
		<?php if($notiiii >= 5){?>
		<div class="bloco">
			<img style="width:100%;" src="img/med1.png">
		</div>
		<?php
		    $query = mysql_query("INSERT INTO medalhas(id_u,img_m,nome_m,desc_m) VALUES ('$logado->id', 'img/med1.png', 'Tarefa Iniciante', 'Completar todas as tarefas da Tarefa Iniciante!')") or die(mysql_error());
		?>
		<?php
		    $query = mysql_query("INSERT INTO noti(id_quem,img,notifica) VALUES ('$logado->id', 'img/med1.png', 'Você ganhou uma nova Medalha!')") or die(mysql_error());
		?>
		<?php }}}}}?>

	</div>
	</div>
	<div class="aba2 aba <?php echo $abaaa2;?>">

	</div>
	<div class="aba3 aba <?php echo $abaaa3;?>">

	</div>
	</section>
</section>