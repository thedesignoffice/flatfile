	<?php get_header(); ?>
</div>
<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	<div id="content-text">
		<div class="article">
			<h4><?php the_title(); ?></h4>
			<?php the_content(); ?>
			<hr>
			<div class="article-controls">
				<a title="Tweet"
					href="#"
					class="addthis_button_twitter flatfile-normal small"
					addthis:url="<?php the_permalink(); ?>"
					addthis:title="<?php the_title(); ?>">T</a>
				<a title="Recommend"
					href="#"
					class="addthis_button_facebook flatfile-normal small"
					addthis:url="<?php the_permalink(); ?>"
					addthis:title="<?php the_title(); ?>">F</a>
				<a title="Email a friend"
					href="#"
					class="addthis_button_email flatfile-normal small"
					addthis:url="<?php the_permalink(); ?>"
					addthis:title="<?php the_title(); ?>">m</a>
			</div>
			<div class="date"><?php the_time( 'F j, Y' ); ?></div>			
		</div>
	</div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>