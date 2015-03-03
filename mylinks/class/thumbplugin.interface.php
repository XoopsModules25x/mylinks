<?php
/**
 *  mylinks Thumb Provider Plugin Interface Class Elements
 *
 * @copyright::  ZySpec Incorporated
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @subpackage:: class
 * @author::     zyspec (owners@zyspec.com)
 * @version::    $Id: $
 * @since::     File available since Release 3.11
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * MylinksThumbPluginInterface
 *
 * @package::   mylinks
 * @author::    zyspec (owners@zyspec.com), Herve Thouzard
 * @copyright:: Copyright (c) 2012 ZySpec Incorporated, Herve Thouzard
 * @version::   $Id: $
 * @access::    public
 */
interface MylinksThumbPlugin
{
    public function getProviderUrl();
    public function getProviderName();
    public function setShotSize($szarray);
    public function getShotSize();
    public function setSiteUrl($url);
    public function getSiteUrl();
    public function setAttribution();
    public function getAttribution();
    public function setProviderPublicKey($key);
    public function getProviderPublicKey();
    public function setProviderPrivateKey($key);
    public function getProviderPrivateKey();
}
