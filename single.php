<?php 
	global $options;
	global $image_categories;
	global $text_categories;
?>

<?php get_header(); ?>

<?php /* retrieve and filter categories */
	
	$parent_categories = array();
	$sub_categories = array();
	
	foreach( get_the_category() as $category ) {
		if( $category->category_parent == 0 ) {
			if( !in_array( $category, $parent_categories )) {
				$parent_categories[] = $category;
			}
		} else {
			/* add parent categories of subcategories, checking for duplicates */
			if( !in_array( get_category( $category->category_parent ), $parent_categories )) {
				$parent_categories[] = get_category( $category->category_parent );
			}
			$sub_categories[] = $category;
		}
	}
	
	$in_image_category = true;
	
	foreach( $parent_categories as $parent_category ) {
		if( in_array( $parent_category->cat_ID, $text_categories) ) {
			$in_image_category = false;
		}
	}
?>

	<div id="breadcrumbs">		
		<?php if( !empty( $parent_categories )) { ?>
			<?php foreach( $parent_categories as $parent_category ) { ?>
				<h2><a href="<?php echo get_category_link( $parent_category->cat_ID ); ?>"><?php echo $parent_category->name; ?></a></h2>
			<?php } ?>
		<?php } ?>
		<?php if( !empty( $sub_categories )) { ?>
			<?php foreach( $sub_categories as $sub_category ) { ?>
				<h2><a href="<?php echo get_category_link( $parent_categories[0]->cat_ID ) . '#' . $sub_category->name; ?>"><?php echo $sub_category->name; ?></a></h2>
			<?php } ?>
		<?php } ?>
	</div>

<?php if( $in_image_category ) { ?>
	
	<ul class="local">
		<li class="nav" id="next">
			<?php
				$next_post = get_next_post( true );
				echo empty( $next_post ) ? '<a class="inactive">&nbsp;</a>' : '<a href="' . get_permalink( $next_post->ID ) . '">Previous</a>';
			?>
		</li>
		<li class="nav" id="prev">
			<?php
				$prev_post = get_previous_post( true );
				echo empty( $prev_post ) ? '<a class="inactive">&nbsp;</a>' : '<a href="' . get_permalink( $prev_post->ID ) . '">Next</a>';
			?>
		</li>
		<li class="all">
			<?php 
				if ( !empty( $sub_categories )) {
					echo '<a href="' . get_category_link( $parent_categories[0]->cat_ID ) . '#' . $sub_categories[0]->name . '">All</a>';
				} else {
					echo '<a href="' . get_category_link( $parent_categories[0]->cat_ID ) . '#">All</a>';
				}
			?>
		</li>
	</ul>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php if($post->post_content != "") : ?>	
			<div id="caption" class="hide-videos">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>
	<?php endwhile; ?>
	<?php the_tags('<ul class="tags"><li>','</li><li>/</li><li>', '</li></ul>'); ?>
</div>
	
<?php } else { ?>
	
	<ul class="local local-narrow">
		<li class="nav" id="next">
			<?php
				$prev_post = get_previous_post( true );
				echo empty( $prev_post ) ? '<a class="inactive">&nbsp;</a>' : '<a href="' . get_permalink( $prev_post->ID ) . '">Older</a>';
			?>
		</li>
		<li class="nav" id="prev">
			<?php
				$next_post = get_next_post( true );
				echo empty( $next_post ) ? '<a class="inactive">&nbsp;</a>' : '<a href="' . get_permalink( $next_post->ID ) . '">Newer</a>';
			?>
		</li>
		<li class="all">
			<?php 
				if ( !empty( $sub_categories )) {
					echo '<a href="' . get_category_link( $parent_categories[0]->cat_ID ) . '#' . $sub_categories[0]->name . '">All</a>';
				} else {
					echo '<a href="' . get_category_link( $parent_categories[0]->cat_ID ) . '#">All</a>';
				}
			?>
		</li>
	</ul>
	<div class="article-controls">
		<a class="addthis_button_twitter"
			href="#"
			addthis:url="<?php the_permalink(); ?>"
			addthis:title="<?php the_title(); ?>">
			<span class="flatfile-normal large monospace">t</span> Tweet this to your timeline
		</a>
		<a class="addthis_button_facebook"
			href="#"
			addthis:url="<?php the_permalink(); ?>"
			addthis:title="<?php the_title(); ?>">
			<span class="flatfile-normal large monospace">G</span> Recommend on Facebook
		</a>
		<a class="addthis_button_email"
			href="#"
			addthis:url="<?php the_permalink(); ?>"
			addthis:title="<?php the_title(); ?>">
			<span class="flatfile-normal large monospace">m</span> Email to a friend
		</a>
		<a class="addthis_button_print"
			href="#"
			addthis:url="<?php the_permalink(); ?>"
			addthis:title="<?php the_title(); ?>">
			<span class="flatfile-normal large monospace">d</span> Print this page
		</a>
	</div>	
</div>
	
	<?php while ( have_posts() ) { ?>
		
		<?php the_post(); ?>
		<div id="content-text">
			<div class="article">
				<h4 style="margin-bottom: 15px;">
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</h4>
				<?php the_content(); ?>
				<hr>
				<?php the_tags('<ul class="tags"><li>','</li><li>/</li><li>', '</li></ul>'); ?>
				<div class="date"><?php the_time( 'F j, Y' ); ?></div>
			</div>
		</div>
		
	<?php } ?>
<?php } ?>

<?php if( $in_image_category ) { ?>
	<div id="featured">
		<div class="default">
		<?php the_post_thumbnail( 'large', array( )); ?>
		</div>
	</div>
<?php } ?>

<?php get_footer(); ?>