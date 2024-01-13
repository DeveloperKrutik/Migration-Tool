<?php
  function configurations(){
    $config_json = file_get_contents('config.json');
    $config = json_decode($config_json,true);
    
    return $config;
  }

  function migrate(){
    $config = configurations();
    
    foreach (glob("migrations/*.php") as $filename) {
      include("config/common.php");

      $file = explode('/', $filename)[1];
      $sql = "SELECT status FROM migrations WHERE project = '".$config['project_name']."' AND migration = '".$file."' ";
      $data = $obj->select($sql);

      if ($data[0]['status'] == 0){
        include $filename;

        $classname = "";
        $filearr = explode("_", $filename);
        array_shift($filearr);
        foreach ($filearr as $ele){
          $classname .= ucfirst($ele);
        }

        $classname = explode(".", $classname)[0];
        $obj = new $classname();

        $obj->up();
      }
    }
  }

  function rollback(){
    $config = configurations();
    include("config/common.php");

    $sql = "SELECT migration FROM migrations WHERE project = '".$config['project_name']."' AND status = 1 ";
    $data = $obj->select($sql);

    $file = $data[count($data)-1]['migration'];
    $filename = "migrations/".$file;

    include $filename;

    $classname = "";
    $filearr = explode("_", $filename);
    array_shift($filearr);
    foreach ($filearr as $ele){
      $classname .= ucfirst($ele);
    }

    $classname = explode(".", $classname)[0];
    $object = new $classname();

    $object->down();

    $update_sql = "UPDATE migrations SET status = 0 WHERE migration = '".$file."' ";
    $update = $obj->edit($update_sql);
  }
?>