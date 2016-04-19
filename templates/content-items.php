<div class="blocks">

<?php 
$category = get_field('case-category');
// WP_Query arguments
$args = array (
	'post_type'              => array( 'case-study' ),
	'posts_per_page'		=> '3',
);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ):
	$count = 0;
?>

<?php
	while ( $query->have_posts() ):
		$query->the_post();
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
		$thumb_url = $thumb_url_array[0];
		$img_width = $thumb_url_array[1];
		$img_w = $img_width / 3;
		$delay = $count*3;

		if($count==0):
			$class = 'full-block';
		elseif($count==1):
			$class = 'one-third';
		elseif($count==2):
			$class = 'two-thirds';
		endif;
?>
<?php if($count==0||$count==1): ?>
	<div class="col-md-4">
<?php endif; ?>
<a href="<?php the_permalink(); ?>">
<div class="<?php echo $class; ?> animated fadeIn" style="background-image: url(<?php echo $thumb_url; ?>); background-size: cover; background-repeat: no-repeat;">
<div class="block-text">
<?php 
        // display a sub field value
        the_title();
?>
</div>
</div>
</a>
<?php if($count==0||$count==2): ?>
	</div>
<?php endif; ?>
<?php 		
	$count++;
    endwhile;
?>
<?php 
endif;
wp_reset_query();
?>
<div class="col-md-4">
	<div class="content-block">
	<?php the_content(); ?>
	</div>
</div>
</div>