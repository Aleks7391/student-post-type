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

//           Meta Boxes

//Lives in meta box
function ag_add_lives_in_meta_box() {
    $screens = [ 'student' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'ag_lives_in_box',              // Unique ID
            'Lives in: ',                   // Box title
            'ag_lives_in_meta_box_html',    // Content callback, must be of type callable
            $screen                         // Post type
        );
    }
}

add_action( 'add_meta_boxes', 'ag_add_lives_in_meta_box' );

function ag_lives_in_meta_box_html( $post ) {
    $country_value = get_post_meta( $post->ID, '_ag_country_meta', true );
    $city_value = get_post_meta( $post->ID, '_ag_city_meta', true );
    ?>
    <label for="ag_city_field">Country:</label>
    <input name="ag_country_field" id="ag_country_field" type="text" value="<?php echo $country_value ?>" placeholder="Country...">
    <br>
    <br>
    <label for="ag_city_field">City:</label>
    <input name="ag_city_field" id="ag_city_field" type="text" value="<?php echo $city_value ?>" placeholder="City...">
    <?php
}

//Address meta box
function ag_add_address_meta_box() {
    $screens = [ 'student' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'ag_address_box',              // Unique ID
            'Address: ',                   // Box title
            'ag_address_meta_box_html',    // Content callback, must be of type callable
            $screen                        // Post type
        );
    }
}

add_action( 'add_meta_boxes', 'ag_add_address_meta_box' );

function ag_address_meta_box_html( $post ) {
    $value = get_post_meta( $post->ID, '_ag_address_meta', true );
    ?>
    <label for="ag_city_field">Address:</label>
    <input name="ag_address_field" id="ag_address_field" type="text" value="<?php echo $value ?>">
    </input>
    <?php
}

//Date of birth meta box
function ag_add_birthday_meta_box() {
    $screens = [ 'student' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'ag_birthday_box',             // Unique ID
            'Date of Birth: ',             // Box title
            'ag_birthday_meta_box_html',   // Content callback, must be of type callable
            $screen                        // Post type
        );
    }
}

add_action( 'add_meta_boxes', 'ag_add_birthday_meta_box' );

function ag_birthday_meta_box_html( $post ) {
    $value = get_post_meta( $post->ID, '_ag_birthday_meta', true );
    ?>
    <label for="ag_city_field">Enter your birthday:</label>
    <input name="ag_birthday_field" id="ag_birthday_field" type="date" value="<?php echo $value ?>">
    </input>
    <?php
}

//Grade meta box
function ag_add_grade_meta_box() {
    $screens = [ 'student' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'ag_grade_box',              // Unique ID
            'Grade: ',                   // Box title
            'ag_grade_meta_box_html',    // Content callback, must be of type callable
            $screen                      // Post type
        );
    }
}

add_action( 'add_meta_boxes', 'ag_add_grade_meta_box' );

function ag_grade_meta_box_html( $post ) {
    $value = get_post_meta( $post->ID, '_ag_grade_meta', true );
    ?>
    <input name="ag_grade_field" id="ag_grade_field" type="text" value="<?php echo intval( $value ) ?>" placeholder="grade / Grade...">
    <?php
}

//Status meta box
function ag_add_status_meta_box() {
    $screens = [ 'student' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'ag_status_box',              // Unique ID
            'Active: ',                   // Box title
            'ag_status_meta_box_html',    // Content callback, must be of type callable
            $screen                       // Post type
        );
    }
}

add_action( 'add_meta_boxes', 'ag_add_status_meta_box' );

function ag_status_meta_box_html( $post ) {
    $value = get_post_meta( $post->ID, '_ag_status_meta', true );
    ?>
    <input name="ag_status_field" id="ag_status_field" type="checkbox" value="1" <?php checked( $value, 1, true ); ?>>
    <?php
}

//Save all meta boxes
function ag_save_meta_data( $post_id ) {
    if ( array_key_exists( 'ag_country_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_ag_country_meta',
            sanitize_meta( '_ag_country_meta', $_POST['ag_country_field'], 'post' )
        );
    }

    if ( array_key_exists( 'ag_city_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_ag_city_meta',
            sanitize_meta( '_ag_city_meta', $_POST['ag_city_field'], 'post' )
        );
    }

    if ( array_key_exists( 'ag_address_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_ag_address_meta',
            sanitize_meta( '_ag_address_meta', $_POST['ag_address_field'], 'post' )

        );
    }

    if ( array_key_exists( 'ag_birthday_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_ag_birthday_meta',
            $_POST['ag_birthday_field']
        );
    }

    if ( array_key_exists( 'ag_grade_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_ag_grade_meta',
            sanitize_meta( '_ag_grade_meta', $_POST['ag_grade_field'], 'post' )
        );
    }

    if ( array_key_exists( 'ag_status_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_ag_status_meta',
            $_POST['ag_status_field']
        );
    } else {
        delete_post_meta( $post_id, "_ag_status_meta" );
    }
}

//Status checkbox in students admin page
add_filter('manage_student_posts_columns', function( $columns ) {
	$columns['status'] = __( 'Active' );
	return $columns;
});

add_action( 'save_post', 'ag_save_meta_data' );

add_action('manage_student_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'status') {
        $value = get_post_meta( $post_id, '_ag_status_meta', true );
        ?>
		<input type="checkbox" class="ag_status_meta_admin" value="1" <?php checked( $value, 1 ); ?>>
        <?php
	}
}, 10, 2);

add_action("wp_ajax_ag_update_active_status", "ag_update_active_status");

function ag_update_active_status() {
    $post_id = $_POST['post_id'];
    if ( get_post_meta( $post_id, '_ag_status_meta', true ) ) {
        delete_post_meta( $post_id, "_ag_status_meta" );
    } else {
        update_post_meta(
            $post_id,
            '_ag_status_meta',
            1
        );
    }
    wp_die();
}

add_action( 'admin_init', 'ag_custom_post_type_student_enqueuer' );

function ag_custom_post_type_student_enqueuer() {
   wp_register_script( "student_post_type_script", WP_PLUGIN_URL.'/student-post-type/student_post_type_script.js', array('jquery') );
   wp_localize_script( 'student_post_type_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'student_post_type_script' );
}

//Shortcode

function ag_student_shortcode( $atts ) {

    if ( $atts == "" ) {
        return;
    }
    $post_id = $atts['id'];
    $args = array(
        'p'           => $post_id,
        'post_type'   => 'student',
        'meta_query'  => array(
            'key'     => '_ag_status_meta',
            'value'   => '1',
            'compare' => '=',
        )
    );
    $query = new WP_Query( $args );

    if ( $query->have_posts() ) : 
        while ( $query->have_posts() ) : $query->the_post(); 
            $info = '<div style="text-align: center">';
            $info .= '~~~~~~~~~~~~~~~Shortcode~~~~~~~~~~~~~~~';
            $info .= '<br>';
            $info .= get_the_post_thumbnail();
            $info .= '<br>';
            $info .= 'Name: ' . get_the_title(); 
            $info .= '<br>';
            $info .= 'Grade: ' . get_post_meta( $post_id, '_ag_grade_meta', true );
            $info .= '<br>';
            $info .= '~~~~~~~~~~~~~~~Shortcode~~~~~~~~~~~~~~~';
            $info .= '</div>';
            return $info;
        endwhile;
    endif;
    wp_reset_postdata();
}

add_shortcode( 'student', 'ag_student_shortcode' );