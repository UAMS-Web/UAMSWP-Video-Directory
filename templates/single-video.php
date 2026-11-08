<?php get_header(); ?>

<?php get_template_part('header', 'image'); ?>

<div class="container uams-body">

  <div class="row">

    <div <?php if ( function_exists( 'uams_content_class' ) ) { uams_content_class(); } else { echo 'class="uams-content col-md-12"'; } ?> role='main'>

      <?php get_template_part('breadcrumbs'); ?>

      <div id='main_content' class="uams-body-copy" tabindex="-1">

            <?php
                // Start the Loop.
                while (have_posts()) {
                    the_post();

                    ?>
                        <h1><?php the_title() ?></h1>

                        <?php

                        the_content();

                }
?>

            <span class="next-page"><?php next_posts_link('Next page', ''); ?></span>

      </div>

    </div>

    <?php get_sidebar() ?>

  </div>

</div>

<?php get_footer(); ?>

