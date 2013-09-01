	<?php get_header(); ?>	
	<h2>Search = <?php the_search_query(); ?></h2>			
</div>
<div id="content-images">
	<?php
		global $wp_query;
		$total_results = $wp_query->found_posts;
		
		if( $total_results > 0 ) {
			get_template_part( 'aggregate' );
		} else {
			echo '<h1>No search results were found.</h1>';
		}
	?>
</div>
<?php get_footer(); ?>