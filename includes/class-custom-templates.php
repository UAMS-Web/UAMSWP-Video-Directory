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
class UAMSWP_Video_Directory_Custom_Templates {

	/**
	 * Initializes the plugin by registering the hooks necessary
	 * for creating our custom post type within WordPress.
	 *
	 * @since    1.0.0
	 */
	public function init() {

		add_filter('single_template', array( $this, 'video_single' ) );
		add_action('template_include', array( $this, 'video_archive' ) );

		//add_action( 'init', array( $this, 'custom_post_types' ) );
		//$this->add_video_caps_to_admin();
		//$this->create_video_editor_role();
	}

	 //add_filter('single_template', array( $this, 'get_video_template' ));
	//add_action('template_include', array( $this, 'video_archive' ) );

	//route single- template
	public function video_single($single_template){
	  global $post;
	  $found = locate_template('single-video.php');
	  if($post->post_type == 'video' && $found == ''){
	    $single_template = plugin_dir_path(__DIR__).'templates/single-video.php';
	  }
	  return $single_template;
	}

	//route archive- template
	public function video_archive($template){
	  if(is_post_type_archive('video')){
	    $theme_files = array('archive-video.php');
	    $exists_in_theme = locate_template($theme_files, false);
	    if($exists_in_theme == ''){
	      return plugin_dir_path(__DIR__) . 'templates/archive-video.php';
	    }
	  }
	  return $template;
	}
}