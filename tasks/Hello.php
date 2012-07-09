<?php
namespace app\tasks;

class Hello {
	public static function run() {
		echo "I am " . __METHOD__ . "\n";
	}

	public static function say($name) {
		echo "I am " . __METHOD__ . "\n";
		return 'Hello ' . $name;
	}
}

?>
