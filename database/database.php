<?php

define('SERVER_NAME', 'localhost');
define('USER_NAME', 'root');
define('PASSWORD', '');

class Database
{

    private $conn;

    function __construct()
    {
        $this->conn = new mysqli(SERVER_NAME, USER_NAME, PASSWORD);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $this->conn->query("CREATE DATABASE IF NOT EXISTS `ski_vm`");
        $this->conn->select_db('ski_vm');

        $sql = "CREATE TABLE IF NOT EXISTS `ski_vm`.`brukere`(
`id` INT AUTO_INCREMENT PRIMARY KEY,
`brukernavn` VARCHAR(30) NOT NULL,
`passord` VARCHAR(50) NOT NULL);";
        $this->conn->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `ski_vm`.`ovelse`(
                `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `navn` VARCHAR(30) DEFAULT NULL UNIQUE,
                `verdensrekord` TIME DEFAULT NULL,
                `rekordholder` INT(30) DEFAULT NULL);";
        $this->conn->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `ski_vm`.`person`(
                `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `fornavn` VARCHAR(30) NOT NULL,
                `etternavn` VARCHAR(30) NOT NULL,
                `telefonnummer` VARCHAR(10) NOT NULL,
                `adresse` VARCHAR(30) NOT NULL,
                `postnummer` CHAR(4) NOT NULL,
                `poststed` VARCHAR(20) NOT NULL);";
        $this->conn->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `ski_vm`.`tilskuere`(
                `ovelse_id` INT(10) NOT NULL,
                `tilskuer_id` INT(10) NOT NULL,
                KEY `ovelse` (`ovelse_id`),
                KEY `tilskuer` (`tilskuer_id`),
                CONSTRAINT `ovelse` FOREIGN KEY (`ovelse_id`) REFERENCES `ovelse` (`id`),
                CONSTRAINT `tilskuer` FOREIGN KEY (`tilskuer_id`) REFERENCES `person` (`id`));";
        $this->conn->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `ski_vm`.`utovere` (
                `ovelse_id` INT(10) NOT NULL,
                `utover_id` INT(10) NOT NULL,
                KEY `utover` (`utover_id`),
                KEY `utover_ovelse` (`ovelse_id`),
                CONSTRAINT `utover` FOREIGN KEY (`utover_id`) REFERENCES `person` (`id`),
                CONSTRAINT `utover_ovelse` FOREIGN KEY (`ovelse_id`) REFERENCES `ovelse` (`id`));";
        $this->conn->query($sql);

    }

    function getBestillinger()
    {
        return $this->conn->query("SELECT * FROM `ski_vm`.`person`");
    }

    /**
     * @return mysqli
     */
    public function getConn()
    {
        return $this->conn;
    }

}