<?php
/**
 * Created by PhpStorm.
 * User: hakon
 * Date: 07.05.2017
 * Time: 18.04
 */
include_once( 'database/database.php' );
$db = new Database();
$result = $db->select("select * from `ski_vm`.`person`");
if(!$result) {
    echo 'Ingen resultater';
}
while ($row = $result->fetch_row()) {
    echo join(' ', $row);
}