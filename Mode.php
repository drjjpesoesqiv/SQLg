<?php

interface Mode
{
  public function open();
  public function query($sql);
  public function select($table, $cols, $where, $limit);
  public function insert($table, $cols, $vals);
  public function update($table, $cols, $vals, $where);
  public function delete($table, $where);
  public function where($where);
  public function limit($limit);
}