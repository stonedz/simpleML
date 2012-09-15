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
$plugin->loadAdmin();
