<?php
// $Id: footer.php 11819 2013-07-09 18:21:40Z zyspec $
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

defined('XOOPS_ROOT_PATH') or die('Restricted access');

if (is_object($xoopsTpl) && ($mylinks_right_wide_theme === true)) {
    $xoopsTpl->assign('xoops_showrblock', 0);
} elseif (is_object($xoopsTpl) && ($mylinks_left_wide_theme === true)) {
    $xoopsTpl->assign('xoops_showlblock', 0);
} elseif (is_object($xoopsTpl) && ($mylinks_both_wide_theme === true)) {
    $xoopsTpl->assign('xoops_showrblock', 0);
    $xoopsTpl->assign('xoops_showlblock', 0);
}

//wanikoo
$xoopsTpl->assign('mylinksshowsiteinfo', $mylinks_show_siteinfo);
$xoopsTpl->assign('mylinksshowextrafunc', $mylinks_show_extrafunc);
$xoopsTpl->assign('mylinksshowextrafuncbig', $mylinks_show_extrafunc_big);
$xoopsTpl->assign('mylinksshowsearch', $mylinks_show_search);
$xoopsTpl->assign('mylinksshowlogo', $mylinks_show_logo);
$xoopsTpl->assign('mylinkslogoimage', $logoimage);
$xoopsTpl->assign('mylinksadcodes', $mylinks_adcodes);
$xoopsTpl->assign('mylinksshowfeed', $mylinks_show_feed);
$xoopsTpl->assign('mylinksshowthemechanger', $mylinks_show_themechanger);

//wanikoo
$can_print    = _MD_MYLINKS_DISALLOW;
$can_pdf      = _MD_MYLINKS_DISALLOW;
$can_qrcode   = _MD_MYLINKS_DISALLOW;
$can_bookmark = _MD_MYLINKS_DISALLOW;

//print func
switch ($mylinks_can_print)
{
    case _MD_MYLINKS_MEMBERONLY:
        $can_print = ( $xoopsUser ) ? _MD_MYLINKS_ALLOW : _MD_MYLINKS_DISALLOW;
        break;
    case _MD_MYLINKS_ALLOW:
        $can_print = _MD_MYLINKS_ALLOW;
        break;
    case _MD_MYLINKS_DISALLOW:
    default:
        $can_print = _MD_MYLINKS_DISALLOW;
        break;
}

if ( _MD_MYLINKS_DISALLOW == $can_print ) {
    $xoopsTpl->assign('mylinksextrafuncprint', false);
} else {
    $xoopsTpl->assign('mylinksextrafuncprint', true);
}

//pdf function
switch ($mylinks_can_pdf) {
    case _MD_MYLINKS_MEMBERONLY:
        $can_pdf = ($xoopsUser) ? _MD_MYLINKS_ALLOW : _MD_MYLINKS_DISALLOW;
        break;
    case _MD_MYLINKS_ALLOW:
        $can_pdf = _MD_MYLINKS_ALLOW;
        break;
    case _MD_MYLINKS_DISALLOW:
    default:
        $can_pdf = _MD_MYLINKS_DISALLOW;
        break;
}
if ( _MD_MYLINKS_DISALLOW == $can_pdf ) {
    $xoopsTpl->assign('mylinksextrafuncpdf', false);
} else {
    $xoopsTpl->assign('mylinksextrafuncpdf', true);
}

//qrcode func
switch ($mylinks_can_qrcode) {
    case _MD_MYLINKS_MEMBERONLY:
        $can_qrcode = ($xoopsUser) ? _MD_MYLINKS_ALLOW : _MD_MYLINKS_DISALLOW;
        break;
    case _MD_MYLINKS_ALLOW:
        $can_qrcode = _MD_MYLINKS_ALLOW;
        break;
    case _MD_MYLINKS_DISALLOW:
    default:
        $can_qrcode = _MD_MYLINKS_DISALLOW;
        break;
}
if ( _MD_MYLINKS_DISALLOW == $can_qrcode ) {
    $xoopsTpl->assign('mylinksextrafuncqrcode', false);
} else {
    $xoopsTpl->assign('mylinksextrafuncqrcode', true);
}

//ver3.0 bookmark
//bookmark func
switch ($mylinks_can_bookmark) {
    case _MD_MYLINKS_MEMBERONLY:
        $can_bookmark = ($xoopsUser) ? _MD_MYLINKS_ALLOW : _MD_MYLINKS_DISALLOW;
        break;
    case _MD_MYLINKS_ALLOW:
        $can_bookmark = _MD_MYLINKS_ALLOW;
        break;
    case _MD_MYLINKS_DISALLOW:
    default:
        $can_bookmark = _MD_MYLINKS_DISALLOW;
        break;
}
if ( _MD_MYLINKS_DISALLOW == $can_bookmark ) {
    $xoopsTpl->assign('mylinksextrafuncbookmark', false);
} else {
    $xoopsTpl->assign('mylinksextrafuncbookmark', true);
}
//ver 3.11
$xoopsTpl->assign('mylinks_shotprovider', $mylinks_shot_provider);

//ver3.0
$xoopsTpl->assign('lang_fullview', _MD_MYLINKS_FULLVIEW);
$xoopsTpl->assign('lang_print', _MD_MYLINKS_MAKE_PRINT);
$xoopsTpl->assign('lang_pdf', _MD_MYLINKS_MAKE_PDF);
$xoopsTpl->assign('lang_qrcode', _MD_MYLINKS_MAKE_QRCODE);
$xoopsTpl->assign('lang_bookmark', _MD_MYLINKS_BOOKMARK);
$xoopsTpl->assign('lang_feedsubscript', _MD_MYLINKS_FEEDSUBSCRIPT);
$xoopsTpl->assign('lang_feedsubscript_desc', _MD_MYLINKS_FEEDSUBSCRIPT_DESC);
$xoopsTpl->assign('lang_minimizeblock', _MD_MYLINKS_MINIMIZEBLOCK);
$xoopsTpl->assign('lang_restoreblock', _MD_MYLINKS_RESTOREBLOCK);
$xoopsTpl->assign('lang_gototop', _MD_MYLINKS_GOTOTOP);
$xoopsTpl->assign('lang_gotobottom', _MD_MYLINKS_GOTOBOTTOM);
$xoopsTpl->assign('lang_rssfeed', _MD_MYLINKS_RSSFEED);
$xoopsTpl->assign('lang_atomfeed', _MD_MYLINKS_ATOMFEED);
$xoopsTpl->assign('lang_pdafeed', _MD_MYLINKS_PDAFEED);
$xoopsTpl->assign('lang_rssfeed_cat', _MD_MYLINKS_RSSFEED_CAT);
$xoopsTpl->assign('lang_atomfeed_cat', _MD_MYLINKS_ATOMFEED_CAT);
$xoopsTpl->assign('lang_pdafeed_cat', _MD_MYLINKS_PDAFEED_CAT);

//ver2.5
$xoopsTpl->assign('mylinks_weburl', XOOPSMYLINKURL);
if (file_exists(XOOPSMYLINKIMGPATH . "/{$mylinks_theme}")) {
    $xoopsTpl->assign('mylinks_imgurl', XOOPSMYLINKIMGURL."/{$mylinks_theme}");
} else {
    $xoopsTpl->assign('mylinks_imgurl', XOOPSMYLINKIMGURL);
}

include_once XOOPS_ROOT_PATH . '/footer.php';
