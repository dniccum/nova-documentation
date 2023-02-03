<?php

use Dniccum\NovaDocumentation\Library\Contracts\DocumentationPage;
use Dniccum\NovaDocumentation\Library\MarkdownUtility;
use Dniccum\NovaDocumentation\Library\RouteUtility;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;

/*
|--------------------------------------------------------------------------
| Tool Routes
|--------------------------------------------------------------------------
|
| Here is where you may register Inertia routes for your tool. These are
| loaded by the ServiceProvider of the tool. The routes are protected
| by your tool's "Authorize" middleware by default. Now - go build!
|
*/

Route::get('/', [ \Dniccum\NovaDocumentation\Http\Controllers\NovaDocumentationController::class, 'home' ])
    ->name('nova.tools.documentation-home');

try {
    $utility = new MarkdownUtility();
    $pageRoutes = $utility->buildPageRoutes();

    /**
     * @var DocumentationPage[] $filteredRoutes
     */
    $filteredRoutes = collect($pageRoutes)
        ->filter(fn(DocumentationPage $item) => !$item->isHome)
        ->toArray();

    foreach ($filteredRoutes as $filteredRoute) {
        \Illuminate\Support\Facades\Route::get("/$filteredRoute->route", function () use ($filteredRoute, $pageRoutes) {
            return RouteUtility::buildDocumentRoute($filteredRoute->file, $pageRoutes);
        });
    }
} catch (\Dniccum\NovaDocumentation\Exceptions\DocumentationParsingException $exception) {
    abort($exception->getCode() > 0 ? $exception->getCode() : 500, $exception->getMessage());
}