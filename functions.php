<?php

register_sidebar();

function edit_admin_menus() {  
    global $menu;  
    global $submenu;  
      
    remove_menu_page('link-manager.php'); // Remove the Links Menu  
    remove_menu_page('edit-comments.php'); // Remove the Links Menu  
}  
add_action( 'admin_menu', 'edit_admin_menus' );  



/* Add support for JQuery
---------------------------------------------- */
function add_jquery() {
	wp_enqueue_script( 'jquery' );
}
add_action( 'init', 'add_jquery' );

/* Register nav menus
---------------------------------------------- */
register_nav_menu( 'main', 'Main Navigation' );
register_nav_menu( 'footer', 'Footer Navigation' );

/* Set image category thumbnail sizes
---------------------------------------------- */
add_theme_support( 'post-thumbnails', array( 'post' ));
set_post_thumbnail_size( 1024, 300, false );

/* Register Flatfile options page
---------------------------------------------- */
function flatfile_menu()
{
	// Register page
	add_theme_page(
		'Flatfile Options',
		'Flatfile Options',
		'edit_theme_options',
		__FILE__,
		'flatfile_options_page'
	);
	register_setting(
		'flatfile_options',
		'flatfile_options'
	);
	
	// Set defaults
	$options = array(
		'spotcolor' => '#123456',
		'featured' => -1,
		'category_types' => array( ),
		'latest_posts' => 3,
		'analytics' => ''
	);
	add_option('flatfile_options', $options, '', 'yes');
}
add_action('admin_menu', 'flatfile_menu');

/* Build Flatfile options page
---------------------------------------------- */
function flatfile_options_page() {
	
	/* Include Farbtastic
	---------------------------------------------- */		
	echo '<script type="text/javascript" src="'
	    . get_bloginfo( 'stylesheet_directory' )
	    . '/lib/farbtastic/farbtastic.js"></script>';
	echo '<script type="text/javascript">'
	   . 'jQuery(document).ready(function() {'
	   . 'jQuery("#colorpicker").farbtastic("#spotcolor");'
	   . '});'
	   . '</script>';
	
	/* Build page structure
	---------------------------------------------- */		
	echo '<div class="wrap">'
	   . '<h2>Flatfile Options</h2>'
	   . '<form method="post" action="options.php">'
	   . '<table class="form-table">';

	/* Get current options
	---------------------------------------------- */		
	settings_fields('flatfile_options');
	$options = get_option('flatfile_options');
	
	/* Display sample typography
	---------------------------------------------- */
	// coming soon
	
	/* Spot color
	---------------------------------------------- */	
	echo '<tr>'
	   . '<th scope="row">Spot Color</th>'
   	   . '<td>';
	echo '<label>Choose a color:</label><br />'
	   . '<input type="text" id="spotcolor" name="flatfile_options[spotcolor]" value="' . $options['spotcolor'] . '" />'
	   . '<div id="colorpicker"></div>';
	echo '</td></tr>';
	
	/* Generate favicon
	---------------------------------------------- */
	// coming soon
			
	/* Featured image
	---------------------------------------------- */
	echo '<tr>'
	   . '<th scope="row">Featured Image</th>'
	   . '<td>';
	echo '<label>Choose an image to appear on the homepage.</label><br />'
	   . '<select name="flatfile_options[featured]">';
	   	   
	// loop through all posts that have a featured image
	query_posts(array(
		'posts_per_page' => -1
	));
	while( have_posts() ) : the_post();
		$post_id = get_the_ID();
		if( has_post_thumbnail() ) {
			echo '<option value="'
				 . $post_id . '" '
				 . selected( $post_id, $options['featured'] ) 
				 . '>';
			the_title();
			echo '</option>';
		}
	endwhile;
 	echo '</select>';
	echo '</td></tr>';
	
	/* Category options
	---------------------------------------------- */
	echo '<tr>'
	   . '<th scope="row">Categories</th>'
	   . '<td>';

	// loop through top level categories
	$categories = get_categories(array(
		'title_li' => '',
		'orderby' => 'count'
	));
	foreach( $categories as $category ) {
		if( $category->parent == 0 ) {
		
			// set defaults to image
			if( !array_key_exists( $category->cat_ID, $options['category_types'] )) {
				$options['category_types'][ $category->cat_ID ] = 'image'; // set the default category type to image
			}
			
			// create an entry for each top-level category
			echo '<span style="display: block; float: left; min-width: 110px;">' . $category->name . '</span> ';
			echo '<input type="radio"'
				 . ' name="flatfile_options[category_types][' . $category->cat_ID . ']" '
				 . 'value="image" ';
			checked( 'image', $options[ 'category_types' ][ $category->cat_ID ] );
			echo '> Image ';
			echo '<input type="radio"'
				 . ' name="flatfile_options[category_types][' . $category->cat_ID . ']" '
				 . 'value="text" ';
			checked( 'text', $options[ 'category_types' ][ $category->cat_ID ] );
			echo '> Text<br>';
		}
	}
	echo '</td></tr>';

	/* Latest posts
	---------------------------------------------- */
	echo '<tr>'
	   . '<th scope="row">Latest</th>'
	   . '<td>';
	echo '<label>On the homepage, show ';
	echo '<select name="flatfile_options[latest_posts]">';
	echo '<option ' . selected('0', $options['latest_posts']) . 'value="0">no recent posts</option>';
	echo '<option ' . selected('1', $options['latest_posts']) . 'value="1">the most recent post</option>';
	echo '<option ' . selected('2', $options['latest_posts']) . 'value="2">the 2 most recent posts</option>';
	echo '<option ' . selected('3', $options['latest_posts']) . 'value="3">the 3 most recent posts</option>';
	echo '<option ' . selected('4', $options['latest_posts']) . 'value="4">the 4 most recent posts</option>';
	echo '</select>';
	echo ' from Text categories.</label>';
	echo '</td></tr>';
	
	/* Fonts
	---------------------------------------------- */
	// coming soon	
	
	/* Google Analytics
	---------------------------------------------- */
	echo '<tr>'
	   . '<th scope="row">Google Analytics</th>'
	   . '<td>';
	echo '<label>Copy and paste your tracking code (UA-XXXXX-X):</label><br />'
	   . '<input type="text" name="flatfile_options[analytics]" value="' . $options['analytics'] . '" />';
	echo '</td></tr>';
	
	/* Complete page
	---------------------------------------------- */
	echo '</table>';
	echo '<p class="submit"><input type="submit" class="button-primary" value="Save Changes"></p>';
	echo '</form></div>';
}

