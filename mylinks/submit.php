<?php
// $Id: submit.php 11819 2013-07-09 18:21:40Z zyspec $
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
$myts =& MyTextSanitizer::getInstance();// MyTextSanitizer object
include_once XOOPS_ROOT_PATH . '/include/xoopscodes.php';

include_once './class/utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));

if (empty($xoopsUser) and !$xoopsModuleConfig['anonpost']) {
  redirect_header(XOOPS_URL . '/user.php', 2, _MD_MYLINKS_MUSTREGFIRST);
  exit();
}

if (!empty($_POST['submit'])) {

//    include_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
//    $eh = new ErrorHandler; //ErrorHandler object
    $submitter = !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0;

    $msg = "";
    switch ( true ) {
        case ( empty( $_POST['title'] ) ):
            $msg .= _MD_MYLINKS_ERRORTITLE;
        case ( empty( $_POST['url'] ) ):
            $msg .= _MD_MYLINKS_ERRORURL;
        case ( empty( $_POST['message'] ) ):
            $msg .= _MD_MYLINKS_ERRORDESC;
    }
    if ( '' !== $msg ) {
        mylinksUtility::show_message($msg);
        exit();
    }

    $title        = $myts->addSlashes($_POST['title']);
    $url          = $myts->addSlashes($url);
    $notify       = !empty($_POST['notify']) ? 1 : 0;
    $cid          = mylinksUtility::mylinks_cleanVars($_POST, 'cid', 0, 'int', array('min'=>0));
    $description  = $myts->addSlashes($_POST['message']);
    $date         = time();
    $newid        = $xoopsDB->genId($xoopsDB->prefix('mylinks_links').'_lid_seq');
    $mylinksAdmin = ( is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid()) ) ? true : false;
    $status       = ( ( 1 == $xoopsModuleConfig['autoapprove'] ) || $mylinksAdmin ) ? 1 : 0;

    $sql = sprintf("INSERT INTO %s (lid, cid, title, url, logourl, submitter, status, date, hits, rating, votes, comments) VALUES (%u, %u, '%s', '%s', '%s', %u, %u, %u, %u, %u, %u, %u)", $xoopsDB->prefix("mylinks_links"), $newid, $cid, $title, $url, ' ', $submitter, $status, $date, 0, 0, 0, 0);
    $result = $xoopsDB->query($sql);
    if ( !$result ) {
        mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
        exit();
    }
    if ( 0 == $newid ) {
        $newid = $xoopsDB->getInsertId();
    }
    $sql = sprintf("INSERT INTO %s (lid, description) VALUES (%u, '%s')", $xoopsDB->prefix("mylinks_text"), $newid, $description);
    $result = $xoopsDB->query($sql);
    if ( !$result ) {
        mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
        exit();
    }
        // Notify of new link (anywhere) and new link in category.
    $notification_handler =& xoops_gethandler('notification');
    $tags = array();
    $tags['LINK_NAME'] = $title;
    $tags['LINK_URL'] = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/singlelink.php?cid={$cid}&amp;lid={$newid}";
    $sql = "SELECT title FROM " . $xoopsDB->prefix("mylinks_cat") . " WHERE cid={$cid}";
    $result = $xoopsDB->query($sql);
    $row = $xoopsDB->fetchArray($result);
    $tags['CATEGORY_NAME'] = $row['title'];
    $tags['CATEGORY_URL'] = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/viewcat.php?cid={$cid}";
    if ( 1 == $xoopsModuleConfig['autoapprove'] ) {
        $notification_handler->triggerEvent('global', 0, 'new_link', $tags);
        $notification_handler->triggerEvent('category', $cid, 'new_link', $tags);
        redirect_header('index.php', 2, _MD_MYLINKS_RECEIVED . "<br />" . _MD_MYLINKS_ISAPPROVED . "");
    } else {
        $tags['WAITINGLINKS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?op=listNewLinks';
        $notification_handler->triggerEvent('global', 0, 'link_submit', $tags);
        $notification_handler->triggerEvent('category', $cid, 'link_submit', $tags);
        if ($notify) {
            include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
            $notification_handler->subscribe('link', $newid, 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
        }
        redirect_header('index.php', 2, _MD_MYLINKS_RECEIVED);
    }
    exit();
} else {

    include_once XOOPS_ROOT_PATH . '/class/tree.php';
    $mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
    $catObjs           = $mylinksCatHandler->getAll();
    $myCatTree         = new XoopsObjectTree($catObjs, 'cid', 'pid');

    $xoopsOption['template_main'] = 'mylinks_submit.html';
    include XOOPS_ROOT_PATH . '/header.php';
    //wanikoo
    $xoTheme->addStylesheet('browse.php?' . mylinksGetStylePath('mylinks.css', 'include'));
    $xoTheme->addScript('browse.php?' . mylinksGetStylePath('mylinks.js', 'include'));
    //
    ob_start();
    xoopsCodeTarea('message',37,8);
    $xoopsTpl->assign('xoops_codes', ob_get_contents());
    ob_end_clean();
    ob_start();
    xoopsSmilies('message');
    $xoopsTpl->assign('xoops_smilies', ob_get_contents());
    ob_end_clean();
    $notify_show = (!empty($xoopsUser) && !$xoopsModuleConfig['autoapprove']) ? 1 : 0;
    $xoopsTpl->assign('notify_show', $notify_show);
    $xoopsTpl->assign('lang_submitonce', _MD_MYLINKS_SUBMITONCE);
    $xoopsTpl->assign('lang_submitlinkh', _MD_MYLINKS_SUBMITLINKHEAD);
    $xoopsTpl->assign('lang_allpending', _MD_MYLINKS_ALLPENDING);
    $xoopsTpl->assign('lang_dontabuse', _MD_MYLINKS_DONTABUSE);
    $xoopsTpl->assign('lang_wetakeshot', _MD_MYLINKS_TAKESHOT);
    $xoopsTpl->assign('lang_sitetitle', _MD_MYLINKS_SITETITLE);
    $xoopsTpl->assign('lang_siteurl', _MD_MYLINKS_SITEURL);
    $xoopsTpl->assign('lang_category', _MD_MYLINKS_CATEGORYC);
    $xoopsTpl->assign('lang_options', _MD_MYLINKS_OPTIONS);
    $xoopsTpl->assign('lang_notify', _MD_MYLINKS_NOTIFYAPPROVE);
    $xoopsTpl->assign('lang_description', _MD_MYLINKS_DESCRIPTIONC);
    $xoopsTpl->assign('lang_submit', _SUBMIT);
    $xoopsTpl->assign('lang_cancel', _CANCEL);
    $xoopsTpl->assign('category_selbox', $myCatTree->makeSelBox('cid', 'title', '-', 0, false));

    //wanikoo theme changer
    $xoopsTpl->assign('lang_themechanger', _MD_MYLINKS_THEMECHANGER);
    $mymylinkstheme_options = '';

    foreach ($GLOBALS['mylinks_allowed_theme'] as $mymylinkstheme) {
        $mymylinkstheme_options .= "<option value='{$mymylinkstheme}'";
        if ($mymylinkstheme == $GLOBALS['mylinks_theme']) {
            $mymylinkstheme_options .= " selected='selected'";
        }
        $mymylinkstheme_options .= ">{$mymylinkstheme}</option>";
    }

    $mylinkstheme_select = "<select name='mylinks_theme_select' onchange='submit();' size='1'>{$mymylinkstheme_options}</select>";

    $xoopsTpl->assign('mylinksthemeoption', $mylinkstheme_select);

    //wanikoo search
    if (file_exists(XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/search.php")) {
       include_once XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/search.php";
    } else {
       include_once XOOPS_ROOT_PATH . '/language/english/search.php';
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
