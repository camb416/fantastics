<?php

/**
 * Breaking search results into groups.
 * from http://wordpress.stackexchange.com/questions/14881/seperating-custom-post-search-results
 * @param $orderby
 * @param $query
 * @return string
 */
function group_by_post_type($orderby, $query) {
    global $wpdb;
    if ($query->is_search) {
        return $wpdb->posts . '.post_type DESC';
    }
// provide a default fallback return if the above condition is not true
    return $orderby;
}
add_filter('posts_orderby', 'group_by_post_type', 2, 2);


/**
 * Limit Searches to Stories and Covers
 * @param $query
 * @return mixed
 */
function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('post_type', array('fmag_story', 'fmag_cover'));
    }
    return $query;
}

add_filter('pre_get_posts','SearchFilter');