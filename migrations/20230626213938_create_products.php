<?php
	include_once('function.php');

	class CreateProducts {

		function up(){
			create_table('20230626213938_create_products', 'products',
				// [column_name, datatype, length, allow_null(default:false), default_value(default:'')],
				// id, created_at & updated_at columns will be created.
				["pname", 'varchar', 100],
			);
		}

		function down(){
			drop_table('20230626213938_create_products', 'products');
		}

	}
?>