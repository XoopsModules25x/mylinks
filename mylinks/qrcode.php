<?php
// $Id: qrcode.php 11158 2013-03-05 14:10:36Z zyspec $
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

$lid = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));
$cid = mylinksUtility::mylinks_cleanVars($_GET, 'cid', 0, 'int', array('min'=>0));
if ( empty($lid) || empty($cid) ) {
    redirect_header('index.php', 3, _MD_MYLINKS_IDERROR);
}
/*
$lid = isset($_GET['lid']) ? intval($_GET['lid']) : 0;
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
if ( empty($lid) ) {
  die("No lid!");
} elseif ( empty($cid) ) {
  die("No cid!");
}
*/
$result = $xoopsDB->query("SELECT l.lid, l.cid, l.title, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description FROM " . $xoopsDB->prefix("mylinks_links") . " l, " . $xoopsDB->prefix("mylinks_text") . " t where l.lid={$lid} AND l.lid=t.lid and status>0");
if (!$result) {
    redirect_header('index.php', 3, _MD_MYLINKS_NORECORDFOUND);
    exit();
}

list($lid, $cid, $ltitle, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);

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
/*
if ( _MD_MYLINKS_DISALLOW == $can_qrcode ) {
    $xoopsTpl->assign( 'mylinksextrafuncqrcode' , false );
} else {
    $xoopsTpl->assign( 'mylinksextrafuncqrcode' , true );
}

$can_qrcode = 0;
if ( $mylinks_can_qrcode == 0 ) {
  $can_qrcode = 0;
}
else if ( $mylinks_can_qrcode == 1) {
  $can_qrcode = 1;
}
else if ( $mylinks_can_qrcode == 2) {
  if ( $xoopsUser ) {
  $can_qrcode =1;
  }
  else {
  $can_qrcode =0;
  }
}
else {
  $can_qrcode = 0;
}
*/
if ( _MD_MYLINKS_DISALLOW == $can_qrcode ) {
    redirect_header('index.php', 3, _MD_MYLINKS_QRCODEDISALLOWED);
    exit();
}

$myts =& MyTextSanitizer::getInstance();

function mylinks_qrcode_convert_encoding($str, $to = 'SJIS', $from = _CHARSET)
{
    if (function_exists('mb_convert_encoding')) {
        if (is_array($str)) {
            foreach ($str as $key=>$val) {
                $str[$key] = mylinks_qrcode_convert_encoding($val, $to, $from);
            }

            return $str;
        } else {
            return mb_convert_encoding($str, $to, $from);
        }
    } else {
        return $str;
    }
}

function mylinks_qrcode_encoding($data="")
{
    $data = mylinks_qrcode_convert_encoding($data);
    $data = rawurlencode($data);
    $data = ereg_replace("%20", "+", $data);

    return $data;
}

$link_data          = array();
$link_data['text']  = $myts->displayTarea($myts->stripSlashesGPC($description, 0));
$link_data['title'] = $myts->htmlSpecialChars($myts->stripSlashesGPC($ltitle));
$link_data['url']   = $myts->htmlSpecialChars($url);
$data       = "{$link_data['title']}\r\n{$link_data['url']}\r\n{$link_data['text']}";
$qrcodedata = mylinks_qrcode_encoding($data);
$linkqrcode = "<img alt='qrcode of linkdata' title='qrcode of linkdata'src='" . XOOPS_URL . "/modules/qrcode/qrcode_image.php?d={$qrcodedata}&amp;e=M&amp;s=4&amp;v=0&amp;t=P&amp;rgb=000000' />\n";

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n"
  ."<html>\n"
  ."<head>\n"
    ."<title>" . $xoopsConfig['sitename'] . "</title>\n"
    ."<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n"
    ."<meta name='AUTHOR' content='" . $xoopsConfig['sitename'] . "' />\n"
    ."<meta name='COPYRIGHT' content='Copyright (c) " . date('Y') . " by " . $xoopsConfig['sitename'] . "' />\n"
    ."<meta name='DESCRIPTION' content='" . $xoopsConfig['slogan'] . "' />\n"
    ."<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n"
    ."</head>\n"
    ."<body style='background-color: #ffffff; color: #000000;'>\n"
    ."  <div style='width: 750px; border: 1px solid #000; padding: 20px;'>\n"
    ."    <div style='text-align: center; display: block; margin: 0 0 6px 0;'>\n"
    ."      <h2 style='margin: 0px;'>" . _MD_MYLINKS_SITETITLE . "&nbsp;{$link_data['title']}</h2>\n"
    ."    </div>\n"
    ."    <div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>\n"
    ."    <div style='text-align: left'>" . _MD_MYLINKS_SITEURL . "&nbsp;:&nbsp;{$link_data['url']}</div>\n"
    ."    <div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>\n"
    ."    <div style='text-align: left'>"._MD_MYLINKS_DESCRIPTIONC."<br />".$link_data['text']."</div>\n"
    ."    <div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>\n"
    ."    <div style='text-align: left'>LINK DATA QRCODE<br />{$linkqrcode}</div>\n"
    ."    <div style='padding-top: 12px; border-top: 2px solid #ccc;'></div>\n"
    ."      <p>From: &nbsp;" . XOOPSMYLINKURL . "/singlelink.php?cid={$cid}&amp;lid={$lid}</p>\n"
    ."    </div>\n"
    ."    <br />\n"
  ."    <br />\n"
  ."</body>\n"
  ."</html>";
