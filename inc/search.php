<?php

// breaking search results into groups...
// from http://wordpress.stackexchange.com/questions/14881/seperating-custom-post-search-results

add_filter('posts_orderby', 'group_by_post_type', 2, 2);
function group_by_post_type($orderby, $query) {
    global $wpdb;
    if ($query->is_search) {
        return $wpdb->posts . '.post_type DESC';
    }
// provide a default fallback return if the above condition is not true
    return $orderby;
}