/* Add Farbastic css for colorpicker to admin <head>
---------------------------------------------- */
function add_farbtastic_css() {
    echo '<link rel="stylesheet" type="text/css" href="'
       . get_bloginfo( 'stylesheet_directory' )
       . '/lib/farbtastic/farbtastic.css">';
}
add_action('admin_head', 'add_farbtastic_css');

/* Create filtered text/image category arrays
---------------------------------------------- */
$options = get_option('flatfile_options');
$categories = get_categories( array() );
$text_categories = array();
$image_categories = array();

// loop through top level categories
foreach( $categories as $category ) {
	if( $category->category_parent == 0 ) {
		if( $options[ 'category_types' ][ $category->cat_ID ] == 'text' ) {
			$text_categories[] = $category->cat_ID;
		} else {
			$image_categories[] = $category->cat_ID;
		}
	}
}

/* Replace pictogram shortcodes
---------------------------------------------- */
function insert_pictogram( $atts ) {

	extract( shortcode_atts( array(
		'icon' => 'default',
		'size' => 'medium',
	), $atts ));

	$character = '_';
	if( $icon == 'camera' )    	{ $character = 'A'; }
	if( $icon == 'book' )      	{ $character = 'B'; }
	if( $icon == 'cd' )        	{ $character = 'C'; }
	if( $icon == 'download' )  	{ $character = 'D'; }
	if( $icon == 'browse' )    	{ $character = 'E'; }
	if( $icon == 'facebook' )  	{ $character = 'F'; }
	if( $icon == 'super8' )    	{ $character = 'H'; }
	if( $icon == 'cart' )      	{ $character = 'I'; }
	if( $icon == 'tag' )       	{ $character = 'J'; }
	if( $icon == 'document' )  	{ $character = 'K'; }
	if( $icon == 'dislike' )   	{ $character = 'L'; }
	if( $icon == 'play' )      	{ $character = 'P'; }
	if( $icon == 'slideshow' ) 	{ $character = 'S'; }
	if( $icon == 'twitter' )   	{ $character = 'T'; }
	if( $icon == 'write' )     	{ $character = 'V'; }
	if( $icon == 'window' )    	{ $character = 'W'; }
	if( $icon == 'text' )      	{ $character = 'Z'; }
	if( $icon == 'images' )    	{ $character = '\\'; }
	if( $icon == 'rss' )       	{ $character = '^'; }
	if( $icon == 'comment' )   	{ $character = 'b'; }
	if( $icon == 'print' )     	{ $character = 'd'; }
	if( $icon == 'video' )     	{ $character = 'h'; }
	if( $icon == 'shop' )      	{ $character = 'i'; }
	if( $icon == 'favorite' )  	{ $character = 'j'; }
	if( $icon == 'like' )      	{ $character = 'l'; }
	if( $icon == 'email' )     	{ $character = 'm'; }
	if( $icon == 'lock' )      	{ $character = 'n'; }
	if( $icon == 'unlock' )    	{ $character = 'q'; }
	if( $icon == 'share' )     	{ $character = 'o'; }
	if( $icon == 'home' )      	{ $character = 'p'; }
	if( $icon == 'draw' )      	{ $character = 'r'; }
	if( $icon == 'search' )    	{ $character = 's'; }
	if( $icon == 'fullscreen' )	{ $character = 'v'; }
	if( $icon == 'separator' ) 	{ $character = '|'; }
	if( $icon == 'help' )      	{ $character = '?'; }

	$class = 'medium';
	if( $size == 'small' || $size == 'large' ) { $class = $size; }

	return wptexturize( '<span class="flatfile-normal ' . $size . '">' . $character . '</span>' );
}
add_shortcode( 'pictogram', 'insert_pictogram' );

