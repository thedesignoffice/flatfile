<?php 
	global $options;
	global $image_categories;
	global $text_categories;
?>

<?php get_header(); ?>
	<?php
	/* check if news articles should be shown at all */
	if( !empty( $text_categories ) && $options[ 'latest_posts' ] > 0 ) :
	?>
	<div id="latest">
		<?php
			/* get the most recent post in text categories */
			query_posts( array(
				'category__in' => $text_categories,
				'post__in'  => get_option('sticky_posts'),
				'posts_per_page' => $options[ 'latest_posts' ]
			));
			if( have_posts() ) : while( have_posts() ) : the_post();
		?>
		<div>
		<span class="latest-post">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</span>
		<span class="latest-category">
			<?php
				$category = get_the_category();
				echo 'IN&nbsp;' . $category[0]->cat_name;
			?>
		</span>
		</div>
		<?php 	
			endwhile; endif;
			wp_reset_query();
		?>
	</div>
	<?php endif; ?>
</div>

<?php
	/* if a featured image is defined */
	if( $options['featured'] > 0 ) :
?>
<?php
	/* query for it by post id */	
	query_posts( array(
		'p' => $options['featured']
	));
	if( have_posts() ) : while( have_posts() ) : the_post();	
?>
<div id="featured">
	<div class="default">
		<a href="<?php the_permalink(); ?>">
		<?php
			the_post_thumbnail( 'large', array( ));
		?>
		</a>
	</div>
</div>
<?php
	endwhile; endif; endif;
?>
<?php get_footer(); ?>