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
        $bigcover = get_queried_object();
        $coverid = $post->ID;

        if($bigcover === null){
            $bigcover = get_post(get_the_ID());
        }

        // Find connected pages
        $connected = new WP_Query( array(
        'connected_type' => 'cover_to_story',
        'connected_items' => $bigcover,
        'nopaging' => true,
        ) );


        if ( $connected->have_posts() ) :
        ?>

        <?php while ( $connected->have_posts() ) : $connected->the_post();

        $storyLink = get_the_permalink();
        endwhile;
        endif;

        if(is_single()) wp_reset_postdata();

        ?>

        <?php

        $attachments = get_posts( array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => $coverid,
            'exclude'     => get_post_thumbnail_id(),
            'orderby'     => 'menu_order',
        ) );

        if ( $attachments ) {
            $numPages = count($attachments);
           if($numPages>0){
                $attachment = $attachments[0];
                $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );

                $img = wp_get_attachment_image( $attachment->ID, 'thumbnail-size', true );
          echo '<a class="coverlink" href="'.esc_url( $storyLink ).'">';
                echo ''.$img.'';

                // for testing. remove before prod
                //echo fmag_img(wp_get_attachment_url($attachment->ID), 100);


              echo '</a>';
           }

        }
        ?>


	</header><!-- .entry-header -->






    <footer class="entry-footer">
        <?php fantastics_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
