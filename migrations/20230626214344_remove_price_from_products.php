<?php
	include_once('function.php');

	class RemovePriceFromProducts {

		function up(){
			remove_column('20230626214344_remove_price_from_products', 'products', 'price');
		}

		function down(){
			add_column('20230626214344_remove_price_from_products', 'products',
				['price', 'VARCHAR', 100]
			);
		}

	}
?>