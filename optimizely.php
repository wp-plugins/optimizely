<?php
/**
 * @package Optimizely
 * @version 3.2.2
 */
/*
Plugin Name: Optimizely
Plugin URI: http://wordpress.org/extend/plugins/optimizely/
Description: Simple, fast, and powerful.  <a href="http://www.optimizely.com">Optimizely</a> is a dramatically easier way for you to improve your website through A/B testing. Create an experiment in minutes with our easy-to-use visual interface with absolutely no coding or engineering required. Convert your website visitors into customers and earn more revenue today! To get started: 1) Click the "Activate" link to the left of this description, 2) Sign up for an <a href="http://www.optimizely.com">Optimizely account</a>, and 3) Create an API Token here: <a href="https://www.optimizely.com/tokens">API Tokens</a>, and enter your API token in the Configuration Tab of the Plugin, then select a project to start testing!
Author: Optimizely Inc.
Version: 3.2.2
Author URI: http://www.optimizely.com/
License: GPL2
*/

/*  Copyright 2015 Optimizely Inc (email: support@optimizely.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( is_admin() ) {
  require_once dirname( __FILE__ ) . '/admin.php';
  require_once dirname( __FILE__ ) . '/edit.php';
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-tabs');
  wp_enqueue_script('jquery-ui-progressbar');
  wp_enqueue_script('jquery-ui-tooltip');
  wp_enqueue_script('optimizely_api', plugins_url('optimizely.js', __FILE__));
  wp_enqueue_script('optimizely_editor', plugins_url('edit.js', __FILE__));
  wp_localize_script('optimizely_editor', 'wpAjaxUrl', admin_url('admin-ajax.php'));
  wp_enqueue_script('optimizely_config', plugins_url('config.js', __FILE__));
  wp_enqueue_script('optimizely_results', plugins_url('results.js', __FILE__));
  wp_enqueue_style('jquery_ui_styles', plugins_url('jquery-ui.css', __FILE__));
  wp_enqueue_style('font_awesome_styles',plugins_url('font-awesome.min.css', __FILE__));
  wp_enqueue_style('optimizely_styles', plugins_url('style.css', __FILE__));
}


  $DEFAULT_VARIATION_TEMPLATE = '$(".post-$POST_ID .entry-title a").text("$NEW_TITLE");';
  add_option('optimizely_variation_template', $DEFAULT_VARIATION_TEMPLATE);
  $DEFAULT_VISITOR_COUNT = 10316;
  add_option('optimizely_post_types', 'post');
  add_option('optimizely_visitor_count', $DEFAULT_VISITOR_COUNT);
  add_option('num_variations', 2);

  add_option('optimizely_launch_auto', false);

  // Force Optimizely to load first in the head tag
  add_action('wp_head', 'add_optimizely_script', -1000);
  add_action('plugins_loaded', 'upgrade_old_version');

  function add_optimizely_script() {
  	echo get_option('optimizely_project_code');
  }

  function can_create_experiments() {
    return get_option('optimizely_token');
  }

  function upgrade_old_version (){
    if(get_option('optimizely_project_code') && strpos(get_option('optimizely_project_code'),'js')){
       $project_id = substr(get_option('optimizely_project_code'),strpos(get_option('optimizely_project_code'),'js')+3);
       $project_id = substr($project_id,0,strpos($project_id,'js')-1);
       update_option('optimizely_project_code', $project_id);
    }
  }

?>