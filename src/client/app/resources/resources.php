<?php
	/**
	 * Created by PhpStorm.
	 * User: hakon
	 * Date: 11.05.2017
	 * Time: 14.43
	 */

	namespace Resources;

	use Monolog;

	abstract class Service {
		static $logger;

		function __construct() {
			if ( !isset( self::$logger ) ) {
				self::$logger = new Monolog\Logger( 'ServiceLogger' );
			}
		}
	}