<?php

namespace Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Contracts;

interface TemplateLoaderContract
{
	/**
	 * Setup loader for a page objects
	 *
	 * @param PageContract $page matched virtual page
	 */
	public function init(PageContract $page);

	/**
	 * Trigger core and custom hooks to filter templates,
	 * then load the found template.
	 */
	public function load();
}
