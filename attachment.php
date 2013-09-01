	<?php get_header(); ?>
	<h2><?php the_title(); ?></h2>
	<div id="content-images">
		<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				echo wp_get_attachment_image($post->ID, 'large');	
			endwhile; endif;
		?>
	</div>
</div>
<?php get_footer(); ?>