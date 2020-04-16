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

/////////////////////////////////////////////////////////////
// Title    : Frame Branding Hack for Xoops Mylinks        //
// Author   : Freeop                                       //
// Email    : Webmaster@belizecountry.com                  //
// Website  : http://www.Belizecountry.com                 //
// System   : Xoops RC 3.0.4 / 3.0.5             10-14-02  //
// Filename: myheader.php                                 //
// Type     : Module Hack for MyLinks                      //
/////////////////////////////////////////////////////////////

// Code below uses users current selected theme style      //

use XoopsModules\Mylinks;

require_once __DIR__ . '/header.php';
$url = htmlspecialchars(preg_replace('/javascript:/si', 'java script:', $_GET['url']), ENT_QUOTES | ENT_HTML5);
//xoops_load('utility', $xoopsModule->getVar('dirname'));

$lid = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);
$cid = Mylinks\Utility::cleanVars($_GET, 'cid', 0, 'int', ['min' => 0]);

echo '<html><head><style><!--.bg1 {    background-color: #E3E4E0;}.bg2 {    background-color: #e5e5e5;}.bg3 {     background-color: #f6f6f6;}.bg4 {    background-color: #f0f0f0;}.bg5 {    background-color: f8f8f8;}body { margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;font-family: Tahoma, taipei; color;#000000; font-size: 10px; background-color: #2F5376; color: #ffffff;}a {  font-weight: bold;font-family: Tahoma, taipei; font-size: 10px; text-decoration: none; color: #666666; font-style: normal}A:hover {  font-weight: bold;text-decoration: underline;  font-family: Tahoma, taipei; font-size: 10px; color: #FF9966; font-style: normal}td {  font-family: Tahoma, taipei; color: #000000; font-size: 10px;border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px;}img { border:0;}//--></style>';
$mail_subject = rawurlencode(sprintf(_MD_MYLINKS_INTRESTLINK, $xoopsConfig['sitename']));
$mail_body    = rawurlencode(sprintf(_MD_MYLINKS_INTLINKFOUND, $xoopsConfig['sitename']) . ':  ' . XOOPSMYLINKURL . "/singlelink.php?cid={$cid}&amp;lid={$lid}");

echo '</head><body>'
     . "<table style='width: 100%; border-width: 0px; margin:0px; padding: 0px;'>\n"
     . "   <tr>\n"
     . "     <td style='width: 150px;'><a href='"
     . XOOPS_URL
     . "' target='_blank'><img src='"
     . XOOPS_URL
     . "/images/logo.gif' alt=''></a></td>\n"
     . "     <td style='width: 100%; text-align: center;'>\n"
     . "       <table class='bg3' style='width: 95%; margin: 2px; padding: 3px; border-width: 0px; border: #e0e0e0 1px solid;'>\n"
     . "         <tr>\n"
     . "           <td style='border-bottom: #e0e0e0 1px solid;'>\n"
     . '             <strong>'
     . htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)
     . "</strong>\n"
     . "           </td>\n"
     . "         </tr>\n"
     . "         <tr>\n"
     . "           <td class='bg4' style='text-align: center font-size: small;'>\n"
     . "             <a target='main' href='ratelink.php?cid={$cid}&amp;lid={$lid}'>"
     . _MD_MYLINKS_RATETHISSITE
     . "</a>&nbsp;|&nbsp;\n"
     . "             <a target='main' href='modlink.php?lid={$lid}'>"
     . _MD_MYLINKS_MODIFY
     . "</a>&nbsp;|&nbsp;\n"
     . "             <a target='main' href='brokenlink.php?lid={$lid}'>"
     . _MD_MYLINKS_REPORTBROKEN
     . "</a>&nbsp;|&nbsp;\n"
     . "             <a target='_top' href='mailto:?subject={$mail_subject}&amp;body={$mail_body}'>"
     . _MD_MYLINKS_TELLAFRIEND
     . '</a>&nbsp;|&nbsp;'
     . "             <a target='_top' href='"
     . XOOPS_URL
     . "'>"
     . _MD_MYLINKS_BACKTO
     . htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)
     . '</a>&nbsp;|&nbsp;'
     . "             <a target='_top' href='{$url}'>"
     . _MD_MYLINKS_CLOSEFRAME
     . "</a>\n"
     . "           </td>\n"
     . "         </tr>\n"
     . "       </table>\n"
     . "     </td>\n"
     . "   </tr>\n"
     . "</table>\n"
     . "</body></html>\n";
