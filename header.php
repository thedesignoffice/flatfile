<?php global $options; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php bloginfo('name'); ?><?php wp_title( '/' ); ?></title>
<meta name="description" content="<?php bloginfo('description'); ?>">
<link rel="shortcut icon" href="<?php bloginfo( 'stylesheet_directory' ); ?>/favicon.ico" />

<?php wp_head(); ?>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo( 'rss_url' ); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo( 'atom_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/lib/css/reset.css">
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>">

<style type="text/css">
	
	a:hover,
	#nav li a,
	#nav li a:hover,
	#header h1,
	#header h1 a,
	h4, h5,
	#header h2 a:hover,
	#header h2 a:visited:hover,
	#header .menu a:hover,
	#header .menu a:visited:hover,
	#rollover-nav h1,
	#rollover-nav h1 a,
	#rollover-nav a:hover,
	#header #latest .latest-post a,
	.local li a,
	.article h4,
	.article h4 a,
	#caption strong,
	#content-text strong,
	#footer a,
	.tooltip-label,
	#controls .logged-in a,
	#controls li a:hover,
	.sidebar .widgettitle,
	.article-controls a:hover,
	.article h5.marketing,
	.article h6 {
		color: <?= $options['spotcolor'] ?>;
	}
	a:hover,
	#nav li a:hover,
	#footer a:hover,
	#header #latest .latest-post a:hover,
	.description a.highlight:hover {
		border-bottom: 1px solid <?= $options['spotcolor'] ?>;
	}
	.thumbnail a:hover img,
	#caption a img:hover,
	.local li a:hover,
	.excerpt:hover {
		border: 1px solid <?= $options['spotcolor'] ?>;
	}
	#caption del,
	#content-text del,
	.tooltip-system {
		background-color: <?= $options['spotcolor'] ?>;
	}

</style>
<style type="text/css">
.addthis_toolbox .custom_images a
{
    width: 60px;
    height: 60px;
    margin: 0;
    padding: 0;
}

.addthis_toolbox .custom_images a:hover img
{
    opacity: 1;
}

.addthis_toolbox .custom_images a img
{
    opacity: 0.75;
}
</style>

<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/lib/js/hoverintent.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/lib/js/tools.js"></script> 
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/lib/js/main.js"></script>
<script type="text/javascript">
	var addthis_config = {
		ui_header_color: "<?php echo $options['spotcolor']; ?>"
	}
</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>

<?php if( $options['analytics'] ) { ?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $options['analytics']; ?>']);
		_gaq.push(['_trackPageview']);
		
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
<?php } ?>

</head>

<body <?php body_class(); ?>>
<div id="wrapper">
<div id="header">
	<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
	<?php get_template_part( 'nav' ); ?>