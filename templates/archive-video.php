<?php get_header(); ?>

<?php get_template_part( 'header', 'image' );  ?>

<div class="container uams-body">

  <div class="row">

    <div <?php uams_content_class(); ?> role='main'>

      <?php get_template_part( 'breadcrumbs' ); ?>

      <div id='main_content' class="uams-body-copy" tabindex="-1">

            <?php
                // Start the Loop.
                while ( have_posts() ) : the_post();

                    ?>
                    <h2>
                        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a>
                    </h2>

                    <?php

                        the_post_thumbnail( array(130, 130), array( 'class' => 'attachment-post-thumbnail blogroll-img' ) );
                        the_excerpt();
                        $vid_cats = get_the_terms(get_the_ID(), 'video_categories');
                        if (!empty($vid_cats)){
                                $categories = array_values($vid_cats);
                                $formatted_categories = "";
                                ?><p class=''><?php
                                foreach ($categories as $category) {
                                    if (!empty($formatted_categories)) {
                                        $formatted_categories = $formatted_categories . ", " . '<a href="' . $category->link . '">' . $category->name . '</a>';
                                    }
                                    else {
                                        $formatted_categories = '<a href="' . $category->link . '">' . $category->name . '</a>';
                                    }
                                }
                                echo $formatted_categories;
                                ?></p><?php
                            }

                        echo "<hr>";

                endwhile;
            ?>

            <span class="next-page"><?php next_posts_link( 'Next page', '' ); ?></span>

      </div>

    </div>

    <?php get_sidebar() ?>

  </div>

</div>

<?php get_footer(); ?>

