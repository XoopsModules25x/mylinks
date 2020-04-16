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
 * @copyright    {@link https://xoops.org/ XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use XoopsModules\Mylinks;
use XoopsModules\Mylinks\Utility;

require_once __DIR__ . '/header.php';
$myts = \MyTextSanitizer::getInstance(); // MyTextSanitizer object

//xoops_load('utility', $xoopsModule->getVar('dirname'));

if (!empty($_POST['submit'])) {
    if (empty($xoopsUser)) {
        redirect_header(XOOPS_URL . '/user.php', 2, _MD_MYLINKS_MUSTREGFIRST);
    }
    $user = $xoopsUser->getVar('uid');
    $lid  = Mylinks\Utility::cleanVars($_POST, 'lid', 0, 'int', ['min' => 0]);

    //    require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
    //    $eh = new ErrorHandler; //ErrorHandler object

    $msg = '';
    switch (true) {
        case ('' == $_POST['title']):
            $msg .= _MD_MYLINKS_ERRORTITLE;
        // no break
        case ('' == $_POST['url']):
            $msg .= _MD_MYLINKS_ERRORURL;
        // no break
        case ('' == $_POST['description']):
            $msg .= _MD_MYLINKS_ERRORDESC;
    }
    if ('' !== $msg) {
        Mylinks\Utility::show_message($msg);
        exit();
    }

    $url         = $myts->addSlashes($_POST['url']);
    $logourl     = $myts->addSlashes($_POST['logourl']);
    $cid         = Mylinks\Utility::cleanVars($_POST, 'cid', 0, 'int', ['min' => 0]);
    $title       = $myts->addSlashes($_POST['title']);
    $description = $myts->addSlashes($_POST['description']);
    $newid       = $xoopsDB->genId($xoopsDB->prefix('mylinks_mod') . '_requestid_seq');
    $sql         = sprintf("INSERT INTO `%s` (requestid, lid, cid, title, url, logourl, description, modifysubmitter) VALUES (%u, %u, %u, '%s', '%s', '%s', '%s', %u)", $xoopsDB->prefix('mylinks_mod'), $newid, $lid, $cid, $title, $url, $logourl, $description, $user);
    $result      = $xoopsDB->query($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_DBNOTUPDATED);
        exit();
    }
    $tags                      = [];
    $tags['MODIFYREPORTS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?op=listModReq';
    $notificationHandler       = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('global', 0, 'link_modify', $tags);
    redirect_header('index.php', 2, _MD_MYLINKS_THANKSFORINFO);
} else {
    if (empty($xoopsUser)) {
        redirect_header(XOOPS_URL . '/user.php', 2, _MD_MYLINKS_MUSTREGFIRST);
    }
    $lid = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);

    require_once XOOPS_ROOT_PATH . '/class/tree.php';
    $categoryHandler = $helper->getHandler('Category');
    $catObjs           = $categoryHandler->getAll();
    $myCatTree         = new \XoopsObjectTree($catObjs, 'cid', 'pid');

    $GLOBALS['xoopsOption']['template_main'] = 'mylinks_modlink.tpl';
    require_once XOOPS_ROOT_PATH . '/header.php';

    //wanikoo
    $xoTheme->addStylesheet('browse.php?' . Utility::getStylePath('mylinks.css', 'include'));
    $xoTheme->addScript('browse.php?' . Utility::getStylePath('mylinks.js', 'include'));
    /*
        $mylinks_module_header = ""
                              ."<link rel='stylesheet' type='text/css' href='" . Utility::getStyleURL('mylinks.css') . "'>"
                              ."<script src='" . Utility::getStyleURL('mylinks.js') . "' type='text/javascript'></script>";
        $xoopsTpl->assign('xoops_module_header', $mylinks_module_header);
    */

    $result = $xoopsDB->query('SELECT l.lid, l.cid, l.title, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description FROM ' . $xoopsDB->prefix('mylinks_links') . ' l, ' . $xoopsDB->prefix('mylinks_text') . " t WHERE l.lid={$lid} AND l.lid=t.lid AND status>0");
    list($lid, $cid, $title, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);
    if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
        $adminlink = "<a href='" . XOOPSMYLINKURL . "/admin/index.php?op=modLink&amp;lid={$lid}'><img src='" . Utility::getIconURL('edit.png') . "' style='border-width: 0px;' alt='" . _MD_MYLINKS_EDITTHISLINK . "'></a>";
    } else {
        $adminlink = '';
    }
    $votestring = (1 == $votes) ? _MD_MYLINKS_ONEVOTE : sprintf(_MD_MYLINKS_NUMVOTES, $votes);

    $xoopsTpl->assign(
        'link',
        [
            'id'          => $lid,
            'rating'      => number_format($rating, 2),
            'title'       => $myts->htmlSpecialChars($myts->stripSlashesGPC($title)),
            'url'         => $myts->htmlSpecialChars($url),
            'logourl'     => $myts->htmlSpecialChars($logourl),
            'updated'     => formatTimestamp($time, 'm'),
            'description' => $myts->htmlSpecialChars($myts->stripSlashesGPC($description)),
            'adminlink'   => $adminlink,
            'hits'        => $hits,
            'votes'       => $votestring,
        ]
    );
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
            $mymylinkstheme_options .= ' selected';
        }
        $mymylinkstheme_options .= ">{$mymylinkstheme}</option>";
    }

    $mylinkstheme_select = "<select name='mylinks_theme_select' onchange='submit();' size='1'>{$mymylinkstheme_options}</select>";

    $xoopsTpl->assign('mylinksthemeoption', $mylinkstheme_select);

    //wanikoo search
    if (file_exists(XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/search.php')) {
        require_once XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/search.php';
    } else {
        require_once XOOPS_ROOT_PATH . '/language/english/search.php';
    }
    $xoopsTpl->assign('lang_all', _SR_ALL);
    $xoopsTpl->assign('lang_any', _SR_ANY);
    $xoopsTpl->assign('lang_exact', _SR_EXACT);
    $xoopsTpl->assign('lang_search', _SR_SEARCH);
    $xoopsTpl->assign('module_id', $xoopsModule->getVar('mid'));
    //category head
    $catarray = [];
    if ($mylinks_show_letters) {
        $catarray['letters'] = Utility::letters();
    }
    if ($mylinks_show_toolbar) {
        $catarray['toolbar'] = Utility::toolbar();
    }
    $xoopsTpl->assign('catarray', $catarray);

    require_once XOOPSMYLINKPATH . '/footer.php';
}
