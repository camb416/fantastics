<?php


/**
* FMAG_Widget_Latest_Focus
*
*/
class FMAG_Widget_Latest_Focus extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_latest_focuscover',
            'description' => __( "The most recent focus cover on your site") );

        /**
         * Register widget with wordpress
         */
        parent::__construct(
            'latest-focus', // Base ID
            __('Latest Focus Cover'),  // Name
            $widget_ops); // Args

        $this->alt_option_name = 'widget_latest_focuscover';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    public function widget($args, $instance) {
        $cache = wp_cache_get('widget_focus_cover', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Latest Focus' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 1;
        //if ( ! $number )
        $number = 1;
         //$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
         $show_date = false;
        $r = new WP_Query( apply_filters( 'widget_posts_args',
            array( 'posts_per_page' => $number,
                'no_found_rows' => true,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,
                'post_type' => 'fmag_cover',
                'tax_query' => array(
                    array(
                    'taxonomy' => 'term',
                    'field' => 'slug',
                    'terms' => array('focus')
                    )
                )
            ) ) );

           // var_dump($r);

        if ($r->have_posts()) :
        ?>
        <?php

            $before_widget =  $args['before_widget'];
            $before_title =  $args['before_title'];
            $after_title =  $args['after_title'];
            echo $before_widget; ?>

        <?php
            //  display title
             if ( $title ) echo $before_title . $title . $after_title;

            ?>
        <ul class="focuswidget">
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>

                    <?php
                    // working methods here:
                    // the_permalink()
                    // esc_attr( get_the_title() ? get_the_title() : get_the_ID() );
                    // <?php if ( get_the_title() ) the_title(); else the_ID();
                    // get_the_date();

                    // echo get_the_title();

                    $args = array(
                        'post_type' => 'attachment',
                        'numberposts' => 1,
                        'post_status' => null,
                        'post_parent' => get_the_ID()
                    );

                    $attachments = get_posts( $args );
                    if ( $attachments ) {
                        foreach ( $attachments as $attachment ) {
                            echo '<li><a href="'.get_the_permalink().'">';
                            echo wp_get_attachment_image( $attachment->ID, array(470,610) );
                            echo '</a></li>';
                        }
                    }
                    ?>

            <?php endwhile; ?>
        </ul>
        <?php
            $after_widget = $args['after_widget'];

            echo $after_widget; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_focus_cover', $cache, 'widget');

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = (bool) $new_instance['show_date'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_latest_focuscover']) )
            delete_option('widget_latest_focuscover');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_focus_cover', 'widget');
    }

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
    <?php
    }
}


// register Focus_Widget widget
function register_focus_widget() {
    register_widget( 'FMAG_Widget_Latest_Focus' );

}
add_action( 'widgets_init', 'register_focus_widget' );


/**
 * FMAG_Widget_Latest_Stories
 *
 */
class FMAG_Widget_Latest_Stories extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_latest_stories', 'description' => __( "The most recent stories on your site") );
        parent::__construct('latest-stories', __('Latest Stories'), $widget_ops);
        $this->alt_option_name = 'widget_latest_stories';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    public function widget($args, $instance) {
       $cache = wp_cache_get('widget_latest_stories', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);

        //$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Latest Stories' );
        $title = $instance['title'];
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
if ( ! $number )
        $number = 10;
        //$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $show_date = false;
        $r = new WP_Query( apply_filters( 'widget_posts_args',
            array( 'posts_per_page' => $number,
                'no_found_rows' => true,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,
                'post_type' => 'fmag_story',

            ) ) );

        // var_dump($r);

        if ($r->have_posts()) :
            ?>
            <?php

            $before_widget =  $args['before_widget'];
            $before_title =  $args['before_title'];
            $after_title =  $args['after_title'];
            $after_widget = $args['after_widget'];
            echo $before_widget; ?>

            <?php
            //  display title
            if ( $title ) echo $before_title . $title . $after_title;

            ?>
            <ul class="stories">
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                    <a href="<?php echo the_permalink() ?>">
                    <li class="story">


                        <?php
                        //echo get_the_title();
                        // working methods here:
                        // the_permalink()
                        // esc_attr( get_the_title() ? get_the_title() : get_the_ID() );
                        // <?php if ( get_the_title() ) the_title(); else the_ID();
                        // get_the_date();

                        // echo get_the_title();
                        //echo the_permalink();

                        $args = array(
                            'post_type' => 'attachment',
                            'numberposts' => 2,
                            'post_status' => null,
                            'post_parent' => get_the_ID(),
                            'order' => 'ASC'
                        );

                        $args = array(
                            'post_type' => 'attachment',
                            'posts_per_page' => -1,
                            'post_parent' => get_the_ID(),
                            'exclude'     => get_post_thumbnail_id(),
                            'orderby'     => 'menu_order',
                            'order'       => 'ASC'
                        );


                        $attachments = get_posts( $args );
                        if ( $attachments ) {
                            foreach ( $attachments as $attachment ) {
                                echo '';
                                echo wp_get_attachment_image( $attachment->ID );
                                //echo '<p>';
                                //echo apply_filters( 'the_title', $attachment->post_title );
                                echo '';
                            }
                        }
                        ?>
                        </li></a>
                <?php endwhile; ?>
            </ul>
            <?php echo $after_widget; ?>
<?php
// Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_latest_stories', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = (bool) $new_instance['show_date'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_latest_stories']) )
            delete_option('widget_latest_stories');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_latest_stories', 'widget');
    }

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
    <?php
    }
}





