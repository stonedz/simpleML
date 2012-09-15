<?php

include_once(dirname(__FILE__).'/AFilter.php');

/**
 * Filters the output
 *
 * @author andrea.tarocchi@gmail.com
 * @author paolo.fagni<at>gmail.com
 */
class SMLFilter extends AFilter {

    /**
     * @var string The default langauge, from db
     */
    private $_defaultLanguage;

    /**
     * @param string $language The default language 3 letter code (eng,fra,esp, ita...)
     */
    public function __construct($language="") {
        $this->_defaultLanguage = $language;
    }

    public function loadPlugin() {
        // Add default language option in wordpress DB
        add_option('simpleML_default_lang');

        $this->registerGetVar('lng');

        $this->registerFilter('the_content');
        $this->registerFilter('the_title');
    }

    public function loadAdmin() {
        add_action('admin_menu', array($this, 'create_menu'));
    }

    public function create_menu() {
        //create new top-level menu
        add_options_page('SimpleML Plugin Settings', 'SimpleML', 'administrator', __FILE__, array($this, 'simpleML_settings_page'),plugins_url('/images/icon.png', __FILE__));

        //call register settings function
        add_action( 'admin_init', array($this, 'register_mysettings'));
    }

    public function register_mysettings() {
        //register our settings
        register_setting( 'simpleML-settings-group', 'simpleML_default_lang' );
    }

    function simpleML_settings_page() {
        ?>
        <div class="wrap">
            <h2>SimpleML Settings</h2>

            <form method="post" action="options.php">
                Default Language: <input type="text" name="simpleML_default_lang" value="<?php echo get_option('simpleML_default_lang')?>"/>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
                <?php settings_fields( 'simpleML-settings-group' ); ?>
                <?php do_settings( 'simpleML-settings-group' ); ?>


            </form>
        </div>
        <?php
    }


    /**
     * Filters the body in order to display only the selected language, or default if not specified
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
            $lang = get_option('simpleML_default_lang');
        }

        return $this->filterDOM($content, $lang);
    }

    /**
     * @param string $text The text to be filtered
     * @param string $lang 3 letter language code
     * @return string The filtered text
     */
    private function filterDOM($text, $lang) {
        $doc = new DOMDocument();
        $doc->validateOnParse = false;
        $doc->loadHTML($text);
        $divs = $doc->getElementsByTagName('div');
        for($i=0; $i<$divs->length; $i++) {
            $id = $divs->item($i)->attributes->getNamedItem('class');
            if($id && $id->value != 'simpleML_'.$lang && (substr($id->value,0,9)==='simpleML_')) {
                $nodesToDelete[] = $divs->item($i);
            }
        }
        foreach($nodesToDelete as $n) {
            $n->parentNode->removeChild($n);
        }

        $filteredText = $doc->saveHTML();
        return $filteredText;
    }

}
