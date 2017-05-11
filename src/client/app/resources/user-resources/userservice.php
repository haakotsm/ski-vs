<?php

	namespace Resources\UserResources;

	use Database;
	use mysqli_sql_exception;
	use Resources\Service;

	class UserService extends Service {
		private $db;

		function __construct() {
			parent::__construct();

			try {
				$this->db = new Database\Database();
			} catch (mysqli_sql_exception $error) {
				self::$logger->err( $this->db->error() );

			}

		}



	}