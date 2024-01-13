<?php
  
  // trait Schema {
    function connect_db(){
      $config = configurations();

      $servername = $config['database']['servername'];
      $username = $config['database']['username'];
      $password = $config['database']['password'];
      $dbname = $config['database']['database_name'];

      $conn = mysqli_connect($servername, $username, $password, $dbname);

      if (!$conn) {
        echo "\n----------------------------------------------------------------------------------------------------\n";
        echo "\tConnection failed: " . mysqli_connect_error();
        echo "\n----------------------------------------------------------------------------------------------------\n";
        die();
      }else{
        return $conn;
      }
    }

    function close_db($conn){
      mysqli_close($conn);
    }

    function create_table($migration, $table_name, ...$columns){
      $connect = connect_db();
      if($connect){
        include("config/common.php");
        $query = "CREATE TABLE ".$table_name." (\n\t`id` INT(11) NOT NULL AUTO_INCREMENT,\n\t";
        foreach($columns as $cdata){
          if (count($cdata) == 5){
            $allow_null = 'NOT NULL';
            $default = "'".$cdata[4]."'";
            if($cdata[3] == '1'){
              $allow_null = 'NULL';
            }
            if($cdata[4] == ''){
              $default = 'NULL';
            }
            $query .= "`".$cdata[0]."` ".strtoupper($cdata[1])."(".$cdata[2].") ".$allow_null." DEFAULT ".$default.",\n\t";
          }
        } 
        $query .= "`created_at` TIMESTAMP NULL DEFAULT current_timestamp(),\n\t`updated_at` TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),\n\tPRIMARY KEY (`id`) USING BTREE\n);";

        if (mysqli_query($connect, $query)) {
          $update_sql = "UPDATE migrations SET status = 1 WHERE migration = '".$migration.".php' ";
          $update = $obj->edit($update_sql);

          echo "\n\t-------------------------------------------------------------------------\n";
          echo "\t".$migration." Migrated successfully   :::   \n";
          echo "\t\t".$table_name." created successfully.\n";
          echo "\t-------------------------------------------------------------------------\n";
        } else {
          echo "Error::" . mysqli_error($connect);
        }

        close_db($connect);
      }
    }

    function add_column($migration, $table_name, $column){
      $connect = connect_db();
      if($connect){
        include("config/common.php");
        $query = "ALTER TABLE ".$table_name."\n\t";
        
        $allow_null = 'NOT NULL';
        if (isset($column[3]) && $column[3] == '1'){
          $allow_null = "NULL";
        }

        $column_name = $column[0];
        $query .= "ADD ".$column_name." ".strtoupper($column[1])."(".$column[2].") ".$allow_null.";\n\t";
        
        if (mysqli_query($connect, $query)) {
          $update_sql = "UPDATE migrations SET status = 1 WHERE migration = '".$migration.".php' ";
          $update = $obj->edit($update_sql);

          echo "\n\t-------------------------------------------------------------------------\n";
          echo "\t".$migration." Migrated successfully   :::   \n";
          echo "\t\t".$column_name." added to ".$table_name." successfully.\n";
          echo "\t-------------------------------------------------------------------------\n";
        } else {
          echo "Error::" . mysqli_error($connect);
        }

        close_db($connect);
      }
    }

    function remove_column($migration, $table_name, $column){
      $connect = connect_db();
      if($connect){
        include("config/common.php");
        $query = "ALTER TABLE ".$table_name."\n\t";

        $query .= "DROP COLUMN ".$column.";\n\t";
        
        if (mysqli_query($connect, $query)) {
          $update_sql = "UPDATE migrations SET status = 1 WHERE migration = '".$migration.".php' ";
          $update = $obj->edit($update_sql);

          echo "\n\t-------------------------------------------------------------------------\n";
          echo "\t".$migration." Migrated successfully   :::   \n";
          echo "\t\t".$column." removed from ".$table_name." successfully.\n";
          echo "\t-------------------------------------------------------------------------\n";
        } else {
          echo "Error::" . mysqli_error($connect);
        }

        close_db($connect);
      }
    }

    function drop_table($migration, $table_name){
      $connect = connect_db();
      if($connect){
        include("config/common.php");
        $query = "DROP TABLE ".$table_name.";\n\t";
        
        if (mysqli_query($connect, $query)) {
          $update_sql = "UPDATE migrations SET status = 1 WHERE migration = '".$migration.".php' ";
          $update = $obj->edit($update_sql);

          echo "\n\t-------------------------------------------------------------------------\n";
          echo "\t".$migration." Migrated successfully   :::   \n";
          echo "\t\t".$table_name." dropped successfully.\n";
          echo "\t-------------------------------------------------------------------------\n";
        } else {
          echo "Error::" . mysqli_error($connect);
        }

        close_db($connect);
      }
    }
  // }
?>