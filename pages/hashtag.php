<?php include_once "inc/sidebar.php";?>
<section id="content_wrapper">
	<?php
		$hashtag = '#'.$explode[1];
	?>
	<h1 class="title-page">Menções a <?php echo $hashtag;?></h1>

	<section id="content">
		<div class="content_tweets">
	<?php
		$twt = $pdo->prepare("SELECT * FROM `tweets` WHERE `tweet` LIKE '%$hashtag%'");
		$twt->execute();

		$pega_mencoes = $pdo->prepare("SELECT * FROM `tweets` WHERE `tweet` LIKE '%$hashtag%' ORDER BY `id` DESC LIMIT 5");
		$pega_mencoes->execute();

		$_SESSION['ids_carregados'] = array();
		while($tweet = $pega_mencoes->fetchObject()){

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
		</article>
	<?php }?>
	</div>
	<?php
	if($twt->rowCount() > 1){
		echo '<a href="#" class="button load_more" id="tweets_hashtag" data-tag="'.$hashtag.'">Carregar Mais</a>';
	}
	?>
	</section>
</section>