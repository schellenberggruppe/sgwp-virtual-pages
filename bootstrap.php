<?php

// exit if accessed directly

if (! defined('ABSPATH')) { die(); }

// autoload composer & other dependencies

if (is_readable(SGWP_VIRTUAL_PAGES_PLUGIN_DIR.'/vendor/autoload.php')) {
    require_once(SGWP_VIRTUAL_PAGES_PLUGIN_DIR.'/vendor/autoload.php');

	/**
	 * Enable PHP dotenv package.
	 *
	 * Loads environment variables from .env to getenv(), $_ENV and $_SERVER automagically.
	 *
	 * @link https://github.com/vlucas/phpdotenv
	 */
	$dotenv = Dotenv\Dotenv::createImmutable(SGWP_VIRTUAL_PAGES_PLUGIN_DIR);
	$dotenv->load();
}
