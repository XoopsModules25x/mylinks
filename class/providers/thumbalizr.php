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
 *  <img src='<{$mylinks_shotprovider}>' target='_blank' alt='' style='margin: 3px 7px;'>
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
 * @since::         3.11
 * @author::     zyspec <owner@zyspec.com>
 */
require_once XOOPS_ROOT_PATH . '/modules/mylinks/class/thumbplugin.interface.php';
class MylinksThumbalizr implements MylinksThumbPlugin
{
    private $image_width     = 0;
    private $site_url        = null;
    private $key             = null;
    private $attribution     = "<a href=\"http://www.thumbalizr.com\" target=\"_blank\" title=\"Thumbnail Screenshots by Thumbalizr\">Thumbnail Screenshots by Thumbalizr</a>";
    private $provider_url    = 'http://api.thumbalizr.com';
    private $provider_name   = 'Thumbalizr';

    function __construct()
    {
    }
    public function getProviderUrl()
    {
        $query_string = array('url'      => $this->site_url,
                              'width'    => $this->image_width,
                              'encoding' => 'jpg',
                              'mode'     => 'screen'
        );
        $api_key = self::getProviderPublicKey();
        if (!empty($api_key)) {
            $query_string['api_key'] = $api_key;
        }
        $query = http_build_query($query_string);
        $query = empty($query) ? '' : '/?' . $query;
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
            if (is_array($sz) && array_key_exists('width', $sz)) {
                $this->image_width = intval($sz['width']);
            } else {
                $this->image_width = intval($sz);
            }
        }
    }
    public function getShotSize()
    {
        return array('width'=>$this->image_width, 'height'=>0);
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
        $this->key = $key;
    }
    public function getProviderPublicKey()
    {
        return $this->key;
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
