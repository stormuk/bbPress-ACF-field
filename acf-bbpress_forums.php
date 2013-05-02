<?php
/*
Plugin Name: Advanced Custom Fields: bbPress Forums
Plugin URI: https://github.com/stormuk/bbPress-ACF-field
Description: bbPress forum field for ACF
Version: 1.0.0
Author: Adam Pope - Storm Consultancy
Author URI: http://www.stormconsultancy.co.uk
License: MIT
License URI: http://opensource.org/licenses/MIT
*/


class acf_field_bbpress_forums_plugin
{
	/*
	*  Construct
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/

	function __construct()
	{

  	// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));


		// version 3-
		add_action( 'init', array( $this, 'init' ), 5);
	}


	/*
	*  Init
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/

	function init()
	{
		if(function_exists('register_field'))
		{
			register_field('acf_field_bbpress_forums', dirname(__File__) . '/bbpress_forums-v3.php');
		}
	}

	/*
	*  register_fields
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/

	function register_fields()
	{
		include_once('bbpress_forums-v4.php');
	}

}

new acf_field_bbpress_forums_plugin();

?>