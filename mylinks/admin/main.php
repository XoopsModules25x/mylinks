<?php
/**
 * MyLinks category.php
 *
 * Xoops mylinks - a multicategory links module
 *
 * @copyright::  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @subpackage:: admin
 * @since::		 unknown
 * @author::     Thatware - http://thatware.org/
 * @version::    $Id: main.php 11819 2013-07-09 18:21:40Z zyspec $
 */
// ------------------------------------------------------------------------- //
//                XOOPS - PHP Content Management System                      //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
// Based on:                                                                 //
// myPHPNUKE Web Portal System - http://myphpnuke.com/                       //
// PHP-NUKE Web Portal System - http://phpnuke.org/                          //
// Thatware - http://thatware.org/                                           //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //

include 'admin_header.php';
xoops_loadLanguage('main', $xoopsModule->getVar('dirname'));
include_once '../class/utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));

include '../include/functions.php';
include_once XOOPS_ROOT_PATH . '/class/tree.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/include/xoopscodes.php';
//include_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

$myts =& MyTextSanitizer::getInstance();
//$eh = new ErrorHandler;

$mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
$catObjs = $mylinksCatHandler->getAll();
$myCatTree = new XoopsObjectTree($catObjs, 'cid', 'pid');

function listNewLinks()
{
    global $xoopsDB, $myts, $myCatTree, $xoopsModule;
    // List links waiting for validation
    $linkimg_array = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/images/shots/");
    $result = $xoopsDB->query("SELECT lid, cid, title, url, logourl, submitter FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE status='0' ORDER BY date DESC");
    $numrows = $xoopsDB->getRowsNum($result);
    xoops_cp_header();

    $indexAdmin = new ModuleAdmin();
    echo $indexAdmin->addNavigation('main.php?op=listNewLinks');

    //@TODO: change to use XoopsForm
    echo "<table  class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
        ."  <tr><th colspan='7'>" . sprintf(_MD_MYLINKS_LINKSWAITING, $numrows) . "<br /></th></tr>\n";
    if ( $numrows > 0 ) {
        while (list($lid, $cid, $title, $url, $logourl, $submitterid) = $xoopsDB->fetchRow($result)) {
            $result2 = $xoopsDB->query("SELECT description FROM " . $xoopsDB->prefix("mylinks_text") . " WHERE lid='{$lid}'");
            list($description) = $xoopsDB->fetchRow($result2);
            $title = $myts->htmlSpecialChars($title);
            $url = $myts->htmlSpecialChars($url);
            //      $url = urldecode($url);
            //      $logourl = $myts->htmlSpecialChars($logourl);
            //      $logourl = urldecode($logourl);
            $description = $myts->htmlSpecialChars($description);
            $submitter = XoopsUser::getUnameFromId($submitterid);
            echo "  <tr><td>\n"
              ."    <form action='main.php' method='post'>\n"
              ."	    <table style='width: 80%;'>\n"
              ."          <tr><td style='text-align: right; nowrap='nowrap'>" . _MD_MYLINKS_SUBMITTER . "</td>\n"
              ."            <td><a href=\"".XOOPS_URL."/userinfo.php?uid=".$submitterid."\">$submitter</a></td>\n"
              ."		  </tr>\n"
              ."          <tr><td style='text-align: right;' nowrap='nowrap'>" . _MD_MYLINKS_SITETITLE . "</td>\n"
              ."            <td><input type='text' name='title' size='50' maxlength='100' value='{$title}' /></td>\n"
              ."		  </tr>\n"
              ."		  <tr><td style='text-align: right;' nowrap='nowrap'>" . _MD_MYLINKS_SITEURL . "</td>\n"
              ."		    <td><input type='text' name='url' size='50' maxlength='250' value='{$url}' />&nbsp;\n"
              ."              [&nbsp;<a href='" . preg_replace("/javascript:/si", 'java script:', $url) . "' target='_blank'>" . _MD_MYLINKS_VISIT . "</a>&nbsp;]\n"
              ."			</td>\n"
              ."		  </tr>\n"
              ."		  <tr><td style='text-align: right;' nowrap'nowrap'>" . _MD_MYLINKS_CATEGORYC . "</td>\n"
              ."            <td>" . $myCatTree->makeSelBox("cid", "title", '- ', $cid) . "</td>\n"
              ."          </tr>\n"
              ."        <tr><td style='text-align: right; vertical-align: top;' nowrap='nowrap'>" . _MD_MYLINKS_DESCRIPTIONC . "</td>\n"
              ."          <td><textarea name='description' cols='60' rows='5'>{$description}</textarea></td>\n"
              ."        </tr>\n"
              ."        <tr><td style='text-align: right; nowrap='nowrap'>" . _MD_MYLINKS_SHOTIMAGE . "</td>\n"
              ."			<td><select size='1' name='logourl'><option value=' '>------</option>";
            foreach ($linkimg_array as $image){
                echo "<option value='{$image}'>{$image}</option>";
            }
            $shotdir = "<strong>" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/images/shots/</strong>";
            echo "</select></td>\n"
                ."        </tr>\n"
                ."        <tr><td></td><td>" . sprintf(_MD_MYLINKS_SHOTMUST, $shotdir) . "</td></tr>\n"
                ."      </table>\n"
                ."      <br /><input type='hidden' name='op' value='approve' />\n"
                ."		<input type='hidden' name='lid' value='{$lid}' />\n"
                ."      <input type='submit' value='" . _MD_MYLINKS_APPROVE . "' />\n"
                ."    </form>\n";
            echo "    <form action='main.php?op=delNewLink&amp;lid={$lid}' method='post'><input type='submit' value='" . _DELETE . "' /></form>\n"
                ."    <br /><br />\n"
                ."  </td></tr>\n";
        }
    } else {
        echo "  <tr><td colspan='7' class='odd bold italic'>" . _MD_MYLINKS_NOSUBMITTED . "</td></tr>\n";
    }
        echo "</table>\n";

    include 'admin_footer.php';
}

