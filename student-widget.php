<?php
class Students_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'students_widget', // Base ID
			esc_html__( 'Students List' ), // Name
			array( 'description' => esc_html__( 'Displays a list of students.' ) )
		);
	}

	public function widget( $args, $instance ) {
		if ( ! empty( $instance['title'] ) ) {
			echo esc_attr( ['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		$posts_per_page = $instance['pages_per_page'];
		$search_active = ( 'active' === $instance['select_active'] ) ? 1 : 0;

		$args = array(
			'post_type'      => 'student',
			'posts_per_page' => $posts_per_page,
			'meta_key'       => '_ag_status_meta',
			'meta_query'     => array(
				'key'     => '_ag_status_meta',
				'value'   => $search_active,
				'compare' => '=',
			),
		);

		$query = new WP_Query( $args );
		echo '<strong>More students:</strong><br>';
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) :
				$query->the_post();
				the_title( sprintf( '<p><a href="%s">', esc_url( get_permalink() ) ), '</a></p>' );
			endwhile;
		else :
			echo 'No students to display.';
		endif;
		wp_reset_postdata();
	}

	//Back-end
	public function form( $instance ) {
		$pages_per_page = ! empty( $instance['pages_per_page'] ) ? $instance['pages_per_page'] : esc_html__( '3' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'pages_per_page' ) ); ?>"><?php esc_html( 'Pages per page:' ); ?></label> 
		<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'pages_per_page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pages_per_page' ) ); ?>" type="number" value="<?php echo esc_attr( $pages_per_page ); ?>">
		</p>
		<?php

		$select_active = $instance['select_active'];
		echo esc_html( $select_active );

		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'select_active' ) ); ?>"><?php esc_html( 'Show students who are:' ); ?></label> 
		<select id="<?php echo esc_attr( $this->get_field_id( 'select_active' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'select_active' ) ); ?>">
			<option value="active" <?php echo ( 'active' === $select_active ) ? 'selected' : ''; ?>>Active</option>
			<option value="inactive" <?php echo ( 'inactive' === $select_active ) ? 'selected' : ''; ?>>Inactive</option>
		</select>
		</p>
		<?php
	}

	//Save the values
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['pages_per_page'] = ( ! empty( $new_instance['pages_per_page'] ) ) ? sanitize_text_field( $new_instance['pages_per_page'] ) : '';
		$instance['select_active']  = $new_instance['select_active'];

		return $instance;
	}
}

// register Students_widget widget
function register_students_widget() {
	register_widget( 'Students_widget' );
}
add_action( 'widgets_init', 'register_students_widget' );
