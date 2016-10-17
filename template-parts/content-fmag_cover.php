<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fantastics
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">



        <?php

        $attachments = get_posts( array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => $post->ID,
            'exclude'     => get_post_thumbnail_id(),
            'orderby'     => 'menu_order',
        ) );

        if ( $attachments ) {
            $numPages = count($attachments);
           if($numPages>0){
                $attachment = $attachments[0];
                $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );

                $img = wp_get_attachment_image( $attachment->ID, 'thumbnail-size', true );
          echo '<a href="'.esc_url( get_permalink() ).'">';
                echo ''.$img.'';

                // for testing. remove before prod
                //echo fmag_img(wp_get_attachment_url($attachment->ID), 100);


              echo '</a>';
           }

        }
        ?>


	</header><!-- .entry-header -->




    <?php
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
                <li>
                    <h3><?php the_title(); ?></h3>
                    <ul class="tinyspreads">
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
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>


                </li>

            <?php endwhile; ?>
        </ul>

        <?php
// Prevent weirdness
        wp_reset_postdata();

    endif;
    ?>



    <footer class="entry-footer">
        <?php fantastics_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