function linksConfigMenu()
{
    global $xoopsDB, $myts, $myCatTree, $xoopsModule;

    $mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
    $catCount = $mylinksCatHandler->getCount();
    $linkimg_array = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/images/shots/");

    xoops_cp_header()    ;
    $indexAdmin = new ModuleAdmin();
    echo $indexAdmin->addNavigation('main.php?op=linksConfigMenu');

//    echo "<h4>" . _MD_MYLINKS_WEBLINKSCONF . "</h4>\n";

    // If there is a category, display add a New Link table
    //@TODO:  change to use XoopsForm
    if ($catCount) {
        echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
          ."  <tr><th style='font-size: larger;'>" . _MD_MYLINKS_ADDNEWLINK . "</th></tr>\n"
          ."  <tr class='odd'><td style='padding: 0 10em;'>\n"
          ."    <form method='post' action='main.php'>\n"
          ."      <table style='width: 80%;'>\n"
          ."        <tr>\n"
          ."          <td style='text-align: right;'>" . _MD_MYLINKS_SITETITLE . "</td>\n"
          ."			<td><input type='text' name='title' size='50' maxlength='100' /></td>\n"
          ."		  </tr>\n"
          ."        <tr>\n"
          ."          <td style='text-align: right;' nowrap='nowrap'>" . _MD_MYLINKS_SITEURL . "</td>\n"
          ."          <td><input type='text' name='url' size='50' maxlength='250' value='http://' /></td>\n"
          ."        </tr>\n"
          ."        <tr>\n"
          ."          <td style='text-align: right;' nowrap='nowrap'>" . _MD_MYLINKS_CATEGORYC . "</td>\n"
          ."          <td>\n"
          ."            " . $myCatTree->makeSelBox("cid", "title") . "\n"
          ."		    </td>\n"
          ."		  </tr>\n"
          ."		  <tr>\n"
          ."          <td style='text-align: right; vertical-align: top;' nowrap='nowrap'>" . _MD_MYLINKS_DESCRIPTIONC . "</td>\n"
          ."          <td>";
        xoopsCodeTarea("descarea", 60, 8);
        xoopsSmilies("descarea");
        echo "          </td>\n"
            ."        </tr>\n"
            ."        <tr>\n"
            ."          <td style='text-align: right; nowrap='nowrap'>" . _MD_MYLINKS_SHOTIMAGE . "</td>\n"
            ."          <td><select size='1' name='logourl'><option value=' '>------</option>";
        foreach ($linkimg_array as $image) {
            echo "<option value='{$image}'>{$image}</option>";
        }
        echo "</select></td>\n"
          ."        </tr>\n";
        $shotdir = "<strong>" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/images/shots/</strong>";
        echo "        <tr><td></td><td>" . sprintf(_MD_MYLINKS_SHOTMUST, $shotdir) . "</td></tr>\n"
            ."      </table><br />\n"
            ."      <div style='text-align: center;'>\n"
            ."        <input type='hidden' name='op' value='addLink' />\n"
            ."        <input type='submit' class='button' value='" . _ADD . "' />\n"
            ."      </div>\n"
            ."    </form>\n"
            ."  </td></tr>\n"
            ."</table>\n"
            ."<br />\n";

        // Modify Link
        $result2 = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_links") . "");
        list($numLinks) = $xoopsDB->fetchRow($result2);
        if ( $numLinks ) {
            echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
                ."  <tr><th style='font-size: larger;'>" . _MD_MYLINKS_MODLINK . "</th></tr>\n"
                ."  <tr class='odd'><td style='text-align: center;'>\n"
                ."    <form method='get' action='main.php'>\n"
                ."      " . _MD_MYLINKS_LINKID . "\n"
                ."      <input type='text' name='lid' size='12' maxlength='11' />\n"
                ."      <input type='hidden' name='fct' value='mylinks' />\n"
                ."      <input type='hidden' name='op' value='modLink' /><br /><br />\n"
                ."      <input type='submit' value='" . _MD_MYLINKS_MODIFY . "' />\n"
                ."    </form>\n"
                ."  </td></tr>\n"
                ."</table>";
        }
    }

    // Add a New Main Category
    echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
        ."  <tr><th style='font-size: larger;'>" . _MD_MYLINKS_ADDMAIN . "</th></tr>\n"
        ."  <tr class='odd'><td style='text-align: center;'>\n"
        ."    <form method='post' action='main.php'>\n"
        ."      " . _MD_MYLINKS_TITLEC . "\n"
        ."      <input type='text' name='title' size='30' maxlength='50' /><br />\n"
        ."      " . _MD_MYLINKS_IMGURL . "<br />\n"
        ."      <input type='text' name='imgurl' size='100' maxlength='150' value='http://' /><br /><br />\n"
        ."	    <input type='hidden' name='cid' value='0' />\n"
        ."      <input type='hidden' name='op' value='addCat' />\n"
        ."      <input type='submit' value='" . _ADD . "' /><br />\n"
        ."    </form>\n"
        ."  </td></tr>\n";
    if (!$catCount) {
        echo "  <tr><th style='font-size: larger;'>" . _MD_MYLINKS_IMPORTCATHDR . "</th></tr>\n"
            ."  <tr class='even'><td style='text-align: center;'>\n"
            ."    <form method='post' action='main.php'>\n"
            ."      " . _MD_MYLINKS_IMPORTCATS . "<br />\n"
            ."      <input type='hidden' name='op' value='importCats' />\n"
            ."      <input type='hidden' name='ok' value='0' />\n"
            ."      <input style='margin: .5em 0em;' type='submit' value='" . _SUBMIT . "' /><br />\n"
            ."    </form>\n"
            ."  </td></tr>"
            ."</table>\n"
            ."<br />\n";
    }
    // Add a New Sub-Category
    if ($catCount) {
        echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
            ."  <tr><th style='font-size: larger;'>" . _MD_MYLINKS_ADDSUB . "</th></tr>\n"
            ."  <tr class='odd'><td style='text-align: center;'>\n"
            ."    <form method='post' action='main.php'>\n"
            ."      " . _MD_MYLINKS_TITLEC . "\n"
            ."      <input type='text' name='title' size='30' maxlength='50' />&nbsp;" . _MD_MYLINKS_IN . "&nbsp;\n"
            ."      " . $myCatTree->makeSelBox("pid", "title") . "\n"
            ."      <input type='hidden' name='op' value='addCat' /><br /><br />\n"
            ."      <input type='submit' value='" . _ADD . "' /><br />\n"
            ."    </form>\n"
            ."  </td></tr>\n"
            ."</table>\n"
            ."<br />";
    }

    // Modify Category Table Display
    if ($catCount) {
        echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
            ."  <tr><th style='font-size: larger;'>" . _MD_MYLINKS_MODCAT . "</th></tr>\n"
            ."  <tr class='odd'><td style='text-align: center;'>\n"
            ."    <form method='get' action='main.php'>\n"
//            ."      <h4>" . _MD_MYLINKS_MODCAT . "</h4><br />\n"
            ."      " . _MD_MYLINKS_CATEGORYC . "\n"
            ."      " . $myCatTree->makeSelBox("cid", "title") . "\n"
            ."      <br /><br />\n"
            ."      <input type='hidden' name='op' value='modCat' />\n"
            ."      <input type='submit' value='" . _MD_MYLINKS_MODIFY . "' />\n"
            ."    </form>\n"
            ."  </td></tr>\n"
            ."</table>\n"
            ."<br />\n";
    }
    include 'admin_footer.php';
}

