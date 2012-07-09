<?php
/**
 * Configure proper permissions on image folders 
 *
 * @copyright     Copyright 2012, Michael Nitschinger (michael@nitschinger.at)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\extensions\command;

class Install extends \lithium\console\Command {

	

	public $webroot = null;

	protected function _init() {
		parent::_init();
		$this->webroot = $this->webroot ?: LITHIUM_APP_PATH . '/webroot';
	}

	public function run() {
		$this->header("Installing Biarq Admin site");

		$cmd = "find {$this->webroot}/img/. -type d -exec chmod 777 {} \;";

		$this->out("Executing: $cmd"); 
		
		system($cmd);
	}

}

?>