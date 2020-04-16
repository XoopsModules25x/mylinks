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

require_once __DIR__ . '/header.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));

$lid = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);
$cid = Mylinks\Utility::cleanVars($_GET, 'cid', 0, 'int', ['min' => 0]);
if (empty($lid) || empty($cid)) {
    redirect_header('index.php', 3, _MD_MYLINKS_IDERROR);
}
/*
$lid = isset($_GET['lid']) ? (int)($_GET['lid']): 0;
$cid = isset($_GET['cid']) ? (int)($_GET['cid']): 0;
if ( empty($lid) ) {
  die("No lid!");
} elseif ( empty($cid) ) {
  die("No cid!");
}
*/
$result = $xoopsDB->query('SELECT l.lid, l.cid, l.title, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description FROM ' . $xoopsDB->prefix('mylinks_links') . ' l, ' . $xoopsDB->prefix('mylinks_text') . " t where l.lid={$lid} AND l.lid=t.lid and status>0");
if (!$result) {
    redirect_header('index.php', 3, _MD_MYLINKS_NORECORDFOUND);
}

list($lid, $cid, $ltitle, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);

//qrcode func
switch ($mylinks_can_qrcode) {
    case _MD_MYLINKS_MEMBERONLY:
        $can_qrcode = $xoopsUser ? _MD_MYLINKS_ALLOW : _MD_MYLINKS_DISALLOW;
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
if (_MD_MYLINKS_DISALLOW == $can_qrcode) {
    $xoopsTpl->assign( 'mylinksextrafuncqrcode' , false );
} else {
    $xoopsTpl->assign( 'mylinksextrafuncqrcode' , true );
}

$can_qrcode = 0;
if ($mylinks_can_qrcode == 0) {
  $can_qrcode = 0;
} elseif ($mylinks_can_qrcode == 1) {
  $can_qrcode = 1;
} elseif ($mylinks_can_qrcode == 2) {
  if ($xoopsUser) {
  $can_qrcode =1;
  } else {
  $can_qrcode =0;
  }
} else {
  $can_qrcode = 0;
}
*/
if (_MD_MYLINKS_DISALLOW == $can_qrcode) {
    redirect_header('index.php', 3, _MD_MYLINKS_QRCODEDISALLOWED);
}

$myts = \MyTextSanitizer::getInstance();

/**
 * @param                     $str
 * @param string              $to
 * @param string              $from
 * @return array|mixed|string
 */
function mylinks_qrcode_convert_encoding($str, $to = 'SJIS', $from = _CHARSET)
{
    if (function_exists('mb_convert_encoding')) {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = mylinks_qrcode_convert_encoding($val, $to, $from);
            }

            return $str;
        }

        return mb_convert_encoding($str, $to, $from);
    }

    return $str;
}

/**
 * @param string $data
 * @return array|mixed|string
 */
function mylinks_qrcode_encoding($data = '')
{
    $data = mylinks_qrcode_convert_encoding($data);
    $data = rawurlencode($data);
    $data = preg_replace('/%20/', '+', $data);

    return $data;
}

$link_data          = [];
$link_data['text']  = $myts->displayTarea($myts->stripSlashesGPC($description, 0));
$link_data['title'] = $myts->htmlSpecialChars($myts->stripSlashesGPC($ltitle));
$link_data['url']   = $myts->htmlSpecialChars($url);
$data               = "{$link_data['title']}\r\n{$link_data['url']}\r\n{$link_data['text']}";
$qrcodedata         = mylinks_qrcode_encoding($data);
$linkqrcode         = "<img alt='qrcode of linkdata' title='qrcode of linkdata'src='" . XOOPS_URL . "/modules/qrcode/qrcode_image.php?d={$qrcodedata}&amp;e=M&amp;s=4&amp;v=0&amp;t=P&amp;rgb=000000'>\n";

echo "<!DOCTYPE HTML>\n"
     . "<html>\n"
     . "<head>\n"
     . '<title>'
     . $xoopsConfig['sitename']
     . "</title>\n"
     . "<meta http-equiv='Content-Type' content='text/html; charset="
     . _CHARSET
     . "'>\n"
     . "<meta name='AUTHOR' content='"
     . $xoopsConfig['sitename']
     . "'>\n"
     . "<meta name='COPYRIGHT' content='Copyright (c) "
     . date('Y')
     . ' by '
     . $xoopsConfig['sitename']
     . "'>\n"
     . "<meta name='DESCRIPTION' content='"
     . $xoopsConfig['slogan']
     . "'>\n"
     . "<meta name='GENERATOR' content='"
     . XOOPS_VERSION
     . "'>\n"
     . "</head>\n"
     . "<body style='background-color: #ffffff; color: #000000;'>\n"
     . "  <div style='width: 750px; border: 1px solid #000; padding: 20px;'>\n"
     . "    <div style='text-align: center; display: block; margin: 0 0 6px 0;'>\n"
     . "      <h2 style='margin: 0px;'>"
     . _MD_MYLINKS_SITETITLE
     . "&nbsp;{$link_data['title']}</h2>\n"
     . "    </div>\n"
     . "    <div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>\n"
     . "    <div style='text-align: left'>"
     . _MD_MYLINKS_SITEURL
     . "&nbsp;:&nbsp;{$link_data['url']}</div>\n"
     . "    <div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>\n"
     . "    <div style='text-align: left'>"
     . _MD_MYLINKS_DESCRIPTIONC
     . '<br>'
     . $link_data['text']
     . "</div>\n"
     . "    <div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>\n"
     . "    <div style='text-align: left'>LINK DATA QRCODE<br>{$linkqrcode}</div>\n"
     . "    <div style='padding-top: 12px; border-top: 2px solid #ccc;'></div>\n"
     . '      <p>From: &nbsp;'
     . XOOPSMYLINKURL
     . "/singlelink.php?cid={$cid}&amp;lid={$lid}</p>\n"
     . "    </div>\n"
     . "    <br>\n"
     . "    <br>\n"
     . "</body>\n"
     . '</html>';
