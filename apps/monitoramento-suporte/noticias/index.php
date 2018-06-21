<?php
// Include the SimplePie library
// For 1.0-1.2:
#require_once('simplepie.inc');
// For 1.3+:
require_once('autoloader.php');
 
// Create a new SimplePie object
$feed = new SimplePie();
$feed->item_limit = 5;
 
// Instead of only passing in one feed url, we'll pass in an array of three
$feed->set_feed_url(array(
	'http://g1.globo.com/dynamo/tecnologia/rss2.xml',
	'http://www.baixaki.com.br/rss/tecnologia.xml',
	'http://feeds.feedburner.com/Plantao-INFO?format=xml',
	'http://feeds.feedburner.com/NoticiasINFO?format=xml',
	'http://feeds.feedburner.com/colunatecnosfera?format=xml',
	'http://tecnologia.uol.com.br/ultnot/index.xml'
));
 
// Initialize the feed object
$feed->init();
 
// This will work if all of the feeds accept the same settings.
$feed->handle_content_type();
header('Content-type:text/html; charset=utf-8');
 
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="simplepie.css" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="sIFR-screen.css" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" charset="utf-8" />
	<title>Notícias GEINF</title>
</head>
	
</head>

<body>

<div id="container">
	<div id="site">
		
		<ul id="widget">
			<?php foreach($feed->get_items(0, 15) as $item) : ?>
			<li>
				<div class="chunk">
					<?php /* Here, we'll use the $item->get_feed() method to gain access to the parent feed-level data for the specified item. */ ?>
					<h4 class="title" style="background-image:url('favicon.ico');"><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h4>
					<?php  if($item->get_content()) { 
						$content = preg_replace("/<img[^>]+\>/i", "",  $item->get_content());
						$content = preg_replace('/<p\b[^>]*>(.*?)<\/p>/i', '', $content);
						$content = strip_tags($content);
					?>
						<p class="subtitulo"><?php echo $content; ?></p>
					<?php  } ?>
					<p class="footnote">Fonte: <a href="<?php $feed = $item->get_feed(); echo $feed->get_permalink(); ?>"><?php $feed = $item->get_feed(); echo $feed->get_title(); ?></a> | <?php echo $item->get_date('j M Y | g:i a'); ?></p>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div><!--end container-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="js/scroller.js"></script>

<script type="text/javascript">
	$('#widget').newsScroll({
		speed: 2000,
		delay: 5000
	});
	
	// or just call it like:
	// $('#widget').newsScroll();
</script>

</body>
</html>
