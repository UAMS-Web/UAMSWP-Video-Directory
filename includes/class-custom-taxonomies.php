<?php

/**
 * The core plugin class file
 *
 * Defines the functions necessary to register our custom taxonomies with
 * WordPress.
 *
 * @link       http://code.tutsplus.com/series/the-beginners-guide-to-wordpress-taxonomies--cms-706
 * @since      1.0.1
 *
 * @package    UAMSWP_Video_Directory_Custom_Taxonomies
 * @author     Todd McKee <todd@uams.edu>
 */
class UAMSWP_Video_Directory_Custom_Taxonomies {

	/**
	 * Initializes the plugin by registering the hooks necessary
	 * for creating our custom taxonomies within WordPress.
	 *
	 * @since    1.0.0
	 */
	public function init() {

		add_action( 'init', array( $this, 'init_taxonomies' ) );

	}

	public function init_taxonomies() {
		$taxonomies = array();

		$taxonomies[] = array(
			'name' => 'video_categories',
			'post_type' => 'video',
			'labels' => array(
				'name'          => 'Video Categories',
				'singular_name' => 'Video Category',
				'edit_item'     => 'Edit Video Category',
				'update_item'   => 'Update Video Category',
				'add_new_item'  => 'Add New Video Category',
				'menu_name'     => 'Video Categories',
			),
		);

		// $taxonomies[] = array(
		// 	'name' => 'idonate_colleges',
		// 	'post_type' => 'video',
		// 	'labels' => array(
		// 		'name'          => 'Colleges',
		// 		'singular_name' => 'College',
		// 		'edit_item'     => 'Edit College',
		// 		'update_item'   => 'Update College',
		// 		'add_new_item'  => 'Add New College',
		// 		'menu_name'     => 'Colleges',
		// 	),
		// );

		// $taxonomies[] = array(
		// 	'name' => 'idonate_campuses',
		// 	'post_type' => 'video',
		// 	'labels' => array(
		// 		'name'          => 'Campuses',
		// 		'singular_name' => 'Campus',
		// 		'edit_item'     => 'Edit Campus',
		// 		'update_item'   => 'Update Campus',
		// 		'add_new_item'  => 'Add New Campus',
		// 		'menu_name'     => 'Campuses',
		// 	),
		// );

		// $taxonomies[] = array(
		// 	'name' => 'idonate_programs',
		// 	'post_type' => 'video',
		// 	'labels' => array(
		// 		'name'          => 'Programs',
		// 		'singular_name' => 'Program',
		// 		'edit_item'     => 'Edit University Program',
		// 		'update_item'   => 'Update University Program',
		// 		'add_new_item'  => 'Add New University Program',
		// 		'menu_name'     => 'Programs',
		// 	),
		// );

		// $taxonomies[] = array(
		// 	'name' => 'idonate_scholarships',
		// 	'post_type' => 'video',
		// 	'labels' => array(
		// 		'name'          => 'Featured Scholarships',
		// 		'singular_name' => 'Featured Scholarship',
		// 		'edit_item'     => 'Edit Featured Scholarship',
		// 		'update_item'   => 'Update Featured Scholarship',
		// 		'add_new_item'  => 'Add New Featured Scholarship',
		// 		'menu_name'     => 'Featured Scholarships',
		// 	),
		// );

		foreach ( $taxonomies as $taxonomy ) {
			$this->register_custom_taxonomy( $taxonomy['name'], $taxonomy['post_type'], $taxonomy['labels'] );
		}
	}

	private function register_custom_taxonomy( $name, $post_type, $labels ) {
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'public'            => true,
			'show_in_rest' => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'capabilities' => array(
				'assign_terms' => 'edit_videos',
			),
		);

		register_taxonomy( $name, $post_type, $args );
	}
}