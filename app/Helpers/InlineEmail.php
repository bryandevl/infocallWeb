<?php namespace App\Helpers;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**

 * Class inlineEmail
 * 
 * Returns rendered Email view with inlined CSS
 * @package App\Library
 */
class InlineEmail {
    /**
     * Filename of the view to render
     * @var string
     */
    private $view;
    /**
     * Data - passed to view
     * @var array
     */
    private $data;

    /**
     * @param string $view Filename/path of view to render
     * @param array $data Data of email
     */
    public function __construct($view, array $data)
    {
        // Render the email view
        $emailView = view($view, $data)->render();
        $this->view = $emailView;
        $this->data = $data;
    }

    /**
     * Convert to inlined CSS
     * 
     * @return string
     * @throws \TijsVerkoyen\CssToInlineStyles\Exception
     */
    public function convert()
    {
        $converter = new CssToInlineStyles();
        //$converter->setUseInlineStylesBlock();
        //$converter->setCleanup();
        //$converter->setStripOriginalStyleTags();
        //$converter->setHTML($this->view);
        //echo $this->view;dd();
        $content =  $converter->convert($this->view);

        return $content;
    }
}