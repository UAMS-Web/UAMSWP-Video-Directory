<?php get_header(); ?>

<?php get_template_part('header', 'image'); ?>

<div class="container uams-body">

  <div class="row">

    <div <?php if (function_exists('uams_content_class')) {
        uams_content_class();
    } else {
        echo 'class="uams-content col-md-12"';
    } ?> role='main'>

      <?php get_template_part('breadcrumbs'); ?>

      <div id='main_content' class="uams-body-copy" tabindex="-1">

            <?php
                // Start the Loop.
                while (have_posts()) {
                    the_post();

                    ?>
                    <h2>
                        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a>
                    </h2>

                    <?php

                        the_post_thumbnail([130, 130], ['class' => 'attachment-post-thumbnail blogroll-img']);
                    the_excerpt();
                    $vid_cats = get_the_terms((int) get_the_ID(), 'video_categories');
                    if (is_array($vid_cats) && $vid_cats !== []) {
                        // Equivalent mutant: `array_values()` only renumbers the keys, and the loop below reads values only.
                        // @pest-mutate-ignore:UnwrapArrayValues
                        $categories = array_values($vid_cats);
                        $formatted_categories = '';
                        ?><p class=''><?php
                        foreach ($categories as $category) {
                            // `get_term_link()` returns a `WP_Error` when it has no archive to link to: show the name alone.
                            $term_link = get_term_link($category);
                            $category_html = is_string($term_link) ? '<a href="'.$term_link.'">'.$category->name.'</a>' : $category->name;
                            if (! empty($formatted_categories)) {
                                $formatted_categories = $formatted_categories.', '.$category_html;
                            } else {
                                $formatted_categories = $category_html;
                            }
                        }
                        echo $formatted_categories;
                        ?></p><?php
                    }

                    echo '<hr>';

                }
?>

            <span class="next-page"><?php next_posts_link('Next page', 0); ?></span>

      </div>

    </div>

    <?php get_sidebar() ?>

  </div>

</div>

<?php get_footer(); ?>
