<?php

namespace XoopsModules\Mylinks\Providers;

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

use XoopsModules\Mylinks;

/**
 * MyLinks category.php
 *
 * Xoops mylinks - a multicategory links module
 *
 * @copyright ::  {@link http://www.zyspec.com ZySpec Incorporated}
 * @license   ::    {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package   ::    mylinks
 * @subpackage:: class
 * @since     ::      3.11
 * @author    ::     zyspec <owner@zyspec.com>
 */

/**
 * Class MylinksNemui
 */
class Nemui implements Mylinks\ThumbPlugin
{
    private   $image_width   = 0;
    private   $image_height  = 0;
    protected $image_ratio   = 1.33;  // (4:3)
    private   $site_url      = null;
    private   $key           = null;
    private   $attribution   = '<a href="http://mozshot.nemui.org" target="_blank" title="Thumbnails Screenshots by Nemui.org">Thumbnail Screenshots by Nemui.org</a>';
    private   $provider_url  = 'http://mozshot.nemui.org';
    private   $provider_name = 'Nemui';

    /**
     * MylinksNemui constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getProviderUrl()
    {
        $sz          = $this->getShotSize();
        $image_size  = $sz['width'] . 'x' . $sz['height'];
        $providerUrl = $this->provider_url . "/shot/{$image_size}?" . $this->site_url;

        return $providerUrl;
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return $this->provider_name;
    }

    /**
     * @param $sz
     * @return mixed|void
     */
    public function setShotSize($sz)
    {
        if (\is_array($sz)) {
            if (\array_key_exists('width', $sz)) {
                $this->image_width = (int)$sz['width'];
                if (\array_key_exists('height', $sz)) {
                    $this->image_height = (int)$sz['height'];
                } else {
                    $this->image_height = (int)($this->image_width / $this->image_ratio);
                }
            } else {
                $this->image_width  = (int)$sz;
                $this->image_height = (int)($sz / $this->image_ratio);
            }
        } else {
            $this->image_width  = (int)$sz;
            $this->image_height = (int)($sz / $this->image_ratio);
        }
    }

    /**
     * @return array
     */
    public function getShotSize()
    {
        return ['width' => $this->image_width, 'height' => $this->image_height];
    }

    /**
     * @param $url
     * @return mixed|void
     */
    public function setSiteUrl($url)
    {
        //@todo: sanitize url;
        $this->site_url = \formatURL($url);
    }

    /**
     * @return string
     */
    public function getSiteUrl()
    {
        return \urlencode($this->site_url);
    }

    /**
     * @param null $attr
     */
    public function setAttribution($attr = null)
    {
        $this->attribution = $attr;
    }

    /**
     * @param int $allowhtml
     * @return string
     */
    public function getAttribution($allowhtml = 0)
    {
        if ($allowhtml) {
            return $this->attribution;
        }
        $myts = \MyTextSanitizer::getInstance();

        return $myts->htmlSpecialChars($this->attribution);
    }

    /**
     * @param $key
     * @return mixed|void
     */
    public function setProviderPublicKey($key)
    {
        $this->key = $key;
    }

    public function getProviderPublicKey()
    {
        return $this->key;
    }

    /**
     * @param $key
     * @return bool
     */
    public function setProviderPrivateKey($key)
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getProviderPrivateKey()
    {
        return false;
    }
}
