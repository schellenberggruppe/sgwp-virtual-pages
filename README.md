## Installation

### Step-01: Require Composer

Install the composer package using your shell:

```shell
composer require schellenberggruppe/sgwp-virtual-pages
```

### Step-02: Configuration

Use the `.env` file to set the configuration.


## Configuration

### `ACTION_ADD_PAGE`

A string that determines the action to call to add a new virtual 
page. Default is: `'add_virtual_pages''`

## How to use

### Step-01: Create Controller

Create a new controller class and implement the 
`Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Traits\HasVirtualPages` 
trait:

```php
<?php

use Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Traits\HasVirtualPages;

class FrontendMagazineController
{
	use HasVirtualPages;
}
```

### Step-02: Add Page

Create a new public static function choose the name you want. 
Execute the `enable_virtual_pages()` function and call the `gm_virtual_pages` 
action:

```php
public static function register_pages() 
{
    $controller = self::enable_virtual_pages();
    
    add_action('add_virtual_pages', function($controller) {
        $controller->addPage(new Page('/custom/page'))
            ->setTitle('Page Title')
            ->setContent('<a href="#">a html link</a>');
    });
}
```

### Page Object

The `Schellenberg\Gruppe\WP\Plugin\Virtual\Pages\Frontend\Page` 
can be used to create a new page. The constructor helps to setup 
the page:

```php
$url = '/custom/url/'; // The URL used to get the page. (required)
$title = 'Untilted Document'; // The page title.
$template = 'page.php'; // WordPress Template file for the page.

$page = new Page($url, $title, $template);
```

You can also use setter or getter functions:

```php
$url = '/custom/url/';

$page = new Page($url);

$page->setTitle('A new Title');
$page->setContent('<span>HTML content</span>');
$page->setTemplate('index.php');

$page->getUrl(); // Get the url for the page.
$page->getTemplate(); // Get the template file path.
$page->getTitle(); // Get the page's title.
```

Use the `asWpPost()` function to convert the page into a WP Post:

```php
$post = $page->asWpPost();
```