// register Latest_Stories widget
function register_latest_stories_widget() {
    register_widget( 'FMAG_Widget_Latest_Stories' );
}

add_action( 'widgets_init', 'register_latest_stories_widget' );



if (function_exists('register_sidebar')) {

    register_sidebar(array(
        'name'=> 'Cover Side',
        'id' => 'cover_side',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name'=> 'Index Intermission A',
        'id' => 'index_intermission_a',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name'=> 'Index Intermission b',
        'id' => 'index_intermission_b',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name'=> 'Index Intermission C',
        'id' => 'index_intermission_c',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name'=> 'Index Top-Side',
        'id' => 'index_top_side',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name'=> 'Index Mid-Side',
        'id' => 'index_mid_side',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name'=> 'Index Mid2-Side',
        'id' => 'index_mid2_side',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name'=> 'Index Bottom-Side',
        'id' => 'index_bottom_side',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name'=> 'Global Footer',
        'id' => 'global_footer',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

}




/**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'foo_widget', // Base ID
            __( 'Widget Title', 'text_domain' ), // Name
            array( 'description' => __( 'A Foo Widget', 'text_domain' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        echo __( 'Hello, World!', 'text_domain' );
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }

} // class Foo_Widget

// register Foo_Widget widget
function register_foo_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );




/////////////////////////////
// LATEST COVERS
/**
 * FMAG_Widget_Latest_Covers
 *
 */
class FMAG_Widget_Latest_Covers extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_latest_covers', 'description' => __( "The most recent covers on your site") );
        parent::__construct('latest-covers', __('Latest Covers'), $widget_ops);
        $this->alt_option_name = 'widget_latest_covers';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    public function widget($args, $instance) {
        $cache = wp_cache_get('widget_latest_covers', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }
        ob_start();
        extract($args);

$myterm = '';
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number )
            $number = 10;

        $postargs = array( 'posts_per_page' => $number,
            'no_found_rows' => true,
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
            'post_type' => 'fmag_cover',
            'offset' => 1


        );

        if ( isset ( get_queried_object()->taxonomy )
            && isset( get_queried_object()->name )
        )
        {
            $myterm = get_queried_object()->name;

            if($myterm == 'women' || $myterm == 'men'){
                // keep it
                $postargs = array( 'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'post_type' => 'fmag_cover',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'term',
                            'field'    => 'slug',
                            'terms'    => $myterm,
                        ),
                    ),

                );
            }
            /*
            return print $args['before_widget']
                . '<b style="padding:10px;border:3px solid red">'
                . get_queried_object()->name
                . '</b>'
                . $args['after_widget'];
            */
        }


        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Latest Covers' );

        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number )
            $number = 10;
        //$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $show_date = false;
        $r = new WP_Query( apply_filters( 'widget_posts_args',
            $postargs ) );

        // var_dump($r);

        if ($r->have_posts()) :
            ?>
            <?php
            $before_widget =  $args['before_widget'];
            $before_title =  $args['before_title'];
            $after_title =  $args['after_title'];
            echo $before_widget; ?>

            <?php
            //  display title
            echo $args['before_widget'];
            if ( $title ) echo $before_title . $title . $after_title;

            ?>
            <ul class="covers">
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>





                    <!-- a href="<?php echo the_permalink() ?>" -->
                        <li class="cover">


                            <?php
                            //echo get_the_title();
                            // working methods here:
                            // the_permalink()
                            // esc_attr( get_the_title() ? get_the_title() : get_the_ID() );
                            // <?php if ( get_the_title() ) the_title(); else the_ID();
                            // get_the_date();

                            // echo get_the_title();
                            //echo the_permalink();

                            $args = array(
                                'post_type' => 'attachment',
                                'numberposts' => 1,
                                'post_status' => null,
                                'post_parent' => get_the_ID(),
                                'order' => 'ASC'
                            );

                            $attachments = get_posts( $args );
                            if ( $attachments ) {
                                foreach ( $attachments as $attachment ) {
                                    echo '<a href="'.get_the_permalink().'">';
                                    echo wp_get_attachment_image( $attachment->ID, 'full' );
                                    //echo '<p>';
                                    //echo apply_filters( 'the_title', $attachment->post_title );
                                    echo '</a>';
                                }
                            }
                            ?>
                        </li><!--/a -->
                <?php endwhile; ?>
            </ul>
            <?php echo $after_widget; ?>
            <?php
// Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_latest_covers', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = (bool) $new_instance['show_date'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_latest_covers']) )
            delete_option('widget_latest_covers');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_latest_covers', 'widget');
    }

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
        <?php
    }
}
// register Latest_Stories widget
function register_latest_covers_widget() {
    register_widget( 'FMAG_Widget_Latest_Covers' );
}

add_action( 'widgets_init', 'register_latest_covers_widget' );
//////////////////