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

</article><!-- #post-## -->
