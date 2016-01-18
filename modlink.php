<?php
// $Id: modlink.php 11819 2013-07-09 18:21:40Z zyspec $
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

include 'header.php';
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object

include_once './class/utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));

if (!empty($_POST['submit'])) {
    if (empty($xoopsUser)) {
        redirect_header(XOOPS_URL . '/user.php', 2, _MD_MYLINKS_MUSTREGFIRST);
        exit();
    }
    $user = $xoopsUser->getVar('uid');
    $lid = mylinksUtility::mylinks_cleanVars($_POST, 'lid', 0, 'int', array('min'=>0));

//    include_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
//    $eh = new ErrorHandler; //ErrorHandler object

    $msg = "";
    switch (true) {
        case ( '' == $_POST['title'] ):
            $msg .= _MD_MYLINKS_ERRORTITLE;
        case ( '' == $_POST['url'] ):
            $msg .= _MD_MYLINKS_ERRORURL;
        case ( '' == $_POST['description'] ):
            $msg .= _MD_MYLINKS_ERRORDESC;
    }
    if ('' !== $msg) {
        mylinksUtility::show_message($msg);
        exit();
    }

    $url         = $myts->addSlashes($_POST['url']);
    $logourl     = $myts->addSlashes($_POST['logourl']);
    $cid         = mylinksUtility::mylinks_cleanVars($_POST, 'cid', 0, 'int', array('min'=>0));
    $title       = $myts->addSlashes($_POST['title']);
    $description = $myts->addSlashes($_POST['description']);
    $newid       = $xoopsDB->genId($xoopsDB->prefix('mylinks_mod') . '_requestid_seq');
    $sql         = sprintf("INSERT INTO %s (requestid, lid, cid, title, url, logourl, description, modifysubmitter) VALUES (%u, %u, %u, '%s', '%s', '%s', '%s', %u)", $xoopsDB->prefix("mylinks_mod"), $newid, $lid, $cid, $title, $url, $logourl, $description, $user);
    $result = $xoopsDB->query($sql);
    if (!result) {
        mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
        exit();
    }
    $tags = array();
    $tags['MODIFYREPORTS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?op=listModReq';
    $notification_handler =& xoops_gethandler('notification');
    $notification_handler->triggerEvent('global', 0, 'link_modify', $tags);
    redirect_header("index.php", 2, _MD_MYLINKS_THANKSFORINFO);
    exit();
} else {
    if (empty($xoopsUser)) {
        redirect_header(XOOPS_URL . '/user.php', 2, _MD_MYLINKS_MUSTREGFIRST);
        exit();
    }
    $lid = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));

    include_once XOOPS_ROOT_PATH . '/class/tree.php';
    $mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
    $catObjs           = $mylinksCatHandler->getAll();
    $myCatTree         = new XoopsObjectTree($catObjs, 'cid', 'pid');

    $xoopsOption['template_main'] = 'mylinks_modlink.html';
    include XOOPS_ROOT_PATH . '/header.php';

    //wanikoo
    $xoTheme->addStylesheet('browse.php?' . mylinksGetStylePath('mylinks.css', 'include'));
    $xoTheme->addScript('browse.php?' . mylinksGetStylePath('mylinks.js', 'include'));
/*
    $mylinks_module_header = ""
                          ."<link rel='stylesheet' type='text/css' href='" . mylinksGetStyleURL('mylinks.css') . "' />"
                          ."<script src='" . mylinksGetStyleURL('mylinks.js') . "' type='text/javascript'></script>";
    $xoopsTpl->assign('xoops_module_header', $mylinks_module_header);
*/
    //

    $result = $xoopsDB->query("SELECT l.lid, l.cid, l.title, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description FROM " . $xoopsDB->prefix("mylinks_links") . " l, " . $xoopsDB->prefix("mylinks_text") . " t WHERE l.lid={$lid} AND l.lid=t.lid AND status>0");
    list($lid, $cid, $title, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);
    if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
        $adminlink = "<a href='" . XOOPSMYLINKURL . "/admin/index.php?op=modLink&amp;lid={$lid}'><img src='" . mylinksGetIconURL('edit.png') . "' style='border-width: 0px;' alt='" . _MD_MYLINKS_EDITTHISLINK . "' /></a>";
    } else {
        $adminlink = '';
    }
    $votestring = (1 == $votes) ? _MD_MYLINKS_ONEVOTE : sprintf(_MD_MYLINKS_NUMVOTES, $votes);

    $xoopsTpl->assign('link', array('id'          => $lid,
                                    'rating'      => number_format($rating, 2),
                                    'title'       => $myts->htmlSpecialChars($myts->stripSlashesGPC($title)),
                                    'url'         => $myts->htmlSpecialChars($url),
                                    'logourl'     => $myts->htmlSpecialChars($logourl),
                                    'updated'     => formatTimestamp($time, 'm'),
                                    'description' => $myts->htmlSpecialChars($myts->stripSlashesGPC($description)),
                                    'adminlink'   => $adminlink,
                                    'hits'        => $hits,
                                    'votes'       => $votestring));
    $xoopsTpl->assign('lang_requestmod', _MD_MYLINKS_REQUESTMOD);
    $xoopsTpl->assign('lang_linkid', _MD_MYLINKS_LINKID);
    $xoopsTpl->assign('lang_sitetitle', _MD_MYLINKS_SITETITLE);
    $xoopsTpl->assign('lang_siteurl', _MD_MYLINKS_SITEURL);
    $xoopsTpl->assign('lang_category', _MD_MYLINKS_CATEGORYC);
    $xoopsTpl->assign('category_selbox', $myCatTree->makeSelBox('cid', 'title', '-', $cid));
    $xoopsTpl->assign('lang_description', _MD_MYLINKS_DESCRIPTIONC);
    $xoopsTpl->assign('lang_sendrequest', _MD_MYLINKS_SENDREQUEST);
    $xoopsTpl->assign('lang_cancel', _CANCEL);
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
