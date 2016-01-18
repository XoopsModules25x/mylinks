<?php
// $Id: makepdf.php 11158 2013-03-05 14:10:36Z zyspec $
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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

error_reporting(0);
include_once 'header.php';
include_once './class/utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname')) ;

$lid   = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0)) ;
$cid   = mylinksUtility::mylinks_cleanVars($_GET, 'cid', 0, 'int', array('min'=>0)) ;

if ( empty($lid) || empty($cid) ) {
    redirect_header('index.php', 3, _MD_MYLINKS_IDERROR);
}

$result = $xoopsDB->query("SELECT l.lid, l.cid, l.title, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description FROM " . $xoopsDB->prefix("mylinks_links") . " l, " . $xoopsDB->prefix("mylinks_text") . " t WHERE l.lid={$lid} AND l.lid=t.lid AND status>0");
list($lid, $cid, $ltitle, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);

if ( empty($lid) ) {
    redirect_header('index.php', 3, _MD_MYLINKS_NORECORDFOUND) ;
}

switch ($mylinks_can_pdf)
{
    case _MD_MYLINKS_MEMBERONLY:
        $can_pdf = ( $xoopsUser ) ? _MD_MYLINKS_ALLOW : _MD_MYLINKS_DISALLOW;
    case _MD_MYLINKS_ALLOW:
        $can_pdf = _MD_MYLINKS_ALLOW;
        break;
    case _MD_MYLINKS_DISALLOW:
    default:
        $can_pdf = _MD_MYLINKS_DISALLOW;
        break;
}

if ( _MD_MYLINKS_DISALLOW == $can_pdf) {
    redirect_header('index.php', 3, _MD_MYLINKS_PDFDISALLOWED);
}

$myts =& MyTextSanitizer::getInstance();
require_once XOOPSMYLINKPATH . '/fpdf/fpdf.inc.php' ;

//$pdf_data['title'] = $myts->htmlSpecialChars($ltitle);
$pdf_data['title']       = $ltitle;
$pdf_data['subtitle']    = '';
$pdf_data['subsubtitle'] = $myts->htmlSpecialChars($url);
$pdf_data['date']        = formatTimestamp($time);
$pdf_data['filename']    = '';
$pdf_data['author']      = '';

// strip out unwanted html code from description
$description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');
$allowable_tags = '<br><br/><b><i><u><em><strong><p>';
$description = strip_tags($description, $allowable_tags);
$pdf_data['content'] = $myts->displayTarea($description, 1);

//Other stuff
$puff='<br />';
$puffer='<br /><br /><br />';

//create the A4-PDF...
$pdf_config['slogan']=$xoopsConfig['sitename'].' - '.$xoopsConfig['slogan'];

$pdf=new PDF();
if (method_exists($pdf, "encoding")) {
  $pdf->encoding($pdf_data, _CHARSET);
}
$pdf->SetCreator($pdf_config['creator']);
$pdf->SetTitle($pdf_data['title']);
$pdf->SetAuthor($pdf_config['url']);
$pdf->SetSubject($pdf_data['author']);
$out=$pdf_config['url'].', '.$pdf_data['author'].', '.$pdf_data['title'].', '.$pdf_data['subtitle'].', '.$pdf_data['subsubtitle'];
$pdf->SetKeywords($out);
$pdf->SetAutoPageBreak(true, 25);
$pdf->SetMargins($pdf_config['margin']['left'], $pdf_config['margin']['top'], $pdf_config['margin']['right']);
$pdf->Open();

//First page
$pdf->AddPage();
$pdf->SetXY(24, 25);
$pdf->SetTextColor(10, 60, 160);
$pdf->SetFont($pdf_config['font']['slogan']['family'],$pdf_config['font']['slogan']['style'], $pdf_config['font']['slogan']['size']);
$pdf->WriteHTML($pdf_config['slogan'], $pdf_config['scale']);
//$pdf->Image($pdf_config['logo']['path'],$pdf_config['logo']['left'],$pdf_config['logo']['top'],$pdf_config['logo']['width'],$pdf_config['logo']['height'],'',$pdf_config['url']);
$pdf->Line(25, 30, 190, 30);
$pdf->SetXY(25, 35);
$pdf->SetFont($pdf_config['font']['title']['family'], $pdf_config['font']['title']['style'], $pdf_config['font']['title']['size']);
$pdf->WriteHTML($pdf_data['title'],$pdf_config['scale']);

if ($pdf_data['subtitle']<>'') {
  $pdf->WriteHTML($puff, $pdf_config['scale']);
  $pdf->SetFont($pdf_config['font']['subtitle']['family'], $pdf_config['font']['subtitle']['style'], $pdf_config['font']['subtitle']['size']);
  $pdf->WriteHTML($pdf_data['subtitle'], $pdf_config['scale']);
}
if ($pdf_data['subsubtitle']<>'') {
  $pdf->WriteHTML($puff, $pdf_config['scale']);
  $pdf->SetFont($pdf_config['font']['subsubtitle']['family'], $pdf_config['font']['subsubtitle']['style'], $pdf_config['font']['subsubtitle']['size']);
  $pdf->WriteHTML($pdf_data['subsubtitle'], $pdf_config['scale']);
}

$pdf->WriteHTML($puff, $pdf_config['scale']);
$pdf->SetFont($pdf_config['font']['author']['family'], $pdf_config['font']['author']['style'], $pdf_config['font']['author']['size']);
$out='';
$out.=$pdf_data['author'];
$pdf->WriteHTML($out, $pdf_config['scale']);
$pdf->WriteHTML($puff, $pdf_config['scale']);
$out=_DATE.':';
$out.=$pdf_data['date'];
$pdf->WriteHTML($out, $pdf_config['scale']);
$pdf->WriteHTML($puff, $pdf_config['scale']);

$pdf->SetTextColor(0, 0, 0);
$pdf->WriteHTML($puffer, $pdf_config['scale']);

$pdf->SetFont($pdf_config['font']['content']['family'], $pdf_config['font']['content']['style'], $pdf_config['font']['content']['size']);
$pdf->WriteHTML($pdf_data['content'], $pdf_config['scale']);

//$pdf->Output($pdf_data['filename'],'');
$pdf->Output();
