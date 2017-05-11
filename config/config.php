<?php

	namespace Config;
	class AppConfig {
		function getConfig() {
			return (object) array(
				'host'     => 'localhost',
				'username' => 'root',
				'password' => '',
				'dbname'   => 'ski_vm'
			);
		}
	}