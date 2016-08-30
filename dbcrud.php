<?php
class connect
{
 public function connect()
 {
  mysql_connect("localhost","root","TFS78ZEvUazrszv6");
  mysql_select_db("dbtuts");
 }
 public function setdata($sql)
 {
  mysql_query($sql);
 }
 public function getdata($sql)
 {
  return mysql_query($sql);
 }
 public function delete($sql)
 {
  mysql_query($sql);
 }
}
?>