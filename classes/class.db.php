<?php 

/*
 * This class is to handle the database table
 * */

class WooShopRecognitionDb{
	
	var $customer_table;
	
	function __construct(){
		global $wpdb;
		$this->customer_table = $wpdb->prefix . 'woo_customers';
	}
	
	/*
	 * sync db
	 * creates table if not exists
	 */
	function sync_db(){
		$sql[] = "create table if not exists $this->customer_table(
			id biginit not null auto_increment primary key,
			order_id bigint not null unique,
			email varchar(200) not null,
			name varchar(200) not null,
			status varchar(200) not null
		)";
	}
	
}


?>