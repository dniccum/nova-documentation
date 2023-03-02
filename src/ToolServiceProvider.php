<?php

namespace Dniccum\NovaDocumentation;

use Dniccum\NovaDocumentation\Library\Contracts\DocumentationPage;
use Dniccum\NovaDocumentation\Library\MarkdownUtility;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;
use Dniccum\NovaDocumentation\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    private string $config = 'novadocumentation';

    private string $namespace = 'nova-documentation';

    /**
     * What is used to construct routes
     * @var string
     */
    public string $prefix = 'documentation';

    /**
     * @var MarkdownUtility $utility
     */
    protected MarkdownUtility $utility;

    /**
     * @var DocumentationPage[] $pageRoutes
     */
    protected array $pageRoutes = [];

    /**
     * Bootstrap any application services.
     *
     * @throws \Exception
     * @return void
     */
    public function boot()
    {
        $this->utility = new MarkdownUtility();
        $this->pageRoutes = $this->utility->buildPageRoutes();

        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->namespace);
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', $this->namespace);

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::provideToScript([
                'urlPrefix' => $this->prefix,
                'pages' => $this->pageRoutes,
                'highlightFlavor' => config('novadocumentation.flavor')
            ]);
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/'.$this->config.'.php' => base_path('config/'.$this->config.'.php'),
            ], 'config');
        }

        $this->publishes([
            __DIR__.'/../resources/documentation/home.md' => resource_path('documentation/home.md'),
            __DIR__.'/../resources/documentation/sample.md' => resource_path('documentation/sample.md'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/'.$this->namespace),
        ], 'lang');
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix(\Str::finish(config('nova.path'), '/').$this->prefix)
            ->group(__DIR__.'/../routes/inertia.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/'.$this->config.'.php', $this->config);
    }
}
