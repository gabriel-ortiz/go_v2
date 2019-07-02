<?php

/**
 * Converts and console logs data from PHP on the front end
 *
 * @param $data to log, $title
 *
 * @todo - set up hook for displaying on admin side
 *
 * @return array|mixed|string|\WP_Error
 */
function debug_to_console( $data, $title = null) {
    //check for title and localize arguments
    $fn_title = !empty( $title ) ? $title : 'From WP';
    $fn_data = $data;
    add_action( (is_admin() ? 'admin_footer' : 'wp_footer'), function() use ($fn_title, $fn_data){
        if( is_array($fn_data) || is_object($fn_data) ) {
            echo "<script>
					if(console.debug!='undefined'){
						console.log('{$fn_title}:' , ". json_encode($fn_data) .");
					}</script>" ;
        } else {
            echo "<script>
					if(console.debug!='undefined'){	
						console.log('{$fn_title}: ".$fn_data."');
					}</script>" ;
        }
    } );
}

/**
 *
 * Converts regular string to camelcase
 *
 * @param string $str
 * @param array $noStrip
 * @return mixed|null|string|string[]
 */
function camelCase( $str, $noStrip = [])
{
    // non-alpha and non-numeric characters become spaces
    $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
    $str = trim($str);
    // uppercase the first character of each word
    $str = ucwords($str);
    $str = str_replace(" ", "", $str);
    $str = lcfirst($str);
    return $str;
}
/**
 *
 * Converts an array to a json string, useful for adding json to data attributes
 *
 * @param array $array
 *
 * @return strng
 *
 */
function array_to_json_string( $array = array() ){
    $json_stringified = null;
    if( is_array( $array ) ){
        $json_stringified = htmlspecialchars(json_encode($array), ENT_QUOTES, 'UTF-8' );
        return $json_stringified;
    }
}
/**
 * Get post by slug
 *
 * @param string $slug The post's slug.
 * @param string $type The post's type
 *
 * @return object
 */
function get_post_by_slug( $slug, $type = 'post' ) {
    $posts = new \WP_Query( array(
        'name'                => $slug,
        'posts_per_page'      => 1,
        'post_type'           => $type,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true
    ) );
    if ( ! $posts ) {
        return null;
    }
    return $posts;
}
/**
 *
 * Uses WP's option functionality to merge data, this way data for this option is never lost
 *
 * @param $option_name
 * @param $new_data
 * @return array|mixed|null
 */
function merge_wp_option_array($option_name, $new_data ){
    //get option and check for value
    $option_cache = get_option( $option_name );
    $output = array();
    if( ! $option_name ){
        return null;
    }
    if( is_array( $option_cache ) && is_array( $new_data) ){
        $output = array_unique( array_merge( $option_cache, $new_data ) );
    }elseif( is_array( $option_cache )  ){
        $output = array_push( $option_cache, $new_data );
    }
    update_option( $option_name, $output );
    return $output;
}
/**
 *
 * Checks if a key exists an array and return that keys val
 *
 * @param array $arr
 * @param $key
 * @return bool
 */
function multiKeyExists(array $arr, $key) {
    // is in base array?
    if (array_key_exists($key, $arr)) {
        return $arr[$key];
    }
    // check arrays contained in this array
    foreach ($arr as $element) {
        if (is_array($element)) {
            if (multiKeyExists($element, $key)) {
                return $element[$key];
            }
        }
    }
    return false;
}
/**
 *
 * Same version of a recursive search function, only using native PHP iterators
 *
 * @param array $array
 * @param string $needle
 * @return array
 */
function recursiveFind(array $array, string $needle)
{
    $iterator  = new RecursiveArrayIterator($array);
    $recursive = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
    $aHitList = array();
    foreach ($recursive as $key => $value) {
        if ($key === $needle) {
            array_push($aHitList, $value);
        }
    }
    return $aHitList;
}
/**
 * Recursively searches array for key and returns value
 *
 * NOTE: this function will return the first match
 *
 * @param string $needle_key
 * @param array $array
 * @return bool|mixed
 */
function array_search_key( $needle_key,  $array ) {
    if( !is_array( $array ) ) {
        return false;
    }
    foreach( $array AS $key=>$value){
        if( (string) $key == (string) $needle_key) {
            return $value;
        }
        if(is_array($value) ){
            ($result = array_search_key($needle_key,$value));
            if( $result ){
                return $result;
            }
        }
    }
    return false;
}