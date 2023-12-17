<?php

// Show custom posts shortcode
function shortcode_posts( $atts ) {
    global $post;
 
    // Defining Shortcode's Attributes
    $shortcode_args = shortcode_atts(
                        array(
                            'cat' => null,
                            'category' => '',
                            'order' => 'DESC',
                            'order_type' => 'date',
                            'posts_num'=> -1,
                            'post_type' => 'post'
                        ), $atts);
    //default arguments
    $args = array(
        'cat' => $shortcode_args['cat'],
        'category_name' => $shortcode_args['category'],
        'order' => $shortcode_args['order'],
        'orderby' => $shortcode_args['order_type'],
        'posts_per_page'=> $shortcode_args['posts_num'],
        'post_type' => $shortcode_args['post_type'],
     );
    
    $content = "";
    
    // The Query
    $the_query = new WP_Query( $args );
    
    // The Loop
    if ( $the_query->have_posts() ) {
        //beginning of the shortcode element
        $content .= '<div class="custom-category-post-container">';
    
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            foreach((array)get_the_category() as $cat) :
                $content .= '<div class="custom-post-container cat-' . $cat->slug . '">';
                    $content .= '<div class="image-part">';
                        $content .= '<div class="image-container">';
                            $content .= '<img src="' . wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) . '" class="custom-post-image">';
                        $content .= '</div>';
                    $content .= '</div>';
                    $content .= '<div class="desc-part">';
                        $content .= '<h4 class="custom-post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
                        $content .= '<div class="custom-post-excerpt"><p>' . get_the_excerpt() . '</p></div>';
                    $content .= '</div>';
                $content .= '</div>';
            endforeach;
        }
    
        //closing the shortcode element
        $content .= '</div>';
    
    } else {
        $content .= '<h4 class="custom-no-content">No se encontraron publicaciones al respecto.</h4>';
    }
    /* Restore original Post Data */
    wp_reset_postdata();
    
    return $content;
}
add_shortcode( 'custom_posts_shortcodes', 'shortcode_posts' );

/*Show related posts*/
function custom_related_posts() {
         
    $content = "";

    $id = get_the_ID();  

    /*@ Get current post's categories */
    $categories = get_the_category($id); // Disabled this if you want tag wise posts 

    /*@ Get current post's Tags */
    // $categories = wp_get_post_tags($id); // Enable this for tags wise related posts


    if (!empty($categories)) {

        /*@ Pluck all categories Ids */
        $categories_ids = array_column( $categories, 'term_id' );

        $args = [
            'post_status'         => 'publish',
            'category__in'        => $categories_ids, // Disabled this if you want tag wise posts
            //'tag__in'        => $categories_ids, // Enable this for tag wise related posts
            'post__not_in'        => [ $id ], // Exclude Current Post
            'posts_per_page'      => 5, // Number of related posts to show
            'ignore_sticky_posts' => 1
        ];

        $the_query = new WP_Query( $args );

        if ( $the_query->have_posts() ) {

            $content .= '<div class="related_posts_list">';

            while ( $the_query->have_posts() ) {
                $the_query->the_post();

                $content .= '<div class="custom-post-container">';
                    $content .= '<div class="image-part">';
                        $content .= '<div class="image-container">';
                            $content .= '<img src="' . wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) . '" class="custom-post-image">';
                        $content .= '</div>';
                    $content .= '</div>';
                    $content .= '<div class="desc-part">';
                        $content .= '<h4 class="custom-post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
                    $content .= '</div>';
                $content .= '</div>';

            }

            $content .= '</div>';

        }
       
    }
    /* Restore original Post Data */
    wp_reset_postdata();

    return $content; 

}
add_shortcode('shortcode_related_posts', 'custom_related_posts');

// Show custom posts shortcode
function shortcode_categories() {

    $categories = get_categories( array(
        'orderby' => 'name',
        'order'   => 'ASC',
        'parent'  => 14,
    ) );

    $content = "";

    $content .= '<div class="category-menu-container">';
        $content .= '<h2 class="category-menu-heading" style="text-align: center;">';
            $content .= get_cat_name( $category_id = 14 );
            $content .= '</h2>';
            $content .= '<div class="custom-category-post-container">';

            foreach( $categories as $category ) {
                $category_link = sprintf( 
                    '<a href="%1$s" alt="%2$s">%3$s</a>',
                    esc_url( get_category_link( $category->term_id ) ),
                    esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
                    esc_html( $category->name )
                );

                $content .= '<div class="custom-post-container">';
                    /*$content .= '<div class="image-part">';
                        $content .= '<div class="image-container">';
                            $content .= sprintf( esc_html__( '%s', 'textdomain' ), $category->description );
                        $content .= '</div>';
                    $content .= '</div>';*/
                    $content .= '<div class="desc-part">';
                        $content .= '<h4 class="custom-post-title">' . sprintf( esc_html__( '%s', 'textdomain' ), $category_link ) . '</h4>';
                        $content .= '<div class="custom-post-excerpt"><p>' . sprintf( esc_html__( '%s', 'textdomain' ), $category->description ) . '</p></div>';
                    $content .= '</div>';
                $content .= '</div>';
            }
            $content .= '</div>';
 
        $content .= '</div>';
        return $content;

}
add_shortcode( 'show_categories', 'shortcode_categories' );

?>