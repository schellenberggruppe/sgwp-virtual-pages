<?php

namespace Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Frontend;

use JetBrains\PhpStorm\NoReturn;
use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Contracts\ControllerContract;
use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Contracts\TemplateLoaderContract;
use SplObjectStorage;
use WP;
use WP_Post;

class Controller implements ControllerContract
{
	private $pages;
	private TemplateLoaderContract $loader;
	private $matched;

	/**
	 * Create a new virtual pages controller instance.
	 *
	 * @param TemplateLoaderContract $loader
	 */
	function __construct(TemplateLoaderContract $loader)
	{
		$this->pages = new SplObjectStorage;
		$this->loader = $loader;
	}

	/**
	 * Execute add virtual pages action.
	 *
	 * @return void
	 */
	function init(): void
	{
        $action = 'add_virtual_pages';

        if (array_key_exists('ACTION_ADD_PAGE', $_ENV)) {
            $action = $_ENV['ACTION_ADD_PAGE'];
        }
        
		do_action($action, $this);
	}

    /**
     * Add a page to the controller.
     *
     * @param  Page $page
     * @return Page
     */
	function addPage(Page $page): Page
	{
		$this->pages->attach($page);
		return $page;
	}

    /**
     * Dispatches the controller request.
     *
     * @param  bool $bool
     * @param  WP $wp
     * @return bool
     */
	function dispatch(bool $bool, WP $wp): bool
    {
		if ($this->checkRequest() && $this->matched instanceof Page) {
			$this->loader->init($this->matched);
			$wp->virtual_page = $this->matched;
			do_action('parse_request', $wp);
			$this->setupQuery();
			do_action('wp', $wp);
			$this->loader->load();
			$this->handleExit();
		}

		return $bool;
	}

    /**
     * Proofs the page request.
     *
     * @return true|void
     */
	private function checkRequest()
    {
		$this->pages->rewind();

		$path = trim(strtok($this->getPathInfo(), "?"), "/");

		while($this->pages->valid()) {
			if (trim($this->pages->current()->getUrl(), '/' ) === $path) {
				$this->matched = $this->pages->current();

				return TRUE;
			}
			$this->pages->next();
		}
	}

    /**
     * Return the info for the pages path url.
     *
     * @return array|string|null
     */
	private function getPathInfo(): array|string|null
    {
		$home_path = parse_url(home_url(), PHP_URL_PATH);

		return preg_replace( "#^/?{$home_path}/#", '/', esc_url( add_query_arg(array()) ) );
	}

    /**
     * Set up the query to fetch the page.
     *
     * @return void
     */
	private function setupQuery(): void
    {
		global $wp_query;

		$wp_query->init();
		$wp_query->is_page       = TRUE;
		$wp_query->is_singular   = TRUE;
		$wp_query->is_home       = FALSE;
		$wp_query->found_posts   = 1;
		$wp_query->post_count    = 1;
		$wp_query->max_num_pages = 1;

		$posts = (array) apply_filters(
			'the_posts', [$this->matched->asWpPost()], $wp_query
		);
		$post = $posts[0];
		$wp_query->posts          = $posts;
		$wp_query->post           = $post;
		$wp_query->queried_object = $post;
		$GLOBALS['post']          = $post;
		$wp_query->virtual_page   = $post instanceof WP_Post && isset($post->is_virtual)
			? $this->matched
			: NULL;
	}

    /**
     * Handle the controllers request exit.
     *
     * @return void
     */
	#[NoReturn] public function handleExit(): void
    {
		exit();
	}
}