function modLink()
{
    global $xoopsDB, $myts, $myCatTree, $xoopsModule;

    $linkimg_array = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/images/shots/");
    $lid      = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));
    $bknrptid = mylinksUtility::mylinks_cleanVars($_GET, 'bknrptid', 0, 'int', array('min'=>0));

    xoops_cp_header();

    $result = $xoopsDB->query("SELECT cid, title, url, logourl FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE lid={$lid}");
    if (!result) {
        mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    list($cid, $title, $url, $logourl) = $xoopsDB->fetchRow($result);

    $title                  = $myts->htmlSpecialChars($myts->stripSlashesGPC($title));
    $url                    = $myts->htmlSpecialChars($myts->stripSlashesGPC($url));
    $logourl                = $myts->htmlSpecialChars($myts->stripSlashesGPC($logourl));
    //$url                    = urldecode($url);
    //$logourl                = urldecode($logourl);
    $result2                = $xoopsDB->query("SELECT description FROM " . $xoopsDB->prefix("mylinks_text") . " WHERE lid={$lid}");
    list($description)      = $xoopsDB->fetchRow($result2);
    $GLOBALS['description'] = $myts->htmlSpecialChars($myts->stripSlashesGPC($description));

    echo "<h4>" . _MD_MYLINKS_WEBLINKSCONF . "</h4>"
        ."<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>"
        ."  <tr><th colspan='2'>" . _MD_MYLINKS_MODLINK . "</th></tr>\n"
        ."  <tr class='odd'>\n"
        ."    <td>\n"
        ."      <form method='post' action='main.php' style='display: inline;'>\n"
        ."        <table>\n"
        ."          <tr><td>" . _MD_MYLINKS_LINKID . "</td><td style='font-weight: bold;'>{$lid}</td></tr>\n"
        ."          <tr><td>" . _MD_MYLINKS_SITETITLE . "</td><td><input type='text' name='title' value='{$title}' size='50' maxlength='100' /></td></tr>\n"
        ."			<tr><td>" . _MD_MYLINKS_SITEURL . "</td><td><input type='text' name='url' value='{$url}' size='50' maxlength='250' /></td></tr>\n"
        ."          <tr><td style='vertical-align: top;'>" . _MD_MYLINKS_DESCRIPTIONC . "</td><td>";
    xoopsCodeTarea("description", 60, 8);
    xoopsSmilies("description");
    echo "</td></tr>\n"
        ."			<tr><td>" . _MD_MYLINKS_CATEGORYC . "</td><td>"
        ."" . $myCatTree->makeSelBox("cid", "title", '- ', $cid) . ""
        ."          </td></tr>\n"
        ."			<tr><td>"._MD_MYLINKS_SHOTIMAGE."</td><td>"
        ."<select size='1' name='logourl'>"
        ."<option value=' '>------</option>";
    foreach ($linkimg_array as $image) {
        $opt_selected = ( $image == $logourl ) ? " selected='selected'" : '';
        echo "<option value='{$image}'{$opt_selected}>{$image}</option>";
    }
    echo "</select>"
        ."</td></tr>\n";

    $shotdir = "<strong>" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/images/shots/</strong>";
    echo "          <tr><td>&nbsp;</td><td>" . sprintf(_MD_MYLINKS_SHOTMUST, $shotdir) . "</td></tr>\n"
        ."        </table>"
        ."        <br /><br /><input type='hidden' name='lid' value='{$lid}' />\n"
        ."        <input type='hidden' name='bknrptid' value='{$bknrptid}' />\n"
        ."        <input type='hidden' name='op' value='modLinkS' />\n"
        ."        <input type='submit' value='" . _MD_MYLINKS_MODIFY . "' />"
        ."      </form>\n"
        ."		<form action='main.php?op=delLink&amp;lid={$lid}' method='post' style='margin-left: 1em; display: inline;'><input type='submit' value='" . _DELETE . "' /></form>\n"
        ."		<form action='main.php?op=linksConfigMenu' method='post' style='margin-left: 1em; display: inline;'><input type='submit' value='" . _CANCEL . "' /></form>\n"
        ."      <hr />";

    $result5=$xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("mylinks_votedata")." WHERE lid='{$lid}'");
    list($totalvotes) = $xoopsDB->fetchRow($result5);
    echo "      <table style='width: 100%;'>\n"
        ."        <tr><td colspan='7' style='font-weight: bold;'>" . sprintf(_MD_MYLINKS_TOTALVOTES , $totalvotes) . "<br /><br /></td></tr>\n";
    // Show Registered Users Votes
    $result5=$xoopsDB->query("SELECT ratingid, ratinguser, rating, ratinghostname, ratingtimestamp FROM " . $xoopsDB->prefix("mylinks_votedata") . " WHERE lid='{$lid}' AND ratinguser >0 ORDER BY ratingtimestamp DESC");
    $votes = $xoopsDB->getRowsNum($result5);
    echo "        <tr><td colspan='7' style='font-weight: bold;'><br /><br />" . sprintf(_MD_MYLINKS_USERTOTALVOTES, $votes) . "<br /><br /></td></tr>\n";
    echo "        <tr>\n"
        ."          <th>" . _MD_MYLINKS_USER . "  </th>\n"
        ."          <th>" . _MD_MYLINKS_IP . "  </th>\n"
        ."          <th>" . _MD_MYLINKS_RATING . "  </th>\n"
        ."			<th>" . _MD_MYLINKS_USERAVG . "  </th>\n"
        ."          <th>" . _MD_MYLINKS_TOTALRATE . "  </th>\n"
        ."          <th>" . _MD_MYLINKS_DATE . "  </th>\n"
        ."          <th>" . _DELETE . "</td>\n"
        ."        </tr>\n";
    if ( 0 == $votes ) {
        echo "        <tr><td style='text-align: center;' colspan='7'>" . _MD_MYLINKS_NOREGVOTES . "<br /></td></tr>\n";
    }

    $x = 0;
    $colorswitch = "#DDDDDD";

    while (list($ratingid, $ratinguser, $rating, $ratinghostname, $ratingtimestamp)=$xoopsDB->fetchRow($result5)) {
        //  $ratingtimestamp = formatTimestamp($ratingtimestamp);
        //Individual user information
        //v3.11 changed to let SQL do calculations instead of PHP
        $result2 = $xoopsDB->query("SELECT COUNT(), FORMAT(AVG(rating),2) FROM " . $xoopsDB->prefix("mylinks_votedata") . " WHERE ratinguser = '$ratinguser'");
        list($uservotes, $useravgrating) = $xoopsDB->fetchRow($result2);
//        $useravgrating = ($rating2) ? sprintf("%01.2f", ($useravgrating / $uservotes)) : 0;
/*
        $result2=$xoopsDB->query("SELECT rating FROM ".$xoopsDB->prefix("mylinks_votedata")." WHERE ratinguser = '$ratinguser'");
        $uservotes = $xoopsDB->getRowsNum($result2);
        $useravgrating = 0;
        while ( list($rating2) = $xoopsDB->fetchRow($result2) ) {
            $useravgrating = $useravgrating + $rating2;
        }
        $useravgrating = sprintf("%01.2f", ($useravgrating / $uservotes));
*/
        $ratingusername = XoopsUser::getUnameFromId($ratinguser);
        echo "        <tr>\n"
            ."    		<td style='background-color: {$colorswitch};'>{$ratingusername}</td>\n"
            ."    		<td style='background-color: {$colorswitch};'>{$ratinghostname}</td>\n"
            ."    		<td style='background-color: {$colorswitch};'>{$rating}</td>\n"
            ."    		<td style='background-color: {$colorswitch};'>{$useravgrating}</td>\n"
            ."    		<td style='background-color: {$colorswitch};'>{$uservotes}</td>\n"
            ."    		<td style='background-color: {$colorswitch};'>{$ratingtimestamp}</td>\n"
            ."    		<td style='background-color: {$colorswitch}; text-align: center; font-weight: bold;'>\n"
            ."      	  <form action='main.php?op=delVote&amp;lid={$lid}&amp;rid={$ratingid}' method='post'><input type='submit' value='X' /></form>\n"
            ."    		</td>\n"
            ."  	  </tr>\n";
        $x++;
        $colorswitch = ( $colorswitch == "#DDDDDD" ) ? "#FFFFFF" : "#DDDDDD";
    }
    // Show Unregistered Users Votes
    $result5=$xoopsDB->query("SELECT ratingid, rating, ratinghostname, ratingtimestamp FROM ".$xoopsDB->prefix("mylinks_votedata")." WHERE lid ='{$lid}' AND ratinguser='0' ORDER BY ratingtimestamp DESC");
    $votes = $xoopsDB->getRowsNum($result5);
    echo "        <tr><td colspan='7' style='font-weight: bold;'><br /><br />" . sprintf(_MD_MYLINKS_ANONTOTALVOTES , $votes) . "<br /><br /></td></tr>\n"
        ."        <tr>\n"
        ."          <th colspan='2'>" . _MD_MYLINKS_IP . "  </th>\n"
        ."		    <th colspan='3' style='font-weight: bold;'>" . _MD_MYLINKS_RATING . "  </th>\n"
        ."			<th style='font-weight: bold;'>" . _MD_MYLINKS_DATE . "  </th>\n"
        ."          <th style='text-align: center; font-weight: bold;'>" . _DELETE . "<br /></th>\n"
        ."        </tr>\n";
    if ( 0 == $votes ) {
        echo "        <tr><td colspan='7' style='text-align: center;'>" . _MD_MYLINKS_NOUNREGVOTES . "<br /></td></tr>\n";
    }
    $x = 0;
    $colorswitch = "#DDDDDD";
    while ( list($ratingid, $rating, $ratinghostname, $ratingtimestamp)=$xoopsDB->fetchRow($result5) ) {
        $formatted_date = formatTimestamp($ratingtimestamp);
        echo "        <tr>\n"
          ."          <td colspan='2' style='background-color: {$colorswitch}'>{$ratinghostname}</td>\n"
          ."          <td colspan='3' style='background-color: {$colorswitch}'>{$rating}</td>\n"
          ."          <td style='background-color: {$colorswitch}'>{$formatted_date}</td>\n"
          ."          <td style='background-color: {$colorswitch} text-align: center; font-weight: bold;'>\n"
          ."            <form action='main.php?op=delVote&amp;lid={$lid}&amp;rid={$ratingid}' method='post'><input type='submit' value='X' /></form>\n"
          ."          </td>"
          ."        </tr>";
        $x++;
        $colorswitch = ( $colorswitch == "#DDDDDD" ) ? "#FFFFFF" : "#DDDDDD";
    }
    echo "        <tr><td colspan='7'>&nbsp;<br /></td></tr>\n"
        ."      </table>\n"
        ."    </td>\n"
        ."  </tr>\n"
        ."</table>\n";
    include 'admin_footer.php';
}

