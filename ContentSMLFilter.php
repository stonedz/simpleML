<?php

include_once(dirname(__FILE__).'/ASMLFilter.php');

/**
 * Created by IntelliJ IDEA.
 * User: valdar
 * Date: 9/16/12
 * Time: 5:24 PM
 * To change this template use File | Settings | File Templates.
 */
class ContentSMLFilter extends ASMLFilter
{
    public function __construct($language="") {
//        parent::__consruct($language);
        parent::init($language);
    }

    /**
     * Filters the body in order to display only the selected language, or default if not specified.
     * Also add the multilanguage selection div (in order to switch to the filtered langages).
     *
     * @param string $content The post's body to be filtered
     * @return string
     */
    public function filter($content) {
        global $wp_query;
        if (isset($wp_query->query_vars['lng'])) {
            $lang =  $wp_query->query_vars['lng'];
        }
        else {
            $lang = $this->_defaultLanguage;
        }

        $filteringReturn = $this->filterDOM($content, $lang);

        $multilanguageFlagDiv = '';
        if(array_unique($filteringReturn[1]) > 0){
            $multilanguageFlagDiv = '<div class="robots-nocontent">';
            foreach(array_unique($filteringReturn[1]) as $currClassNames){
                $multilanguageFlagDiv .= $this->addMutilanguageFlags($currClassNames);
            }
            $multilanguageFlagDiv .= '</div>';
        }

        $tmpArr = $this->filterDOM($content, $lang);
        return $multilanguageFlagDiv.$tmpArr[0];
    }

    /**
     * Create the post permalink for a given language (class name)
     *
     * @param $undisplayedLanguaeClass The undisplayed language class name
     * @return string The post's permalink of undisplayed language
     */
    private function addMutilanguageFlags($undisplayedLanguaeClass){
        //TODO: verificare se siamo il primo parametro o no!!!
        $undisplayedLanguae = substr($undisplayedLanguaeClass,9,3);
        $multilanguageFlagLink = '<a href="'.get_permalink().'&lng='.$undisplayedLanguae.'">'.$undisplayedLanguae.'</a> ';
        return $multilanguageFlagLink;
    }
}
