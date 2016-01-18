<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * to use the provider:
 * $shot = new MylinksThumbshots();
 * $shot->setProviderPrivateKey(my_key);
 * $shot->setShotSize(array('width'=>120));
 * $shot->setSiteUrl("http://site_to_capture");
 * $mylinks_shotprovider = $shot->getProviderUrl();
 *
 * Then in the template use something like:
 *  <img src='<{$mylinks_shotprovider}>' target='_blank' alt='' style='margin: 3px 7px;' />
 *  and at the bottom of the page show the attribution
 *  echo $shot->getAttribution();
 */

/**
 * MyLinks category.php
 *
 * Xoops mylinks - a multicategory links module
 *
 * @copyright::  {@link http://www.zyspec.com ZySpec Incorporated}
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @subpackage:: class
 * @since::		 3.11
 * @author::     zyspec <owner@zyspec.com>
 * @version::    $Id: $
 */
require_once XOOPS_ROOT_PATH . "/modules/mylinks/class/thumbplugin.interface.php";
class MylinksHeartrails implements MylinksThumbPlugin
{
    private $image_width     = 0;
    private $image_height    = 0;
    protected $image_ratio   = 1.33;  // (4:3)
    private $site_url        = null;
    private $key             = null;
    private $attribution     = "";
    private $provider_url    = "http://capture.heartrails.com";
    private $provider_name   = "Heartrails";

    function __construct()
    {
    }
    public function getProviderUrl()
    {
        $query = "/" . $this->image_width . "x" . $this->image_height . "/cool?" . $this->getSiteUrl();
        $providerUrl = $this->provider_url . $query;

        return $providerUrl;
    }
    public function getProviderName()
    {
        return $this->provider_name;
    }
    public function setShotSize($sz)
    {
        if (isset($sz)) {
            if (is_array($sz)) {
                if (array_key_exists('width', $sz)) {
                    $this->image_width = intval($sz['width']);
                    if (array_key_exists('height', $sz)) {
                        $this->image_height = intval($sz['height']);
                    } else {
                        $this->image_height = intval($this->image_width / $this->image_ratio);
                    }
                } else {
                    $this->image_width  = intval($sz);
                    $this->image_height = intval($sz / $this->image_ratio);
                }
            }
        }
    }
    public function getShotSize()
    {
        return array('width'=>$this->image_width, 'height'=>$this->image_height);
    }
    public function setSiteUrl($url)
    {
        //@todo: sanitize url;
        $this->site_url = formatURL($url);
    }
    public function getSiteUrl()
    {
        return urlencode($this->site_url);
    }
    public function setAttribution($attr=null)
    {
        $this->attribution = $attr;
    }
    public function getAttribution($allowhtml = 0)
    {
        if ($allowhtml) {
            return $this->attribution;
        } else {
            $myts =& MyTextSanitizer::getInstance();

            return $myts->htmlSpecialChars($this->attribution);
        }
    }
    public function setProviderPublicKey($key)
    {
        return false;
    }
    public function getProviderPublicKey()
    {
        return false;
    }
    public function setProviderPrivateKey($key)
    {
        return false;
    }
    public function getProviderPrivateKey()
    {
        return false;
    }
}