function delVote()
{
    global $xoopsDB;
    $lid   = mylinksUtility::mylinks_cleanVars($_POST, 'lid', 0, 'int', array('min'=>0));
    $rid   = mylinksUtility::mylinks_cleanVars($_POST, 'rid', 0, 'int', array('min'=>0));

    $sql = sprintf("DELETE FROM %s WHERE ratingid = %u", $xoopsDB->prefix("mylinks_votedata"), $rid);
    $result = $xoopsDB->query($sql);
    if (!result) {
        mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    updaterating($lid);
    redirect_header('index.php', 2, _MD_MYLINKS_VOTEDELETED);
    exit();
}

function listBrokenLinks()
{
    global $xoopsDB, $xoopsModule, $pathIcon16, $myts;

    $result = $xoopsDB->query("SELECT * FROM " . $xoopsDB->prefix("mylinks_broken") . " GROUP BY lid ORDER BY reportid DESC");
    $totalBrokenLinks = $xoopsDB->getRowsNum($result);
    xoops_cp_header();

    $indexAdmin = new ModuleAdmin();
    echo $indexAdmin->addNavigation('main.php?op=listBrokenLinks');
    $GLOBALS['xoTheme']->addStylesheet(mylinksGetStylePath('mylinks.css', 'include'));
//    echo "<link rel='stylesheet' href='" . $GLOBALS['xoops']->url('browse.php?modules/mylinks/include/mylinks.css') . "' type='text/css' />";

    echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
       . "  <tr><th>" . sprintf(_MD_MYLINKS_BROKENREPORTS, $totalBrokenLinks) . "<br /></th></tr>\n"
       . "  <tr class='odd'><td>\n";

    if ( 0 == $totalBrokenLinks ) {
        echo "    <span class='italic bold'>" . _MD_MYLINKS_NOBROKEN . "</span>";
    } else {
        $colorswitch = "#DDDDDD";
        echo "<img src='{$pathIcon16}/on.png' /> = "._MD_MYLINKS_IGNOREDESC . "<br />"
           . "<img src='{$pathIcon16}/edit.png' /> = " . _MD_MYLINKS_EDITDESC . "<br />"
           . "<img src='{$pathIcon16}/delete.png' /> = ". _MD_MYLINKS_DELETEDESC .  "<br />"
           . "   <table class='center width100'>\n"
//           ."      <tr><th colspan='6'>" . _MD_MYLINKS_DELETEDESC . "</th><tr>"
           . "      <tr>\n"
           . "        <th>" . _MD_MYLINKS_LINKNAME . "</th>\n"
           . "        <th>" . _MD_MYLINKS_REPORTER . "</th>\n"
           . "        <th>" . _MD_MYLINKS_LINKSUBMITTER . "</th>\n"
           . "        <th>" . _MD_MYLINKS_ACTIONS . "</th>\n"
           . "      </tr>\n";

        $formToken = $GLOBALS['xoopsSecurity']->getTokenHTML();

        while ( list($reportid, $lid, $sender, $ip)=$xoopsDB->fetchRow($result) ) {
            $result2 = $xoopsDB->query("SELECT title, url, submitter FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE lid={$lid}");
            if ( 0 != $sender ) {
                $result3 = $xoopsDB->query("SELECT uname, email FROM " . $xoopsDB->prefix("users") . " WHERE uid={$sender}");
                list($uname, $email) = $xoopsDB->fetchRow($result3);
            }
            list($title, $url, $ownerid) = $xoopsDB->fetchRow($result2);
            $title = $myts->stripSlashesGPC($title);
            //          $url=urldecode($url);
            $result4 = $xoopsDB->query("SELECT uname, email FROM " . $xoopsDB->prefix("users") . " WHERE uid='{$ownerid}'");
            list($owner, $owneremail) = $xoopsDB->fetchRow($result4);
            echo "      <tr>\n"
                ."        <td style='background-color: {$colorswitch}'><a href=$url target='_blank'>{$title}</a></td>\n";
            if ( $email=='' ) {
                echo "        <td style='background-color: {$colorswitch};'>{$sender} ({$ip})";
            } else {
                echo "        <td style='background-color: {$colorswitch};'><a href='mailto:{$email}'>{$uname}</a> ({$ip})";
            }
            echo "        </td>\n";
            if ( '' == $owneremail ) {
                echo "        <td style='background-color: {$colorswitch};'>{$owner}";
            } else {
                echo "        <td style='background-color: {$colorswitch};'><a href='mailto:{$owneremail}'>{$owner}</a>\n";
            }
            echo "        <td style='text-align: center; background-color: {$colorswitch};'>\n"
//                ."          <a href='main.php?op=ignoreBrokenLinks&amp;lid={$lid}'><img src=". $pathIcon16 ."/on.png alt='" . _AM_MYLINKS_IGNORE . "' title='" . _AM_MYLINKS_IGNORE . "'></a>\n"
//                ."          <a href='main.php?op=modLink&amp;lid={$lid}&amp;bknrptid={$reportid}'><img src=". $pathIcon16 ."/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>\n"
//                ."          <a href='main.php?op=delBrokenLinks&amp;lid={$lid}'><img src=". $pathIcon16 ."/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>\n"
               . "          <form class='inline' action='" . $_SERVER['PHP_SELF'] . "' method='post'>\n"
               . "	           <input type='hidden' name='op' value='ignoreBrokenLinks' />\n"
               . "	           <input type='hidden' name='bknrptid' value='{$reportid}' />\n"
               . "            {$formToken}\n"
               . "            <input type='button' title='" . _MD_MYLINKS_IGNOREDESC . "' alt='" . _AM_MYLINKS_IGNORE . "' id='image-button-on' onclick='this.form.submit();'></input>\n"
               . "          </form>\n"
               . "          <form class='inline' action='" . $_SERVER['PHP_SELF'] . "'?op=modLink&amp;lid={$lid} method='get'>\n"
               . "            <input type='hidden' name='op' value='modLink' />\n"
               . "            <input type='hidden' name='bknrptid' value='{$reportid}' />\n"
               . "            <input type='hidden' name='lid' value={$lid} />\n"
               . "            <input type='button' title='" . _MD_MYLINKS_EDITDESC . "' alt='" . _EDIT . "' id='image-button-edit' onclick='this.form.submit();'></input>\n"
               . "          </form>\n"
               . "          <form class='inline' action='" . $_SERVER['PHP_SELF'] . "' method='post'>\n"
               . "	           <input type='hidden' name='op' value='delBrokenLinks' />\n"
               . "	           <input type='hidden' name='lid' value='{$lid}' />\n"
               . "            {$formToken}\n"
               . "            <input type='button' title='" . _MD_MYLINKS_DELETEDESC . "' alt='" . _DELETE . "' id='image-button-delete' onclick='this.form.submit();'></input>\n"
               . "          </form>\n"
               . "        </td>\n"
               . "      </tr>\n";

            $colorswitch = ( $colorswitch == "#DDDDDD" ) ? "#FFFFFF" : "#DDDDDD";
        }
        echo "    </table>\n";
    }

    echo "</td></tr></table>";
    include 'admin_footer.php';
}

function delBrokenLinks()
{
    global $xoopsDB;

    $lid   = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));

    $sql = sprintf("DELETE FROM %s WHERE lid = %u", $xoopsDB->prefix("mylinks_broken"), $lid);
    $result = $xoopsDB->queryF($sql);
    if (!result) {
        mylinksUtility::show_message(_MD_MYLINKS_NOBROKEN);
        exit();
    }

    $sql = sprintf("DELETE FROM %s WHERE lid = %u", $xoopsDB->prefix("mylinks_links"), $lid);
    $result = $xoopsDB->queryF($sql);
    if (!result) {
        mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
    } else {
        mylinksUtility::show_message(_MD_MYLINKS_LINKDELETED);
    }
    exit();
}

function ignoreBrokenLinks()
{
    global $xoopsDB;

    $bknrptid = mylinksUtility::mylinks_cleanVars($_POST, 'bknrptid', 0, 'int', array('min'=>0));
    $sql = sprintf("DELETE FROM %s WHERE reportid = %u", $xoopsDB->prefix("mylinks_broken"), $bknrptid);
    $result = $xoopsDB->queryF($sql);
    if (!result) {
        mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
    } else {
        mylinksUtility::show_message(_MD_MYLINKS_BROKENDELETED);
    }
    exit();
}

