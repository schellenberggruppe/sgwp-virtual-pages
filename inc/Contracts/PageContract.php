<?php

namespace Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Contracts;

use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Frontend\Page;
use WP_Post;

interface PageContract
{
    /**
     * Return the url assigned to the page.
     *
     * @return string
     */
	function getUrl(): string;

    /**
     * Return the template file path.
     *
     * @return string
     */
	function getTemplate(): string;

    /**
     * Return the title of a page.
     *
     * @return string
     */
	function getTitle(): string;

    /**
     * Set the title for a page.
     *
     * @param  string $title
     * @return Page
     */
	function setTitle(string $title): Page;

    /**
     * Set the HTML content for a page.
     *
     * @param  string $content
     * @return Page
     */
	function setContent(string $content): Page;

    /**
     * Set the title for the page.
     *
     * @param  string $template
     * @return Page
     */
	function setTemplate(string $template): Page;

	/**
	 * Get a WP_Post build using virtual page object
	 *
	 * @return WP_Post
	 */
	function asWpPost(): WP_Post;
}
