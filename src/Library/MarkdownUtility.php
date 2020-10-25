<?php
namespace Dniccum\NovaDocumentation\Library;

use cebe\markdown\Markdown;
use cebe\markdown\GithubMarkdown;
use cebe\markdown\MarkdownExtra;
use Dniccum\NovaDocumentation\Library\Contracts\DocumentationPage;
use Dniccum\NovaDocumentation\Library\Contracts\PageContent;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class MarkdownUtility
{

    /**
     * The Markdown parsing package
     * @var Markdown|GithubMarkdown|MarkdownExtra $markdownParser
     */
    public $markdownParser;

    /**
     * @var YamlFrontMatter $yamlParser
     */
    public $yamlParser;

    /**
     * The home page
     * @var string
     */
    public $home;

    /**
     * MarkdownUtility constructor.
     */
    public function __construct()
    {
        $flavor = config('novadocumentation.flavor');

        switch ($flavor) {
            case 'standard':
                $this->markdownParser = new Markdown();
                break;
            case 'extra':
                $this->markdownParser = new MarkdownExtra();
                break;
            default:
                $this->markdownParser = new GithubMarkdown();
        }

        $this->markdownParser->html5 = true;

        $this->yamlParser = YamlFrontMatter::class;

        if (\File::exists(resource_path(config('novadocumentation.home')))) {
            $this->home = resource_path(config('novadocumentation.home'));
        } else {
            $this->home = __DIR__.'/../../resources/'.config('novadocumentation.home');
        }
    }

    /**
     * Parse content into the selected markdown flavor
     * @param string $content
     * @return PageContent
     */
    public function parse(string $content)
    {
        if (config('novadocumentation.parser') === 'yaml') {
            $content = $this->yamlParser::parse($content);
            return new PageContent($content->body(), $content->matter());
        } else {
            return new PageContent($this->markdownParser->parse($content));
        }
    }

    /**
     * Builds all of the Vue routes depending on the pages that are available.
     * @return DocumentationPage[]
     * @throws \Exception
     */
    public function buildPageRoutes()
    {
        $pathName = explode('/', config('novadocumentation.home'));
        $directory = '';

        for ($i = 0; $i < (count($pathName) - 1); $i++) {
            $directory .= $pathName[$i].'/';
        }

        if (!\File::exists(resource_path(config('novadocumentation.home')))) {
            $baseDirectory = __DIR__.'/../../resources/'.$directory;
            $files  = $this->getDirContents($baseDirectory);
        } else {
            $baseDirectory = resource_path($directory);
            $files  = $this->getDirContents($baseDirectory);
        }

        $files = $this->removeFileSuffix($files);

        $pathsToAdd = collect($files)->map(function($path) use ($directory) {
            return $this->addFilesToPath($path, preg_replace('{/$}', '', $directory));
        })->values();

        $options = [];

        try {
            for($i = 0; $i < count($pathsToAdd); $i++) {
                $target = $files[$i];
                $fileToParse = \File::get($target);

                $content = $this->parse($fileToParse);

                array_push($options, new DocumentationPage(
                    $target,
                    $pathsToAdd[$i],
                    $content,
                    is_int(strpos($files[$i], config('novadocumentation.home')))
                ));
            }
        } catch (\Exception $e) {
            abort(500, $e);
        }

        return collect($options)->sortBy('order')
            ->values()
            ->toArray();
    }

    /**
     * @param $dir
     * @param array $results
     * @return array
     */
    private function getDirContents($dir, &$results = array()){
        $files = scandir($dir);

        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                $results[] = $path;
            } else if($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }

    /**
     * Removes the file suffix
     * @param array $fileArray
     * @return array
     */
    private function removeFileSuffix(array $fileArray) {
        return collect($fileArray)->filter(function($filePath) {
            return strpos($filePath, '.markdown') ||
                strpos($filePath, '.mdown') ||
                strpos($filePath, '.mkdn') ||
                strpos($filePath, '.md') ||
                strpos($filePath, '.mkd') ||
                strpos($filePath, '.mdwn') ||
                strpos($filePath, '.mdtxt') ||
                strpos($filePath, '.text') ||
                strpos($filePath, '.Rmd') ||
                strpos($filePath, '.mdtext');
        })->values()->all();
    }

    /**
     * Adds the file name to the resource path
     * @param string $path
     * @param string $directory
     * @return string
     */
    private function addFilesToPath($path, $directory)
    {
        $pathParts = explode('/', $path);
        $index = array_search($directory, $pathParts);
        $filePath = '';

        for ($i = ($index + 1); $i < (count($pathParts) - 1); $i++) {
            $filePath .= $pathParts[$i].'/';
        }

        $fullFileName = $pathParts[count($pathParts) - 1];
        $fileName = substr($fullFileName, 0, strrpos($fullFileName, "."));

        if (!empty($fileName)) {
            return $filePath.$fileName;
        }
    }
}
