<?php
/**
 * Generic Wordpress plugin
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class APlugin {

    /**
     * @var array
     */
    private $_attributes;

    /**
     * @param string $varName Name of the GET variable to register
     */
    public function registerGetVar($varName) {
        add_filter('query_vars', function($qvars) use ($varName) {$qvars[] = $varName; return $qvars;});
    }

    /**
     * Create a wrapping shorttag
     *
     * The shortag may contain one argument (for example [shorttag var="value"]) And the content will be wrapped
     * by a user defined function ($this->wrapContent). The class that extends APlugin must also implements the
     * IWrappableShorttag interface.
     *
     * @param string $shortCodeName
     * @param array $attributes Array of attributes for the shortcode. "val" => "defaultVal". Only one is allowed.
     */
    public function createWrappingShortcode ($shortCodeName, $attributes) {
        $this->_attributes = $attributes;
        add_shortcode($shortCodeName, array($this, 'applyShortcode'));
    }

    /**
     * Helper function to dispatch the shorttag action to the class
     *
     * @param $atts
     * @param string|null $content The content of the shorttag
     * @return string|bool
     * @todo Error handling
     */
    public function applyShortcode ($atts, $content = null) {

        extract(shortcode_atts($this->_attributes, $atts));
        $keys = array_keys($this->_attributes);

        if($this instanceof IWrappableShorttag){
            return $this->wrapContent($content, $this->_attributes[$keys[0]]);
        }
        else {
            return false;
        }
   }

    /*
     * Initializes the plugin
     */
    abstract public function loadPlugin();
}
