<?php

/**
 *  mylinks Utility Class Elements
 *
 * @copyright::  ZySpec Incorporated
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @subpackage:: class
 * @author::     zyspec (owners@zyspec.com)
 * @version::    $Id: utility.php 11819 2013-07-09 18:21:40Z zyspec $
 * @since::     File available since Release 3.11
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * MylinksUtility
 *
 * @package::   mylinks
 * @author::    zyspec (owners@zyspec.com), Herve Thouzard
 * @copyright:: Copyright (c) 2010 ZySpec Incorporated, Herve Thouzard
 * @version::   $Id: utility.php 11819 2013-07-09 18:21:40Z zyspec $
 * @access::    public
 */
class mylinksUtility
{
/**
     * Sanitize input variables
     * @param  string          $global  the input array ($_REQUEST, $_GET, $_POST)
     * @param  unknown_type    $key     the array key for variable to clean
     * @param  unknown_type    $default the default value to use if filter fails
     * @param  string          $type    the variable type (string, email, url, int)
     * @param  array           $limit   'min' 'max' keys - the lower/upper limit for integer values
     * @return number|Ambigous <boolean, unknown>
     */
    function mylinks_cleanVars( &$global, $key, $default = '', $type = 'int', $limit=NULL)
    {
        switch ( $type )
        {
            case 'string':
                $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_MAGIC_QUOTES ) : $default;
                break;
            case 'email':
                $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_EMAIL ) : $default;
                break;
            case 'url':
                $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_URL ) : $default;
                break;
            case 'int':
            default:
                $default = intval($default);
                $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_NUMBER_INT ) : false;
                if ( isset($limit) && is_array($limit) && ( false !== $ret) ) {
                    if (array_key_exists('min', $limit)) {
                        $ret = ( $ret >= $limit['min'] ) ? $ret : false;
                    }
                    if (array_key_exists('max', $limit)) {
                        $ret = ( $ret <= $limit['max'] ) ? $ret : false;
                    }
                }
                break;
        }
        $ret = ($ret === false) ? $default : $ret;

        return $ret;
    }
    /**
     *
     * Temporary patch for error_handler processing
     * @deprecated
     * @param  string $msg   message to display
     * @param  int    $pages number of pages to jump back for link
     * @param  string $type  error||info to add errorMsg CSS to display
     * @return null
     */
    function show_message($msg, $pages=1, $type='error') {
        switch (mb_strtolower($type)) {
            case 'error':
                $div_class = "class='errorMsg'";
                break;
            case 'info':
                $div_class = "";
                break;
        }
        include_once XOOPS_ROOT_PATH . '/header.php';
        echo "<div{$div_class}><strong>{$xoopsConfig['sitename']} Error</strong><br /><br />\n"
           . "Error Code: {$e_code}<br /><br /><br />\n"
           . "<strong>ERROR:</strong> {$msg}<br />\n";
           $pages = intval($pages);
           if (0 != $pages) {
               $pages = '-' . abs($pages);
               echo "<br /><br />\n"
                  . "[ <a href=\'javascript:history.go(-{$pages})\'>" . _BACK . "</a> ]</div>";
           }
        include_once XOOPS_ROOT_PATH . '/footer.php';

        return;
    }
}
