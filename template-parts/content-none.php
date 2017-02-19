<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fantastics
 */

?>
<section class="no-results not-found">
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
                    get_template_part( 'template-parts/content', 'fmag_cover-single' );



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

                        get_template_part('template-parts/content', 'fmag_cover-single');


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
            $cat_identifier = "Archive";
        } else if(is_paged()){
            $cat_identifier = "Listing"; // display nothing if you get there via "more stories"
        }
        ?>

        <div class="category-identifier"><?php echo($cat_identifier); ?></div>


		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'fantastics' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'fantastics' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fantastics' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fantastics' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>

	</div><!-- .page-content -->
    <hr />
</section><!-- .no-results -->
