<?php
	include_once('function.php');

	class AddPriceToProducts {

		function up(){
			add_column('20230626214109_add_price_to_products', 'products',
				// [column_name, datatype, length, allow_null(default:false)]
				['price', 'int', 10]
			);
		}

		function down(){
			remove_column('20230626214109_add_price_to_products', 'products', 'price');
		}

	}
?>