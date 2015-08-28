<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fantastics
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php fantastics_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
<?php

                        $attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => $post->ID,
			'exclude'     => get_post_thumbnail_id()
		) );

                        ?>



            <ul class="bigspreads">
            <?php
		if ( $attachments ) {
                    $numPages = count($attachments);
			for ( $i = 0; $i < $numPages ; $i++) {
                $attachment = $attachments[($numPages-1)-$i];
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

        <div id="bottomcols">
            <div id="leftcol">
                <?php  the_content(); ?>
                <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fantastics' ),
                    'after'  => '</div>',
                ) );
                ?>
        </div>
            <div id="rightcol">
        <ul class="tinyspreads">
            <?php
            if ( $attachments ) {
                $numPages = count($attachments);
                for ( $i = 0; $i < $numPages ; $i++) {
                    $attachment = $attachments[($numPages-1)-$i];
                    $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
                    if($i<2){
                        $class .= " active";
                    }
                    $thumbimg = wp_get_attachment_image( $attachment->ID, 'thumbnail-size', true );
                    if(0 === $i%2) echo '<li class="' . $class . ' data-design-thumbnail">';
                    echo $thumbimg;
                    if(0 !== $i%2) echo '</li>';
                }

            }

            ?>
        </ul>
            </div>


        </div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php fantastics_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