function listModReq()
{
    global $xoopsDB, $myts, $xoopsModuleConfig, $xoopsModule;

    $result = $xoopsDB->query("SELECT requestid, lid, cid, title, url, logourl, description, modifysubmitter FROM " . $xoopsDB->prefix("mylinks_mod") . " ORDER BY requestid");
    $totalModRequests = $xoopsDB->getRowsNum($result);
    xoops_cp_header();
    $indexAdmin = new ModuleAdmin();
    echo $indexAdmin->addNavigation('main.php?op=listModReq');

    $mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));

    //echo "<h4>" . _MD_MYLINKS_WEBLINKSCONF . "</h4>\n";
    echo "<table class='outer' style='width: 100%; border-weight: 0px; margin: 1px;'>\n"
      ."  <tr class='even'><th>" . sprintf(_MD_MYLINKS_MODREQUESTS, $totalModRequests) . "</th></tr>\n"
      ."  <tr class='odd'>\n"
      ."    <td>\n";
    if ( $totalModRequests > 0 ) {
        echo "  <table style='width: 95%;'>\n"
            ."    <tr>\n"
            ."      <td>\n";
        $lookup_lid = array();
        while ( list($requestid, $lid, $cid, $title, $url, $logourl, $description, $submitterid)=$xoopsDB->fetchRow($result) ) {
            $catObj = $mylinksCatHandler->get($cid);
            $lookup_lid[$requestid] = $lid;
            $result2 = $xoopsDB->query("SELECT cid, title, url, logourl, submitter FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE lid='{$lid}'");
            list($origcid, $origtitle, $origurl, $origlogourl, $ownerid)=$xoopsDB->fetchRow($result2);
            $origCatObj = $mylinksCatHandler->get($origcid);
            $result2 = $xoopsDB->query("SELECT description FROM " . $xoopsDB->prefix("mylinks_text") . " WHERE lid='{$lid}'");
            list($origdescription) = $xoopsDB->fetchRow($result2);
            $result7      = $xoopsDB->query("SELECT uname, email FROM " . $xoopsDB->prefix("users") . " WHERE uid='{$submitterid}'");
            $result8      = $xoopsDB->query("SELECT uname, email FROM " . $xoopsDB->prefix("users") . " WHERE uid='{$ownerid}'");
            $cidtitle     = $catObj->getVar('title');
            $cidtitle     = $myts->htmlSpecialChars($cidtitle);
            $origcidtitle = $origCatObj->getVar('title');
            $origcidtitle = $myts->htmlSpecialChars($origcidtitle);
/*
            $cidtitle     = $catObj->getPathFromID();
            $origcidtitle = $origCatObj->getPathFromID();
*/
            list($submitter, $submitteremail) = $xoopsDB->fetchRow($result7);
            list($owner, $owneremail)         = $xoopsDB->fetchRow($result8);
            $title = $myts->htmlSpecialChars($title);
            $url   = $myts->htmlSpecialChars($url);
            //$url   = urldecode($url);

            // use original image file to prevent users from changing screen shots file
            $origlogourl = $myts->htmlSpecialChars($origlogourl);
            $logourl     = $origlogourl;

            //$logourl     = urldecode($logourl);
            $description = $myts->displayTarea($myts->stripSlashesGPC($description), 0);
            $origurl     = $myts->htmlSpecialChars($origurl);
            //$origurl     = urldecode($origurl);
            //$origlogourl = urldecode($origlogourl);
            $origdescription = $myts->displayTarea($myts->stripSlashesGPC($origdescription), 0);
            $owner = ( '' == $owner ) ? 'administration' : $owner;
            echo "        <table style='border-width: 1px; border-color: black; padding: 5px; margin: auto; text-align: center; width: 800px;'>\n"
                ."          <tr><td>\n"
                ."            <table style='width: 100%; background-color: #DDDDDD'>\n"
                ."			    <tr>\n"
                ."                <td style='vertical-align: top; width: 45%; font-weight: bold;'>" . _MD_MYLINKS_ORIGINAL . "</td>\n"
                ."                <td rowspan='14' style='vertical-align: top; text-align: left; font-size: small;'><br />" . _MD_MYLINKS_DESCRIPTIONC . "<br />{$origdescription}</td>\n"
                ."              </tr>\n"
                ."              <tr><td style='vertical-align: top; width: 45%; font-size: small;'>" . _MD_MYLINKS_SITETITLE . "{$myts->stripSlashesGPC($origtitle)}</td></tr>\n"
                ."              <tr><td style='vertical-align: top; width: 45%; font-size: small;'>" . _MD_MYLINKS_SITEURL . "{$origurl}</td></tr>\n"
                ."              <tr><td style='vertical-align= top; width: 45%; font-size: small;'>" . _MD_MYLINKS_CATEGORYC . "{$origcidtitle}</td></tr>\n"
                ."              <tr><td style='vertical-align: top; width: 45%; font-size: small;'>" . _MD_MYLINKS_SHOTIMAGE . "";
            if ( $xoopsModuleConfig['useshots'] && !empty($origlogourl) ) {
                echo "<img src='" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/images/shots/{$origlogourl}' style='width: " . $xoopsModuleConfig['shotwidth'] . ";' />";
            } else {
                echo "&nbsp;";
            }
            echo "</td></tr>\n"
                ."        </table>\n"
                ."      </td></tr>\n"
                ."      <tr><td>\n"
                ."        <table style='width: 100%; background-color: #DDDDDD'>\n"
                ."		    <tr>\n"
                ."            <td style='vertical-align: top; width: 45%; font-weight: bold;'>" . _MD_MYLINKS_PROPOSED . "</td>\n"
                ."            <td rowspan='14' style='vertical-align: top; text-align: left; font-size: small;'><br />" . _MD_MYLINKS_DESCRIPTIONC . "<br />{$description}</td>\n"
                ."          </tr>\n"
                ."          <tr><td style='vertical-align: top; width: 45%; font-size: small;'>" . _MD_MYLINKS_SITETITLE . "{$title}</td></tr>\n"
                ."          <tr><td style='vertical-align: top; width: 45%; font-size: small;'>" . _MD_MYLINKS_SITEURL . "{$url}</td></tr>\n"
                ."          <tr><td style='vertical-align: top; width: 45%; font-size: small;'>" . _MD_MYLINKS_CATEGORYC . "{$cidtitle}</td></tr>\n"
                ."          <tr><td style='vertical-align: top; width: 45%; font-size: small;'>" . _MD_MYLINKS_SHOTIMAGE . "";
            if ( $xoopsModuleConfig['useshots'] == 1 && !empty($logourl) ) {
                echo "<img src='" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/images/shots/{$logourl}' style='width: " . $xoopsModuleConfig['shotwidth'] . ";' alt='' />";
            } else {
                echo "&nbsp;";
            }
            echo "</td></tr>\n"
              ."        </table>\n"
              ."      </td></tr>\n"
              ."    </table>\n"
              ."    <table style='text-align: center; width: 800px; margin: auto;'>\n"
              ."      <tr>\n";
            if ( '' == $submitteremail ) {
                echo "      <td style='text-align: center; font-weight: bold;'>" . _MD_MYLINKS_SUBMITTER . "{$submitter}</td>\n";
            } else {
                echo "      <td style='text-align: center; font-size: small;'>" . _MD_MYLINKS_SUBMITTER . "<a href='mailto:{$submitteremail}'>{$submitter}</a></td>\n";
            }
            if ( '' == $owneremail ) {
                echo "      <td style='text-align: center; font-size: small;'>" . _MD_MYLINKS_OWNER . "{$owner}</td>\n";
            } else {
                echo "      <td style='text-align: center; font-size: small;'>" . _MD_MYLINKS_OWNER . "<a href='mailto:{$owneremail}'>{$owner}</a></td>\n";
            }
            echo "      <td style='text-align: center; font-size: small;'>\n"
//                ."        <form style='display: inline; margin-right: 1.5em;' action='main.php?op=changeModReq&amp;requestid={$requestid}' method='get'>\n"
                ."        <form style='display: inline; margin-right: 1.5em;' action='main.php' method='post'>\n"
                ."          <input type='hidden' name='op' value='changeModReq' />\n"
                ."          <input type='hidden' name='requestid' value='{$requestid}' />\n"
                ."          <input type='submit' value='" . _MD_MYLINKS_APPROVE . "' />\n"
                ."        </form>\n"
//                ."        <form style='display: inline; margin-right: 1.5em;' action='main.php?op=modLink&amp;lid={$lid}' method='get'>\n"
                ."        <form style='display: inline; margin-right: 1.5em;' action='main.php' method='get'>\n"
                ."          <input type='hidden' name='op' value='modLink'>\n"
                ."          <input type='hidden' name='lid' value='{$lid}'>\n"
                ."          <input type='submit' value='" . _EDIT . "' /></form>\n"
//                ."        <form style='display: inline;' action='main.php?op=ignoreModReq&amp;requestid={$requestid}' method='post'><input type='submit' value='" . _MD_MYLINKS_IGNORE . "' /></form>\n"
                ."        <form style='display: inline;' action='main.php' method='post'>\n"
                ."          <input type='hidden' name='op' value='ignoreModReq' />\n"
                ."          <input type='hidden' name='requestid' value='{$requestid}' />\n"
                ."          <input type='submit' value='" . _MD_MYLINKS_IGNORE . "' />\n"
                ."        </form>\n"
                ."      </td>\n"
                ."    </tr>\n"
                ."  </table><br /><br />\n";
        }
        echo "    </td></tr></table>";
    } else {
        echo "      <em>" . _MD_MYLINKS_NOMODREQ . "</em>\n";
    }
    echo "    </td>\n"
        ."  </tr>\n"
        ."</table>\n";
    include 'admin_footer.php';
}

