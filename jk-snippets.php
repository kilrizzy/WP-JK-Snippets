<?php
/**
 * Plugin Name: JK Snippets
 * Plugin URI: http://jeffkilroy.com
 * Description: Custom text / html snippet widgets
 * Version: 1.0.0
 * Author: Jeffrey Kilroy
 * Author URI: http://jeffkilroy.com
 * License: GPL2
 */

//Require JK PostDeveloper
if(!class_exists('WPDeveloper')){
    require_once( 'classes/WPDeveloper.php' );
}
$wpDeveloper = new WPDeveloper();
$wpDeveloper->verify();
if(!class_exists('Snippet')){
    require_once __DIR__.'/classes/Snippet.php';
}
//Create Post Type
add_action( 'init', 'jksnippets_init' );

function jksnippets_init(){
    //Shortcodes
    add_shortcode( 'snippet', 'jksnippets_display_snippet' );
}

function jksnippets_display_snippet( $atts ) {
    $a = shortcode_atts( array(
        'id' => false,
    ), $atts );
    $output = array();
    //
    $output[] = 'test';

    $output = implode("\n",$output);
    return $output;
}