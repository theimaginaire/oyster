<?php

// check if the repeater field has rows of data
if( have_rows('panels', 'options') ):
?>
<div class="blocks">
<?php
	$count = 0;
 	// loop through the rows of data
    while ( have_rows('panels', 'options') ) : the_row();
?>
<?php if($count==0||$count==1||$count==3): ?>
	<div class="col-md-4">
<?php endif; ?>
<?php if($count==1||$count==2):
		$class = 'half-block';
	elseif($count==0):
		$class = 'full-block';
	elseif($count==3):
		$class = 'one-third';
	elseif($count==4):
		$class = 'two-thirds';
	endif;
?>
<a href="<?php the_sub_field('links_to'); ?>">
<div class="<?php echo $class; ?> animated fadeIn" style="background-image: url(<?php the_sub_field('image'); ?>); background-size: cover; background-repeat: no-repeat;">
<div class="block-text">
<?php 
        // display a sub field value
        the_sub_field('title');
?>
</div>
</div>
</a>
<?php if($count==0||$count==2||$count==4): ?>
	</div>
<?php endif; ?>
<?php 		
	$count++;
    endwhile;
?>
</div>
<?php 
endif;

?>