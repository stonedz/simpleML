<?php

include_once(dirname(__FILE__).'/APlugin.php');
include_once(dirname(__FILE__).'/IWrappableShorttag.php');
include_once(dirname(__FILE__).'/ContentSMLFilter.php');
include_once(dirname(__FILE__).'/TitleSMLFilter.php');

/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class SMLPlugin extends APlugin implements IWrappableShorttag {

    public function loadPlugin() {
        $this->registerGetVar('lng');
        $this->createWrappingShortcode('simpleML',array('lang'=> get_option('simpleML_default_lang')));

        $filterContent = new ContentSMLFilter();
        $filterTitle = new TitleSMLFilter();

        $filterContent->registerFilter('the_content');
        $filterTitle->registerFilter('the_title');

        add_action('init', array($this, 'addButton'));
    }

    public function addButton() {
        if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') ) {
            add_filter('mce_external_plugins', array($this,'addPlugin'));
            add_filter('mce_buttons', array($this,'registerButton'));
        }
    }

    function addPlugin($plugin_array) {
        $plugin_array['simpleML'] = get_bloginfo('wpurl').'/wp-content/plugins/simpleML/customShortCode.js';
        return $plugin_array;
    }

    public function registerButton($buttons) {
       array_push($buttons, "simpleML");
       return $buttons;
    }

    public function loadAdmin() {
        add_action('admin_menu', array($this, 'create_menu'));
    }

    public function wrapContent($content, $var) {
        return '<span class="simpleML_'.$var.'"> '.$content.'</span>';
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
}
