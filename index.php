<?php
/**
 * Plugin Name:       SGWP Virtual Pages
 * Description:       Allow to create virtual pages for wordpress.
 * Version:           1.0.0
 * Requires at least: 6.7
 * Requires PHP:      8.3
 * Author:            Schellenberg Gruppe AG
 * Text Domain:       sgwp_virtual_pages
 * Domain Path: 	  /languages/
 */

// exit if accessed directly

if (! defined('ABSPATH')) { die(); }

// define plugin constants

define('SGWP_VIRTUAL_PAGES', __FILE__);
define('SGWP_VIRTUAL_PAGES_PLUGIN_URL', plugin_dir_url(SGWP_VIRTUAL_PAGES));
define('SGWP_VIRTUAL_PAGES_PLUGIN_DIR', untrailingslashit(dirname(SGWP_VIRTUAL_PAGES)));

// autoload composer dependencies

require_once(SGWP_VIRTUAL_PAGES_PLUGIN_DIR.DIRECTORY_SEPARATOR.'bootstrap.php');

