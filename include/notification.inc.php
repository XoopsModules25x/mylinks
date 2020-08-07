<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright     {@link https://xoops.org/ XOOPS Project}
 * @license       {@link https://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package       mylinks
 * @since
 * @author        XOOPS Development Team
 * @param mixed $category
 * @param mixed $item_id
 */

/**
 * @param $category
 * @param $item_id
 * @return mixed
 */
function mylinks_notify_iteminfo($category, $item_id)
{
    global $xoopsModule, $xoopsModuleConfig, $xoopsConfig, $xoopsDB;
    $dirname = basename(dirname(__DIR__));

    $item_id = (isset($item_id) && ((int)$item_id > 0)) ? (int)$item_id : 0;

    if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != $dirname) {
        /** @var \XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $module        = $moduleHandler->getByDirname($dirname);
        $configHandler = xoops_getHandler('config');
        $config        = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
    } else {
        $module = &$xoopsModule;
        $config = &$xoopsModuleConfig;
    }

    switch ($category) {
        case 'category':
            // Assume we have a valid category id
            $helper          = \Xmf\Module\Helper::getHelper('mylinks');
            $categoryHandler = $helper->getHandler('Category');
            $catObj            = $categoryHandler->get($item_id);
            if ($catObj) {
                $item['name'] = $catObj->getVar('title');
                $item['url']  = XOOPS_URL . "/modules/{$dirname}/viewcat.php?cid={$item_id}";
                /*
                            $sql          = "SELECT title FROM " . $xoopsDB->prefix('mylinks_cat') . " WHERE cid={$item_id}";
                            $result       = $xoopsDB->query($sql); // TODO: error check
                            $result_array = $xoopsDB->fetchArray($result);
                            $item['name'] = $result_array['title'];
                            $item['url']  = XOOPS_URL . "/modules/" . $module->getVar('dirname') . "/viewcat.php?cid={$item_id}";
                */
            } else {
                $item['name'] = '';
                $item['url']  = '';
            }
            break;
        case 'link':
            $sql          = 'SELECT cid,title FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE lid={$item_id}";
            $result       = $xoopsDB->query($sql); // TODO: error check
            $result_array = $xoopsDB->fetchArray($result);
            if (!empty($result_array['title'])) {
                $item['name'] = $result_array['title'];
                $item['url']  = XOOPS_URL . "/modules/{$dirname}/singlelink.php?cid={$result_array['cid']}&amp;lid={$item_id}";
            } else {
                $item['name'] = '';
                $item['url']  = '';
            }
            break;
        case 'global':
        default:
            $item['name'] = '';
            $item['url']  = '';
            break;
    }

    return $item;
}
