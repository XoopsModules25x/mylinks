<?php
/**
 *  mylinks Thumb Provider Plugin Interface Class Elements
 *
 * @copyright ::  {@link https://xoops.org/ XOOPS Project}
 * @copyright ::  ZySpec Incorporated
 * @license   ::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package   ::    mylinks
 * @subpackage:: class
 * @author    ::     zyspec (owners@zyspec.com)
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * MylinksThumbPluginInterface
 *
 * @package   ::   mylinks
 * @author    ::    zyspec (owners@zyspec.com), Herve Thouzard
 * @copyright ::  {@link https://xoops.org/ XOOPS Project}
 * @copyright :: Copyright (c) 2012 ZySpec Incorporated, Herve Thouzard
 * @access::    public
 */
interface MylinksThumbPlugin
{
    public function getProviderUrl();

    public function getProviderName();

    /**
     * @param $szarray
     * @return mixed
     */
    public function setShotSize($szarray);

    public function getShotSize();

    /**
     * @param $url
     * @return mixed
     */
    public function setSiteUrl($url);

    public function getSiteUrl();

    public function setAttribution();

    public function getAttribution();

    /**
     * @param $key
     * @return mixed
     */
    public function setProviderPublicKey($key);

    public function getProviderPublicKey();

    /**
     * @param $key
     * @return mixed
     */
    public function setProviderPrivateKey($key);

    public function getProviderPrivateKey();
}
