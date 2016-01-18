<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
// Based on:								                                 //
// myPHPNUKE Web Portal System - http://myphpnuke.com/	  		             //
// PHP-NUKE Web Portal System - http://phpnuke.org/	  		                 //
// Thatware - http://thatware.org/					                         //
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
include '../../mainfile.php';

//wanikoo
$mylinks_theme = 'mylinksdefault';
$mylinks_allowed_theme = array(
              'mylinksdefault',
              'mylinksdefault-RW',
              'mylinksdefault-LW',
              'mylinksdefault-BW',
              'weblinkslike',
              'weblinkslike-RW',
              'weblinkslike-LW',
              'weblinkslike-BW'
                         );

if (!empty($_POST['mylinks_theme_select']) && in_array($_POST['mylinks_theme_select'], $mylinks_allowed_theme)) {
    $mylinks_theme = $_POST['mylinks_theme_select'];
    $_SESSION['mylinksUserTheme'] = $_POST['mylinks_theme_select'];
} elseif (!empty($_SESSION['mylinksUserTheme']) && in_array($_SESSION['mylinksUserTheme'], $mylinks_allowed_theme)) {
    $mylinks_theme = $_SESSION['mylinksUserTheme'];
}

//wanikoo
if (in_array($mylinks_theme, $mylinks_allowed_theme)) {
    $valid_theme = true;
} else {
    $valid_theme = false;
}

$mylinks_wide_theme       = false;
$mylinks_right_wide_theme = false;
$mylinks_left_wide_theme  = false;
$mylinks_both_wide_theme  = false;

if ( true == $valid_theme ) {
    if ( (strpos($mylinks_theme, '-RW') || strpos($mylinks_theme, '-w')) ) {
        $mylinks_wide_theme       = true;
        $mylinks_right_wide_theme = true;
    } elseif ( strpos($mylinks_theme, '-LW') ) {
        $mylinks_wide_theme      = true;
        $mylinks_left_wide_theme = true;
    } elseif ( strpos($mylinks_theme, '-BW') ) {
        $mylinks_wide_theme      = true;
        $mylinks_both_wide_theme = true;
    }
}
//wanikoo
$modulename = basename(dirname(__FILE__));

define('XOOPSMYLINKURL', XOOPS_URL . "/modules/{$modulename}");
define('XOOPSMYLINKPATH', XOOPS_ROOT_PATH . "/modules/{$modulename}");
define('XOOPSMYLINKINCURL', XOOPSMYLINKURL . "/include");
define('XOOPSMYLINKINCPATH', XOOPSMYLINKPATH . "/include");
define('XOOPSMYLINKIMGURL', XOOPSMYLINKURL . "/images");
define('XOOPSMYLINKIMGPATH', XOOPSMYLINKPATH . "/images");

include_once XOOPSMYLINKPATH . '/include/functions.php';

//wanikoo
$mylinks_show_siteinfo  = $xoopsModuleConfig['showsiteinfo']  ? true : false;
$mylinks_show_extrafunc = $xoopsModuleConfig['showextrafunc'] ? true : false;
if (strpos($GLOBALS['xoopsRequestUri'], 'singlelink.php')) {
    $mylinks_show_extrafunc_big = true;
} else {
    $mylinks_show_extrafunc_big = false;
}
//ver3.11
$mylinks_shot_provider = $xoopsModuleConfig['shotprovider'];

//ver3.0
//$mylinks_show_externalsearch = false;
$mylinks_show_feed         = $xoopsModuleConfig['showfeed']         ? true : false;

//ver2.0
$mylinks_show_logo         = $xoopsModuleConfig['showlogo']         ? true : false;
$mylinks_show_letters      = $xoopsModuleConfig['showletters']      ? true : false;
$mylinks_show_toolbar      = $xoopsModuleConfig['showtoolbar']      ? true : false;
$mylinks_show_search       = $xoopsModuleConfig['showxoopssearch']  ? true : false;

/* v3.11 changed theme changer to not display by default
 * since there are no themes included with module and adds
 * complexity for new users/admins
 */
$mylinks_show_themechanger = false;

$mylinks_adcodes = array();
$mylinks_adcodes['all']        = '';
$mylinks_adcodes['index']      = '';
$mylinks_adcodes['singlelink'] = '';
$mylinks_adcodes['viewcat']    = '';
$mylinks_adcodes['topten']     = '';
$mylinks_adcodes['recent']     = '';
$mylinks_adcodes['ratelink']   = '';
$mylinks_adcodes['modlink']    = '';
$mylinks_adcodes['brokenlink'] = '';
$mylinks_adcodes['submit']     = '';

//wanikoo
// disallow=0, allow =1, memberonly =2
$mylinks_can_print    = $xoopsModuleConfig['canprint'];
$mylinks_can_pdf      = $xoopsModuleConfig['canpdf'];
$mylinks_can_bookmark = $xoopsModuleConfig['canbookmark'];

//if qrcode module exists
if ( file_exists(XOOPS_ROOT_PATH."/modules/qrcode/qrcode_image.php") ) {
    // disallow=0, allow =1, memberonly =2
    $mylinks_can_qrcode = $xoopsModuleConfig['canqrcode'];
} else {
    //no qrcode module
    $mylinks_can_qrcode = 0;
}

//logo
if ( $mylinks_show_logo && !is_dir(XOOPSMYLINKIMGPATH."/{$mylinks_theme}/icons/logo.gif") && file_exists(XOOPSMYLINKIMGPATH."/{$mylinks_theme}/icons/logo.gif") ) {
    $logoimage = "<a href='" . XOOPSMYLINKURL . "/index.php'><img src='" . XOOPSMYLINKIMGURL . "/{$mylinks_theme}/icons/logo.gif' style='border-width: 0px;' alt='' /></a>";
} elseif ( $mylinks_show_logo && !is_dir(XOOPSMYLINKIMGPATH."/icons/logo.gif") && file_exists(XOOPSMYLINKIMGPATH."/icons/logo.gif") ) {
    $logoimage = "<a href='" . XOOPSMYLINKURL . "/index.php'><img src='" . XOOPSMYLINKIMGURL . "/icons/logo.gif' style='border-width: 0px' alt='' /></a>";
} else {
    $logoimage = "";
}
