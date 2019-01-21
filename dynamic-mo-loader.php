<?php
/*
Plugin Name: Dynamic MO Loader
Plugin URI: 
Description: Better text domain loading with object cache support
Version: 1.1.3
Author: Aucor Oy
Author URI: 
License: GPL3
*/
if(!class_exists('Dynamic_MO_Loader')) {
  
  require_once('inc/mo_dynamic.php');
  
  class Dynamic_MO_Loader {
    function __construct() {
 			add_filter( 'override_load_textdomain', array( $this, 'load_textdomain_override' ), 0, 3 );
  	}
  	
  	function load_textdomain_override( $retval, $domain, $mofile ) {
  		global $l10n;
  
  		$result = false;
  		$mo = NULL;
    
  
  		if ( $mo === NULL ) {
  			do_action( 'load_textdomain', $domain, $mofile );
  			$mofile = apply_filters( 'load_textdomain_mofile', $mofile, $domain );
  
  			if ( isset( $l10n[$domain] ) ) {
  				if ( $l10n[$domain] instanceof WPPP_MO_dynamic && $l10n[$domain]->Mo_file_loaded( $mofile ) ) {
  					return true;
  				}
  			}

  			if ( !is_readable( $mofile ) ) {
  				return false; // return false is important so load_plugin_textdomain/load_theme_textdomain/... can call load_textdomain for different locations
  			}
  			
  			$cache = TRUE;

  			$mo = new WPPP_MO_dynamic ( $domain, $cache );
  			
  			if ( $mo->import_from_file( $mofile ) ) { 
  				$result = true;
  			} else {
  				$mo->unhook_and_close();
  				$mo = NULL;
  			}
  		}
  
  		if ( $mo !== NULL ) {
  			if ( isset( $l10n[$domain] ) ) {
  				$mo->merge_with( $l10n[$domain] );
  				if ( $l10n[$domain] instanceof WPPP_MO_dynamic ) {
  					$l10n[$domain]->unhook_and_close();
  				}
  			}
  			$l10n[$domain] = $mo;
  		}
  
  		return $result;
  	}
  }
}

if(class_exists('Dynamic_MO_Loader')) {
    // instantiate the plugin class
    $dynamic_mo_loader = new Dynamic_MO_Loader();
}
