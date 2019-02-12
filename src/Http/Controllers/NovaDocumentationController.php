<?php
namespace Dniccum\NovaDocumentation\Http\Controllers;

use Dniccum\NovaDocumentation\Library\MarkdownUtility;

class NovaDocumentationController
{
    /**
     * @var MarkdownUtility $parser
     */
    public $utility;

    /**
     * NovaDocumentationController constructor.
     * @param MarkdownUtility $utility
     */
    public function __construct(MarkdownUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Returns the initial view
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index()
    {
        try {
            $homeFile = \File::get($this->utility->home);
            $homeContent = $this->utility->parse($homeFile);
        } catch (\Exception $exception) {
            return response()
                ->json($exception, 500);
        }

        return response()
            ->json([
                'home' => $homeContent,
                'title' => config('novadocumentation.title')
            ]);
    }
}