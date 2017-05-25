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
 * @copyright ::  {@link http://xoops.org/ XOOPS Project}
 * @copyright ::  {@link http://www.zyspec.com ZySpec Incorporated}
 * @license   ::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package   ::    mylinks
 * @subpackage:: class
 * @author    ::     zyspec <owner@zyspec.com>
 */
require_once XOOPS_ROOT_PATH . '/modules/mylinks/class/thumbplugin.interface.php';

/**
 * Class MylinksThumbshots
 */
class MylinksThumbshots implements MylinksThumbPlugin
{
    private $image_width   = 0;
    private $site_url      = null;
    private $key           = null;
    private $attribution   = "<a href=\"http://www.thumbshots.com\" target=\"_blank\" title=\"Thumbnails Screenshots by Thumbshots\">Thumbnail Screenshots by Thumbshots</a>";
    private $provider_url  = 'http://images.thumbshots.com/image.aspx';
    private $provider_name = 'Thumbshots';

    /**
     * MylinksThumbshots constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getProviderUrl()
    {
        $query_string = array(
            'cid' => $this->getProviderPublicKey(),
            'v'   => 1,
            'w'   => $this->image_width,
            'url' => $this->site_url
        );
        $query        = http_build_query($query_string);
        $query        = empty($query) ? '' : '?' . $query;
        $providerUrl  = $this->provider_url . $query;

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
        if (isset($sz)) {
            if (is_array($sz) && array_key_exists('width', $sz)) {
                $this->image_width = (int)$sz['width'];
            } else {
                $this->image_width = (int)$sz;
            }
        }
    }

    /**
     * @return array
     */
    public function getShotSize()
    {
        return array('width' => $this->image_width, 'height' => 0);
    }

    /**
     * @param $url
     * @return mixed|void
     */
    public function setSiteUrl($url)
    {
        //@todo: sanitize url;
        $this->site_url = formatURL($url);
    }

    /**
     * @return string
     */
    public function getSiteUrl()
    {
        return urlencode($this->site_url);
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
        } else {
            $myts = MyTextSanitizer::getInstance();

            return $myts->htmlSpecialChars($this->attribution);
        }
    }

    /**
     * @param $key
     * @return mixed|void
     */
    public function setProviderPublicKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return null
     */
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
