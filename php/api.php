<?php

  require_once 'resources/Utils.php';

  $nickname = @$_GET['nickname'];
  if($allowedips){
	  if(!in_array(getClientIp(), $allowedips)){
		  header('HTTP/1.1 403 Forbidden');
		  die('403 – Forbidden');
	  }
  }

  try{
    if(!$nickname || (!ctype_alnum($nickname))){
      header('HTTP/1.1 400 Bad Request');
		  die('400 – Bad Request');
    }

    header('Content-Type: application/json');
    $pdo = getConnection();
    $pdo->query("use $dbname");
    $result = $pdo->query("SELECT * FROM $tablename WHERE nickname = '$nickname'");
    if(!$result)
    {
      die("Execute query error, because: ". print_r($pdo->errorInfo(),true) );
    }
    echo json_encode(successResponse((boolean) $result->fetchAll()));
  } catch(PDOException $e){
    header('HTTP/1.1 500 Internal Server Error');
    die(json_encode(failureResponse()));
  }
