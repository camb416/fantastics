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
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// gradient background
// TODO: deprecate this
if(false && 1 == $paged && is_front_page()): ?>
    <div id="index-stage"></div>

<?php endif; ?>

<?php
///////////////////////////////////////////////////
// Do the top bit
///////////////////////////////////////////////////
?>

<div class="lefty twocol top">

    <?php // top-main ?>

    <div class="primary">

            <?php

            // TODO: refactor this!



            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            // are we on page one?

            if(1 == $paged && is_front_page()): ?>




                <div class="bigcover">
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
                                    'terms' => array('focus'),
                                    'operator' => 'NOT IN'

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
                        echo "else";
                    } ?>



                    <?php
                    $wp_query = $mainQuery;
                    ?>
                </div>
</div>
	            <?php

	            echo '    <div class="secondary">';

	            // hiding social buttons
	            //
	            //        echo '        <div class="socialbuttons">
	            //
	            //
	            //    <p>Follow FANTASTICS on:</p>
	            //
	            //<a class="sb-f sb-f" href="https://twitter.com/fantasticsmag"><div class="sb-f sb-f-twi"></div>twitter</a>
	            //
	            //<a class="sb-f " href="http://www.facebook.com/pages/Fantastics/100542323355212"><div class="sb-f sb-f-fac"></div>facebook</a>
	            //
	            //<a class="sb-f" href="http://pinterest.com/fantasticsmag/"><div class="sb-f sb-f-pin"></div>pinterest</a>
	            //
	            //<a class="sb-f" href="http://fantasticsmag.tumblr.com/"><div class="sb-f sb-f-tum"></div>tumblr</a>
	            //
	            //<a class="sb-f" href="http://instagram.com/fantastics/"><div class="sb-f sb-f-ins"></div>instagram</a>
	            //
	            //
	            //        </div>';

	            wp_nav_menu( array( 'theme_location' => 'sidebarfronttop' ) );


//        echo '<div class="adspace">adspace</div> ';
	            echo ' </div>';

	            ?>


            <?php endif;  ?>
</div>
<div class="lefty twocol">
	<div class="primary">
    <!-- h2 class="cgef">Latest</h2 -->


        <div class="storyroll">

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


            if($i === 2 && 1 == $paged && is_front_page()){


                // close out the story roll div
                echo '</div>';
                // close out top main
                echo '</div>';


           // top-side


	            // MID SIDEBAR
	            echo '<div class="index-side">';

	            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Index Top-Side')){
		            // do nothing if not there
		            // echo "<!-- default stuff -->";
	            } else {
		            // display nothing if there is indeed a widget.
		            //echo "do something";
	            }
	            echo '</div>';


    if(1 == $paged && is_front_page()){

        // close out the whole top
        echo '</div>';
    }









                // do the first intermission
                echo '<div class="intermission-a">';
                //echo '<div class="intermission-outer"><div class="intermission">';
                if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Index Intermission A')){
                    // do nothing if not there
                    // echo "default stuff";
                }
                echo '</div>'; // close intermission


                echo '<div class="righty twocol">';
                echo '<div class="primary">';
                // echo ' <h2 class="cgef">Latest</h2>';
                echo '<div class="storyroll">';

            } elseif($i === 4 && 1 == $paged){
                // close story roll
                echo '</div>';
                // close mid main
                echo '</div>';
                // TODO: do the mid sidebar

                // MID SIDEBAR
                    echo '<div class="index-side">';
                if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Index Mid-Side')){
                    // do nothing if not there
                    // echo "<!-- default stuff -->";
                } else {
                    // display nothing if there is indeed a widget.
                    //echo "do something";
                }
                    echo '</div>';

                // close the mid container
                echo '</div>';


                // do the second intermission
                echo '<div class="intermission-b">';
                //echo '<div class="intermission-outer"><div class="intermission">';
                if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Index Intermission B')){
                    // do nothing if not there
                    //echo "default stuff";
                }
                echo '</div>'; // close intermission


                // open the bottom container
                echo '<div class="lefty 2 twocol">';
                // open the bottom main
                echo '<div class="primary">';
                //echo ' <h2 class="cgef">Latest</h2>';
                // open the story roll
                echo '<div class="storyroll">';

            } elseif($i === 6 && 1 == $paged){
                // close story roll
                echo '</div>';
                // close mid main
                echo '</div>';
                // TODO: do the bottom sidebar

                echo '<div class="index-side">';
                if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Index Mid2-Side')){
                    // do nothing if not there
                    // echo "default stuff";
                } else {
                    // display nothing if there is indeed a widget.
                    //echo "do something";
                }
                echo '</div>';



                // close the mid container
                echo '</div>';


                // do the third intermission
                echo '<div class="intermission-c">';
                //echo '<div class="intermission-outer"><div class="intermission">';
                if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Index Intermission C')){
                    // do nothing if not there
                    //echo "default stuff";
                }
                echo '</div>'; // close intermission


                // open the bottom container
                echo '<div class="lefty twocol">';
                // open the bottom main
                echo '<div class="primary">';
	            //echo ' <h2 class="cgef">Latest</h2>';
                // open the story roll
                echo '<div class="storyroll">';
            }

            ?>



            <?php




            /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
            if("fmag_story" === get_post_type()){ ?>
            <div class="fmag_story wrapper <?= $orderClass ?>">
                <?php
                get_template_part( 'template-parts/content', get_post_type() );
                echo "</div>";
                //$myvar = locate_template('content.php');
                //echo $myvar;
                //include(locate_template('template-parts/content-fmag_story'));
                } else {
                    get_template_part( 'template-parts/content', get_post_format() );
                }

                $i++;
                ?>




                <?php endwhile; ?>

                <div class="athing"></div>

                <?php posts_navigation(); ?>

                <?php else : ?>

                    <?php get_template_part( 'template-parts/content', 'none' ); ?>

                <?php endif; ?>






            <!--
            <article>article</article>
            <article>article</article> -->

        </div><?php // close story roll ?>




    </div><?php // close primary ?>
<?php
 echo '<div class="index-side">';
if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Index Bottom-Side')){
                    // do nothing if not there
                    // echo "default stuff";
                } else {
                    // display nothing if there is indeed a widget.
                    //echo "do something";
                }
                 echo '</div>';
                ?>







 </div>
    <?php
///////////////////////////////////////////////////
// Intermission A
///////////////////////////////////////////////////

//intermission A

///////////////////////////////////////////////////
// Middle
///////////////////////////////////////////////////

// mid-main

// mid-side


///////////////////////////////////////////////////
// Intermission B
///////////////////////////////////////////////////

// intermission b

///////////////////////////////////////////////////
// Bottom
///////////////////////////////////////////////////

// bottom-main

// bottom-side

///////////////////////////////////////////////////
// Footer
///////////////////////////////////////////////////

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">




		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
