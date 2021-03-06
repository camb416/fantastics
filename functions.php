<?php
/**
 * fantastics functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package fantastics
 */

if ( ! function_exists( 'fantastics_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function fantastics_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on fantastics, use a find and replace
         * to change 'fantastics' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'fantastics', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Menu', 'fantastics' ),
            'sidebarfronttop' => esc_html__( 'Sidebar Front Top', 'fantastics' ),
            'undercover' => esc_html__('Under Front Cover', 'fantastics')
        ) );




        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'fantastics_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );
    }
endif; // fantastics_setup
add_action( 'after_setup_theme', 'fantastics_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fantastics_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'fantastics_content_width', 850 );
}
add_action( 'after_setup_theme', 'fantastics_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fantastics_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'fantastics' ),
        'id'            => 'sidebar-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Archive Sidebar', 'fantastics' ),
        'id'            => 'sidebar-2',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'fantastics_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fantastics_scripts() {

    wp_enqueue_style('fantastics-icons', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');

    wp_enqueue_style( 'fantastics-fonts', 'https://fonts.googleapis.com/css?family=News+Cycle:400,700');

    wp_enqueue_style( 'fantastics-style', get_stylesheet_uri(), array(), '20170416' );

    wp_enqueue_script( 'fantastics-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

    wp_enqueue_script( 'fantastics-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

    wp_enqueue_script( 'fantastics-index', get_template_directory_uri() . '/js/fmag-index.js', array('jquery'), '20170416', true);


    if ( is_singular('fmag_story')){
        wp_enqueue_script( 'fantastics-single', get_template_directory_uri() . '/js/single-fmag_story.js', array('jquery'), '20170308', true );
    }
    if(is_singular('fmag_cover')){
        wp_enqueue_script( 'fantastics-single-cover', get_template_directory_uri() . '/js/single-fmag_cover.js', array('jquery'), '20170308', true );

    }

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    if(is_archive() || is_search() || is_paged()){
        wp_enqueue_script('fantastics-archive',get_template_directory_uri() . '/js/archive.js', array('jquery'), '20170308', true);
    }
}

add_filter( 'pre_get_posts', 'fantastics_get_posts' );

function fantastics_get_posts( $query ) {

    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'fmag_story' ) );

    return $query;
}

// Add the Events Meta Boxes
function add_story_metaboxes() {

    add_meta_box('fmag_legacy_id', 'Legacy Drupal Node ID', 'fmag_legacy_id', 'fmag_story', 'side', 'default');
    add_meta_box('fmag_layout', 'Story Layout', 'fmag_layout', 'fmag_story', 'side', 'default');

}
// Add the Events Meta Boxes
function add_cover_metaboxes() {

    add_meta_box('fmag_storyref_id', ' Story Post ID', 'fmag_storyref_id', 'fmag_cover', 'side', 'default');
    add_meta_box('fmag_legacy_id', 'Legacy Drupal Node ID', 'fmag_legacy_id', 'fmag_cover', 'side', 'default');
    add_meta_box('fmag_legacy_storyref_id', 'Legacy Drupal Story ID', 'fmag_legacy_storyref_id', 'fmag_cover', 'side', 'default');


}

function fmag_layout($post){
    global $post;
    wp_nonce_field( basename( __FILE__ ), 'fmag_layout_metabox_nonce' );
    ?>
    <p>
        <label for="my_meta_box_post_type">Columns: </label>
        <select name='fmag_layout' id='fmag_layout'>
                <option value="2" <?php if(get_post_meta( $post->ID, 'fmag_layout', true ) == "2") echo "selected=\"selected\""; ?> >2</option>
            <option value="1" <?php if(get_post_meta( $post->ID, 'fmag_layout', true ) == "1") echo "selected=\"selected\""; ?> >1</option>
        </select>
    </p>
    <?php
}
add_action('save_post', 'fmag_layout_save_meta', 10,2);

