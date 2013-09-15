<?php 

if( ! class_exists( 'WP_List_Table' ) ) {
	if(!class_exists('WP_Internal_Pointers')){
		require_once( ABSPATH . '/wp-admin/includes/template.php' );
	}
	require_once( ABSPATH . '/wp-admin/includes/class-wp-list-table.php' );
}

class WooShopRecognitionWays extends WP_List_Table{
	
	private $per_page;
	private $total_items;
	private $current_page;
	
	
	function __construct(){
		parent::__construct();
	}
	
	
	/*preparing items must overwirte the mother function*/
	function prepare_items(){
			
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
	
		$this->_column_headers = array($columns, $hidden, $sortable);
	
		//paginations
		$this->_set_pagination_parameters();
	
		//every elements
		$this->items = $this->populate_table_data();
	}
	
	
	//columns
	function get_columns(){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'order' => __('Order'),	
			'name' => __('Name'),
			'email' => __('Email'),
			'recognition' => __('Shop Recognition')			
		);
		
		return $columns;
	}
	
	
	//make some column sortable
	function get_sortable_columns(){
		$sortable_columns = array(
			//	'name' => array('name', false),
			//	'email' => array('email', false),
				'recognition' => array('recognition', false),
				'order' => array('order', false)
		);
	
		return $sortable_columns;
	}
	
	
	//pagination
	private function _set_pagination_parameters(){
		global $wpdb;
		$sql = "select count(ID) from $wpdb->posts where post_type = 'shop_order'";
	
		$this->current_page = $this->get_pagenum(); //it comes form mother class (WP_List_Table)
	
		$this->total_items = $wpdb->get_var($sql);
		$this->per_page = 25;
	
		$this->set_pagination_args( array(
				'total_items' => $this->total_items,                  //WE have to calculate the total number of items
				'per_page'    => $this->per_page,                     //WE have to determine how many items to show on a page
				'total_pages' => ceil($this->total_items/$this->per_page)   //WE have to calculate the total number of pages
		) );
	
	}
	
	
	
	//collectes every information
	function populate_table_data(){
			
		$return = array();
		
		$args = array(
			'post_type' => 'shop_order',
			'fields' => 'ids',
			'posts_per_page' => $this->per_page,
			'paged' => $this->get_pagenum(),								
		);
		
		switch($_GET['orderby']){
			case 'recognition':
				$args['meta_key'] = '_shop_recognition';
				$args['orderby'] = 'meta_value';
				$args['order'] = isset($_GET['order']) ? $_GET['order'] : 'desc';
				break;
			default:
				$args['orderby'] = 'ID';
				$args['order'] = isset($_GET['order']) ? $_GET['order'] : 'asc';	
		}
				
		
		$query = new WP_Query($args);		
		$posts = $query->posts;
		wp_reset_query();
		
		//var_dump($posts);
		
		
		foreach($posts as $post){
			$order = new WC_Order($post);
			$return[] = array(
				'id' => $post,
				'name' => $order->billing_first_name . ' ' . $order->billing_last_name,
				'email' => $order->billing_email,
				'order' => '<a href="' . admin_url( 'post.php?post=' . absint( $post ) . '&action=edit' ) . '"><strong>' . sprintf( __( 'Order %s', 'woocommerce' ), esc_attr( $order->get_order_number() ) ) . '</strong></a>',
				'recognition' => get_post_meta($post, '_shop_recognition', true)			
			);
		}	
		
		return $return;
	}
	
	
	/* Utility that are mendatory   */
	
	/* checkbox for bulk action*/
	function column_cb($item) {
		return sprintf(
				'<input type="checkbox" name="customer_id[]" value="%s" />', $item['id']
		);
	}
	
	
	/* default column checking and it is must */
	function column_default($item, $column_name){
		switch($column_name){
			case "id":
			case "name":
			case "email":
			case "recognition":
			case "order":
				return $item[$column_name];
				break;
			default:
				var_dump($item);
					
		}
	}
	
	
	
}



?>