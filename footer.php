
<?php global $options; ?>

<div id="footer">
	<p id="copyright">©<?php echo date("Y") . ' '; bloginfo('name'); ?></p>
	<?php	
		if( has_nav_menu( 'footer' )) {			
			wp_nav_menu(array( 
				'theme_location' => 'footer',
				'container' => ''
			));
		} else {
	?>	
	<ul>
		<?php 
		wp_list_pages(array( 
			'sort_column' => 'menu_order',
			'title_li' => '',
			'depth' => '1'
		));
		?>
	</ul>	
	<?php } ?>
	<p id="credit">
		<a class="ff" href="http://www.flatfile.ws">
			<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/lib/images/cabinet.png">
		</a>
		<a class="ff" href="http://www.flatfile.ws">Built with Flatfile</a>
	</p>
</div>

<ul id="controls">
	<li>
		<a id="subscribe" title="Subscribe" href="<?php bloginfo( 'rss2_url' ); ?>" class="flatfile-normal medium">^</a>
	</li>
	<li <?php if( is_user_logged_in() ) { echo 'class="logged-in"'; } ?>>
		<a id="edit" title="Edit"
			<?php
				if(( is_page() || is_single() ) && is_user_logged_in() ) {
					echo 'href="' . get_edit_post_link() . '"';
				} else {
					echo 'href="' . get_bloginfo('wpurl') . '/wp-admin"';
				}
			?>
		class="flatfile-normal medium">&#9998;</a>
	</li>
</ul>

</div>
</body>
</html>