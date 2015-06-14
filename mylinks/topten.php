<?php
// $Id: topten.php 11158 2013-03-05 14:10:36Z zyspec $
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

$mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
$catObjs           = $mylinksCatHandler->getAll();
$myCatTree         = new XoopsObjectTree($catObjs, 'cid', 'pid');

$xoopsOption['template_main'] = 'mylinks_topten.html';
include XOOPS_ROOT_PATH."/header.php";
//wanikoo
$xoTheme->addStylesheet('browse.php?' . mylinksGetStylePath('mylinks.css', 'include'));
$xoTheme->addScript('browse.php?' . mylinksGetStylePath('mylinks.js', 'include'));
//

//generates top 10 charts by rating and hits for each main category
include_once './class/utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));
$sort = MylinksUtility::mylinks_cleanVars( $_GET, 'sort', 2, 'int', $limit=array(1,3));
switch ($sort)
{
    case '1':  // Popular
        $sort = _MD_MYLINKS_RATING;
        $sortDB = "rating";
        break;
    case '3':  // Most Recent
        $sort = _MD_MYLINKS_RECENT;
        $sortDB = "date";
        break;
    case '2':  // Rating
    default:
        $sort = _MD_MYLINKS_HITS;
        $sortDB = 'hits';
        break;
}
/*
if(!empty($_GET['rate'])){
  $sort = _MD_MYLINKS_RATING;
  $sortDB = "rating";
}else{
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
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('pid', 0, '='));
$catElements       = array('title');
$mainCatTitleArray = $mylinksCatHandler->getAll($criteria, $catElements, false, true);
$mainCatIdArray    = array_keys($mainCatTitleArray);
$catCount          = count($mainCatIdArray);
$mainCatIds        = ($catCount) ? '(' . implode(',', $mainCatIdArray) . ')' : '';
$rankings          = array();

foreach ($mainCatIdArray as $catKey) {
    $treeIds = array();
    $thisCatTree = $myCatTree->getAllChild($catKey);
    if (!empty($thisCatTree)) {
        $treeIds = array_keys($thisCatTree);
    }
    array_push($treeIds, $catKey);
    $subcatIds = '(' . implode(',', $treeIds) . ')';
    $sql = "SELECT lid, cid, title, hits, rating, votes FROM "
          ."" . $xoopsDB->prefix("mylinks_links") . ""
          ." WHERE status>0 AND {$sortDB}>0 AND cid IN {$subcatIds} ORDER BY {$sortDB} DESC LIMIT 0,10";
    $result = $xoopsDB->query($sql);
    if ($result) {
        $catTitle = $myts->htmlSpecialChars($mainCatTitleArray[$catKey]['title']);
        $rankings[$catKey]['title'] = sprintf(_MD_MYLINKS_TOP10, $catTitle);
        $rank = 1;
        while (list($lid,$lcid,$ltitle,$hits,$rating,$votes)=$xoopsDB->fetchRow($result)) {
            $thisCatObj = $mylinksCatHandler->get($lcid);
            $homePath   = "<a href='" . XOOPSMYLINKURL . "/index.php'>" . _MD_MYLINKS_MAIN . "</a>&nbsp;:&nbsp;";
            $itemPath   = "<a href='" . XOOPSMYLINKURL . "/viewcat.php?cid={$lcid}'>" . $thisCatObj->getVar('title') . "</a>";
            $path       = '';
            $myParent = $thisCatObj->getVar('pid');
            while ( $myParent != 0 ) {
                $ancestorObj = $myCatTree->getByKey($myParent);
                $path  = "<a href='" . XOOPSMYLINKURL . "/viewcat.php?cid=" . $ancestorObj->getVar('cid') . "'>" . $ancestorObj->getVar('title') . "</a>&nbsp;:&nbsp;{$path}";
                $myParent = $ancestorObj->getVar('pid');
            }
            $path = "{$path}{$itemPath}";
            $path = str_replace("&nbsp;:&nbsp;", " <img src='" . mylinksGetIconURL('arrow.gif') . "' style='border-width: 0px;' alt='' /> ", $path);

            $thisRanking = array( 'id'       => $lid,
                                  'cid'      => $catKey,
                                  'rank'     => $rank,
                                  'title'    => $myts->htmlSpecialChars($myts->stripSlashesGPC($ltitle)),
                                  'category' => $path,
                                  'hits'     => $hits,
                                  'rating'   => number_format($rating, 2),
                                  'votes'    => $votes
                                );
            $rankings[$catKey]['links'][$rank] = $thisRanking;
            $rank++;
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
        $mymylinkstheme_options .= " selected='selected'";
    }
    $mymylinkstheme_options .= ">{$mymylinkstheme}</option>";
}

$mylinkstheme_select = '<select name="mylinks_theme_select" onchange="submit();" size="1">'.$mymylinkstheme_options.'</select>';

$xoopsTpl->assign("mylinksthemeoption", $mylinkstheme_select);

//wanikoo search
xoops_loadLanguage('search');
/*
if ( file_exists(XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/search.php") ) {
   include_once XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/search.php";
} else {
   include_once XOOPS_ROOT_PATH."/language/english/search.php";
}
*/
$xoopsTpl->assign('lang_all', _SR_ALL);
$xoopsTpl->assign('lang_any', _SR_ANY);
$xoopsTpl->assign('lang_exact', _SR_EXACT);
$xoopsTpl->assign('lang_search', _SR_SEARCH);
$xoopsTpl->assign('module_id', $xoopsModule->getVar('mid'));

//category head
$catarray = array();
/* removed, not used
if ( $mylinks_show_letters ) {
  $catarray['letters'] = ml_wfd_letters();
}
*/
if ( $mylinks_show_toolbar ) {
    $catarray['toolbar'] = ml_wfd_toolbar();
}
$xoopsTpl->assign('catarray', $catarray);

include_once XOOPSMYLINKPATH . '/footer.php';
