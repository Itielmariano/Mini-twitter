<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		session_start();
		include_once "../config.php";
		$pega_logado = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nickname` = ?");
		$pega_logado->execute(array($_SESSION['nickname']));
		$logado = $pega_logado->fetchObject();

		$tweet = strip_tags($_POST['tweet']);
		$tweet_sem_link = $tweet;

		$tweet = preg_replace('/\B#([\d\w_]+)/i', '<a href="'.BASE.'/hashtag/$1">$0</a>', $tweet);
		$tweet = preg_replace('/\B@([\d\w_]+)/i', '<a href="'.BASE.'/$1">$0</a>', $tweet);
		$tweet = preg_replace('/\[img\](.*?)\[\/img\]/is', '<a target="_blank" href="$1"><img src="$1" style="width: 100%;" /></a>', $tweet);
		$retorno = array();
		$retorno['user_id'] = $logado->id;
		$retorno['nome'] = $logado->nome;
		$retorno['foto'] = $logado->foto;
		$retorno['tweet'] = $tweet;
		$retorno['date'] = date('d/m/Y H:i');

		//codigo para mensoes de hashtags
		$palavras_tweet = explode(' ', $tweet_sem_link);
		$hashtags = array();
		foreach($palavras_tweet as $in => $palavra){
			if(preg_match('/^#+[a-z0-9_]/i', $palavra)){
				$hashtags[] = $palavra;
			}
		}
		$palavrass_tweet = explode(' ', $tweet_sem_link);
		$hashtagss = array();
		foreach($palavrass_tweet as $in => $palavras){
			if(preg_match('/^@+[a-z0-9_]/i', $palavras)){
				$hashtagss[] = $palavras;
			}
		}
		$contagem_hashtags = count($hashtagss);
		$n_tags = 0;
		if($contagem_hashtags >= 1){
			foreach($hashtagss as $ind => $tag){
				$verifica_tag = $pdo->prepare("SELECT * FROM `marca` WHERE `id_m` = $logado->id, `marca` = ?");
				$verifica_tag->execute(array($tag));

				if($verifica_tag->rowCount() == 1){
					$tag_trending = $verifica_tag->fetchObject();

					$update_mencoes = $pdo->prepare("UPDATE `marca` SET `marca` = ? WHERE `id` = ?");
					if($update_mencoes->execute(array($tag_trending->id))){
					}
				}else{
					$insert_tag = $pdo->prepare("INSERT INTO `marca` SET `id_m` = $logado->id, `marca` = ?");
					if($insert_tag->execute(array($tag))){
					}
				}
			}
		}
		$contagem_hashtags = count($hashtags);
		$n_tags = 0;
		if($contagem_hashtags >= 1){
			foreach($hashtags as $ind => $tag){
				$verifica_tag = $pdo->prepare("SELECT * FROM `hast` WHERE `id_h` = $logado->id, `hashtag` = ?");
				$verifica_tag->execute(array($tag));

				if($verifica_tag->rowCount() == 1){
					$tag_trending = $verifica_tag->fetchObject();

					$update_mencoes = $pdo->prepare("UPDATE `hast` SET `hashtag` = ? WHERE `id` = ?");
					if($update_mencoes->execute(array($tag_trending->id))){
					}
				}else{
					$insert_tag = $pdo->prepare("INSERT INTO `hast` SET `id_h` = $logado->id, `hashtag` = ?");
					if($insert_tag->execute(array($tag))){
					}
				}
			}
		}
		$contagem_hashtags = count($hashtags);
		$n_tags = 0;
		if($contagem_hashtags >= 1){
			foreach($hashtags as $ind => $tag){
				$verifica_tag = $pdo->prepare("SELECT * FROM `trending` WHERE `hashtag` = ?");
				$verifica_tag->execute(array($tag));

				if($verifica_tag->rowCount() == 1){
					$tag_trending = $verifica_tag->fetchObject();

					$novo_valor = $tag_trending->mencoes+1;
					$update_mencoes = $pdo->prepare("UPDATE `trending` SET `mencoes` = ? WHERE `id` = ?");
					if($update_mencoes->execute(array($novo_valor, $tag_trending->id))){
						$n_tags += 1;
					}
				}else{
					$insert_tag = $pdo->prepare("INSERT INTO `trending` SET `hashtag` = ?, `mencoes` = 1");
					if($insert_tag->execute(array($tag))){
						$n_tags += 1;
					}
				}
			}
		}

		if($contagem_hashtags == $n_tags){
			$insert = $pdo->prepare("INSERT INTO `tweets` SET `user_id` = ?, `foto` = ?, `tweet` = ?, `data` = ?, `timestamp` = ?");
			$dados = array($retorno['user_id'], $retorno['foto'], $retorno['tweet'], date('Y-m-d H:i:s'), time());
			if($insert->execute($dados)){
				$retorno['status'] = 'ok';
			}else{
				$retorno['status'] = 'no';
			}
		}

		die(json_encode($retorno));
	}
?>