<?php
  require_once 'resources/Utils.php';
  $nickname = @$_GET['nickname'];
  try{
    header('Content-Type: application/json');