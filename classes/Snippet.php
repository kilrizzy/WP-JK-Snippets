<?php

class Snippet{
    public $id;
    public $title;
    public $date;
    public $imageURL;
    public $post;
    public $postUrl;
    public $url;
    public $snippet;

    public function __construct($post=false){
        if($post){
            $this->post = $post;
            $this->setupFromPost();
        }
    }

    public function setupFromPost(){
        $this->id = $this->post->ID;
        $this->title = $this->post->post_title;
        $this->date = $this->post->post_date;
        $this->postUrl = get_post_permalink($this->id);
        $this->snippet = get_post_meta($this->id,'snippet',true);
    }

    public function getMostRecent(){
        $args = array(
            'post_type' => 'jksnippet',
            'posts_per_page' => '1',
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            $this->post = $query->posts[0];
            $this->setupFromPost();
        }
    }

    public function getByPostId($id){
        $args = array(
            'post_type' => 'jksnippet',
            'posts_per_page' => '1',
            'p' => $id
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            $this->post = $query->posts[0];
            $this->setupFromPost();
        }
    }

    public function getBySlug($slug){
        $this->post = get_page_by_path( $slug, OBJECT, 'jksnippet' );
        if($this->post) {
            $this->setupFromPost();
        }
    }

    public static function getAll($argOverrides=array()){
        $posts = array();
        $args = array(
            'post_type' => 'jksnippet',
            'posts_per_page' => '-1',
        );
        $args = array_merge($args, $argOverrides);
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $posts[] = new Banner($query->post);
            }
        }
        return $posts;
    }

}