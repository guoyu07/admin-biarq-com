<?php
/**
 * File: li3/extensions/UbuntuOne.php
 * User: thesyncim
 * Date: 30-03-2012
 * Time: 12:07
 *
 */

namespace li3_u1\extensions;

use Exception;
use \OAuth;
use lithium\core\ConfigException;

/**
 *
 */
class UbuntuOne extends \lithium\core\StaticObject {

	/**
	 * Holds the configuration Options
	 * @var array
	 */
	protected static $_config = array();

	/**
	 * These are the class `defaults`
	 * @var array
	 */
	protected static $_defaults = array(
		'consumer_key' => 'rJQJdDB',
		'consumer_secret' => 'OXZVqHWYhwYBCwssnlJzbsrmkNUzOf',
		'token' => 'LzQKblrgAWohFKXlhLtdrjuCxPKIQOtaOsdfEhSKEqahpqBzaw',
		'token_secret' => 'TVDAqYeabgQbRyfSJojJIozrHOdaLWTQLJqgCtlGrUpZAizQyq',
		'files_api_url' => 'https://one.ubuntu.com/api/file_storage/v1/',
		'files_content_url' => 'https://files.one.ubuntu.com/content/',
		'info_info_api_url' => 'https://one.ubuntu.com/api/account/',
		'base_path' => '~/Ubuntu%20One/'
	);

	public static $_connection;

	public static $_oauth;

	public static $_oauthError;

	public function __construct($config = array()) {
	}

	public static function __init() {
	}

	private static function setErrot($message, $code) {
		static::$_oauthError['message'] = $message;
		static::$_oauthError['code'] = $code;
	}

	/**
	 * Sets configurations for the UbuntuOne
	 * This Method is basically a copy and edit of the config in adaptable.
	 *
	 * @see lithium\core\adaptable
	 *
	 * @param array $config Configuratin.
	 * @return array|void `Collection` of configurations or true if setting configurations.
	 */
	public static function config($config = null) {
		//set if `config`is given
		if ($config && is_array($config)) {
			//filter only accepts configuration options
			foreach ($config as $key => $value) {
				if (\array_key_exists($key, static::$_defaults)) {
					static::$_config[$key] = $value;
					static::$_defaults[$key] = $value;
				}
			}

			return true;
		}

		$result = static::$_config;
		return $result;
	}

	public static function connect($asd) {
		try {

			static::$_oauth = new OAuth(
				static::$_defaults['consumer_key'],
				static::$_defaults['consumer_secret'],
				OAUTH_SIG_METHOD_HMACSHA1,
				OAUTH_AUTH_TYPE_URI);

			static::$_oauth->enableDebug();
			static::$_oauth->enableSSLChecks();
			static::$_oauth->setToken(
				static::$_defaults['token'],
				static::$_defaults['token_secret']);

			//make a simple request to trythe connection
			static::$_oauth->fetch(static::$_defaults['info_info_api_url']);

			static::$_connection = true;
			return static::$_oauth;
		} catch (OAuthException $E) {
			static::setErrot($E->lastResponse, $E->getCode());

			static::$_connection = false;
		}

		return static::$_oauth;
	}

	public static function write($path, $options = array()) {

		if ($options['directory'] == 'true') {

			$kind = json_encode(array(
				'kind' => 'directory'
			));

			try {

				static::$_oauth->fetch(
					static::$_defaults['files_api_url'] . static::$_defaults['base_path'] . $path,
					$kind,
					OAUTH_HTTP_METHOD_PUT);

				return true;
			} catch (OAuthException $E) {

				static::setErrot($E->lastResponse, $E->getCode());
				print_r($options);
				return false;
			}
		}
		else {
			$path_e = rawurlencode($path);
			$path_e = str_replace("%2F", "/", $path_e);

			try {

				static::$_oauth->fetch(
					static::$_defaults['files_content_url'] . static::$_defaults['base_path'] .
							$path_e,
					$options['content'],
					OAUTH_HTTP_METHOD_PUT);

				return true;
			} catch (OAuthException $E) {

				static::setErrot($E->lastResponse, $E->getCode());

				return false;
			}
		}
	}

	public function test($a){
		echo 'asd';

		
		return static::$_defaults;
	}

	public static function run() {

		echo "I am " . __METHOD__ . "\n";
	}
}

