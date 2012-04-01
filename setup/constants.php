<?php 

/**
 * Generate Theme Constants
 *
 * Generate additional constants to use within theme
 *
 * @constant THEME_NAME 				Name of current theme 
 * @constant THEME_SHORT_NAME 	Short name of current theme 
 * @constant THEME_VERSION			Version of current theme 
 * @constant THEME_PATH 				Path of current theme
 * @constant THEME_DIR 					Directory of current theme
 * @constant TEMPLATE_NAME 			Name of template
 * @constant CHILD_NAME 				Name of child theme
 * @constant CHILD_SHORT_NAME		Short name of child theme
 * @constant CHILD_THEME_VER 		Version of child theme
 * @constant CHILD_PATH			 		Path of child theme
 *
 */

function themelib_generate_theme_constants(){
	
	$themeinfo = get_theme_data(TEMPLATEPATH .'/style.css');
	$theme_title = $themeinfo['Title'];
	$theme_shortname = strtolower(preg_replace('/ /', '_', $theme_title));
	$theme_version = $themeinfo['Version'];
	$theme_template = $themeinfo['Template'];
	define('THEME_NAME', $theme_title);
	define('TEMPLATE_NAME', $theme_title);
	define('THEME_SHORT_NAME', $theme_shortname);
	define('THEME_VERSION', $theme_version);

	/* @todo 	Detect whether this file is inside the
	 *				parent or child theme
	 */
	if( file_exists(TEMPLATEPATH.'/lib/load.php') ):
		define( 'THEME_PATH' , TEMPLATEPATH );
		define( 'THEME_DIR' , get_template_directory_uri() );
	elseif( file_exists(STYLESHEETPATH.'/lib/load.php') ):
		define( 'THEME_PATH' , STYLESHEETPATH );
		define( 'THEME_DIR' , get_stylesheet_directory_uri() );
	endif;

	// Grab child theme data and turn it into constants
	if(STYLESHEETPATH != TEMPLATEPATH): 
	    $themeinfo = get_theme_data(STYLESHEETPATH .'/style.css');
	    $theme_title = $themeinfo['Title'];
	    $theme_shortname = strtolower(preg_replace('/ /', '_', $theme_title));
	    $theme_version = $themeinfo['Version'];
	    $theme_template = $themeinfo['Template'];
	    define('CHILD_NAME', $theme_title);
	    define('CHILD_SHORT_NAME', $theme_shortname);
	    define('CHILD_THEME_VER', $theme_version);
	    define('CHILD_PATH', STYLESHEETPATH);
	endif;

}

add_action('init','themelib_generate_theme_constants',1);