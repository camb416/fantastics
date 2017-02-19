<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fantastics
 */

get_header();

get_template_part('template-parts/content','gallery');

?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
