<?php
ob_start("ob_gzhandler");
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		echo $this->element('header_info');
	?>
	<?php

	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
		$params = explode('.', __SITE_URL);

		if(preg_match('/www/', $_SERVER['HTTP_HOST'])){
			//echo 'you got www in your adress';
			$url =  "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		}
		else{
			$url =  "https://www.{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
			//if(!empty($header_canonical)) echo "<link rel='canonical' href='".urldecode($header_canonical)."'>";
		}
		$escaped_url = htmlspecialchars( $url, ENT_COMPAT, 'UTF-8' );
		echo "<link rel='canonical' href='".urldecode($escaped_url)."' />";
	}
	else
	{
		header("Location: https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", true);
	}


	if(isset($open_graph_items)){
		if(!empty($open_graph_items)){

			foreach($open_graph_items as $key=>$value){
				echo "<meta ".$key." content='".$value."'>";
			}
		}
	}
	?>

	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<script>
		_url = '<?php echo __SITE_URL  ?>';
	</script>
</head>

<!-- BEGIN BODY -->
<body >

	<?php
	  echo $this->element('header');
	  echo $this->fetch('content');
	 // echo $this->element('sql_dump');
	  echo $this->Flash->render();
      echo $this->element('footer');   ?>

</body>
<!-- END BODY -->
</html>
