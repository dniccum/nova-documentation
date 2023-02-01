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