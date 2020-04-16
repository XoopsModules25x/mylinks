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
//require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = \MyTextSanitizer::getInstance(); // MyTextSanitizer object
//xoops_load('utility', $xoopsModule->getVar('dirname'));

if (!empty($_POST['submit'])) {
    global $xoopsDB;

    $ip     = getenv('REMOTE_ADDR');
    $lid    = Mylinks\Utility::cleanVars($_POST, 'lid', 0, 'int', ['min' => 0]);
    $cid    = Mylinks\Utility::cleanVars($_POST, 'cid', 0, 'int', ['min' => 0]);
    $rating = Mylinks\Utility::cleanVars($_POST, 'rating', 0, 'int', ['min' => 0]);

    // make sure listing is active
    $result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE lid={$lid} AND status>0");
    if (!$xoopsDB->fetchRow($result)) {
        redirect_header($_SERVER['SCRIPT_NAME'], 3, _MD_MYLINKS_NORECORDFOUND);
    }

    //    $eh = new ErrorHandler; //ErrorHandler object
    $ratinguser = empty($xoopsUser) ? 0 : $xoopsUser->getVar('uid');

    //Make sure only 1 anonymous from an IP in a single day.
    $anonwaitdays = 1;

    // Check if Rating is Null
    //    if ('--' == $rating) {  //bugfix since rating is an int from input filtering
    if ($rating <= 0) {
        redirect_header("ratelink.php?cid={$cid}&amp;lid={$lid}", 4, _MD_MYLINKS_NORATING);
    } elseif ($rating > 10) {
        $rating = 10;
    }

    // Check if Link POSTER is voting (UNLESS Anonymous users allowed to post)
    if (0 != $ratinguser) {
        $result = $xoopsDB->query('SELECT submitter FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE lid={$lid}");
        while (list($ratinguserDB) = $xoopsDB->fetchRow($result)) {
            if ($ratinguserDB == $ratinguser) {
                redirect_header('index.php', 4, _MD_MYLINKS_CANTVOTEOWN);
            }
        }

        // Check if REG user is trying to vote twice.
        $result = $xoopsDB->query('SELECT ratinguser FROM ' . $xoopsDB->prefix('mylinks_votedata') . " WHERE lid={$lid}");
        while (list($ratinguserDB) = $xoopsDB->fetchRow($result)) {
            if ($ratinguserDB == $ratinguser) {
                redirect_header('index.php', 4, _MD_MYLINKS_VOTEONCE2);
            }
        }
    } else {
        // Check if ANONYMOUS user is trying to vote more than once per day.
        $yesterday = (time() - (86400 * $anonwaitdays));
        $result    = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_votedata') . " WHERE lid={$lid} AND ratinguser=0 AND ratinghostname = '{$ip}' AND ratingtimestamp > {$yesterday}");
        list($anonvotecount) = $xoopsDB->fetchRow($result);
        if ($anonvotecount > 0) {
            redirect_header('index.php', 4, _MD_MYLINKS_VOTEONCE2);
        }
    }
    /*
        if ($rating > 10) {
            $rating = 10;
        }
    */
    //All is well.  Add to Line Item Rate to DB.
    $newid    = $xoopsDB->genId($xoopsDB->prefix('mylinks_votedata') . '_ratingid_seq');
    $datetime = time();
    $sql      = sprintf("INSERT INTO `%s` (ratingid, lid, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES (%u, %u, %u, %u, '%s', %u)", $xoopsDB->prefix('mylinks_votedata'), $newid, $lid, $ratinguser, $rating, $ip, $datetime);
    $result   = $xoopsDB->query($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_DBNOTUPDATED);
        exit();
    }

    //All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
    updaterating($lid);
    $ratemessage = _MD_MYLINKS_VOTEAPPRE . '<br>' . sprintf(_MD_MYLINKS_THANKURATE, htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES));
    redirect_header('index.php', 2, $ratemessage);
} else {
    $GLOBALS['xoopsOption']['template_main'] = 'mylinks_ratelink.tpl';
    require_once XOOPS_ROOT_PATH . '/header.php';

    //wanikoo
    $xoTheme->addStylesheet('browse.php?' . Utility::getStylePath('mylinks.css', 'include'));
    $xoTheme->addScript('browse.php?' . Utility::getStylePath('mylinks.js', 'include'));

    $lid    = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);
    $cid    = Mylinks\Utility::cleanVars($_GET, 'cid', 0, 'int', ['min' => 0]);
    $result = $xoopsDB->query('SELECT title FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE lid={$lid}");
    //TODO:  need error checking here in case invalid lid
    list($title) = $xoopsDB->fetchRow($result);
    $xoopsTpl->assign(
        'link',
        [
            'id'    => $lid,
            'cid'   => $cid,
            'title' => $myts->htmlSpecialChars($myts->stripSlashesGPC($title)),
        ]
    );
    $xoopsTpl->assign('lang_voteonce', _MD_MYLINKS_VOTEONCE);
    $xoopsTpl->assign('lang_ratingscale', _MD_MYLINKS_RATINGSCALE);
    $xoopsTpl->assign('lang_beobjective', _MD_MYLINKS_BEOBJECTIVE);
    $xoopsTpl->assign('lang_donotvote', _MD_MYLINKS_DONOTVOTE);
    $xoopsTpl->assign('lang_rateit', _MD_MYLINKS_RATEIT);
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
