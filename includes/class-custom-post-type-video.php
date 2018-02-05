<?php

/**
 * The core plugin class file
 *
 * Defines the functions necessary to register our custom post types with
 * WordPress.
 *
 * @link       https://premium.wpmudev.org/blog/create-wordpress-custom-post-types/
 * @since      1.0.0
 *
 * @package    UAMSWP_Video_Directory_Post_Type_Video
 * @author     Todd McKee, MEd
 */
class UAMSWP_Video_Directory_Post_Type_Video {

	/**
	 * Initializes the plugin by registering the hooks necessary
	 * for creating our custom post type within WordPress.
	 *
	 * @since    1.0.0
	 */
	public function init() {

		add_action( 'init', array( $this, 'custom_post_types' ) );
		//$this->add_video_caps_to_admin();
		//$this->create_video_editor_role();
	}

	function custom_post_types() {
		$labels = array(
			'name' => 'Videos',
			'singular_name' => 'Video',
			'menu_name' => 'Videos',
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'show_in_admin_bar' => true,
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-video-alt3',
			'hierarchical' => false,
			'has_archive' => true,
			'taxonomies' => array( 'video_categories' ),
			'supports' => array( 'title', 'editor', 'custom-fields' ),
			'capability_type' => 'post',
			'map_meta_cap' => true,
		);

		register_post_type( 'video', $args );
	}

	/**
	*
	* Give Administrators all Fund Editing Capabilities
	*
	* @link       http://www.nathanfeaver.com/blog/custom_post_types_and_roles_in_wordpress/
	* @since      1.1.2
	*
	*/
	// function add_video_caps_to_admin() {
	// 	$caps = array(
	// 		'read',
	// 		'read_video',
	// 		'read_private_videos',
	// 		'edit_videos',
	// 		'edit_private_videos',
	// 		'edit_published_videos',
	// 		'edit_others_videos',
	// 		'publish_videos',
	// 		'delete_videos',
	// 		'delete_private_videos',
	// 		'delete_published_videos',
	// 		'delete_others_videos',
	// 	);

	// 	$roles = array(
	// 		get_role( 'administrator' ),
	// 		get_role( 'editor' ),
	// 	);

	// 	foreach ( $roles as $role ) {
	// 		foreach ( $caps as $cap ) {
	// 			$role->add_cap( $cap );
	// 		}
	// 	}
	// }

	/**
	*
	* Creates a new role called Fund Editor that only has access to create and update Funds.
	* This role is designed to allow the delegation of fund updates without access to the rest of the WP site.
	*
	* @link       http://www.nathanfeaver.com/blog/custom_post_types_and_roles_in_wordpress_2/
	* @since      1.1.2
	*
	*/
	// function create_fund_editor_role() {
	// 	if ( ! array_key_exists( 'fund_editor', WP_Roles()->get_names() ) ) {
	// 		# Fund Editors only get these capabilities:
	// 		$caps = array(
	// 			'read' => true,
	// 			'read_video' => true,
	// 			'read_private_videos' => true,
	// 			'edit_videos' => true,
	// 			'edit_private_videos' => true,
	// 			'edit_published_videos' => true,
	// 			'edit_others_videos' => true,
	// 			'publish_videos' => true,
	// 			'delete_videos' => true,
	// 		);

	// 		add_role( 'fund_editor', 'Fund Editor', $caps );
	// 	}
	// }
}