<?php
// $Id: print.php 11158 2013-03-05 14:10:36Z zyspec $
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
include_once './class/utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));

$lid   = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));
//$cid   = mylinksUtility::mylinks_cleanVars($_GET, 'cid', 0, 'int', array('min'=>0));

//
if ( empty($lid) ) {
    redirect_header('index.php', 3, _MD_MYLINKS_IDERROR);
}

$result = $xoopsDB->query("SELECT l.lid, l.cid, l.title, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description FROM " . $xoopsDB->prefix("mylinks_links") . " l, " . $xoopsDB->prefix("mylinks_text") . " t WHERE l.lid={$lid} AND l.lid=t.lid AND status>0");
if ( !$result ) {
    redirect_header('index.php', 3, _MD_MYLINKS_NORECORDFOUND);
}

list($lid, $cid, $ltitle, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);

switch ($mylinks_can_print)
{
    case _MD_MYLINKS_MEMBERONLY:
        $can_print = ( $xoopsUser ) ? _MD_MYLINKS_ALLOW : _MD_MYLINKS_DISALLOW;
    case _MD_MYLINKS_ALLOW:
        $can_print = _MD_MYLINKS_ALLOW;
        break;
    case _MD_MYLINKS_DISALLOW:
    default:
        $can_print = _MD_MYLINKS_DISALLOW;
        break;
}

if ( _MD_MYLINKS_DISALLOW == $can_print) {
    redirect_header('index.php', 3, _MD_MYLINKS_PRINTINGDISALLOWED);
}

$myts =& MyTextSanitizer::getInstance();

$link_data = array( 'text'  => $myts->displayTarea($myts->stripSlashesGPC($description), 0),
                    'title' => $myts->stripSlashesGPC($ltitle),
                    'url'   => $myts->htmlSpecialChars($url),
                    'date'  => $time
                  );

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n"
    ."<html>\n<head>\n"
    ."<title>" . $xoopsConfig['sitename'] . "</title>\n"
    ."<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n"
    ."<meta name='AUTHOR' content='" . $xoopsConfig['sitename'] . "' />\n"
    ."<meta name='COPYRIGHT' content='" . sprintf(_MD_MYLINKS_COPYNOTICE, date('Y'), $xoopsConfig['sitename']) ."' />\n"
    ."<meta name='DESCRIPTION' content='" . $xoopsConfig['slogan'] . "' />\n"
    ."<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n"
    ."<body style='background-color: #ffffff; color: black;' onload='window.print()'>\n"
    ."<div style='width: 750px; border: 1px solid #000; padding: 20px;'>\n"
    ."<div style='text-align: center; display: block; margin: 0 0 6px 0;'>\n"
    ."  <img src='".XOOPSMYLINKURL."/images/mylinks_slogo.png' border='0' alt='' />\n"
    ."  <h2 style='margin: 0;'>"._MD_MYLINKS_SITETITLE."&nbsp;".$link_data['title']."</h2>\n"
    ."</div>\n"
    ."<div style='text-align: center;'>" . _ON . "&nbsp;" . formatTimestamp($link_data['date']) . "</div>\n"
    ."<div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>\n"
    ."<div style='text-align: left'>" . _MD_MYLINKS_SITEURL . "&nbsp;:&nbsp;" . $link_data['url'] . "</div>\n"
    ."<div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>\n"
    ."<div style='text-align: left'>" . _MD_MYLINKS_DESCRIPTIONC . "<br />" . $link_data['text'] . "</div>\n"
    ."<div style='padding-top: 12px; border-top: 2px solid #ccc;'></div>\n"
    ."<p>" . _MD_MYLINKS_FROM . ": &nbsp;" . XOOPSMYLINKURL . "/singlelink.php?cid={$cid}&amp;lid={$lid}</p>\n"
    ."</div>\n"
    ."<br /><br />\n"
    ."</body></html>\n";
