<?php
/**
 * Created by PhpStorm.
 * User: cam
 * Date: 2/19/17
 * Time: 3:43 PM
 */

global $pagewidth, $pageheight;
$pagewidth = 188;
$pageheight = 243;

?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <!-- a href="/" class="frontlink">&lt; Frontpage</a -->
        <?php if ( have_posts() ) : ?>
            <header class="page-header">

                <div class="coverslug">
                    <?php

                    $mainQuery = $wp_query;

                    ?>
                    <?php
                    $r = new WP_Query(
                        array( 'posts_per_page' => 1,
                            'no_found_rows' => true,
                            'post_status' => 'publish',
                            'ignore_sticky_posts' => true,
                            'post_type' => 'fmag_cover',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'term',
                                    'field' => 'slug',
                                    'terms' => array($term),
                                    'operator' => 'IN'

                                )
                            ) ) );

                    if ($r->have_posts()) { ?>



                        <?php while ( $r->have_posts() ) : $r->the_post(); ?>

                            <?php
                            // working methods here:
                            // the_permalink()
                            // esc_attr( get_the_title() ? get_the_title() : get_the_ID() );
                            // <?php if ( get_the_title() ) the_title(); else the_ID();
                            // get_the_date();


                            /*
                                                        $args = array(
                                                            'post_type' => 'attachment',
                                                            'numberposts' => 1,
                                                            'post_status' => null,
                                                            'post_parent' => get_the_ID()
                                                        );

                                                        $attachments = get_posts( $args );
                                                        if ( $attachments ) {
                                                            foreach ( $attachments as $attachment ) {
                                                                //echo '<li>';
                                                                echo '<a class="coverlink" href="'.get_the_permalink().'">'.wp_get_attachment_image( $attachment->ID, 'full' ).'</a>';
                                                                //echo '<p>';
                                                                echo apply_filters( 'the_title', $attachment->post_title );
                                                                //echo '</p></li>';
                                                            }
                                                        }
                                                        */
                            get_template_part( 'template-parts/content', 'fmag_cover-slug' );



                            ?>

                        <?php endwhile; ?>






                    <?php } else {


                        $r2 = new WP_Query(
                            array( 'posts_per_page' => 1,
                                'no_found_rows' => true,
                                'post_status' => 'publish',
                                'ignore_sticky_posts' => true,
                                'post_type' => 'fmag_cover',
                            ) );

                        if ($r2->have_posts()) {


                            while ($r2->have_posts()) {
                                $r2->the_post();

                                get_template_part('template-parts/content', 'fmag_cover-slug');


                            }
                        }




                    } ?>



                    <?php

                    ?>
                </div>

                <?php
                if(is_search()){
                    $cat_identifier = "Seach Results";
                    //$cat_identifier = get_search_query();
                } else if(is_archive()){
                    $cat_identifier = "Gallery";
                } else if(is_paged()){
                    $cat_identifier = "Gallery"; // display nothing if you get there via "more stories"
                }
                ?>

                <div class="category-identifier"><?php echo($cat_identifier); ?></div>

                <?php

                if(is_search()){
                    $title = get_search_query();
                }  else if(is_archive()){
                    $title = get_the_archive_title();
                    $description = get_the_archive_description();
                } else if(is_paged()){
                    $title = "Features";
                }





                ?>

                <h1 class="page-title"><?php echo($title); ?></h1>
                <div class="taxonomy-description"></div>
            </header><!-- .page-header -->

            <div class="archive-wrap">
                <div class="archive-sidebar">
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Archive Sidebar')) : ?>
                        <!-- empty sidebar -->
                    <?php endif; ?>
                </div>
                <div class="archive-stories">
                    <?php /* Start the Loop */ ?>
                    <?php $count; while ( have_posts() ) : the_post(); $count++; $zebra = ($count % 3) ? ' third' : ' notthird'; ?>

                        <?php

                        $postType = get_post_type();
                        if("fmag_story" === $postType){
                            echo '<div class="fmag_story wrapper">';


                            $pagewidth = 229;
                            $pageheight = 296;

                            get_template_part( 'template-parts/content', get_post_type() );

                            echo "</div><!-- wrapper -->";

                        } else if("fmag_cover" === $postType){
                            get_template_part( 'template-parts/content', get_post_type() );
                            //$myvar = locate_template('content.php');
                            //echo $myvar;
                            //include(locate_template('template-parts/content-fmag_story'));
                        } else {
                            echo get_post_format();
                            get_template_part( 'template-parts/content', get_post_format() );
                        }
                        ?>

                    <?php endwhile; ?>
                    <?php posts_navigation(); ?>
                </div>
            </div>


        <?php else : ?>

            <?php get_template_part( 'template-parts/content', 'none' ); ?>

        <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->
