<?php

namespace Dniccum\NovaDocumentation;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaDocumentation extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-documentation', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-documentation', __DIR__.'/../dist/css/tool.css');
        // themes
        Nova::script('nova-documentation-github', __DIR__.'/../dist/github.js');
        Nova::script('nova-documentation-githubDark', __DIR__.'/../dist/githubDark.js');
        Nova::script('nova-documentation-monokai', __DIR__.'/../dist/monokai.js');
        Nova::script('nova-documentation-atom', __DIR__.'/../dist/atom.js');
        Nova::script('nova-documentation-atomDark', __DIR__.'/../dist/atomDark.js');
        Nova::script('nova-documentation-gradient', __DIR__.'/../dist/gradient.js');
        Nova::script('nova-documentation-gradientDark', __DIR__.'/../dist/gradientDark.js');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuSection::make(trans('nova-documentation::navigation.sidebar-link'))
            ->path('/documentation')
            ->icon('document');
    }
}
