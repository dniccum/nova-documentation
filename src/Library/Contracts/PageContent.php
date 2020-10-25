<?php


namespace Dniccum\NovaDocumentation\Library\Contracts;


use Dniccum\NovaDocumentation\Library\MarkdownUtility;

class PageContent
{
    /**
     * @var string|null
     */
    public $title;

    /**
     * @var int|null
     */
    public $order;

    /**
     * @var string|null
     */
    public $path;

    /**
     * @var string $content
     */
    public $content;

    /**
     * @var array
     */
    public $meta;

    /**
     * PageContent constructor.
     * @param string $content
     * @param $meta
     */
    public function __construct(string $content, $meta = [])
    {
        if (array_key_exists('title', $meta)) {
            $this->title = $meta['title'];
        }
        if (array_key_exists('order', $meta)) {
            $this->order = $meta['order'];
        }
        if (array_key_exists('path', $meta)) {
            $this->path = $meta['path'];
        }
        $utility = new MarkdownUtility();
        $this->content = $utility->markdownParser->parse($content);
        $this->meta = $meta;
    }
}