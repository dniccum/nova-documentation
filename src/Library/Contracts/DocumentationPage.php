<?php


namespace Dniccum\NovaDocumentation\Library\Contracts;


class DocumentationPage
{
    /**
     * @var string|null
     */
    public ?string $title;

    /**
     * @var string
     */
    public string $route;

    /**
     * @var mixed
     */
    public mixed $file;

    /**
     * @var bool
     */
    public $isHome = false;

    /**
     * @var
     */
    public $pageTitle;

    /**
     * @var string
     */
    public $content;

    /**
     * @var null|int
     */
    public $order;

    /**
     * What is used to construct routes
     * @var string
     */
    protected string $prefix = 'documentation';

    public function __construct($file, string $route, PageContent $content, bool $isHome = false)
    {
        $this->file = $file;
        $this->title = config('novadocumentation.title');
        $this->content = $this->replaceLinks($content->content);
        $this->isHome = $isHome;

        if ($this->isHome) {
            $this->route = "";
        } else {
            if ($content->path) {
                $this->route = "/$content->path";
            } else {
                $this->route = "/$route";
            }
        }
        $this->route = preg_replace('/([^:])(\/{2,})/', '$1/', $this->route);

        if ($content->title) {
            $this->title = $content->title;
            $this->pageTitle = $content->title;
        } else {
            $this->pageTitle = $this->getPageTitle($file);
            $this->title = $this->pageTitle;
        }
        if ($content->order) {
            $this->order = $content->order;
        }
    }

    /**
     * @param string $htmlContent
     * @return string
     */
    private function replaceLinks(string $htmlContent): string
    {
        $regex = "/<a.+href=['|\"](?!http|https|mailto|\/)([^\"\']*)['|\"].*>(.+)<\/a>/i";
        $novaPath = rtrim(config('nova.path', ''), '/');
        // Ensure we have a proper path structure: /nova/documentation/ or /documentation/
        $basePath = $novaPath ? $novaPath . '/' : '/';
        $output = preg_replace($regex,'<a href="'.$basePath.$this->prefix.'/\1">\2</a>',$htmlContent);
        // Remove file extensions from href attributes (before the closing quote)
        $output = preg_replace('/(href=["\'])([^"\']*)(\.md|\.text|\.mdown|\.mkdn|\.mkd|\.mdwn|\.mdtxt|\.Rmd|\.mdtext)(["\'])/i', '$1$2$4', $output);
        // Fix any double slashes that might have been created
        $output = preg_replace('/([^:])\/\//', '$1/', $output);

        return $output;
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
}
