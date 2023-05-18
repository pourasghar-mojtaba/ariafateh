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
	
	
	//else echo "no things";
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<script>
	_url = '<?php echo __SITE_URL  ?>';
	</script> 
</head>
		
<!-- BEGIN BODY -->
<body class="home page woocommerce-page">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TGRGN2R"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->	

<div class="boxed-container">
	<?php
	  echo $this->element(__THEME_ELEMENT.'header');  		
	  echo $this->fetch('content');  
	 // echo $this->element('sql_dump');  
	  echo $this->Flash->render();  
      echo $this->element(__THEME_ELEMENT.'footer');   
	  
	   echo $this->Html->css('/js/Zebra_Dialog-master/public/css/zebra_dialog.css');
	   echo $this->Html->script('/js/Zebra_Dialog-master/public/javascript/zebra_dialog');
	   
	  ?>	
</div>	 
</body>
<!-- END BODY -->
</html>