<?php

namespace KBNT\TimberHelper;

use Timber\Twig_Function;
use Twig\Environment;


class Debug
{
	/**
	 * Load additional functionality.
	 */
	public function __construct()
	{
		if (defined('WP_DEBUG') && WP_DEBUG ) {
		add_filter('timber/twig', [$this, 'add_to_twig']);
		}
	}

	/**
	 * Adds functionality to Twig.
	 *
	 * @param Twig\Environment $twig The Twig environment.
	 * @return Twig\Environment
	 */
	public function add_to_twig($twig) {
		$twig->addFunction(new Twig_Function('dump', [$this, 'dump']));
	}

	/**
	 * Dump variable.
	 *
	 * @param mixed $var Variable to dump.
	 * @return void
	 */
	private function dump($var) {
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}
}
