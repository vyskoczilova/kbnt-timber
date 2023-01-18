<?php

namespace KBNT\TimberHelper;

use Timber\Twig_Function;
use Twig\Environment;

class AcfBlocksSupport
{

	/**
	 * Load additional functionality.
	 */
	public function __construct()
	{
		add_filter('timber/twig', [$this, 'add_to_twig']);
	}

	/**
	 * Adds functionality to Twig.
	 *
	 * @param Twig\Environment $twig The Twig environment.
	 * @return Twig\Environment
	 */
	public function add_to_twig($twig) {
		$twig->addFunction(new Twig_Function('json_blocks', [$this, 'encode_json']));
		$twig->addFunction(new Twig_Function('blacklist_classes', [$this, 'blacklist_classes']));
	}

	/**
	 * Encode array to JSON.
	 *
	 * @param array $array Array to encode.
	 * @return string
	 */
	private function encode_json($array) {
		return esc_attr(wp_json_encode($array));
	}

	/**
	 * Cleanup string with ACF classes.
	 *
	 * @param $string string with HTML classes.
	 * @param $blacklist array with classes to remove.
	 * @return string
	 */
	private function blacklist_classes($string, $blacklist = []) {
		$array = \explode(' ', $string);
		$new_classes = [];
		foreach( $array as $a ) {
			if (!\in_array($a, $blacklist, true) && \substr($a, 0, strlen('wp-block-acf-')) !== 'wp-block-acf-')  {
				$new_classes[] = $a;
			}
		}
		if (count($new_classes) > 0) {
			return ' ' .\implode(' ', $new_classes);
		}
		return '';
	}

}
