	<?php get_header(); ?>
	<h2>Tag = <?php single_tag_title(); ?></h2>			
</div>
<div id="content-images">
	<?php get_template_part( 'aggregate' ); ?>
</div>
<?php get_footer(); ?>