<?php

namespace Dniccum\NovaDocumentation\Http\Controllers;

use Dniccum\NovaDocumentation\Library\MarkdownUtility;
use Dniccum\NovaDocumentation\Library\RouteUtility;
use Laravel\Nova\Http\Requests\NovaRequest;

class NovaDocumentationController
{
    /**
     * @var MarkdownUtility $markdownUtility
     */
    public MarkdownUtility $markdownUtility;

    /**
     * NovaDocumentationController constructor.
     * @param MarkdownUtility $markdownUtility
     */
    public function __construct(MarkdownUtility $markdownUtility)
    {
        $this->markdownUtility = $markdownUtility;
    }

    /**
     * @param NovaRequest $request
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function home(NovaRequest $request)
    {
        try {
            return RouteUtility::buildDocumentRoute(
                $this->markdownUtility->home,
                $this->markdownUtility->buildPageRoutes()
            );
        } catch (\Exception $exception) {
            abort(
                $exception->getCode() >= 400 ? $exception->getCode() : 500,
                $exception->getMessage()
            );
        }
    }

}