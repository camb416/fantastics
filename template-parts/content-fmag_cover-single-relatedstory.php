<?php
/**
 * Created by PhpStorm.
 * User: cameron.browning
 * Date: 10/18/16
 * Time: 11:07 PM
 */
    // Find connected pages
    $connected = new WP_Query( array(
        'connected_type' => 'cover_to_story',
        'connected_items' => get_queried_object(),
        'nopaging' => true,
    ) );

    // Display connected pages
    if ( $connected->have_posts() ) :
        ?>

            <?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
<div class="relatedstory">
                    <h3 class="fmag-linkstyle-caps header"><?php the_title(); ?></h3>
                    <ul class="tinyspreads tinyplus">
                        <?php

                        $attachments = get_posts( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => -1,
                            'post_parent' => $post->ID,
                            'exclude'     => get_post_thumbnail_id(),
                            'orderby'     => 'menu_order',
                            'order'       => 'ASC'
                        ) );

                        if ( $attachments ) {



                            $numPages = count($attachments);
                            if($numPages > 2){


                                for ( $i = 0; $i < 2 ; $i++) {
                                    $attachment = $attachments[$i];
                                    $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type ) . " this_story ";
                                    if($i<2){
                                        $class .= " active";
                                    }
                                    $thumbimg = wp_get_attachment_image( $attachment->ID, 'thumbnail-size', true );
                                    if(0 === $i%2) echo '<li class="' . $class . ' data-design-thumbnail">';
                                    echo $thumbimg;
                                    if(0 !== $i%2) echo '</li>';
                                }

                            }
                        }
                        ?>
                    </ul>
                    <!-- a href="<?php the_permalink(); ?>"><?php the_title(); ?></a -->
        <?php
        $thisContent = get_the_content("Read Story");
        echo $thisContent;

        ?>




            <?php endwhile; ?>
        </div>

        <?php
// Prevent weirdness
        wp_reset_postdata();

    endif;
    ?>

