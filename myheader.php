<?php
// $Id: myheader.php 11158 2013-03-05 14:10:36Z zyspec $
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
/////////////////////////////////////////////////////////////
// Title    : Frame Branding Hack for Xoops Mylinks        //
// Author   : Freeop                                       //
// Email    : Webmaster@belizecountry.com                  //
// Website  : http://www.Belizecountry.com                 //
// System   : Xoops RC 3.0.4 / 3.0.5             10-14-02  //
// Filename : myheader.php                                 //
// Type     : Module Hack for MyLinks                      //
/////////////////////////////////////////////////////////////

// Code below uses users current selected theme style      //

include 'header.php';
$url = htmlspecialchars(preg_replace('/javascript:/si', 'java script:', $_GET['url']));
include_once './class/utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));

$lid   = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));
$cid   = mylinksUtility::mylinks_cleanVars($_GET, 'cid', 0, 'int', array('min'=>0));

echo"<html><head><style><!--.bg1 {    background-color : #E3E4E0;}.bg2 {    background-color : #e5e5e5;}.bg3 {     background-color : #f6f6f6;}.bg4 {    background-color : #f0f0f0;}.bg5 {    background-color : f8f8f8;}body { margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;font-family: Tahoma, taipei; color;#000000; font-size: 10px; background-color : #2F5376; color: #ffffff;}a {  font-weight: bold;font-family: Tahoma, taipei; font-size: 10px; text-decoration: none; color: #666666; font-style: normal}A:hover {  font-weight: bold;text-decoration: underline;  font-family: Tahoma, taipei; font-size: 10px; color: #FF9966; font-style: normal}td {  font-family: Tahoma, taipei; color: #000000; font-size: 10px;border-top-width : 1px; border-right-width : 1px; border-bottom-width : 1px; border-left-width : 1px;}img { border:0;}//--></style>";
$mail_subject = rawurlencode(sprintf(_MD_MYLINKS_INTRESTLINK, $xoopsConfig['sitename']));
$mail_body = rawurlencode(sprintf(_MD_MYLINKS_INTLINKFOUND, $xoopsConfig['sitename']) . ":  " . XOOPSMYLINKURL . "/singlelink.php?cid={$cid}&amp;lid={$lid}");

echo "</head><body>"
    ."<table style='width: 100%; border-width: 0px; margin:0px; padding: 0px;'>\n"
    ."   <tr>\n"
    ."     <td style='width: 150px;'><a href='" . XOOPS_URL . "' target='_blank'><img src='" . XOOPS_URL . "/images/logo.gif' alt='' /></a></td>\n"
    ."     <td style='width: 100%; text-align: center;'>\n"
    ."       <table class='bg3' style='width: 95%; margin: 2px; padding: 3px; border-width: 0px; border: #e0e0e0 1px solid;'>\n"
    ."         <tr>\n"
    ."           <td style='border-bottom: #e0e0e0 1px solid;'>\n"
    ."             <strong>" . htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES) . "</strong>\n"
    ."           </td>\n"
    ."         </tr>\n"
    ."         <tr>\n"
    ."           <td class='bg4' style='text-align: center font-size: small;'>\n"
    ."             <a target='main' href='ratelink.php?cid={$cid}&amp;lid={$lid}'>" . _MD_MYLINKS_RATETHISSITE . "</a>&nbsp;|&nbsp;\n"
    ."             <a target='main' href='modlink.php?lid={$lid}'>" . _MD_MYLINKS_MODIFY . "</a>&nbsp;|&nbsp;\n"
    ."             <a target='main' href='brokenlink.php?lid={$lid}'>" . _MD_MYLINKS_REPORTBROKEN . "</a>&nbsp;|&nbsp;\n"
    ."             <a target='_top' href='mailto:?subject={$mail_subject}&amp;body={$mail_body}'>" . _MD_MYLINKS_TELLAFRIEND . "</a>&nbsp;|&nbsp;"
    ."             <a target='_top' href='" . XOOPS_URL . "'>" . _MD_MYLINKS_BACKTO . htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES) . "</a>&nbsp;|&nbsp;"
    ."             <a target='_top' href='{$url}'>" . _MD_MYLINKS_CLOSEFRAME . "</a>\n"
    ."           </td>\n"
    ."         </tr>\n"
    ."       </table>\n"
    ."     </td>\n"
    ."   </tr>\n"
    ."</table>\n"
    ."</body></html>\n";
