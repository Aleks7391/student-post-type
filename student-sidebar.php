<?php
register_sidebar( array(
	'name' => __( 'Students Sidebar' ),
	'id' => 'sidebar-students',
	'description' => '',
	'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));

add_filter( 'the_content', 'display_students_sidebar' );

function display_students_sidebar( $the_content ) {
	if ( is_single() && is_active_sidebar( 'sidebar-students' ) ) { ?>
		<aside class="sidebar">
			<?php dynamic_sidebar( 'sidebar-students' ); ?>
		</aside>
	<?php 
	}
	return $the_content;
}
