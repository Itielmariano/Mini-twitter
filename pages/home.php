<?php include_once "inc/sidebar.php";?>
<head>
    <script src="http://code.jquery.com/jquery.js"></script>
</head>
<script>
$(document).ready(function(){
    $(".send_message").click(function(){
        $(this).button("loading").delay(3000).queue(function(){
            $(this).button("reset");
            $(this).dequeue();
        }); 
    });   
});
</script>
<section id="content_wrapper">
	<section id="envio_mensagem">
		<form action="" method="post" enctype="multipart/form-data">
			<label>
				<span class="title">Digite uma mensagem</span>
				<textarea name="mensagem" class="msg"></textarea>
				<span class="counter"></span>
				<button class="send_message" data-loading-text="Enviando...">Enviar</button>
			</label>
		</form>
	</section>

	<section id="content">
		<div class="content_tweets">
	<?php
		//pego as pessoas que estou seguindo
		$pega_follows = $pdo->prepare("SELECT * FROM `follows` WHERE `seguidor` = ?");
		$pega_follows->execute(array($logado->id));

		$ids_seguindo = array($logado->id);
		while($usr = $pega_follows->fetchObject()){
			$ids_seguindo[] = $usr->usuario;
		}
		$str_seguindo = implode(', ', $ids_seguindo);
		$twt = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` IN ($str_seguindo) ORDER BY `id` DESC");
		$twt->execute();

		$tweets = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` IN ($str_seguindo) ORDER BY `id` DESC LIMIT 4");
		$tweets->execute();
		$_SESSION['ids_carregados'] = array();

		while($tweet = $tweets->fetchObject()){
			$user_tweet = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_tweet->execute(array($tweet->user_id));
			$user_dados = $user_tweet->fetchObject();

			$_SESSION['ids_carregados'][] = $tweet->id;
	?>
		<article class="tweet">
		<img style="float: left; width: 50px; border-radius: 5px;" src="<?php echo BASE.'/uploads/'.$user_dados->foto;?>">
			<span class="nome">
				<a href="<?php echo BASE.'/'.$user_dados->nickname;?>"><?php echo $user_dados->nome;?></a> disse:
			</span>
			<span class="date"><?php echo date('d/m/Y H:i', strtotime($tweet->data));?></span>
			<p><?php echo $tweet->tweet;?></p>
			  <button type="button" class="btn btn-inverse btn-lg btn-mini" id="myBtn<?php echo $tweet->id;?>">Comentar</button>

			  <!-- Modal -->
			  <div class="modal fade" id="myModal<?php echo $tweet->id;?>" role="dialog">
			    <div class="modal-dialog">
			    
			      <!-- Modal content-->
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title"><?php echo $user_dados->nome;?></h4>
			        </div>
			        <div class="modal-body">
			          <p><?php echo $tweet->tweet;?></p>
			        </div>
			        <div class="modal-footer">
					<?php
					include_once "config.php";

					@mysql_connect("localhost", "u365417210_mini", "1234567i");
					@mysql_select_db("u365417210_mini");

					    $result = mysql_query("SELECT * FROM comentarios WHERE id_quemc='$logado->id'");
						while($row = mysql_fetch_array($result)){
					?>
					<div class="media">
					  <a class="pull-left" href="#">
					    <img class="media-object" data-src="holder.js/64x64">
					  </a>
					  <div class="media-body">
					    <h4 class="media-heading">Iti</h4>
					    <?php echo $row['comenentario'];?>ff
					  </div>
					</div>
					<?php };?>
			        </div>
			      </div>
			      
			    </div>
			  </div>

			<script>
			$(document).ready(function(){
			    $("#myBtn<?php echo $tweet->id;?>").click(function(){
			        $("#myModal<?php echo $tweet->id;?>").modal();
			    });
			});
			</script>
		</article>
	<?php }?>
	</div>
	<?php
	if($twt->rowCount() > 4){
		echo '<a href="#" class="button load_more" id="tweets_home">Carregar Mais</a>';
	}
	?>
	</section>
</section>