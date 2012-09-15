<?php

include_once(dirname(__FILE__).'/APlugin.php');

/**
 * A wordpress filter
 *
 * @author andrea.tarocchi<at>gmail.com
 * @author paolo.fagni<at>gmail.com
 */
abstract class AFilter extends APlugin{

    /**
     * @param string $where A valid worpress filter hook
     * @internal param callable $function The filter function
     * @return bool|WP_Error
     */
     public function registerFilter($where) {
         add_action($where, array($this,'filter'));
         return true;
     }

    /**
     * The callback function to be hooked to wordpress
     *
     * @abstract
     * @return mixed
     */
    abstract public function filter();
}
