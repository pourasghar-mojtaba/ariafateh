<meta name="viewport" content="initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="robots" content="index, follow"/>
<title>
	<?php if ($title_for_layout == 'Home') echo SettingHandler::Instance()->siteTitle; else echo $title_for_layout; ?>
</title>

<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-TGRGN2R');</script>
<!-- End Google Tag Manager -->
<?php
if (isset($description_for_layout)) {
	echo "<meta name='description' content='" . $description_for_layout . "' />";
} else
	echo "<meta name='description' content='" . SettingHandler::Instance()->siteDescription . "' />";
if (isset($keywords_for_layout)) {
	echo "<meta name='keywords' content='" . $keywords_for_layout . "' />";
} else
	echo "<meta name='keywords' content='" . SettingHandler::Instance()->siteKeywords . "' />";
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
echo $this->Html->meta('icon');

?>
<meta name="copyright" content="picosite.ir"/>
<meta name="robots" content="index, follow"/>
<meta name="HandheldFriendly" content="true"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
