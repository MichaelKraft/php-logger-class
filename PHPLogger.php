<?php

class PHPLogger 
{
	// overloads
	static function d($input) {
		self::debug($input);
	}
	static function i($input) {
		self::info($input);
	}
	static function w($input) {
		self::warn($input);
	}
	static function e($input) {
		self::error($input);
	}
	static function f($input) {
		self::fatal($input);
	}
	// functions
	static function debug($input) {
		self::log($input,"debug",10,7);
	}
	static function info($input) {
		self::log($input,"info",6,8);
	}
	static function warn($input) {
		self::log($input,"warn",11,7);
	}
	static function error($input) {
		self::log($input,"error",9,7);
	}
	static function fatal($input) {
		self::log($input,"fatal",9,15);
	}
	static function log($content,$tag,$callcolor,$contentcolor) {
		if(!is_string($content)) {
			ob_start();
			var_dump($content);
			$content = ob_get_clean();
		}
		$components = explode(PHP_EOL, $content);
		if(count($components) > 1) {
			$string = $components[0] . PHP_EOL;
			for($i = 1; $i < count($components); $i++) {
				$string = "$string         $components[$i]" . PHP_EOL;
			}
		} else {
			$string = $content;
		}
		$buffer = '';
		if(strlen($tag) == 4) {
			$buffer = " ";
		}
		echo $buffer . self::component('[') . "\033[38;5;{$callcolor}m\033[48;5;0m{$tag}\033[0m" . self::component(']') . "\033[38;5;{$contentcolor}m\033[48;5;0m{$string}\033[0m" . PHP_EOL;
	}
	static private function component($piece) {
		switch (trim($piece)) {
			case '[':
				return "\033[38;5;255m\033[48;5;0m[\033[0m";
				break;
			case ']':
				return "\033[38;5;255m\033[48;5;0m]:\033[0m ";
				break;
			default:
				return '';
				break;
		}
	}

	static function demo() {
		PHPLogger::d("Beginning demo!");
		PHPLogger::i("Informational message.");
		$testingArray = array('twelve' => 12, 'four' => 4, 'nineteen' => 19);
		PHPLogger::f($testingArray);
		PHPLogger::w("A warning message");
		PHPLogger::e("Some kind of error message.");
		PHPLogger::f("A fatal message");
	}
}

if(!class_exists("Log"))
{
	class Log extends PHPLogger { }
}

