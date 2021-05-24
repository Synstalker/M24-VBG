<?php

/**
 * Class TF_UIKit
 *
 * functionality needed site wide for UI Kit to smash through
 */
class TF_UIKit {

	public function __construct() {
		add_filter( 'wp_nav_menu_objects', array( __CLASS__, 'set_active_menu_item'), null, 2);
	}


	/**
	 * Iterates through the all navigation menus
	 * and add's the uk-active class to the active menu item page
	 *
	 * @param array $sorted_menu_items
	 * @param $args
	 *
	 * @return mixed
	 */
	public static function set_active_menu_item( $sorted_menu_items, $args ){

		$current_menu_item_found = false;
		$home_item_index = null;
		$active_class = 'uk-active';

		if( is_object( $args ) && key_exists( 'active_class', $args ) && $args->active_class == false )
			return $sorted_menu_items;

		foreach( $sorted_menu_items as $key => $item ){
			$item->classes = is_array($item->classes) ? $item->classes : [];

			/**
			 * Search for the home page menu item link in this menu
			 */
			if( get_home_url().'/' == $item->url ){
				$home_item_index = $key;
			}

			/**
			 * If wordpress assigns current-menu-item
			 * to a nav menu item,
			 * add the style framework active nav class to it
			 */
			if( in_array( 'current-menu-item',$item->classes ) && !$current_menu_item_found ){
				$current_menu_item_found = true;
				$item->classes[] = $active_class;
			}


			/**
			 *
			 * If any of the nav menu items are within the current URL
			 * add an active class to the menu item
			 */
			if( get_home_url().'/' != $item->url && strpos( get_permalink( get_the_ID() ), $item->url) !== false ){
				$current_menu_item_found = true;
				$item->classes[] = $active_class;
			}
		}


		/**
		 * If there is no item that is active in the menu,
		 * set the home page menu item to active
		 */
		if( !$current_menu_item_found && $home_item_index ){
			$sorted_menu_items[ $home_item_index ]->classes[] = $active_class;
		}

		return $sorted_menu_items;
	}
}