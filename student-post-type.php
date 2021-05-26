<?php
/**
 * Plugin Name: Student Post Type
 * Description: Adds a custom post type "student".
 * Author:      Aleks Ganev
 * Version:     1.0
 */

function ag_students_post_type() {
    $labels = array(
        'name'               => _x( 'Students', 'post type general name' ),
        'singular_name'      => _x( 'Student', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'book' ),
        'add_new_item'       => __( 'Add New Student' ),
        'edit_item'          => __( 'Edit Student' ),
        'new_item'           => __( 'New Student' ),
        'all_items'          => __( 'All Students' ),
        'view_item'          => __( 'View Student' ),
        'search_items'       => __( 'Search Students' ),
        'not_found'          => __( 'No students found' ),
        'not_found_in_trash' => __( 'No students found in the Trash' ), 
        'parent_item_colon'  => '’',
        'menu_name'          => 'Students'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our students and student specific data',
        'public'        => true,
        'menu_position' => 5,
        'supports'      => array( 
            'thumbnail', 
            'excerpt', 
            'title', 
            'editor' ),
        'taxonomies'  => array( 'category' ),
        'has_archive'   => true,
    );
    register_post_type( 'student', $args ); 
}
function ag_change_title_text( $title ) {
    $post_type = get_post_type();
 
    if  ( 'student' == $post_type ) {
         $title = 'Enter student name';
    }
 
    return $title;
}
 
add_filter( 'enter_title_here', 'ag_change_title_text' );
add_action( 'init', 'ag_students_post_type' );