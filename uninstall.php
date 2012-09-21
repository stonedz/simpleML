<?php
/**
 *
 * @author paolo.fagni<at>gmail.com
 */
  //if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

delete_option('simpleML_default_lang');