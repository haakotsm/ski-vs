<div class="jumbotron">
	<h1>Dette er en header</h1>
</div>
<?php
	require_once '..\..\vendor\autoload.php';
	require_once '..\..\config\config.php';
	use Database\Database;

	$db = new Database();
	$result = $db->select( "SELECT * FROM `ski_vm`.`person`" );
	if ( !$result ) {
		echo 'Ingen resultater';
	}
	while ( $row = $result->fetch_row() ) {
		echo join( ' ', $row );
	}
	?>

