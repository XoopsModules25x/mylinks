<?php
// $Id: brokenlink.php 11158 2013-03-05 14:10:36Z zyspec $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
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
include 'header.php';
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object

include_once './class/utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));
$lid = mylinksUtility::mylinks_cleanVars($_REQUEST, 'lid', 0, 'int', array('min'=>0));
if (!empty($_POST['submit'])) {
    $sender = (empty($xoopsUser)) ?  0 : $xoopsUser->getVar('uid');
    $ip = getenv("REMOTE_ADDR");
    if ( $sender != 0 ) {
        // Check if REG user is trying to report twice.
        $result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_broken") . " WHERE lid='{$lid}' AND sender='{$sender}'");
        list($count) = $xoopsDB->fetchRow($result);
        if ( $count > 0 ) {
            redirect_header('index.php', 2, _MD_MYLINKS_ALREADYREPORTED);
            exit();
        }
    } else {
        // Check if the sender is trying to report it more than once.
        $result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_broken") . " WHERE lid='{$lid}' AND ip='{$ip}'");
        list($count) = $xoopsDB->fetchRow($result);
        if ($count > 0) {
            redirect_header('index.php', 2, _MD_MYLINKS_ALREADYREPORTED);
            exit();
        }
    }
    $newid = $xoopsDB->genId($xoopsDB->prefix("mylinks_broken") . "_reportid_seq");
    $sql = sprintf("INSERT INTO %s (reportid, lid, sender, ip) VALUES (%u, %u, %u, '%s')", $xoopsDB->prefix("mylinks_broken"), $newid, $lid, $sender, $ip);
    $xoopsDB->query($sql) or exit();
    $tags = array();
    $tags['BROKENREPORTS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?op=listBrokenLinks';
    $notification_handler =& xoops_gethandler('notification');
    $notification_handler->triggerEvent('global', 0, 'link_broken', $tags);
    redirect_header('index.php', 2, _MD_MYLINKS_THANKSFORINFO);
    exit();
} else {
    $xoopsOption['template_main'] = 'mylinks_brokenlink.html';
    include XOOPS_ROOT_PATH . '/header.php';
    //wanikoo
    $xoTheme->addStylesheet('browse.php?' . mylinksGetStylePath('mylinks.css', 'include'));
    $xoTheme->addScript('browse.php?' . mylinksGetStylePath('mylinks.js', 'include'));
    //
    $xoopsTpl->assign('lang_reportbroken', _MD_MYLINKS_REPORTBROKEN);
    $xoopsTpl->assign('link_id', $lid);
    $xoopsTpl->assign('lang_thanksforhelp', _MD_MYLINKS_THANKSFORHELP);
    $xoopsTpl->assign('lang_forsecurity', _MD_MYLINKS_FORSECURITY);
    $xoopsTpl->assign('lang_cancel', _CANCEL);

    //wanikoo theme changer
    $xoopsTpl->assign('lang_themechanger', _MD_MYLINKS_THEMECHANGER);

    $mymylinkstheme_options = '';
    foreach ($GLOBALS['mylinks_allowed_theme'] as $mymylinkstheme) {
        $thisSelected = ($mymylinkstheme == $GLOBALS['mylinks_theme']) ? " selected='selected'" : "";
        $mymylinkstheme_options .= "<option value='{$mymylinkstheme}'{$thisSelected}>{$mymylinkstheme}</option>";
    }

    $mylinkstheme_select = "<select name='mylinks_theme_select' onchange='submit();' size='1'>{$mymylinkstheme_options}</select>";
    $xoopsTpl->assign('mylinksthemeoption', $mylinkstheme_select);

    //wanikoo search
    if (file_exists(XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/search.php")) {
       include_once XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/search.php";
    } else {
       include_once XOOPS_ROOT_PATH."/language/english/search.php";
    }

    $xoopsTpl->assign('lang_all', _SR_ALL);
    $xoopsTpl->assign('lang_any', _SR_ANY);
    $xoopsTpl->assign('lang_exact', _SR_EXACT);
    $xoopsTpl->assign('lang_search', _SR_SEARCH);
    $xoopsTpl->assign('module_id', $xoopsModule->getVar('mid'));
    //category head
    $catarray = array();
    if ($mylinks_show_letters) {
        $catarray['letters'] = ml_wfd_letters();
    }
    if ($mylinks_show_toolbar) {
        $catarray['toolbar'] = ml_wfd_toolbar();
    }
    $xoopsTpl->assign('catarray', $catarray);

    include_once XOOPSMYLINKPATH . '/footer.php';
}
