<?php
/**
 * A wordpress filter
 *
 * @author andrea.tarocchi<at>gmail.com
 * @author paolo.fagni<at>gmail.com
 */
abstract class AFilter {

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
     * @param string $content Content to be filtered
     * @return mixed
     */
    abstract public function filter($content);
}
