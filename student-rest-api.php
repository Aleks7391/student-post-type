<?php

//Endpoint to get all the students
function ag_rest_all_students_callback( $data ) {
	
	$posts = get_posts( array(
		'post_type' => 'student'
	));
	
	if ( empty( $posts ) ) {
		return null;
	}
	return $posts;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'students', '/all', array(
		'methods' => 'GET',
		'callback' => 'ag_rest_all_students_callback',
		'permission_callback' => function () {
			return current_user_can( 'edit_others_posts' );
		},
	));
});

//Endpoint to get a student by ID
function ag_rest_student_by_id_callback( $data ) {
	$posts = get_posts( array(
		'post_type' => 'student',
		'p' => $data['id'],
	));
	
	if ( empty( $posts ) ) {
		return null;
	}

	return $posts[0];
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'students', '/id/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'ag_rest_student_by_id_callback',
		'args' => array(
		'id' => array(
		'validate_callback' => 'is_numeric'),
			),
		),
	);
});

//Endpoint to delete a student by id
function ag_rest_delete_student_callback( $data ) {
	return wp_delete_post( $data['id'] );
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'students/delete', '/id/(?P<id>\d+)', array(
		'methods' => 'DELETE',
		'callback' => 'ag_rest_delete_student_callback',
		'id' => array(
			'validate_callback' => 'is_numeric'
			),
		'permission_callback' => function () {
			return current_user_can( 'edit_others_posts' );
		},
	));
});

//Endpoint to delete a student by id
function ag_rest_add_student_callback( $data ) {
	$postarr = array(
		'post_type' => 'student',
		'post_title' => $_POST['post_title'],
		'post_content' => $_POST['post_content'],
		'post_status' => 'publish'
	);
	$post_id = wp_insert_post( $postarr );
		return "Successfully added a post with ID =>" . $post_id;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'students', '/add', array(
		'methods' => 'POST',
		'callback' => 'ag_rest_add_student_callback',
		'permission_callback' => function () {
			return current_user_can( 'edit_others_posts' );
		},
	));
});

//Endpoint to edit a student by id
function ag_rest_edit_student_callback( $data ) {
	$postarr = array(
		'p' => $data['id'],
		'post_title' => $_POST['post_title'],
		'post_content' => $_POST['post_content'],
	);
	
	$post_id = wp_update_post( $postarr );
	return $post_id;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'students', '/edit/(?P<id>\d+)', array(
		'methods' => 'PUT',
		'callback' => 'ag_rest_edit_student_callback',
		'id' => array(
			'validate_callback' => 'is_numeric'
			),
		'permission_callback' => function () {
			return current_user_can( 'edit_others_posts' );
		},
	));
});