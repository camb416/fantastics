<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package fantastics
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
<div id="leftcol">
			<?php get_template_part( 'template-parts/content', 'fmag_cover-single' ); ?>
</div>
<div id="rightcol">
	<?php // share links ?>
	<h3 class="fmag-linkstyle-caps header">Share</h3>
	<!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_sharing_toolbox"></div>
	<?php get_template_part( 'template-parts/content', 'fmag_cover-single-relatedstory' ); ?>




			<?php // no navigation
			// the_post_navigation(); ?>


	<h3 class="fmag-linkstyle-caps header">More Covers</h3>
			<ul class="tinycovers">
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

					if(count($nextattachments)>0){
						for ( $i = 0; $i < 1 ; $i++) {
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

					if(count($prevattachments)>0){
						for ( $i = 0; $i < 1 ; $i++) {
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



			<?php
			/*
			 * // no comments
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			*/
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
