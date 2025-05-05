<?php

namespace Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Contracts;

use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Frontend\Page;
use WP;

interface ControllerContract
{
	/**
	 * Init the controller, fires the hook that allow consumer to add pages
	 */
	function init();

	/**
	 * Register a page object in the controller
	 *
	 * @param  Page $page
	 * @return Page
	 */
	function addPage(Page $page ): Page;

	/**
	 * Run on 'do_parse_request' and if the request is for one of the registerd
	 * setup global variables, fire core hooks, requires page template and exit.
	 *
	 * @param boolean $bool The boolean flag value passed by 'do_parse_request'
	 * @param WP $wp       The global wp object passed by 'do_parse_request'
	 */
	function dispatch(bool $bool, WP $wp);
}
