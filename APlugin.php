<?php
/**
 * Generic Wordpress plugin
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class APlugin {

    /**
     * @param string $varName Name of the GET variable to register
     */
    public function registerGetVar($varName) {
        add_filter('query_vars', function($qvars) use ($varName) {$qvars[] = $varName; return $qvars;});
    }

    /*
     * Initializes the plugin
     */
    abstract public function loadPlugin();
}
