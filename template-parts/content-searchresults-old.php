<?php
/**
 * Created by PhpStorm.
 * User: cam
 * Date: 2/19/17
 * Time: 3:53 PM
 */
?>
<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


            <a href="/" class="frontlink">&lt; Frontpage</a>
		<?php if ( have_posts() ) : ?>

    <header class="page-header">
        <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'fantastics' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    </header><!-- .page-header -->

    <?php /* Start the Loop */ ?>
    <?php


    $last_type="";
    $typecount = 0;
    while ( have_posts() ) : the_post();

        if ($last_type != $post->post_type){
            $typecount = $typecount + 1;
            if ($typecount > 1){
                echo '</div><!-- result type -->'; //close type container
            }
            // save the post type.
            $last_type = $post->post_type;
            //open type container
            switch ($post->post_type) {
                case 'post':
                    echo "<div class=\" results searchtype-post\"><h2>Posts</h2>";
                    break;
                case 'page':
                    echo "<div class=\"results searchtype-pages\"><h2>Pages</h2>";
                    break;
                case 'fmag_story':
                    echo "<div class=\"results searchtype-story\"><h2>Stories</h2>";
                    break;
                default:
                    echo "<div class=\"results searchtype-cover\"><h2>Covers</h2>";
                    break;
                //add as many as you need.
            }
        }

        ?>




        <?php
        /**
         * Run the loop for the search to output the results.
         * If you want to overload this in a child theme then include a file
         * called content-search.php and that will be used instead.
         */
        //get_template_part( 'template-parts/content', 'search' );

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
    </div><!-- result type -->
    <?php posts_navigation(); ?>

<?php else : ?>

    <?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>

</main><!-- #main -->
</section><!-- #primary -->