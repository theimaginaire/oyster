<div class="owl-carousel">

<?php 
$category = get_field('case_category');

// WP_Query arguments
$args = array (
	'post_type'              => array( 'case-study' ),
	'orderby'				=> 'menu_order',
	'order'					=> 'ASC',
	'case-category'			=> $category->slug,
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
	$img_height = $thumb_url_array[2];
	if($img_height < 500):
		$img_w = $img_width;
	elseif($img_height < 1000):
		$img_w = $img_width;
	elseif($img_height < 1200 && $img_width < 1200):
		$img_w = $img_width;
	else:
		$img_w = $img_width / 3;
	endif;
	$delay = $count*3;
?>

<a href="<?php the_permalink(); ?>">

<div class="item" width="<?php echo $img_w; ?>px" style="background-image: url(<?php echo $thumb_url; ?>); width: <?php echo $img_w; ?>px; height: 100%; animation-delay: .<?php echo $delay; ?>s">
</div>
</a>

<?php
	$count++;
	endwhile;
	else:
	// no posts found
	endif;

// Restore original Post Data
wp_reset_postdata();
?>
</div><!-- #owl-carousel -->
<section class="category-content">
<div class="row">

<div class="col-md-12">
<div class="content-block">
	<?php the_content(); ?>
	</div>
</div>
</div>
</section>