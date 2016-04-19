<?php
/**
 * Template Name: Category Page
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'category'); ?>
<?php endwhile; ?>
