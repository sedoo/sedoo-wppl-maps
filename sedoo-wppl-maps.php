<?php
/**
 * Plugin Name: Sedoo - Maps
 * Description:  Affiche une carte interactive
 * Version: 0.1.8
 * Author: Nicolas Gruwe  - SEDOO DATA CENTER
 * Author URI:      https://www.sedoo.fr 
 * GitHub Plugin URI: sedoo/sedoo-wppl-maps
 * GitHub Branch:     master
 */

if ( ! function_exists('get_field') ) {
        
	add_action( 'admin_init', 'sb_plugin_deactivate');
	add_action( 'admin_notices', 'sb_plugin_admin_notice');

	//Désactiver le plugin
	function sb_plugin_deactivate () {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	
	// Alerter pour expliquer pourquoi il ne s'est pas activé
	function sb_plugin_admin_notice () {
		
		echo '<div class="error">Le plugin requiert ACF Pro pour fonctionner <br><strong>Activez ACF Pro ci-dessous</strong> ou <a href=https://wordpress.org/plugins/advanced-custom-fields/> Téléchargez ACF Pro &raquo;</a><br></div>';

		if ( isset( $_GET['activate'] ) ) 
			unset( $_GET['activate'] );	
	}
} else {

	include 'sedoo-wppl-maps-functions.php';
	include 'sedoo-wppl-maps-acf.php';
	include 'inc/sedoo-wppl-maps-acf-fields.php';

	/////////////////
	// Populate the theme option select field with post type list
	// AND populate the select post type on maps block
	///
	function sedoo_maps_prefill_select_post_type( $field ) {
		// reset choices
		$field['choices'] = array();
		$content_type_list = [];

		$args = array(
			'public'   => true,
			'_builtin' => true
		);
		$output = 'object'; // names or objects, note names is the default
		$operator = 'or'; // 'and' or 'or'
		
		$post_types = get_post_types( $args, $output, $operator );  
		foreach ( $post_types as $post_type ) {        
			// array_push($content_type_list, $post_type->label);
			$content_type_list[$post_type->name] = $post_type->label;
		}    
		
		$field['choices'] = $content_type_list;
		return $field;
	}
	
	add_filter('acf/load_field/name=types_de_contenus', 'sedoo_maps_prefill_select_post_type');
	add_filter('acf/load_field/name=types_de_contenus_a_afficher', 'sedoo_maps_prefill_select_post_type');

	function sedoo_maps_style() {
		wp_register_style( 'sedoo_maps_css', plugins_url('css/maps.css', __FILE__) );
	 //	wp_register_style( 'sedoo_maps_ol_css', plugins_url('css/ol.css', __FILE__) );
	 	wp_enqueue_style( 'sedoo_maps_css' );		
	 //	wp_enqueue_style( 'sedoo_maps_ol_css' );

	 }
	 add_action( 'init', 'sedoo_maps_style' );


	 function sedoo_map_js() {
		// le fichier js qui contient les fonctions tirgger au change des select
		$scrpt_map =  'https://unpkg.com/leaflet@1.6.0/dist/leaflet.js';
		wp_enqueue_script('sedoo_map_front', $scrpt_map,  array ( 'jquery' ));   
	  }
	  add_action( 'init', 'sedoo_map_js' );
	  add_action( 'admin_head', 'sedoo_map_js' );

}
