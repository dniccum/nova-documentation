<?php
namespace Dniccum\NovaDocumentation\Library;

use cebe\markdown\Markdown;
use cebe\markdown\GithubMarkdown;
use cebe\markdown\MarkdownExtra;

class MarkdownUtility
{

    /**
     * The Markdown parsing package
     * @var Markdown|GithubMarkdown|MarkdownExtra $parser
     */
    public $parser;

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
                $this->parser = new Markdown();
                break;
            case 'extra':
                $this->parser = new MarkdownExtra();
                break;
            default:
                $this->parser = new GithubMarkdown();
        }

        $this->parser->html5 = true;

        if (\File::exists(resource_path(config('novadocumentation.home')))) {
            $this->home = resource_path(config('novadocumentation.home'));
        } else {
            $this->home = __DIR__.'/../../resources/'.config('novadocumentation.home');
        }
    }

    /**
     * Parse the file into the selected markdown flavor
     * @param string $filePath
     * @return string
     */
    public function parse(string $filePath)
    {
        return $this->parser->parse($filePath);
    }

    /**
     * Builds all of the Vue routes depending on the pages that are available.
     * @return array
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

                $options[] = [
                    'title' => config('novadocumentation.title'),
                    'pageRoute' => $pathsToAdd[$i],
                    'file' => $target,
                    'home' => is_int(strpos($files[$i], config('novadocumentation.home'))),
//                    'content' => $this->replaceLinks($content, $pathsToAdd[$i]),
                    'content' => $content,
                    'pageTitle' => $this->getPageTitle($target)
                ];
            }

            for($i = 0; $i < count($options); $i++) {
                $options[$i]['content'] = $this->replaceLinks($options[$i]['content'], $options);
            }

        } catch (\Exception $e) {
            abort(500, $e);
        }

        return $options;
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

    /**
     * Returns the title of the page
     * @param string $filePath
     * @return string
     */
    private function getPageTitle(string $filePath): string
    {
        $lines = file($filePath);
        $title = '';

        foreach ($lines as $line) {
            if (strpos($line, '# ') === 0) {
                $title = substr($line, 2);
            }
            break;
        }

        if (strlen($title) === 0) {
            $title = !empty($lines[0]) ? $lines[0] : 'Page Title';
        }

        return $title;
    }

    private function replaceLinks(string $htmlContent, array $otherOptions): string
    {
        $regex = "/<a.+href=['|\"](?!http|https)([^\"\']*)['|\"].*>(.+)<\/a>/i";
        $output = preg_replace($regex,'<a href="'.config('nova.path').'/documentation/\1">\2</a>',$htmlContent);
        $output = preg_replace("/(\.md|\.text|\.mdown|\.mkdn|\.mkd|\.mdwn|.\mdtxt|\.Rmd|\.mdtext)/i", '"', $output);

        return $output;
    }
}
