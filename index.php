<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fantastics
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php /* Start the Loop */
            $i = 0;

            ?>

			<?php while ( have_posts() ) : the_post(); ?>
            <?php
            if($i%2===0){
                $orderClass = "even";
            } else {
                $orderClass = "odd";
            }
            ?>
<div class="fmag_story wrapper <?= $orderClass ?>">
				<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
                if("fmag_story" === get_post_type()){

                   get_template_part( 'template-parts/content', get_post_type() );
                   //$myvar = locate_template('content.php');
                    //echo $myvar;
                   //include(locate_template('template-parts/content-fmag_story'));
                } else {
                    get_template_part( 'template-parts/content', get_post_format() );
                }

               $i++;
				?>
</div>
			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
