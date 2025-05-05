<?php

namespace Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Frontend;

use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Contracts\PageContract;
use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Contracts\TemplateLoaderContract;

class TemplateLoader implements TemplateLoaderContract
{
	private $templates;

    /** @inheritDoc */
	public function init(PageContract $page): void
    {
		$this->templates = wp_parse_args(
			['page.php', 'index.php'], (array) $page->getTemplate()
		);
	}

    /** @inheritDoc */
	public function load(): void
    {
		do_action('template_redirect');
		$template = locate_template(array_filter($this->templates));
		$filtered = apply_filters('template_include',
			apply_filters('virtual_page_template', $template)
		);
		if (empty($filtered) || file_exists( $filtered)) {
			$template = $filtered;
		}
		if (! empty($template) && file_exists($template)) {
			require_once $template;
		}
	}
}
