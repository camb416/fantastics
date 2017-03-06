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
 ?>

<?php get_header(); ?>

<?php

if ( is_paged() ):
    get_template_part('template-parts/content','gallery');
?>
    <hr />
    <?php get_sidebar();
else:
    get_template_part( 'template-parts/content', 'first-page' );
?><hr />
<?php 
endif;


 ?>

<?php get_footer(); ?>
