<?php

/**
* FMAG_Widget_Latest_Focus
*
*/
class FMAG_Widget_Latest_Focus extends WP_Widget {

function __construct() {
$widget_ops = array('classname' => 'widget_latest_focuscover', 'description' => __( "The most recent focus cover on your site") );
parent::__construct('recent-posts', __('Latest Focus Cover'), $widget_ops);
$this->alt_option_name = 'widget_latest_focuscover';

add_action( 'save_post', array($this, 'flush_widget_cache') );
add_action( 'deleted_post', array($this, 'flush_widget_cache') );
add_action( 'switch_theme', array($this, 'flush_widget_cache') );
}

function widget($args, $instance) {
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
<?php echo $before_widget; ?>

<?php
    //  display title
     if ( $title ) echo $before_title . $title . $after_title;

    ?>
<ul>
    <?php while ( $r->have_posts() ) : $r->the_post(); ?>
        <li>
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
                    echo '<li>';
                    echo wp_get_attachment_image( $attachment->ID, array(320) );
                    echo '<p>';
                    echo apply_filters( 'the_title', $attachment->post_title );
                    echo '</p></li>';
                }
            }
            ?>
        </li>
    <?php endwhile; ?>
</ul>
<?php echo $after_widget; ?>
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


// register Foo_Widget widget
function register_focus_widget() {
    register_widget( 'FMAG_Widget_Latest_Focus' );
}
add_action( 'widgets_init', 'register_focus_widget' );



if (function_exists('register_sidebar')) {

    register_sidebar(array(
        'name'=> 'Index Intermission',
        'id' => 'index_intermission',

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}