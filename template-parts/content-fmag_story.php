<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fantastics
 */


?>

<article id="post-<?php the_ID();?>" <?php post_class(); ?>>


	<div class="entry-content">
		<?php




        ?>



        <ul class="medspread">
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
                for ( $i = 0; $i < 2 ; $i++) {
                    $attachment = $attachments[$i];
                    $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
                    if($i>=2){
                        $class .= " hidden";
                    }
                    $thumbimg = wp_get_attachment_image( $attachment->ID, 'thumbnail-size', true );
                    if(0 === $i%2) echo '<li class="' . $class . ' data-design-thumbnail"><a href="'.esc_url( get_permalink() ).'">';
                    echo ''.$thumbimg;
                    if(0 !== $i%2) echo '</a></li>';
                }


            }

            ?>
        </ul>



	</div><!-- .entry-content -->

    <header class="entry-header">



        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>


        <?php
        echo the_content('',false);

        //        the_content( sprintf(
        //        /* translators: %s: Name of current post. */
        //            wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'fantastics' ), array( 'span' => array( 'class' => array() ) ) ),
        //            the_title( '<span class="screen-reader-text">"', '"</span>', false )
        //       ) );

        ?>

        <?php if ( 'post' == get_post_type() ) : ?>
            <div class="entry-meta">
                <?php fantastics_posted_on(); ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>

        <!--ul class="minispreads">
            <?php



            if ( $attachments ) {
                $numPages = count($attachments);
                for ( $i = 2; $i < $numPages && $i<8 ; $i++) {
                    $attachment = $attachments[$i];
                    $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
                    if($i>=2){
                        $class .= " hidden";
                    }
                    $thumbimg = wp_get_attachment_image( $attachment->ID, 'thumbnail-size', true );
                    if(0 === $i%2) echo '<li class="' . $class . ' data-design-thumbnail"><a href="'.esc_url( get_permalink() ).'">';
                    echo ''.$thumbimg.'';

                    // for testing. remove before prod
                    //echo fmag_img(wp_get_attachment_url($attachment->ID), 100);


                    if(0 !== $i%2) echo '</a></li>';
                }

            }

            ?>
        </ul -->
        <?php
        if($numPages>2){
            echo('<a class="morepages" href="'.esc_url( get_permalink() ).'"><em>View all ' . ($numPages) .' pages</em><i class="fa fa fa-long-arrow-right"></i></a>');
        } else {
            echo('<a class="morepages" href="'.esc_url( get_permalink() ).'">view story...</a>');
        }
        ?>

        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fantastics' ),
            'after'  => '</div>',
        ) );
        ?>

    </header><!-- .entry-header -->


	<footer class="entry-footer">
		<?php fantastics_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

