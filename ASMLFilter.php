<?php

include_once(dirname(__FILE__).'/AFilter.php');

/**
 * Filters the output
 *
 * @author andrea.tarocchi@gmail.com
 * @author paolo.fagni<at>gmail.com
 */
abstract class ASMLFilter extends AFilter {

    /**
     * @var string The default langauge, from db
     */
    protected $_defaultLanguage;

    /**
     * @param string $language The default language 3 letter code (eng,fra,esp, ita...)
     */
    public function __construct($language="") {
        // Add default language option in wordpress DB
        add_option('simpleML_default_lang');
        add_filter('the_content', 'do_shortcode');

        $language != "" ? $this->_defaultLanguage = $language : $this->_defaultLanguage = get_option('simpleML_default_lang');
    }

    public function init($language) {
        // Add default language option in wordpress DB
        add_option('simpleML_default_lang');
        add_filter('the_content', 'do_shortcode');

        $language != "" ? $this->_defaultLanguage = $language : $this->_defaultLanguage = get_option('simpleML_default_lang');

    }

    /**
     * @param string $text The text to be filtered
     * @param string $lang 3 letter language code
     * @return array Two elements array: The filtered text in position 0, array of filtered languages classes in position 1
     */
    protected function filterDOM($text, $lang) {
        $doc = new DOMDocument();
        $doc->validateOnParse = false;
        $doc->loadHTML($text);
        $divs = $doc->getElementsByTagName('span');
        for($i=0; $i<$divs->length; $i++) {
            $id = $divs->item($i)->attributes->getNamedItem('class');
            if($id && substr($id->value,0,9) === 'simpleML_') {
                $nodes[] = $divs->item($i);
                if($id->value != 'simpleML_'.$lang && (substr($id->value,0,9)==='simpleML_')) {
                    $nodesToDelete[] = $divs->item($i);
                }
            }
        }
        // Check if we got an unknown lang code or no translation. Fallback to default lang if present
        $deletedNodeClasses[] = array();

        if (count($nodesToDelete) != 0 && count($nodes) == count($nodesToDelete)) {
            foreach($nodesToDelete as $n) {
                if($n->attributes->getNamedItem('class')->value != 'simpleML_'.$this->_defaultLanguage) {
                    $n->parentNode->removeChild($n);
                    $deletedNodeClasses[] = $n->attributes->getNamedItem('class')->value;
                }
            }
        }
        else if(count($nodesToDelete) != 0 && count($nodes) != count($nodesToDelete)) {
            foreach($nodesToDelete as $n) {
                $n->parentNode->removeChild($n);
                $deletedNodeClasses[] = $n->attributes->getNamedItem('class')->value;
            }
        }

        $filteredText = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $doc->saveHTML()));

        return array($filteredText, $deletedNodeClasses);
    }
}
