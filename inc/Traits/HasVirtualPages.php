<?php

namespace Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Traits;

use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Frontend\Controller;
use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Frontend\Page;
use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Frontend\TemplateLoader;
use WP_Query;

trait HasVirtualPages
{
    /**
     * Enable the virtual pages and return the controller.
     *
     * @return Controller
     */
    public static function enable_virtual_pages(): Controller
    {
        $controller = new Controller(new TemplateLoader());

        add_action('init', [$controller, 'init']);

        add_filter('do_parse_request', [$controller, 'dispatch'], PHP_INT_MAX, 2);

        add_action('loop_end', function(WP_Query $query) {
            if (isset($query->virtual_page) && ! empty($query->virtual_page)) {
                $query->virtual_page = NULL;
            }
        });

        add_filter('the_permalink', function( $plink ) {
            global $post, $wp_query;
            if (
                $wp_query->is_page && isset( $wp_query->virtual_page )
                && $wp_query->virtual_page instanceof Page
                && isset($post->is_virtual) && $post->is_virtual
            ) {
                $plink = home_url($wp_query->virtual_page->getUrl());
            }
            return $plink;
        });

        return $controller;
    }
}