function changeModReq()
{
    global $xoopsDB, $myts;

    $requestid   = mylinksUtility::mylinks_cleanVars($_POST, 'requestid', 0, 'int', array('min'=>0));
    $query = "SELECT lid, cid, title, url, logourl, description FROM " . $xoopsDB->prefix("mylinks_mod") . " WHERE requestid='{$requestid}'";
    $result = $xoopsDB->query($query);
    while ( list($lid, $cid, $title, $url, $logourl, $description) = $xoopsDB->fetchRow($result) ) {

        $url         = addslashes($url);
        $logourl     = addslashes($logourl);
        $title       = addslashes($title);
        $description = addslashes($description);

        $sql= sprintf("UPDATE %s SET cid = %u, title = '%s', url = '%s', logourl = '%s', status = 1, date = %u WHERE lid = %u", $xoopsDB->prefix("mylinks_links"), $cid, $title, $url, $logourl, time(), $lid);
        $result = $xoopsDB->query($sql);
        if (!result) {
            mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
            exit();
        } else {
            $sql = sprintf("UPDATE %s SET description = '%s' WHERE lid = %u", $xoopsDB->prefix("mylinks_text"), $description, $lid);
            $result = $xoopsDB->query($sql);
            if (!$result) {
                mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
                exit();
            } else {
                $sql = sprintf("DELETE FROM %s WHERE requestid = %u", $xoopsDB->prefix("mylinks_mod"), $requestid);
                $xoopsDB->query($sql);
                if (!result) {
                    mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
                    exit();
                }
            }
        }
    }
    redirect_header('index.php', 2, _MD_MYLINKS_DBUPDATED);
    exit();
}

function ignoreModReq()
{
    global $xoopsDB;

    $requestid = mylinksUtility::mylinks_cleanVars($_POST, 'requestid', 0, 'int', array('min'=>0));
    $sql = sprintf("DELETE FROM %s WHERE requestid = %u", $xoopsDB->prefix("mylinks_mod"), $requestid);
    $result = $xoopsDB->query($sql);
    if (!result) {
        mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
    } else {
        mylinksUtility::show_message(_MD_MYLINKS_MODREQDELETED);
    }
    exit();
}

function modLinkS()
{
    global $xoopsDB, $myts;

    $cid      = mylinksUtility::mylinks_cleanVars($_POST, 'cid', 0, 'int', array('min'=>0));
    $lid      = mylinksUtility::mylinks_cleanVars($_POST, 'lid', 0, 'int', array('min'=>0));
    $bknrptid = mylinksUtility::mylinks_cleanVars($_POST, 'bknrptid', 0, 'int', array('min'=>0));
    $url      = mylinksUtility::mylinks_cleanVars($_POST, 'url', '', 'string');
    $logourl  = mylinksUtility::mylinks_cleanVars($_POST, 'logourl', '', 'string');
    $title    = mylinksUtility::mylinks_cleanVars($_POST, 'title', '', 'string');
    $description = mylinksUtility::mylinks_cleanVars($_POST, 'description', '', 'string');
/*
    $url     = $myts->addSlashes($url);
    $logourl = $myts->addSlashes($_POST['logourl']);
    $title   = $myts->addSlashes($_POST['title']);
    $description = $myts->addSlashes($_POST['description']);
*/
    $xoopsDB->query("UPDATE " . $xoopsDB->prefix("mylinks_links") . " SET cid='{$cid}', title='{$title}', url='{$url}', logourl='{$logourl}', status='2', date=" . time() . " WHERE lid='{$lid}'");
    $result = $xoopsDB->query("UPDATE " . $xoopsDB->prefix("mylinks_text") . " SET description='{$description}' where lid='{$lid}'");
    if (!result) {
        redirect_header("main.php", 2, _MD_MYLINKS_DBNOTUPDATED);
        exit();
    }
    if ($bknrptid) {
        // edit came after following link from a broken report, so delete broken report too
        $sql = sprintf("DELETE FROM %s WHERE reportid = %u", $xoopsDB->prefix("mylinks_broken"), $bknrptid);
        $result = $xoopsDB->query($sql);
        if (!$result) {
            mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
            exit();
        }
    }
    redirect_header("index.php", 1, _MD_MYLINKS_DBUPDATED);
    exit();
}

function delLink()
{
    global $xoopsDB, $xoopsModule;
    $lid   = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));

    $dbTables = array( 'links', 'text', 'votedata', 'broken', 'mod' );
    foreach ($dbTables as $thisTable) {
        $sql = sprintf("DELETE FROM %s WHERE lid = %u", $xoopsDB->prefix("mylinks_{$thisTable}"), $lid);
        $result = $xoopsDB->query($sql);
        if (!$result) {
            mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
            exit();
        }
    }
    // delete comments & notifications
    xoops_comment_delete($xoopsModule->getVar('mid'), $lid);
    xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'link', $lid);

    redirect_header('index.php', 2, _MD_MYLINKS_LINKDELETED);
    exit();
}

function modCat()
{
    global $xoopsDB, $myts, $xoopsModule;

    $cid   = mylinksUtility::mylinks_cleanVars($_GET, 'cid', 0, 'int', array('min'=>0));
    xoops_cp_header();

    echo "<h4>" . _MD_MYLINKS_WEBLINKSCONF . "</h4>\n"
      ."<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
      ."  <tr><th>" . _MD_MYLINKS_MODCAT . "<br /></th></tr>\n"
      ."  <tr class='odd'>\n"
      ."    <td>\n";
    $mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
    $catObj = $mylinksCatHandler->get($cid);

    if (isset($catObj) && is_object($catObj)) {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('cid', $cid, "!="));
        $catListObjs = $mylinksCatHandler->getAll($criteria);
        $catListTree = new XoopsObjectTree($catListObjs, 'cid', 'pid');

        $title  = $myts->htmlSpecialChars($catObj->getVar('title'));
        $imgurl = $myts->htmlSpecialChars($catObj->getVar('imgurl'),'n');
        $pid    = $catObj->getVar('pid');
        echo "      <form action='main.php' method='post'>" . _MD_MYLINKS_TITLEC . "\n"
            ."        <input type='text' name='title' value='{$title}' size='51' maxlength='50' />\n"
            ."		  <br /><br />\n";
        if ( 0 == $catObj->getVar('pid') ) {
                echo "        " . _MD_MYLINKS_IMGURLMAIN . "<br />\n"
                    ."        <input type='text' name='imgurl' value='{$imgurl}' size='100' maxlength='150' />\n"
                    ."        <br /><br />\n";
        }
        echo "        " . _MD_MYLINKS_PARENT . "&nbsp;\n"
            ."        " . $catListTree->makeSelBox("pid", "title", '- ', $pid, true) . "\n"
            ."        <br />\n"
            ."        <input type='hidden' name='cid' value='{$cid}' />\n"
            ."        <input type='hidden' name='op' value='modCatS' /><br />\n"
            ."        <input type='submit' value='" . _MD_MYLINKS_SAVE . "' />\n"
            ."        <input type='button' value='" . _DELETE . "' onclick=\"location='main.php?pid={$pid}&amp;cid={$cid}&amp;op=delCat'\" />&nbsp;\n"
            ."        <input type='button' value='" . _CANCEL . "' onclick=\"javascript:history.go(-1)\" />\n"
            ."      </form>\n";
    } else {
        echo "  <tr><td>" . _MD_MYLINKS_CIDERROR . "</td></tr>\n"
            ."  <tr><td><input type='button' value='" . _BACK . "' onclick=\"javascript:history.go(-1)\" /></td></tr>\n";
    }
    echo "    </td>\n"
        ."  </tr>\n"
        ."</table>\n";
    include 'admin_footer.php';
}

