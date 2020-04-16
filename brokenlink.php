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
$lid = Mylinks\Utility::cleanVars($_REQUEST, 'lid', 0, 'int', ['min' => 0]);
if (!empty($_POST['submit'])) {
    $sender = empty($xoopsUser) ? 0 : $xoopsUser->getVar('uid');
    $ip     = getenv('REMOTE_ADDR');
    if (0 != $sender) {
        // Check if REG user is trying to report twice.
        $result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_broken') . " WHERE lid='{$lid}' AND sender='{$sender}'");
        list($count) = $xoopsDB->fetchRow($result);
        if ($count > 0) {
            redirect_header('index.php', 2, _MD_MYLINKS_ALREADYREPORTED);
        }
    } else {
        // Check if the sender is trying to report it more than once.
        $result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_broken') . " WHERE lid='{$lid}' AND ip='{$ip}'");
        list($count) = $xoopsDB->fetchRow($result);
        if ($count > 0) {
            redirect_header('index.php', 2, _MD_MYLINKS_ALREADYREPORTED);
        }
    }
    $newid = $xoopsDB->genId($xoopsDB->prefix('mylinks_broken') . '_reportid_seq');
    $sql   = sprintf("INSERT INTO `%s` (reportid, lid, sender, ip) VALUES (%u, %u, %u, '%s')", $xoopsDB->prefix('mylinks_broken'), $newid, $lid, $sender, $ip);
    $xoopsDB->query($sql) || exit();
    $tags                      = [];
    $tags['BROKENREPORTS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?op=listBrokenLinks';
    $notificationHandler       = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('global', 0, 'link_broken', $tags);
    redirect_header('index.php', 2, _MD_MYLINKS_THANKSFORINFO);
} else {
    $GLOBALS['xoopsOption']['template_main'] = 'mylinks_brokenlink.tpl';
    require_once XOOPS_ROOT_PATH . '/header.php';
    //wanikoo
    $xoTheme->addStylesheet('browse.php?' . Utility::getStylePath('mylinks.css', 'include'));
    $xoTheme->addScript('browse.php?' . Utility::getStylePath('mylinks.js', 'include'));

    $xoopsTpl->assign('lang_reportbroken', _MD_MYLINKS_REPORTBROKEN);
    $xoopsTpl->assign('link_id', $lid);
    $xoopsTpl->assign('lang_thanksforhelp', _MD_MYLINKS_THANKSFORHELP);
    $xoopsTpl->assign('lang_forsecurity', _MD_MYLINKS_FORSECURITY);
    $xoopsTpl->assign('lang_cancel', _CANCEL);

    //wanikoo theme changer
    $xoopsTpl->assign('lang_themechanger', _MD_MYLINKS_THEMECHANGER);

    $mymylinkstheme_options = '';
    foreach ($GLOBALS['mylinks_allowed_theme'] as $mymylinkstheme) {
        $thisSelected           = ($mymylinkstheme == $GLOBALS['mylinks_theme']) ? ' selected' : '';
        $mymylinkstheme_options .= "<option value='{$mymylinkstheme}'{$thisSelected}>{$mymylinkstheme}</option>";
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