/* Replace search field shortcodes
---------------------------------------------- */
function insert_search_field( $atts ) {

	extract(shortcode_atts(array(
	), $atts));
	
	$search_field = '<form id="search_form" role="search" method="get" action="' . home_url( '/' ) . '">'
				  . '<input type="text" value="" name="s" id="s">'
				  . ' <a class="flatfile-normal large" href="javascript:{}"'
				  . ' onclick="document.getElementById(\'search_form\').submit(); return false;">s</a>'
				  . '</form>';

	return wptexturize( $search_field );	
}
add_shortcode( 'search', 'insert_search_field' );

/* Replace gallery shortcode
   Modified version of the Wordpress gallery_shortcode function in wp-includes/media.php
---------------------------------------------- */
function ff_gallery( $attr ) {
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	/* Rewritten $output below
	   See http://wpengineer.com/1802/a-solution-for-the-wordpress-gallery/
	   –A
	*/
	$output = apply_filters( 'gallery_style', "
		<div id='$selector' class='gallery galleryid-{$id}'>" );
		
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		
		/* generate a linked image
		   make it to a large, instead of full image
		   and make both file/post galleries link to the image file */

		$image_thumbnail = wp_get_attachment_image_src($id, 'thumbnail', false, false); 
		$image_file =      wp_get_attachment_image_src($id, 'large', false, false);
		$link = "<a href='{$image_file[0]}'><img src='{$image_thumbnail[0]}'></a>";
				
		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br />';
	}
	$output .= "</div>\n";
	
	return $output;
}
add_shortcode( 'gallery', 'ff_gallery' );

/* Restyle the visual editor
---------------------------------------------- */
add_filter('mce_css', 'my_editor_style');
function my_editor_style( $url ) {

  if ( !empty($url) )
    $url .= ',';

  // Change the path here if using sub-directory
  $url .= trailingslashit( get_stylesheet_directory_uri() ) . 'lib/css/editor.css';

  return $url;
}

?>