function modCatS()
{
    global $xoopsDB, $myts, $xoopsModule;
    $cid    = mylinksUtility::mylinks_cleanVars($_POST, 'cid', 0, 'int', array('min'=>0));
    $imgurl = mylinksUtility::mylinks_cleanVars($_POST, 'imgurl', '', 'string');
    $title  = mylinksUtility::mylinks_cleanVars($_POST, 'title', '', 'string');
//    $title  = $myts->addSlashes($title);

    if (empty($title)) {
        redirect_header('index.php', 3, _MD_MYLINKS_ERRORTITLE);
    }

//    $imgurl = $myts->addSlashes($imgurl);
    $updateInfo = array (
                        'pid'    =>  intval($_POST['pid']),
//                        'title'  =>  $myts->addSlashes($_POST['title']),
                        'title'  =>  $title,
                        'imgurl' => $imgurl
                        );

    $mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
    $catObj = $mylinksCatHandler->get($cid);

    if (isset($catObj) && is_object($catObj)) {
        $catObj->setVars($updateInfo);
        $result = $mylinksCatHandler->insert($catObj);
    } else {
        $result = false;
    }

    if (!$result) {
        mylinksUtility::show_message(_MD_MYLINKS_DBNOTUPDATED);
        exit();
    } else {
        redirect_header('index.php', 2, _MD_MYLINKS_DBUPDATED);
    }
}

function delCat()
{
    global $xoopsDB, $myCatTree, $xoopsModule, $xoopsUser;

    $cid = mylinksUtility::mylinks_cleanVars($_REQUEST, 'cid', 0, 'int', array('min'=>0));
    $ok  = mylinksUtility::mylinks_cleanVars($_POST, 'ok', 0, 'int', array('min'=>0, 'max'=>1));

    if ( 1 == $ok ) {
        /**
         * nickname code:
         *
         *	get all subcategories
         *  get all links in these categories/subcategories
         *	get all links in category & subcategories
         *	delete all links in links, text, votedata, broken, & mod db tables that are in any of these categories
         *	delete all comments and notifications for the links that have been deleted
         *	delete category and all subcategories from category db table
         *	delete all notifications for the categories that have been deleted
         */
        $mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));

        //get all subcategories under the specified category
        $catObjArr = $myCatTree->getAllChild($cid);
        $cidArray  = array();
        foreach ($catObjArr as $catObj) {
            $cidArray[] = $catObj->getVar('cid');
        }

        array_push($cidArray, $cid); //add this category id to the array
        $catIDs = implode(',', $cidArray);
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('cid', '(' . intval($cid) . ',' . $catIDs . ')', 'IN'));

        // get list ids in any of these categories
        $sql = sprintf("SELECT lid FROM %s WHERE cid IN %s", $xoopsDB->prefix("mylinks_links"), "({$catIDs})");
        $result = $xoopsDB->query($sql);
        if (!$result) {
            mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
            exit();
        }
        $lidArray = $xoopsDB->fetchArray($result);

        // delete any links, link notifications and link comments from the database tables
        if ( $lidArray ) {
            $linkIDs = '(' . implode(',', $lidArray) . ')';
            $dbTables = array( 'links', 'text', 'votedata', 'broken', 'mod' );
            foreach ($dbTables as $thisTable) {
                $sql = sprintf("DELETE FROM %s WHERE lid IN %s", $xoopsDB->prefix("mylinks_{$thisTable}"), $linkIDs);
                $result = $xoopsDB->query($sql);
                if (!result) {
                    mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
                    exit();
                }
            }
            // remove any notifications and comments for these listings
            foreach ($lidArray as $this_lid) {
                xoops_comment_delete($xoopsModule->getVar('mid'), $this_lid);
                xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'link', $this_lid);
            }
        }
        // delete category and all subcategories from database
        if (!($mylinksCatHandler->deleteAll($criteria))) {
            redirect_header("main.php", 2, _MD_MYLINKS_NORECORDFOUND);
            exit();
        }

        // delete the notification settings for each (sub)category
        foreach( $cidArray as $key=>$id) {
            xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'category', $id);
        }

        redirect_header('index.php', 2, _MD_MYLINKS_CATDELETED);
        exit();
    } else {
        xoops_cp_header();
        xoops_confirm(array('op' => 'delCat', 'cid' => $cid, 'ok' => 1), 'main.php', _MD_MYLINKS_WARNING);
        include 'admin_footer.php';
    }
}

