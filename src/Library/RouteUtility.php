<?php

namespace Dniccum\NovaDocumentation\Library;

use Dniccum\NovaDocumentation\Library\Contracts\DocumentationPage;

class RouteUtility
{
    /**
     * @param mixed $fileToParse
     * @param DocumentationPage[] $pageRoutes
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public static function buildDocumentRoute(mixed $fileToParse, array $pageRoutes): \Inertia\Response|\Inertia\ResponseFactory
    {
        $utility = new MarkdownUtility();
        $file = \File::get($fileToParse);
        $content = $utility->parse($file);
        $content = new DocumentationPage($file, '', $content);

        return inertia('Documentation',
            array_merge([
                'sidebar' => $pageRoutes,
            ], compact('file', 'content'))
        );
    }
}