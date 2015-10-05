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
		<?php //the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php //fantastics_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
<?php

                        $attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => $post->ID,
			'exclude'     => get_post_thumbnail_id(),
            'orderby'     => 'menu_order',
            'order'       => 'ASC'
		) );

                        ?>



            <ul class="bigspreads">
            <?php
		if ( $attachments ) {
                    $numPages = count($attachments);
			for ( $i = 0; $i < $numPages ; $i++) {
                $attachment = $attachments[$i];
                $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
                if($i>=2){
                    $class .= " hidden";
                } else if($i === 0){
                    $class .= " first";
                }
                if($i === ($numPages-2)){
                    $class .= " last";
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
            <?php
                the_title( '<h2 class="entry-title">', '</h2>' );
                //fantastics_posted_on();
            ?>

            <div id="leftcol">
                <?php
                $credits = get_post_meta($id, 'fmag_credits_block', true);
                the_content('',FALSE,'');

                //wp_get_post_terms()

                ?>
                <?php

                if("" !== $credits){
                    echo '<div class="credits"><h2>Credits</h2>' . $credits . '</div>';
                }

                ?>

                <?php

                $fashionTerms = get_the_term_list( $post->ID, 'fashion', '<ul class="styles"><li>', '</li><li>', '</li></ul>' );
                if(!is_wp_error($fashionTerms) && false !== $fashionTerms){
                    echo '<div class="fashions"><h2>Fashions By</h2>' . $fashionTerms . '</div>';
                }

                $creditTerms = get_the_term_list( $post->ID, 'term', '<ul class="styles"><li>', '</li><li>', '</li></ul>' );
                if(!is_wp_error($creditTerms) && false !== $creditTerms){
                    echo '<div class="tags"><h2>File Under</h2>' . $creditTerms . '</div>';
                }


                ?>

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
            /*
            if ( have_posts() ) : while ( have_posts() ) : the_post();

                $args = array(
                    'post_type' => 'attachment',
                    'numberposts' => -1,
                    'post_status' => null,
                    'post_parent' => $post->ID,
                    'orderby' => 'menu_order'
                );

                $original = get_posts( $args );
                if ( $original ) {
                    $attachments = array_reverse($original);
                    foreach ( $attachments as $attachment ) {
                        echo '<li><p>';
                        echo wp_get_attachment_image( $attachment->ID, array(746,500) );
                        echo '</p></li>';
                    }
                }

            endwhile; endif;

            */
            ?>





            <?php
            if ( $attachments ) {



                $numPages = count($attachments);
                for ( $i = 0; $i < $numPages ; $i++) {
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

            ?>

            <?php

            $prev_post = get_previous_post();
            $next_post = get_next_post();

            if (!empty( $next_post )): ?>

                <a class="nextstory" href="<?php echo get_permalink( $next_post->ID ); ?>">

                    <?php

                    $nextattachments = get_posts( array(
                        'post_type' => 'attachment',
                        'posts_per_page' => -1,
                        'post_parent' => $next_post->ID,
                        'exclude'     => get_post_thumbnail_id(),
                        'orderby'     => 'menu_order',
                        'order'       => 'ASC'
                    ) );

                    if(count($nextattachments)>1){
                        for ( $i = 0; $i < 2 ; $i++) {
                            $attachment = $nextattachments[$i];
                            $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
                            $thumbimg = wp_get_attachment_image( $attachment->ID, 'thumbnail-size', true );
                            if(0 === $i%2) echo '<li class="' . $class . ' data-design-thumbnail">';
                            echo $thumbimg;
                            if(0 !== $i%2) echo '</li>';
                        }
                    }

                    ?></a>

            <?php endif; ?>


                <?php if (!empty( $prev_post )): ?>

                <a class="prevstory" href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php

                    $prevattachments = get_posts( array(
                        'post_type' => 'attachment',
                        'posts_per_page' => -1,
                        'post_parent' => $prev_post->ID,
                        'exclude'     => get_post_thumbnail_id(),
                        'orderby'     => 'menu_order',
                        'order'       => 'ASC'
                    ) );

                    if(count($prevattachments)>1){
                        for ( $i = 0; $i < 2 ; $i++) {
                            $attachment = $prevattachments[$i];
                            $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
                            $thumbimg = wp_get_attachment_image( $attachment->ID, 'thumbnail-size', true );
                            if(0 === $i%2) echo '<li class="' . $class . ' data-design-thumbnail">';
                            echo $thumbimg;
                            if(0 !== $i%2) echo '</li>';
                        }
                    }

                    ?></a>

                <?php endif; ?>



        </ul>
            </div>


        </div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php fantastics_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

