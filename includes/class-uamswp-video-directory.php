<?php

class UAMSWP_Video_Directory {
	private static ?\UAMSWP_Video_Directory $instance = null;
    
	/**
     * Maintain and return the one instance. Initiate hooks when
     * called the first time.
     *
     * @since 0.0.1
     */
    public static function get_instance(): \UAMSWP_Video_Directory {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new UAMSWP_Video_Directory();
			self::$instance->setup_hooks();
		}
        
		return self::$instance;
	}
    
	/**
	 * Setup hooks to include.
	 *
	 * @since 0.0.1
	 */
	public function setup_hooks(): void {
		self::$instance->custom_posttypes_run();
		self::$instance->custom_taxonomies_run();
		self::$instance->custom_templates_run();
	}
    
	/**
	* Creates an instance of the UAMSWP_Video_Directory_Post_Type_Video class
	* and calls its initialization method.
	*
	* @since    0.0.1
	*/
	private function custom_posttypes_run(): void {
		/** Loads the custom post type Video class file. */
		require_once( __DIR__ . '/class-custom-post-type-video.php' );
		$custom_post_type = new UAMSWP_Video_Directory_Post_Type_Video();
		$custom_post_type->init();
	}
    
	/**
	* Creates an instance of the UAMSWP_Video_Directory_Custom_Taxonomies class
	* and calls its initialization method.
	*
	* @since    0.0.1
	*/
	private function custom_taxonomies_run(): void {
		/** Loads the custom taxonomy class file. */
		require_once( __DIR__ . '/class-custom-taxonomies.php' );
		$custom_post_type = new UAMSWP_Video_Directory_Custom_Taxonomies();
		$custom_post_type->init();
	}
    
	/**
	* Creates an instance of the UAMSWP_Video_Directory_Custom_Taxonomies class
	* and calls its initialization method.
	*
	* @since    0.0.1
	*/
	private function custom_templates_run(): void {
		/** Loads the custom templates class file. */
		require_once( __DIR__ . '/class-custom-templates.php' );
		$custom_templates = new UAMSWP_Video_Directory_Custom_Templates();
		$custom_templates->init();
	}
}