function delNewLink()
{
    global $xoopsDB, $xoopsModule;
    $lid   = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));

    $sql = sprintf("DELETE FROM %s WHERE lid = %u", $xoopsDB->prefix("mylinks_links"), $lid);
    $result = $xoopsDB->query($sql);
    if (!result) {
        redirect_header("main.php", 2, _MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    $sql = sprintf("DELETE FROM %s WHERE lid = %u", $xoopsDB->prefix("mylinks_text"), $lid);
    $result = $xoopsDB->query($sql);
    if (!$result) {
        mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    // delete comments
    xoops_comment_delete($xoopsModule->getVar('mid'), $lid);
    // delete notifications
    xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'link', $lid);
    redirect_header('index.php', 2, _MD_MYLINKS_LINKDELETED);
}

function addCat()
{
    global $xoopsDB, $myts, $xoopsModule;
    $pid    = mylinksUtility::mylinks_cleanVars($_POST, 'pid', 0, 'int', array('min'=>0));
    $title  = mylinksUtility::mylinks_cleanVars($_POST, 'title', '', 'string');
    $imgurl = mylinksUtility::mylinks_cleanVars($_POST, 'imgurl', '', 'string');
/*
    $title  = $myts->addSlashes($title);
    $imgurl = $myts->addSlashes($imgurl);
*/
    if (empty($title)) {
        redirect_header('index.php', 2, _MD_MYLINKS_ERRORTITLE);
        exit();
    }

    $newCatVars = array(
                    'pid'    => $pid,
                    'title'  => $title,
                    'imgurl' => $imgurl
                    );

    $mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
    $newCatObj = $mylinksCatHandler->create();
    $newCatObj->setVars($newCatVars);
    $newCatId = $mylinksCatHandler->insert($newCatObj);
    if ($newCatId) {
        //now update notification handler & trigger new cat added event
        $tags                  = array();
        $tags['CATEGORY_NAME'] = $title;
        $tags['CATEGORY_URL']  = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/viewcat.php?cid=' . $newCatId;
        $notification_handler  =& xoops_gethandler('notification');
        $notification_handler->triggerEvent('global', 0, 'new_category', $tags);
        redirect_header('index.php', 2, _MD_MYLINKS_NEWCATADDED);

    } else {
        redirect_header('index.php', 2, _MD_MYLINKS_DBNOTUPDATED);
    }
}
function importCats()
{
    global $xoopsDB, $xoopsModule, $xoopsConfig, $myts;

    $ok  = mylinksUtility::mylinks_cleanVars($_POST, 'ok', 0, 'int', array('min'=>0, 'max'=>1));
    if ( 1 == $ok ) {

        if ( file_exists(XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/".$xoopsConfig['language']."/sql/mylinks_cat.dat") ) {
           $importFile = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/" . $xoopsConfig['language'] . "/sql/mylinks_cat.dat";
        } else {
           $importFile =  XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/english/sql/mylinks_cat.dat";
        }

        if ( file_exists($importFile) ) {
            /* the following will not work on some shared servers even though it's the most efficient
            $sql = "LOAD DATA INFILE '{$importFile}' INTO TABLE " . $xoopsDB->prefix('mylinks_cat') . " FIELDS TERMINATED BY ',' IGNORE 1 LINES";
            $result = $xoopsDB->query($sql);
            */

            if (($handle = fopen($importFile, "r")) !== FALSE) {
                // set 1000 to 0 in the following line if input line is truncated
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $sql = sprintf("INSERT INTO %s (cid, pid, title, imgurl) VALUES (%u, %u, '%s', '%s')", $xoopsDB->prefix('mylinks_cat'), intval($data[0]), intval($data[1]), $myts->addSlashes($data[2]) , $myts->addSlashes($data[3]));
                    $result = $xoopsDB->query($sql);
                    if (!$result) {
                        mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
                        exit();
                    }
                }
                fclose($handle);
                redirect_header('index.php' , 2 , _MD_MYLINKS_CATSIMPORTED);
            } else {
                // problem importing categories
                $mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
                $result = $mylinksCatHandler->getAll();
                if (count($result)) {
                    $result = $mylinksCatHandler->deleteAll();  // empty the dB table from partial import
                }
                redirect_header('index.php' , 2, _MD_MYLINKS_CATSNOTIMPORTED);
            }
        } else {  //exit somewhat gracefully if import file not found
            redirect_header('index.php', 2, sprintf(_MD_MYLINKS_IMPORTFILENOTFOUND, $importFile));
        }
        exit();
    } else {
        xoops_cp_header();
        xoops_confirm(array('op' => 'importCats', 'ok' => 1), 'main.php', _MD_MYLINKS_CATWARNING);
        include 'admin_footer.php';
    }
}

function addLink()
{
    global $xoopsDB, $myts, $xoopsUser, $xoopsModule;

    $cid         = mylinksUtility::mylinks_cleanVars($_POST, 'cid', 0, 'int', array('min'=>0));
    $url         = mylinksUtility::mylinks_cleanVars($_POST, 'url', '', 'string');
    $logourl     = mylinksUtility::mylinks_cleanVars($_POST, 'logourl', '', 'string');
    $title       = mylinksUtility::mylinks_cleanVars($_POST, 'title', '', 'string');
    $description = mylinksUtility::mylinks_cleanVars($_POST, 'descarea', '', 'string');
/*
    $url           = $myts->addSlashes($url);
    $logourl       = $myts->addSlashes($logourl);
    $title         = $myts->addSlashes($title);
    $description   = $myts->addSlashes($description);
*/
    $submitter     = $xoopsUser->uid();
    $result        = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE url='{$url}'");
    list($numrows) = $xoopsDB->fetchRow($result);
    $errormsg      = array();
    $error         = false;
    if ( $numrows > 0 ) {
        $errormsg[] = "<h4 style='color: #FF0000'>" . _MD_MYLINKS_ERROREXIST . "</h4>";
        $error = true;
    }
    if ( $title == "" ) {  // check if title exists
        $errormsg[] = "<h4 style='color: #FF0000'>" . _MD_MYLINKS_ERRORTITLE . "</h4>";
        $error = true;
    }
    if ( $url == "" ) {  // check if url exists
        $errormsg[] = "<h4 style='color: #FF0000'>" . _MD_MYLINKS_ERRORURL . "</h4>";
        $error = true;
    }
    if ( $description == "" ) { // check if description exists
        $errormsg[] = "<h4 style='color: #FF0000'>" . _MD_MYLINKS_ERRORDESC . "</h4>";
        $error = true;
    }
    if ( $error ) {
        xoops_cp_header();
        $displayMsg = implode('<br />', $errormsg);
        echo "<div style='text-align: center;'><fieldset>{$displayMsg}</fieldset></div>\n";
        xoops_cp_footer();
        exit();
    }

    $newid = $xoopsDB->genId($xoopsDB->prefix("mylinks_links")."_lid_seq");
    $sql = sprintf("INSERT INTO %s (lid, cid, title, url, logourl, submitter, status, date, hits, rating, votes, comments) VALUES (%u, %u, '%s', '%s', '%s', %u, %u, %u, %u, %u, %u, %u)", $xoopsDB->prefix("mylinks_links"), $newid, $cid, $title, $url, $logourl, $submitter, 1, time(), 0, 0, 0, 0);
    $result = $xoopsDB->query($sql);
    if (!$result) {
        mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    if ( 0 == $newid ) {
        $newid = $xoopsDB->getInsertId();
    }
    $sql = sprintf("INSERT INTO %s (lid, description) VALUES (%u, '%s')", $xoopsDB->prefix("mylinks_text"), $newid, $description);
    $result = $xoopsDB->query($sql);
    if (!$result) {
        mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    $tags              = array();
    $tags['LINK_NAME'] = $title;
    $tags['LINK_URL']  = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/singlelink.php?cid={$cid}&amp;lid={$newid}";

    $mylinksCatHandler =& xoops_getmodulehandler('category' , $xoopsModule->getVar('dirname'));
    $catObj = $mylinksCatHandler->get($cid);
    $tags['CATEGORY_NAME'] = $catObj->getVar('title');
    unset($catObj, $mylinksCatHandler);

    $tags['CATEGORY_URL'] = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/viewcat.php?cid={$cid}";
    $notification_handler =& xoops_gethandler('notification');
    $notification_handler->triggerEvent('global', 0, 'new_link', $tags);
    $notification_handler->triggerEvent('category', $cid, 'new_link', $tags);
    redirect_header("main.php?op=linksConfigMenu", 2, _MD_MYLINKS_NEWLINKADDED);
}

function approve()
{
    global $xoopsDB, $myts, $xoopsModule;

    $lid         = mylinksUtility::mylinks_cleanVars($_POST, 'lid', 0, 'int', array('min'=>0));
    $cid         = mylinksUtility::mylinks_cleanVars($_POST, 'cid', 0, 'int', array('min'=>0));
    $title       = mylinksUtility::mylinks_cleanVars($_POST, 'title', '', 'string');
    $url         = mylinksUtility::mylinks_cleanVars($_POST, 'url', '', 'string');
    $logourl     = mylinksUtility::mylinks_cleanVars($_POST, 'logourl', '', 'string');
    $description = mylinksUtility::mylinks_cleanVars($_POST, 'description', '', 'string');
/*
    $url         = $myts->addSlashes($url);
    $logourl     = $myts->addSlashes($logourl);
    $title       = $myts->addSlashes($title);
    $description = $myts->addSlashes($description);
*/
    $query = "UPDATE " . $xoopsDB->prefix("mylinks_links") . " set cid='{$cid}', title='{$title}', url='{$url}', logourl='{$logourl}', status='1', date=" . time() . " WHERE lid='{$lid}'";
    $result = $xoopsDB->query($query);
    if ($result) {
        $query = "UPDATE " . $xoopsDB->prefix("mylinks_text") . " SET description='{$description}' WHERE lid='{$lid}'";
        $result = $xoopsDB->query($query);
        if (!$result) {
            mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
            exit();
        }
    } else {
        mylinksUtility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    $tags = array();
    $tags['LINK_NAME'] = $title;
    $tags['LINK_URL'] = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/singlelink.php?cid={$cid}&amp;lid={$lid}";
    $mylinksCatHandler =& xoops_getmodulehandler('category' , $xoopsModule->getVar('dirname'));
    $catObj = $mylinksCatHandler->get($cid);
    /*
    $sql = "SELECT title FROM " . $xoopsDB->prefix("mylinks_cat") . " WHERE cid=" . $cid;
    $result = $xoopsDB->query($sql);
    $row = $xoopsDB->fetchArray($result);
    $tags['CATEGORY_NAME'] = $row['title'];
    */
    if ($catObj) {
        $tags['CATEGORY_NAME'] = $catObj->getVar('title');
        $tags['CATEGORY_URL'] = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/viewcat.php?cid={$cid}";
        $notification_handler =& xoops_gethandler('notification');
        $notification_handler->triggerEvent('global', 0, 'new_link', $tags);
        $notification_handler->triggerEvent('category', $cid, 'new_link', $tags);
        $notification_handler->triggerEvent('link', $lid, 'approve', $tags);
        redirect_header('index.php', 2, _MD_MYLINKS_NEWLINKADDED);
    } else {
        redirect_header('index.php', 2, _MD_MYLINKS_DBNOTUPDATED);
    }
}

$op = mylinksUtility::mylinks_cleanVars($_REQUEST, 'op', 'main', 'string');

switch ($op)
{
    case 'delNewLink':
        delNewLink();
        break;
    case 'approve':
        approve();
        break;
    case 'addCat':
        addCat();
        break;
    case 'importCats':
        importCats();
        break;
    case 'addLink':
        addLink();
        break;
    case 'listBrokenLinks':
        listBrokenLinks();
        break;
    case 'delBrokenLinks':
        delBrokenLinks();
        break;
    case 'ignoreBrokenLinks':
        ignoreBrokenLinks();
        break;
    case 'listModReq':
        listModReq();
        break;
    case 'changeModReq':
        changeModReq();
        break;
    case 'ignoreModReq':
        ignoreModReq();
        break;
    case 'delCat':
        delCat();
        break;
    case 'modCat':
        modCat();
        break;
    case 'modCatS':
        modCatS();
        break;
    case 'modLink':
        modLink();
        break;
    case 'modLinkS':
        modLinkS();
        break;
    case 'delLink':
        delLink();
        break;
    case 'delVote':
        delVote();
        break;
    case 'linksConfigMenu':
    default:
        linksConfigMenu();
        break;
    case 'listNewLinks':
        listNewLinks();
        break;
    case 'main':
        break;
}
