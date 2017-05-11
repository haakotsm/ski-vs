<?php
	/**
	 * Created by PhpStorm.
	 * User: hakon
	 * Date: 07.05.2017
	 * Time: 18.04
	 */
	use Database\Database;

	$db = new Database();
	$result = $db->select( "SELECT * FROM `ski_vm`.`person`" );
	if ( !$result ) {
		echo 'Ingen resultater';
	}
	while ( $row = $result->fetch_row() ) {
		echo join( ' ', $row );
	}