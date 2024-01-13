<?php
  date_default_timezone_set("Asia/Calcutta");
  include_once('config/common.php');
  include_once("migrate.php");
  $config_json = file_get_contents('config.json');
  $config = json_decode($config_json,true);

  if($argv[1] == 'g' && $argv[2] == 'migration'){
    
    $directory = "migrations";
    if(!is_dir($directory)){
      mkdir("migrations");
    }
    
    if($argv[3] == 'create_table' && $argc == 5 && isset($argv[4])){
      $filename = date("YmdHis")."_create_".$argv[4].".php";
    
      $sql = "INSERT INTO migrations(project, migration, status) VALUES ('".$config['project_name']."', '".$filename."', 0)";
      
      if ($obj->insert($sql)){
        $file = fopen("migrations/".$filename."", "w") or die("Something went wrong!");

        $classname = "";
        $filearr = explode("_", $filename);
        array_shift($filearr);
        foreach ($filearr as $ele){
          $classname .= ucfirst($ele);
        }

        $classname = explode(".", $classname)[0];
        $tablename = $argv[4];
  
        $content = "<?php\n\tinclude_once('function.php');\n\n\tclass ".$classname." {\n\n\t\tfunction up(){\n\t\t\tcreate_table('".explode('.', $filename)[0]."', '".$tablename."',\n\t\t\t\t// [column_name, datatype, length, allow_null(default:false), default_value(default:'')],\n\t\t\t\t// id, created_at & updated_at columns will be created.\n\t\t\t);\n\t\t}\n\n\t\tfunction down(){\n\t\t\tdrop_table('".explode('.', $filename)[0]."', '".$tablename."');\n\t\t}\n\n\t}\n?>";
        
        fwrite($file, $content);
        fclose($file);
        echo "".$filename." successfully created. :)";
      }else{
        echo "Something went wrong!";
      }

    }if($argv[3] == 'add_column' && $argc == 7 && isset($argv[4]) && $argv[5] == 'to' && isset($argv[6])){
      $filename = date("YmdHis")."_add_".$argv[4]."_to_".$argv[6].".php";
    
      $sql = "INSERT INTO migrations(project, migration, status) VALUES ('".$config['project_name']."', '".$filename."', 0)";

      if ($obj->insert($sql)){
        $file = fopen("migrations/".$filename."", "w") or die("Something went wrong!");

        $classname = "";
        $filearr = explode("_", $filename);
        array_shift($filearr);
        foreach ($filearr as $ele){
          $classname .= ucfirst($ele);
        }

        $classname = explode(".", $classname)[0];
        $tablename = $argv[6];
        $columnname = $argv[4];
  
        $content = "<?php\n\tinclude_once('function.php');\n\n\tclass ".$classname." {\n\n\t\tfunction up(){\n\t\t\tadd_column('".explode('.', $filename)[0]."', '".$tablename."',\n\t\t\t\t// [column_name, datatype, length, allow_null(default:false)]\n\t\t\t\t['".$columnname."', ]\n\t\t\t);\n\t\t}\n\n\t\tfunction down(){\n\t\t\tremove_column('".explode('.', $filename)[0]."', '".$tablename."', '".$columnname."');\n\t\t}\n\n\t}\n?>";
        
        fwrite($file, $content);
        fclose($file);
        echo "".$filename." successfully created. :)";
      }else{
        echo "Something went wrong!";
      }
    }if($argv[3] == 'remove_column' && $argc == 7 && isset($argv[4]) && $argv[5] == 'from' && isset($argv[6])){
      $filename = date("YmdHis")."_remove_".$argv[4]."_from_".$argv[6].".php";
    
      $sql = "INSERT INTO migrations(project, migration, status) VALUES ('".$config['project_name']."', '".$filename."', 0)";

      if ($obj->insert($sql)){
        $file = fopen("migrations/".$filename."", "w") or die("Something went wrong!");

        $classname = "";
        $filearr = explode("_", $filename);
        array_shift($filearr);
        foreach ($filearr as $ele){
          $classname .= ucfirst($ele);
        }

        $classname = explode(".", $classname)[0];
        $tablename = $argv[6];
        $columnname = $argv[4];
  
        $content = "<?php\n\tinclude_once('function.php');\n\n\tclass ".$classname." {\n\n\t\tfunction up(){\n\t\t\tremove_column('".explode('.', $filename)[0]."', '".$tablename."', '".$columnname."');\n\t\t}\n\n\t\tfunction down(){\n\t\t\tadd_column('".explode('.', $filename)[0]."', '".$tablename."',\n\t\t\t\t['".$columnname."', 'VARCHAR', 100]\n\t\t\t);\n\t\t}\n\n\t}\n?>";
        
        fwrite($file, $content);
        fclose($file);
        echo "".$filename." successfully created. :)";
      }else{
        echo "Something went wrong!";
      }
    }if($argv[3] == 'drop_table' && $argc == 5 && isset($argv[4])){
      $filename = date("YmdHis")."_drop_".$argv[4].".php";
    
      $sql = "INSERT INTO migrations(project, migration, status) VALUES ('".$config['project_name']."', '".$filename."', 0)";

      if ($obj->insert($sql)){
        $file = fopen("migrations/".$filename."", "w") or die("Something went wrong!");

        $classname = "";
        $filearr = explode("_", $filename);
        array_shift($filearr);
        foreach ($filearr as $ele){
          $classname .= ucfirst($ele);
        }

        $classname = explode(".", $classname)[0];
        $tablename = $argv[4];
  
        $content = "<?php\n\tinclude_once('function.php');\n\n\tclass ".$classname." {\n\n\t\tfunction up(){\n\t\t\tdrop_table('".explode('.', $filename)[0]."', '".$tablename."');\n\t\t}\n\n\t\tfunction down(){\n\t\t\tcreate_table('".explode('.', $filename)[0]."', '".$tablename."',\n\t\t\t\t// [column_name, datatype, length, allow_null(default:false), default_value(default:'')],\n\t\t\t\t// id, created_at & updated_at columns will be created.\n\t\t\t);\n\t\t}\n\n\t}\n?>";
        
        fwrite($file, $content);
        fclose($file);
        echo "".$filename." successfully created. :)";
      }else{
        echo "Something went wrong!";
      }
    }
    
  }else if($argv[1] == 'db:migrate' && $argc == 2){
    migrate();
  }else if($argv[1] == 'db:migrate:status' && $argc == 2){
    echo "\n===================================================================================================\n\n";
    echo "\t-------------------------------------------------------------------------\n";
    foreach (glob("migrations/*.php") as $filename) {
      $file = explode('/', $filename)[1];
      $sql = "SELECT status FROM migrations WHERE project = '".$config['project_name']."' AND migration = '".$file."' ";
      $data = $obj->select($sql);
      $status = 'down';
      if($data[0]['status'] == 1){
        $status = 'up';
      }
      echo "\t Migration:".$file."\n";
      echo "\t Status:".$status."\n";
      echo "\t-------------------------------------------------------------------------\n";
    }
    echo "\n===================================================================================================\n";
  }else if($argv[1] == 'db:migrate:rollback' && $argc == 2){
    rollback();
  }else{
    echo "Invalid Command!";
  }
?>