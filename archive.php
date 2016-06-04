<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fantastics
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<a href="/" class="frontlink">&lt; Frontpage</a>
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="archive-wrap">
				<div class="archive-sidebar">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Archive Sidebar')) : ?>
						<!-- empty sidebar -->
					<?php endif; ?>
				</div>
				<div class="archive-stories">
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php

                $postType = get_post_type();
                if("fmag_story" === $postType){
                    echo '<div class="fmag_story wrapper">';

                    get_template_part( 'template-parts/content', get_post_type() );

                    echo "</div><!-- wrapper -->";

                } else if("fmag_cover" === $postType){
                    get_template_part( 'template-parts/content', get_post_type() );
                    //$myvar = locate_template('content.php');
                    //echo $myvar;
                    //include(locate_template('template-parts/content-fmag_story'));
                } else {
                    echo get_post_format();
                    get_template_part( 'template-parts/content', get_post_format() );
                }
				?>

			<?php endwhile; ?>
			</div>
			</div>
			<?php posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
