<?php 
/**
 * Plugin Name: Woocommerce Shop Recognition
 * Author: Mahibul Hasan
 * */

class WooShopRecognition{
	
	function __construct(){
		//add a settings tab to set the minimum order
		add_filter('woocommerce_settings_tabs_array', array(&$this, 'add_new_settings_tab'), 90, 1);
		//populate the new tab
		add_action('woocommerce_settings_tabs_shop_recognition', array(&$this, 'populate_new_settings_tab'));
		
		//save new settings
		add_action('woocommerce_update_options_shop_recognition', array(&$this, 'save_new_settings_tab'));
		
		//show the dropdown in checkout page
		add_action('woocommerce_review_order_before_submit', array(&$this, 'show_recognition_options'), 5);
		
		//add a new database tabel to store each customer against how they know the store
		//register_actionvation_hook(__FILE__, array(&$this, 'during_plugin_activation'));
		
		
		//when order is saved
		add_action('woocommerce_checkout_update_order_meta', array(&$this, 'save_shop_recognition_option'), 10, 2);
		
		//add a submenu page to show the shop recognition table
		add_action('admin_menu', array(&$this, 'admin_menu'), 1000);
		
	}
	
	
	function add_new_settings_tab($tabs){
		$tabs['shop_recognition'] = __('Shop Recognition', 'woocommerce');
		return $tabs;
	}
	
	
	function populate_new_settings_tab(){
		include $this->get_base_directory() . 'settings-tab/shop-recognition.php';
	}
	
	function get_base_directory(){
		return dirname(__FILE__) . '/';
	}
	
	function is_recognition_enabled(){
		return 'yes' == get_option('woocommerce_shop_recognition_enabled') ? true : false;
	}
	
	function get_recognitions(){
		return get_option('woocommerce_shop_recognition_options');
	}
	

	function save_new_settings_tab(){
		
		
		if(isset($_POST['woocommerce_shop_recognition_enabled'])){
			update_option('woocommerce_shop_recognition_enabled', 'yes');
		}
		else{
			update_option('woocommerce_shop_recognition_enabled', 'no');
		}
		
		update_option('woocommerce_shop_recognition_options', $_POST['woocommerce_shop_recognition_options']);
	}
	
	//show the recognition options in checkout page
	function show_recognition_options(){
		if($this->is_recognition_enabled()){		
			include $this->get_base_directory() . 'woocommerce/recognitions.php';
		}
	}
	
	
	//plugion activation time
	function during_plugin_activation(){
		
	}
	
	
	//save each shop recognition
	function save_shop_recognition_option($order_id, $posted){
		if(isset($_POST['shop_recognition_select'])){
			update_post_meta($order_id, '_shop_recognition', $_POST['shop_recognition_select']);
		}
	}
	
	
	//admin menu
	function admin_menu(){
		add_submenu_page('woocommerce', 'Shop Recognition', 'Shop Recognition', 'manage_woocommerce', 'shop-recognition', array(&$this, 'shop_recongition_list_table'));
	}
	
	
	//shop recongniton list table
	function shop_recongition_list_table(){
		$list_table = $this->get_list_table();
		include $this->get_base_directory() . 'woocommerce/list-table.php';
	}
	
	
	//get the list table
	function get_list_table(){
		if(!class_exists('WooShopRecognitionWays')){
			include $this->get_base_directory() . 'classes/class.list-table.php';
		}
		
		return new WooShopRecognitionWays();
	}
	
	
}

return new WooShopRecognition();


?>