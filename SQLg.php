<?php

require_once 'modes/mysqlg.php';

class SQLg
{
  protected $db;
  protected $config;

  public static function connect($mode, $config)
  {
    $mode = "{$mode}g";
    $db = new $mode($config);
    $db->open();
    return $db;
  }

  public function __construct($config)
  {
    $this->config = $config;
  }
}