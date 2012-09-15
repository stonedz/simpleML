<?php
/**
 * @package simpleML
 * @version 0.1
 */

/*
Plugin Name: simpleML
Plugin URI: http://github.org/stonedz/simpleML
Description: Translation plugin
Author: Andrea Tarocchi, Paolo Fagni
Version: 0.1
Author URI: http://github.org/stonedz/simpleML
License: GPL2
*/

include_once(dirname(__FILE__).'/SMLFilter.php');

$plugin = new SMLFilter();
$plugin->loadPlugin();

/*function parameter_queryvars( $qvars ) {
    $qvars[] = 'lng';
    return $qvars;
}

function sml_filter($content) {

    global $wp_query;
    if (isset($wp_query->query_vars['lng'])) {
        $lang =  $wp_query->query_vars['lng'];
    }
    else {
        $lang = get_option('simpleML_default_lang');
    }

    return sml_filterHelper($lang, $content);
}

function sml_filterHelper($lang, $content) {

    $doc = new DOMDocument();
    $doc->validateOnParse = false;
    $doc->loadHTML($content);
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

    $content = $doc->saveHTML();

    return $content;
}
add_option('simpleML_default_lang');

add_filter('query_vars', 'parameter_queryvars');
add_filter('the_content', 'sml_filter');



  */


  // create custom plugin settings menu
add_action('admin_menu', 'simpleML_create_menu');

function simpleML_create_menu() {

	//create new top-level menu
	add_options_page('SimpleML Plugin Settings', 'SimpleML', 'administrator', __FILE__, 'simpleML_settings_page',plugins_url('/images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
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
<?php }