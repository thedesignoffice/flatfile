<?php while ( have_posts() ) : the_post(); ?>
	<a href="<?php the_permalink(); ?>">
		<div class="excerpt">
			<p><?php the_title(); ?></p>		
			<?php if( has_post_thumbnail() ) { ?>
				<div class="inner">
					<?php the_post_thumbnail( 'post-thumbnail', array( 'title' => get_the_title() )); ?>
				</div>
			<?php } else { ?>
				<div class="inner">
					<?php the_excerpt(); ?>
				</div>
			<?php } ?>
			<div class="fade"></div>
		</div>
	</a>	
<?php endwhile; ?>