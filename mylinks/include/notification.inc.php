<?php
// $Id: notification.inc.php 8112 2011-11-06 13:41:14Z beckmi $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

function mylinks_notify_iteminfo($category, $item_id)
{
    global $xoopsModule, $xoopsModuleConfig, $xoopsConfig, $xoopsDB;
    $dirname = basename(dirname(dirname(__FILE__)));

    $item_id = (isset($item_id) && (intval($item_id) > 0)) ? intval($item_id) : 0;

    if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != $dirname) {
        $module_handler =& xoops_gethandler('module');
        $module         =& $module_handler->getByDirname($dirname);
        $config_handler =& xoops_gethandler('config');
        $config         =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
    } else {
        $module =& $xoopsModule;
        $config =& $xoopsModuleConfig;
    }

    switch ($category)
    {
        case 'category':
            // Assume we have a valid category id
            $mylinksCatHandler = xoops_getmodulehandler('category', $dirname);
            $catObj = $mylinksCatHandler->get($item_id);
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
            $sql          = "SELECT cid,title FROM " . $xoopsDB->prefix('mylinks_links') . " WHERE lid={$item_id}";
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
