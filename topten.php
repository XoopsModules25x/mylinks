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

$categoryHandler = $helper->getHandler('Category');
$catObjs           = $categoryHandler->getAll();
$myCatTree         = new \XoopsObjectTree($catObjs, 'cid', 'pid');

$GLOBALS['xoopsOption']['template_main'] = 'mylinks_topten.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
//wanikoo
$xoTheme->addStylesheet('browse.php?' . Utility::getStylePath('mylinks.css', 'include'));
$xoTheme->addScript('browse.php?' . Utility::getStylePath('mylinks.js', 'include'));

//generates top 10 charts by rating and hits for each main category
//xoops_load('utility', $xoopsModule->getVar('dirname'));
$sort = Mylinks\Utility::cleanVars($_GET, 'sort', 2, 'int', $limit = [1, 3]);
switch ($sort) {
    case '1':  // Popular
        $sort   = _MD_MYLINKS_RATING;
        $sortDB = 'rating';
        break;
    case '3':  // Most Recent
        $sort   = _MD_MYLINKS_RECENT;
        $sortDB = 'date';
        break;
    case '2':  // Rating
    default:
        $sort   = _MD_MYLINKS_HITS;
        $sortDB = 'hits';
        break;
}
/*
if (!empty($_GET['rate'])) {
  $sort = _MD_MYLINKS_RATING;
  $sortDB = "rating";
} else {
  $sort = _MD_MYLINKS_HITS;
  $sortDB = "hits";
}
*/
$xoopsTpl->assign('lang_sortby', $sort);
$xoopsTpl->assign('lang_rank', _MD_MYLINKS_RANK);
$xoopsTpl->assign('lang_title', _MD_MYLINKS_TITLE);
$xoopsTpl->assign('lang_category', _MD_MYLINKS_CATEGORY);
$xoopsTpl->assign('lang_hits', _MD_MYLINKS_HITS);
$xoopsTpl->assign('lang_rating', _MD_MYLINKS_RATING);
$xoopsTpl->assign('lang_vote', _MD_MYLINKS_VOTE);

// get main category titles
$criteria = new \CriteriaCompo();
$criteria->add(new \Criteria('pid', 0, '='));
$catElements       = ['title'];
$mainCatTitleArray = $categoryHandler->getAll($criteria, $catElements, false, true);
$mainCatIdArray    = array_keys($mainCatTitleArray);
$catCount          = count($mainCatIdArray);
$mainCatIds        = $catCount ? '(' . implode(',', $mainCatIdArray) . ')' : '';
$rankings          = [];

foreach ($mainCatIdArray as $catKey) {
    $treeIds     = [];
    $thisCatTree = $myCatTree->getAllChild($catKey);
    if (!empty($thisCatTree)) {
        $treeIds = array_keys($thisCatTree);
    }
    array_push($treeIds, $catKey);
    $subcatIds = '(' . implode(',', $treeIds) . ')';
    $sql       = 'SELECT lid, cid, title, hits, rating, votes FROM ' . '' . $xoopsDB->prefix('mylinks_links') . '' . " WHERE status>0 AND {$sortDB}>0 AND cid IN {$subcatIds} ORDER BY {$sortDB} DESC LIMIT 0,10";
    $result    = $xoopsDB->query($sql);
    if ($result) {
        $catTitle                   = $myts->htmlSpecialChars($mainCatTitleArray[$catKey]['title']);
        $rankings[$catKey]['title'] = sprintf(_MD_MYLINKS_TOP10, $catTitle);
        $rank                       = 1;
        while (list($lid, $lcid, $ltitle, $hits, $rating, $votes) = $xoopsDB->fetchRow($result)) {
            $thisCatObj = $categoryHandler->get($lcid);
            $homePath   = "<a href='" . XOOPSMYLINKURL . "/index.php'>" . _MD_MYLINKS_MAIN . '</a>&nbsp;:&nbsp;';
            $itemPath   = "<a href='" . XOOPSMYLINKURL . "/viewcat.php?cid={$lcid}'>" . $thisCatObj->getVar('title') . '</a>';
            $path       = '';
            $myParent   = $thisCatObj->getVar('pid');
            while (0 != $myParent) {
                $ancestorObj = $myCatTree->getByKey($myParent);
                $path        = "<a href='" . XOOPSMYLINKURL . '/viewcat.php?cid=' . $ancestorObj->getVar('cid') . "'>" . $ancestorObj->getVar('title') . "</a>&nbsp;:&nbsp;{$path}";
                $myParent    = $ancestorObj->getVar('pid');
            }
            $path = "{$path}{$itemPath}";
            $path = str_replace('&nbsp;:&nbsp;', " <img src='" . Utility::getIconURL('arrow.gif') . "' style='border-width: 0px;' alt=''> ", $path);

            $thisRanking                       = [
                'id'       => $lid,
                'cid'      => $catKey,
                'rank'     => $rank,
                'title'    => $myts->htmlSpecialChars($myts->stripSlashesGPC($ltitle)),
                'category' => $path,
                'hits'     => $hits,
                'rating'   => number_format($rating, 2),
                'votes'    => $votes,
            ];
            $rankings[$catKey]['links'][$rank] = $thisRanking;
            ++$rank;
        }
    }
    if (!array_key_exists('links', $rankings[$catKey])) {
        unset($rankings[$catKey]);
    }
}
$rankings = empty($rankings) ? '' : $rankings;
$xoopsTpl->assign('rankings', $rankings);
unset($rankings);
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

$mylinkstheme_select = '<select name="mylinks_theme_select" onchange="submit();" size="1">' . $mymylinkstheme_options . '</select>';

$xoopsTpl->assign('mylinksthemeoption', $mylinkstheme_select);

//wanikoo search
xoops_loadLanguage('search');
/*
if ( file_exists(XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/search.php") ) {
   require_once XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/search.php";
} else {
   require_once XOOPS_ROOT_PATH."/language/english/search.php";
}
*/
$xoopsTpl->assign('lang_all', _SR_ALL);
$xoopsTpl->assign('lang_any', _SR_ANY);
$xoopsTpl->assign('lang_exact', _SR_EXACT);
$xoopsTpl->assign('lang_search', _SR_SEARCH);
$xoopsTpl->assign('module_id', $xoopsModule->getVar('mid'));

//category head
$catarray = [];
/* removed, not used
if ($mylinks_show_letters) {
  $catarray['letters'] = Utility::letters();
}
*/
if ($mylinks_show_toolbar) {
    $catarray['toolbar'] = Utility::toolbar();
}
$xoopsTpl->assign('catarray', $catarray);

require_once XOOPSMYLINKPATH . '/footer.php';
