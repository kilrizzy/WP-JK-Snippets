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
    jksnippets_create_snippet_post_type();
    //Shortcodes
    add_shortcode( 'snippet', 'jksnippets_display_snippet' );
}

function jksnippets_create_snippet_post_type(){
    $postType = new PostType();
    $postType->name = 'jksnippet';
    $postType->urlSlug = 'snippet';
    $postType->labelPlural = 'Snippets';
    $postType->labelSingular = 'Snippet';
    $postType->iconCSSContent = '\f475';
    $postType->supports = array(
        'title',
        'page-attributes'
    );
    $postType->addCustomField([
        'label' => 'Snippet',
        'name' => 'snippet',
        'type' => 'textarea',
        'sanitize' => 'none',
    ]);
    $postType->create();
}

function jksnippets_display_snippet( $atts ) {
    $a = shortcode_atts( array(
        'id' => false,
        'slug' => false,
    ), $atts );
    $output = array();
    $snippet = false;
    if(!empty($a['id'])){
        $snippet = new Snippet($a['id']);
    }else if(!empty($a['slug'])){
        $snippet = new Snippet();
        $snippet->getBySlug($a['slug']);
        if(!$snippet->post){
            $output[] = 'snippet: "'.$a['slug'].'" Not found';
        }
    }
    if($snippet){
        $output[] = $snippet->snippet;
    }
    $output = implode("\n",$output);
    return $output;
}