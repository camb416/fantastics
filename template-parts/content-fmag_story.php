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
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>


        <?php


        the_content( sprintf(
        /* translators: %s: Name of current post. */
            wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'fantastics' ), array( 'span' => array( 'class' => array() ) ) ),
            the_title( '<span class="screen-reader-text">"', '"</span>', false )
        ) );

        ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php fantastics_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php


        $attachments = get_posts( array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => $post->ID,
            'exclude'     => get_post_thumbnail_id(),
            'orderby'     => 'menu_order',
        ) );

        ?>



        <ul class="medspread">
            <?php
            if ( $attachments ) {
                $numPages = count($attachments);
                for ( $i = 0; $i < 2 ; $i++) {
                    $attachment = $attachments[$i];
                    $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
                    if($i>=2){
                        $class .= " hidden";
                    }
                    $thumbimg = wp_get_attachment_image( $attachment->ID, 'thumbnail-size', true );
                    if(0 === $i%2) echo '<li class="' . $class . ' data-design-thumbnail">';
                    echo $thumbimg;
                    if(0 !== $i%2) echo '</li>';
                }

            }

            ?>
        </ul>




		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fantastics' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php fantastics_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
