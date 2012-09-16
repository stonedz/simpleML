<?php
/**
 *
 *
 * @author paolo.fagni<at>gmail.com
 */
interface IWrappableShorttag {

    /**
     * Wrap the $content with user-defined values
     *
     * @abstract
     * @param string $content Content to be wrapped
     * @param mixed $var The value the user assigned to the shorttag variable (only one is allowed)
     * @return string
     */
    public function wrapContent($content, $var);
}
