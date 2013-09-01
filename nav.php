<?php 
	global $options;
	global $image_categories;
	global $text_categories;
?>

<div id="dim"></div>

<?php
	function do_nav_default() {
		
		global $image_categories;
		global $text_categories;
	
		/* list out image categories in descending order of post count */
		if( !empty( $image_categories )) {
			$categories = wp_list_categories( array(
				'title_li' => '',
				'orderby' => 'count',
				'order' => 'DESC',
				'hide_empty' => 0,
				'include' => implode( ',', $image_categories ),
				'echo' => 0
			));
			echo str_replace( array( "\n", "\r" ), '', $categories );
		}
		/* list out text categories in descending order of post count */
		if( !empty( $text_categories )) {
			$categories = wp_list_categories( array(
				'title_li' => '',
				'orderby' => 'count',
				'order' => 'DESC',
				'hide_empty' => 0,
				'include' => implode( ',', $text_categories ),
				'echo' => 0
			));
			echo str_replace( array( "\n", "\r" ), '', $categories );
		}
	}
?>

<?php if( is_front_page() ) { ?>
	
	<?php if( has_nav_menu( 'main') ) { ?>
		
		<?php 
			wp_nav_menu(array( 
				'theme_location' => 'main',
				'container' => ''
			));
		?>
	
	<?php } else { ?>

		<ul class="menu">
			<?php do_nav_default(); ?>
		</ul>
		
	<?php } ?>

<?php } ?>
	
	<?php if( has_nav_menu( 'main' ) ) { ?>

		<div id="rollover-nav">
			<div id="underlay">
				<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
				<?php 
					wp_nav_menu(array( 
						'theme_location' => 'main',
						'container' => ''
					));
				?>
			</div>
			<div>
				<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
				<?php
					wp_nav_menu(array( 
						'theme_location' => 'main',
						'container' => ''
					));
				?>
			</div>
		</div>
	<? } else { ?>
		<div id="rollover-nav">
			<div id="underlay">
				<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
				<ul>
					<?php do_nav_default(); ?>
				</ul>
			</div>
			<div>
				<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
				<ul>
					<?php do_nav_default(); ?>
				</ul>
			</div>
		</div>
	<?php } ?>