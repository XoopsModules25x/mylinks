<?php
/**
 * MyLinks category.php
 *
 * Xoops mylinks - a multicategory links module
 *
 * @copyright::  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @subpackage:: class
 * @since::		 unknown
 * @author::     Thatware - http://thatware.org/
 * @version::    $Id: index.php 8574 2011-12-27 02:45:39Z beckmi $
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
xoops_cp_header();

$indexAdmin = new ModuleAdmin();

// Temporarily 'homeless' links (to be revised in admin.php breakup)
$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_broken") . "");
list($totalBrokenLinks) = $xoopsDB->fetchRow($result);
if ( $totalBrokenLinks > 0 ) {
    $totalBrokenLinks = "<span style='color: #ff0000; font-weight: bold'>{$totalBrokenLinks}</span>";
}
$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_mod") . "");
list($totalModRequests) = $xoopsDB->fetchRow($result);
if ( $totalModRequests > 0 ) {
    $totalModRequests = "<span style='color: #ff0000; font-weight: bold'>{$totalModRequests}</span>";
}
$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE status='0'");
list($totalNewLinks) = $xoopsDB->fetchRow($result);
if ( $totalNewLinks > 0 ) {
    $totalNewLinks = "<span style='color: #ff0000; font-weight: bold'>{$totalNewLinks}</span>";
}
$result=$xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE status>0");
list($activeLinks) = $xoopsDB->fetchRow($result);

$indexAdmin->addInfoBox(_MD_MYLINKS_WEBLINKSCONF);

if ( 0 == $totalNewLinks ) {
    //$indexAdmin->addLineLabel(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_LINKSWAITING, $totalNewLinks, 'Green');
    $indexAdmin->addInfoBoxLine(_MD_MYLINKS_WEBLINKSCONF,  _MD_MYLINKS_LINKSWAITING, $totalNewLinks, 'Green');
} else {
    $indexAdmin->addInfoBoxLine(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_LINKSWAITING, $totalNewLinks, 'Red');
}

if ( 0 == $totalBrokenLinks ) {
    $indexAdmin->addInfoBoxLine(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_BROKENREPORTS, $totalBrokenLinks, 'Green');
} else {
    $indexAdmin->addInfoBoxLine(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_BROKENREPORTS, $totalBrokenLinks, 'Red');
}

if ( 0 == $totalModRequests ) {
    $indexAdmin->addInfoBoxLine(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_MODREQUESTS, $totalModRequests, 'Green');
} else {
    $indexAdmin->addInfoBoxLine(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_MODREQUESTS, $totalModRequests, 'Red');
}

$indexAdmin->addInfoBoxLine(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_THEREARE, $activeLinks);
//------------------------------

echo $indexAdmin->addNavigation('index.php');
echo $indexAdmin->renderIndex();

include 'admin_footer.php';
