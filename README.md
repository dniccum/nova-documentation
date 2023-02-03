![Documentation tool for Laravel Nova](https://github.com/dniccum/nova-documentation/blob/master/screenshots/nova-documentation-social-image.png?raw=true)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dniccum/nova-documentation.svg?style=flat-square&color=#0E7FC0)](https://packagist.org/packages/dniccum/nova-documentation)
[![License](https://img.shields.io/packagist/l/dniccum/nova-documentation.svg?style=flat-square)](https://packagist.org/packages/dniccum/nova-documentation)
[![Total Downloads](https://img.shields.io/packagist/dt/dniccum/nova-documentation.svg?style=flat-square)](https://packagist.org/packages/dniccum/nova-documentation)

This is a tool for Laravel's Nova administrator panel that allows you to create markdown-based documentation for your application; without having to leave the Nova environment.

[![Screenshot](https://raw.githubusercontent.com/dniccum/nova-documentation/master/screenshots/screenshot-1.png)](https://raw.githubusercontent.com/dniccum/nova-documentation/master/screenshots/screenshot-1.png)



## Compatibility Note

Please note, this plugin now **only supports Laravel Nova v4**. If you are using Laravel Nova <= v3, please use version `^3.0`,

## Features

* Parses each markdown document and renders them in the Nova dashboard
* Dynamic page titles: Each h1 tag (`# title`) is set as the page title
    * Each page title is then used to construct a sidebar, allowing for navigation through your documentation.
    * Allows for nested directories
* Supports YAML parsing to further customize page titles 
* Syntax highlighting for code blocks (via [highlight.js](https://highlightjs.org/))
* Replaces local links within the body content to work within the Nova environment.
* Supports both browser light and dark themes.

## Installation

You can install the package via composer:

```
composer require dniccum/nova-documentation
```

You will then need to publish the package's configuration and blade view files to your applications installation:

```
php artisan vendor:publish --provider="Dniccum\NovaDocumentation\ToolServiceProvider"
```

Finally, you will need to register the tool within the `NovaServiceProvider.php`:

```php

use Dniccum\NovaDocumentation\NovaDocumentation;

...

/**
 * Get the tools that should be listed in the Nova sidebar.
 *
 * @return array
 */
public function tools()
{
    return [
        // other tools
        new NovaDocumentation,
    ];
}
```

## Upgrading from version 2

If you are upgrading from version 2 to version 3 (Laravel Nova 4 support), make sure your `composer.json` has the following version/reference to included the updated version:

```
"dniccum/nova-documentation": "^3.0"
```

### Add YAML configuration

If you published the configuration from this package using the `vendor:publish` command, you will need to add the following code your `novadocumentation.php` configuration file's array:

```php
'parser' => env('NOVA_DOCUMENTATION_PARSER', 'yaml'),
```

### Set environment variable

If you are planning on not refactoring your markdown files to *NOT* take advantage of the new YAML configuration options, you will need to either modify your configuration file accordingly, or simply set the following environment variable:

```dotenv
NOVA_DOCUMENTATION_PARSER=markdown
```

### Remove dashed horizontal rules

If you have any `---` horizontal rules in your markdown files and your are using the `yaml` parser, you will need to convert those to use `***` instead as this will cause the YAML processing to error.

## Using this tool

* After all of this tool's assets have been published, there should be two `.md` (markdown) files placed within a documentation directory at the base of your `resources` directory.
    * If you would like to change this directory, change the `config('novadocumentation.home')` configuration definition.
    * By default, the "home page" entry point is `home.md`. Again if you would like to change that, be sure that you alter the `config('novadocumentation.home')` configuration.
* If using the markdown setup, the sidebar navigation is constructed using two different elements: the name of the file and the title of within the file. This title is dynamically pulled from the first `# title` in each file.

### Page YAML configuration/customization

If you are using the `yaml` parsing method, you have the **OPTIONAL** ability to customize how each page is built and shown within the sidebar. You can modify the following attributes:

* title - The title of the page within the sidebar
* path - The path/route/link of the page. Provide a valid URL
* order - The order in which this page will appear in the sidebar

#### Adding configuration to your pages

If we wanted to customize a page of documentation we would need to add the following content to the top of the page:

```yaml
---
title: "Adding Content"
path: content
order: 2
---

# Adding content to your application

...
```

The important thing to note is the `---` element wrapping the configuration. **This will not work if this is not in place.** The title should be pretty self-explanatory. The path allows you to customize the route to the page.

### Linking

If you would like to link to other markdown files within your body content, outside of the sidebar, be sure to use **relative links** that **DO NOT** begin with a forward slash, like so `/relative`. For example if you are linking from the home page to a sub-directory based file called authentication, you would link to it like so:

```md
[authentication](authentication/base.md)
```

The tool will dynamically replace this link.

#### Relative links

If you would like to include a relative link to another location within your application or Nova itself, include a link that is prefixed with a forward slash (`/`), like so:

```cmd
[terms and services](/terms-and-services)
```

#### Other types

Other types of links that are supported:

* Mailto (`mailto:`) links
* External http and https links

### Routes and adding new pages

When a new document is added to the application architecture, and if your application leverages route caching, **be sure to clear/reset your route cache accordingly** (`php artisan route:clear`).

## Configuration

The configuration items listed below can be found in the `novadocumentation.php` configuration file.

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The name/title of this tool that will appear as a page default if no title is provided.
    |
    */

    'title' => 'Documentation',

    /*
    |--------------------------------------------------------------------------
    | Parser
    |--------------------------------------------------------------------------
    |
    | Set the parser that you would like to use to parse your documentation.
    | It is recommended to use the "yaml" parser as it allows for further
    | configuration, but may not be as user friendly to all devs/users.
    |
    | Available parsers: yaml, markdown
    |
    */

    'parser' => env('NOVA_DOCUMENTATION_PARSER', 'yaml'),

    /*
    |--------------------------------------------------------------------------
    | Markdown Flavor
    |--------------------------------------------------------------------------
    |
    | The flavor/style of markdown that will be used. The GitHub flavor is the
    | default as it supports code blocks and other "common" uses.
    |
    | Available flavors: github, atom, gradient, monokai
    |
    */

    'flavor' => 'github',

    /*
    |--------------------------------------------------------------------------
    | Home Page
    |--------------------------------------------------------------------------
    |
    | The markdown document that will be used as the home page and/or entry
    | point. This will be located within the documentation directory that resides
    | within your application's resources directory.
    |
    */

    'home' => 'documentation/home.md',

];
```

## License

The Nova Documentation tool is free software licensed under the MIT license.

## Credits

* [Doug Niccum](https://github.com/dniccum)
* [Calvin Schemanski](https://github.com/calvinps)
* [Adriaan Zonnenberg](https://github.com/adriaanzon)
