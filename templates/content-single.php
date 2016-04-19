<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>

    <div class="entry-content">
    <div class="grid">
      <?php 

        $images = get_field('gallery');
        $count = count($images);
        if( $images ): 

             ?>

            
                <?php 

                  foreach( $images as $image ): 
                    if($count==1):
                      $class = 'grid-item--width2'; 
                    else:
                      // Get dimensions
                      $width = $image['sizes']['large-width'];
                      $height = $image['sizes']['large-height'];
                      $wh_diff = $width - $height;

                      if($wh_diff > 300):
                        $class = 'grid-item--width2';
                      endif;
                    endif;


                ?>
                    <div class="grid-item <?php echo $class; ?>">                   
                            <?php
                            $content = '<a href="'. $image['sizes']['large'] .'" target="_blank">';
                            $content .= '<img src="'. $image['sizes']['large'] .'" class="img-responsive" />';
                            $content .= '</a>';
                        if ( function_exists('slb_activate') ){
                        $content = slb_activate($content);
                        } 
                        else {
                          echo 'oh no';
                        }
                      echo $content; ?>

                       
                        
                    </div>
                <?php endforeach; ?>
            
        <?php endif; ?>
        <div class="content-item">      
        <?php the_content(); ?>
        </div>
    </div>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