function fmag_layout_save_meta($post_id, $post){
    /* Verify the nonce before proceeding. */
    if ( !isset( $_POST['fmag_layout_metabox_nonce'] ) || !wp_verify_nonce( $_POST['fmag_layout_metabox_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_meta_value = ( isset( $_POST['fmag_layout'] ) ? sanitize_html_class( $_POST['fmag_layout'] ) : '' );

    /* Get the meta key. */
    $meta_key = 'fmag_layout';

    /* Get the meta value of the custom field key. */
    $meta_value = get_post_meta( $post_id, $meta_key, true );

    /* If a new meta value was added and there was no previous value, add it. */
    if ( $new_meta_value && '' == $meta_value )
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );

    /* If the new meta value does not match the old value, update it. */
    elseif ( $new_meta_value && $new_meta_value != $meta_value )
        update_post_meta( $post_id, $meta_key, $new_meta_value );

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ( '' == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, $meta_key, $meta_value );
}

// The Event Location Metabox

function fmag_legacy_id() {
    global $post;

    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

    // Get the location data if its already been entered
    $legacyID = get_post_meta($post->ID, 'legacy_id', true);

    // Echo out the field
    echo '<input type="text" name="legacy_id" value="' . $legacyID  . '" class="widefat" readonly />';

}
function fmag_legacy_storyref_id() {
    global $post;

    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

    // Get the location data if its already been entered
    $legacyID = get_post_meta($post->ID, 'legacy_storyref_id', true);

    // Echo out the field
    echo '<input type="text" name="legacy_storyref_id" value="' . $legacyID  . '" class="widefat" readonly />';
}

function fmag_storyref_id() {
    global $post;

    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

    // Get the location data if its already been entered
    $storyID = get_post_meta($post->ID, 'storyref_id', true);

    // Echo out the field
    echo '<input type="text" name="storyref_id" value="' . $storyID  . '" class="widefat" />';
}


add_action( 'add_meta_boxes', 'add_story_metaboxes' );
add_action( 'add_meta_boxes', 'add_cover_metaboxes' );



add_action( 'wp_enqueue_scripts', 'fantastics_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/* === Add Thumbnails to Posts/Pages List === */
if ( !function_exists('o99_add_thumbs_column_2_list') && function_exists('add_theme_support') ) {

    //  // set your post types , here it is post and page...
    add_theme_support('post-thumbnails', array( 'post', 'page' ) );

    function o99_add_thumbs_column_2_list($cols) {

        $cols['thumbnail'] = __('Thumbnail');

        return $cols;
    }

    function o99_add_thumbs_2_column($column_name, $post_id) {

        $w = (int) 60;
        $h = (int) 60;

        if ( 'thumbnail' == $column_name ) {
            // back comp x WP 2.9
            $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
            // from gal
            $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
            if ($thumbnail_id)
                $thumb = wp_get_attachment_image( $thumbnail_id, array($w, $h), true );
            elseif ($attachments) {
                foreach ( $attachments as $attachment_id => $attachment ) {
                    $thumb = wp_get_attachment_image( $attachment_id, array($w, $h), true );
                }
            }
            if ( isset($thumb) && $thumb ) {
                echo $thumb;
            } else {
                echo __('None');
            }
        }
    }

    // for posts
    add_filter( 'manage_posts_columns', 'o99_add_thumbs_column_2_list' );
    add_action( 'manage_posts_custom_column', 'o99_add_thumbs_2_column', 10, 2 );

    // for pages
    add_filter( 'manage_pages_columns', 'o99_add_thumbs_column_2_list' );
    add_action( 'manage_pages_custom_column', 'o99_add_thumbs_2_column', 10, 2 );
}

function fantastics_filter_post_tag_term_links( $term_links ) {
    $wrapped_term_links = array();
    foreach ( $term_links as $term_link ) {
        $wrapped_term_links[] = $var = preg_replace('/[ ](?=[^>]*(?:<|$))/', '&nbsp', $term_link);
    }
    return $wrapped_term_links;
}
add_filter( 'term_links-fashion', 'fantastics_filter_post_tag_term_links' );
add_filter( 'term_links-term', 'fantastics_filter_post_tag_term_links' );

require_once('inc/widgets.php'); // widgets
require_once('inc/search.php'); // search

// add footer menu location
function register_my_menu() {
    register_nav_menu('footer-menu',__( 'Footer Menu' ));
}
add_action( 'init', 'register_my_menu' );

// remove "tagged with:" in the archive title
// Simply remove anything that looks like an archive title prefix ("Archive:", "Foo:", "Bar:").
add_filter('get_the_archive_title', function ($title) {
    $output = preg_replace('/[^\:]+: /', '', $title);
    return $output;
});

// only show stories in term archive
add_filter( 'pre_get_posts', 'slug_cpt_category_archives' );
function slug_cpt_category_archives( $query )
{

    if ( $query->is_tax() && $query->is_main_query()  )  {
        $query->set( 'post_type',
            array(
                'fmag_story'
            )
        );
    }

    return $query;
}


// Posts to Posts stuff
function my_connection_types() {
    p2p_register_connection_type( array(
        'name' => 'cover_to_story',
        'from' => 'fmag_cover',
        'to' => 'fmag_story'
    ) );
}
add_action( 'p2p_init', 'my_connection_types' );


// override posts per page on archive tag pages
function fmag_tag_posts_per_page( $query ) {
    if( $query->is_archive() && $query->is_main_query()) {
        $query->set( 'posts_per_page', 12 );
    }
}
add_action( 'pre_get_posts', 'fmag_tag_posts_per_page' );

// allow newline in widget title
function fmag_widget_title( $title ) {
    $title = str_replace( '\n', '<br/>', $title );
    return $title;
}
add_filter( 'widget_title', 'fmag_widget_title' );


// hide some shit on the admin
add_action( 'admin_menu', 'my_remove_menu_pages' );

function my_remove_menu_pages() {
    remove_menu_page('edit.php');
    remove_menu_page('tools.php');
    remove_menu_page('edit-comments.php');
}

// ---------------------------
// RIP Fantasticsmag 2005–2019
// Sleep well
// ---------------------------

add_action( 'template_redirect', 'redirect_non_logged_users_to_specific_page' );

function redirect_non_logged_users_to_specific_page() {

    if ( !is_user_logged_in() && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php' ) {

        wp_redirect( 'http://www.usefuldynamics.com', 301 );
        exit;
    }
}