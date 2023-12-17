<?php
function my_enqueue_styles_child_theme() {

    $parent_style = 'hello-elementor-theme-style';
    $child_style = 'aderet-child-theme-style';
    $custom_style = 'custom-style';
    
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version') );
	wp_enqueue_style( $custom_style, get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/custom.css' ) );
	wp_enqueue_style( $child_style, get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );

}
add_action( 'wp_enqueue_scripts', 'my_enqueue_styles_child_theme', 20 );

/*function my_login_logo() {

    wp_enqueue_style( 'login-custom-style', get_bloginfo('stylesheet_directory'). '/assets/css/login.css', array('login') );

}*/
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_custom_scripts() {
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array( 'jquery'),filemtime( get_stylesheet_directory() . '/assets/js/custom.js' ), false );
}
add_action( 'wp_enqueue_scripts', 'my_custom_scripts' ); 

?>