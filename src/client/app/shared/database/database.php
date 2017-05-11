<?php

	namespace Database;

	use Config\AppConfig;
	use Interfaces;
	use mysqli;

	class Database implements Interfaces\IDatabase {

		private $config;
		private $conn;

		function __construct() {
			if ( !isset( $this->config ) ) {
				$config = new AppConfig;
				$this->config = $config->getConfig();
			}
			if ( !isset( $this->conn ) ) {
				$this->conn = new mysqli( $this->config->host, $this->config->username, $this->config->password );
				if ( $this->conn->connect_error ) die( "Connection failed: " . $this->conn->connect_error );
				else $this->create();
			}

		}

		private function create() {
			try {
				$this->conn->query( "CREATE DATABASE IF NOT EXISTS `" . $this->config->dbname . "`" );
				$this->conn->select_db( $this->config->dbname );

				$sql = "CREATE TABLE IF NOT EXISTS `" . $this->config->dbname . "`.`brukere`(
`id` INT AUTO_INCREMENT PRIMARY KEY,
`brukernavn` VARCHAR(30) NOT NULL,
`passord` VARCHAR(50) NOT NULL);";
				$this->conn->query( $sql );

				$sql = "CREATE TABLE IF NOT EXISTS `" . $this->config->dbname . "`.`ovelse`(
                `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `navn` VARCHAR(30) DEFAULT NULL UNIQUE,
                `verdensrekord` TIME DEFAULT NULL,
                `rekordholder` INT(30) DEFAULT NULL);";
				$this->conn->query( $sql );

				$sql = "CREATE TABLE IF NOT EXISTS `" . $this->config->dbname . "`.`person`(
                `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `fornavn` VARCHAR(30) NOT NULL,
                `etternavn` VARCHAR(30) NOT NULL,
                `telefonnummer` VARCHAR(10) NOT NULL,
                `adresse` VARCHAR(30) NOT NULL,
                `postnummer` CHAR(4) NOT NULL,
                `poststed` VARCHAR(20) NOT NULL);";
				$this->conn->query( $sql );

				$sql = "CREATE TABLE IF NOT EXISTS `" . $this->config->dbname . "`.`tilskuere`(
                `ovelse_id` INT(10) NOT NULL,
                `tilskuer_id` INT(10) NOT NULL,
                KEY `ovelse` (`ovelse_id`),
                KEY `tilskuer` (`tilskuer_id`),
                CONSTRAINT `ovelse` FOREIGN KEY (`ovelse_id`) REFERENCES `ovelse` (`id`),
                CONSTRAINT `tilskuer` FOREIGN KEY (`tilskuer_id`) REFERENCES `person` (`id`));";
				$this->conn->query( $sql );

				$sql = "CREATE TABLE IF NOT EXISTS `" . $this->config->dbname . "`.`utovere` (
                `ovelse_id` INT(10) NOT NULL,
                `utover_id` INT(10) NOT NULL,
                KEY `utover` (`utover_id`),
                KEY `utover_ovelse` (`ovelse_id`),
                CONSTRAINT `utover` FOREIGN KEY (`utover_id`) REFERENCES `person` (`id`),
                CONSTRAINT `utover_ovelse` FOREIGN KEY (`ovelse_id`) REFERENCES `ovelse` (`id`));";
				$this->conn->query( $sql );
			} catch (mysqli_sql_exception $error) {
				echo $error;
			}
		}

		public function error() {
			return $this->conn->error;
		}

		public function select( $query ) {
			$result = $this->query( $query );
			return !$result ? $result->fetch_array() : false;
		}

		public function query( $query ) {
			return $this->conn->query( $query );
		}

		public function quote( $value ) {
			return "'" . mysqli_real_escape_string( $this->conn, $value ) . "'";
		}

		/**
		 * @return mysqli
		 */
		public function getConn() {
			return $this->conn;
		}

	}