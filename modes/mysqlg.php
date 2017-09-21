<?php

$dir = dirname(__FILE__);

require_once $dir . '/../SQLg.php';
require_once $dir . '/../Mode.php';

class mysqlg extends SQLg implements Mode
{
  public function open()
  {
    $this->db = new PDO(
      "mysql:host={$this->config['host']};dbname={$this->config['name']}",
      $this->config['user'],
      $this->config['pass']
    );
  }

  public function query($sql)
  {
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function select($table, $cols, $where = null, $limit = null)
  {
    $cols = implode(',', $cols);
    $sql  = "SELECT $cols FROM $table" . $this->where($where) . $this->limit($limit);
    return $this->query($sql);
  }

  public function insert($table, $cols, $vals)
  {
    $cols = implode(',', $cols);
    $vals = implode(',', $vals);
    $sql = "INSERT INTO $table ($cols) VALUES ($vals)";
    return $this->query($sql);
  }

  public function update($table, $cols, $vals, $where)
  {
    $updates = '';
    for ($i = 0; $i < count($cols); $i++)
      $updates .= "{$cols[$i]}='{$val[$i]},";
    $updates = substr($updates, 0, -1);
    $sql = "UPDATE $table SET $updates" . $this->where($where);
    return $this->query($sql);
  }

  public function delete($table, $where)
  {
    $sql = "DELETE FROM $table" . $this->where($where);
    return $this->query($sql);
  }

  public function where($where)
  {
    if ( ! $where) return;

    $sql = ' WHERE ';
    foreach ($where as $key => $val)
      $sql .= "$key = '$val' AND ";
    return substr($sql, 0, -4);
  }

  public function limit($limit)
  {
    if ( ! $limit) return;

    return  "LIMIT $limit";
  }
}