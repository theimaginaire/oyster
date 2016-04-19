<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <div class="cd-main-content">
    <nav class="cd-side-nav">
      <?php 
      wp_nav_menu( array(
          'menu' => 'Primary',
          'menu_class' => 'nav-menu'
      ) );
      ?>
    <div class="contact">
        <p><i class="fa fa-phone"></i> <a href="tel:<?php the_field('telephone', 'options'); ?>" class="tel"><?php the_field('telephone', 'options'); ?></a></p>
        <p><i class="fa fa-envelope-o"></i> <?php the_field('email', 'options'); ?></p>
    </div>
    </nav>
    <?php if(is_front_page()): ?>
    <main class="main">
    <?php get_template_part('templates/content', 'home'); ?>
    </main>
    <?php else: ?>
    <div role="document">
        <main class="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
      </div><!-- /.content -->
    <?php endif; ?>

    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>

    </div>
  </body>
</html>
