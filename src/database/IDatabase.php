<?php
	interface IDatabase {
		function error();
		function query($query);
		function quote($value);
		function select($query);


	}