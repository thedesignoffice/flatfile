<?php	
	global $options;
	global $image_categories;
	global $text_categories;
?>
<?php
	// get the current category
	$category = get_category( get_query_var( 'cat' ));
	
	// find out if we're in an image category as defined in flatfile options
	$in_image_category = false;
	if( in_array( $category->cat_ID, $image_categories )
	 || in_array( $category->category_parent, $image_categories ) ) {
		$in_image_category = true;
	}
?>
	<?php get_header(); ?>
	<?php if( $in_image_category ) { ?>
		<h2 class="image"><?php echo $category->name; ?></h2>
	<? } else { ?>
		<h2 class="text">       
		<?php /* If this is a tag archive */  if( is_tag() ) { ?>
       		<?php single_tag_title(); ?>
       <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
      		<?php the_time('F jS, Y'); ?>
       <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	     <?php the_time('F Y'); ?>
       <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    	   <?php the_time('Y'); ?>
		<? } ?>
	</h2>
		<? } ?>
</div>
<?php 
	/* image category layout
	---------------------------------------------- */
	if( $in_image_category ) {
?>
<div id="content-images">
	<?php
		/* get all of the child categories of the current category */
		$subcategories = get_categories(array( 
			'child_of' => $category->cat_ID,
			'orderby' => 'slug'
		));
		/* create an array of category ids for the subcategories */
		$subcategory_IDs = array();
		foreach( $subcategories as $subcategory ) {
			$subcategory_IDs[] = $subcategory->cat_ID;
		}
	?>
	<?php 
		/* get posts that are in the top-level category, but not any of the subcategories */
		query_posts(array( 
			'cat' => $category->cat_ID,
			'category__not_in' => $subcategory_IDs,
			'posts_per_page' => -1
		));
		$images_in_top = false;
		if( have_posts() ) {
			$images_in_top = true;
	?>
	<hr>
	<?php while( have_posts() ) { ?>
		<?php
			the_post();
			if( has_post_thumbnail() ) { ?>
			<div class="thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'post-thumbnail', array( 'title' => get_the_title() )); ?>
				</a>
			</div>				
		<?php } ?>
	<?php } ?>
	<div class="description" id="<?php echo $category->cat_ID; ?>-description">
	<?php if( !empty( $category->category_description ) ) { ?>
			<a class="highlight" id="<?php echo $category->cat_ID; ?>">About <?php echo $category->name; ?></a>
			<p><?php echo $category->category_description; ?></p>
	<?php } ?>
	</div>
<?php } ?>
<?php 
	/* get posts in each of the subcategories */
	foreach( $subcategories as $subcategory ) {
		query_posts( array(
			'cat' => $subcategory->cat_ID,
			'posts_per_page' => -1
		));
		if( have_posts() ) {
?>
		<h3 class="subcategory" id="<?echo $subcategory->name; ?>">
			<?php echo $subcategory->name; ?>
			<!--
			<a title="View only this section"
			   class="permalink flatfile-normal medium" 
			   href="<?php echo get_category_link( $subcategory->cat_ID ); ?>">W</a>
			-->
		</h3>
		<?php while( have_posts() ) { ?>
			<?php
				the_post();
				if( has_post_thumbnail() ) { ?>
				<div class="thumbnail">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'post-thumbnail', array( 'title' => get_the_title() )); ?>
					</a>
				</div>
			<?php } ?>
		<?php } ?>
		<div class="description" id="<?php echo $subcategory->cat_ID; ?>-description">
		<?php if( !empty( $subcategory->category_description ) ) { ?>
				<a class="highlight" id="<?php echo $subcategory->cat_ID; ?>">About</a>
				<p><?php echo $subcategory->category_description; ?></p>
		<?php } ?>
		</div>
	<?php } ?>
<?php } ?>
<?php if( !$images_in_top ) { ?>
	<?php if( !empty( $category->category_description ) ) { ?>
		<hr>
		<div class="description" id="<?php echo $category->cat_ID; ?>-description">
			<a class="highlight" id="<?php echo $category->cat_ID; ?>">About <?php echo $category->name; ?></a>
			<p><?php echo $category->category_description; ?></p>
		</div>
	<?php } ?>
<?php } ?>
</div>

<?php 
	/* text category layout
	---------------------------------------------- */
	} else {
?>
<div class="sidebar">
	<ul>
	<?php if ( !function_exists('dynamic_sidebar')
			|| !dynamic_sidebar() ) : ?>
	<?php endif; ?>
	</ul>
</div>
<div id="content-text">
	<?php while ( have_posts() ) { ?>
		<?php the_post(); ?>
		<div class="article">
			<h4>
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			</h4>
			<?php the_content(); ?>
			<hr>
			<?php the_tags('<ul class="tags"><li>','</li><li>/</li><li>', '</li></ul>'); ?>
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
	<?php } ?>
	<?php
		$next_posts_link = get_next_posts_link( "Older" );
		$previous_posts_link = get_previous_posts_link( "Newer" );
		if( !empty( $next_posts_link ) || !empty( $previous_posts_link )) {
	?>
	<ul class="local local-top">
		<li class="nav" id="next">
			<?php echo empty( $next_posts_link ) ? '<a class="inactive">&nbsp;</a>' : $next_posts_link; ?>
		</li>
		<li class="nav" id="prev">
			<?php echo empty( $previous_posts_link ) ? '<a class="inactive">&nbsp;</a>' : $previous_posts_link; ?>
		</li>
	</ul>
	<ul class="local local-bottom">
		<li class="nav" id="next">
			<?php echo empty( $next_posts_link ) ? '<a class="inactive">&nbsp;</a>' : $next_posts_link; ?>
		</li>
		<li class="nav" id="prev">
			<?php echo empty( $previous_posts_link ) ? '<a class="inactive">&nbsp;</a>' : $previous_posts_link; ?>
		</li>
	</ul>
	<?php } ?>
</div>
<?php } ?>
<?php get_footer(); ?>