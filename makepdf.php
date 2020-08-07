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
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team, Kazumi Ono (AKA onokazu)
 */

use XoopsModules\Mylinks;

error_reporting(0);
require_once __DIR__ . '/header.php';
//xoops_load('utility', $xoopsModule->getVar('dirname')) ;

$lid = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);
$cid = Mylinks\Utility::cleanVars($_GET, 'cid', 0, 'int', ['min' => 0]);

if (empty($lid) || empty($cid)) {
    redirect_header('index.php', 3, _MD_MYLINKS_IDERROR);
}

$result = $xoopsDB->query('SELECT l.lid, l.cid, l.title, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description FROM ' . $xoopsDB->prefix('mylinks_links') . ' l, ' . $xoopsDB->prefix('mylinks_text') . " t WHERE l.lid={$lid} AND l.lid=t.lid AND status>0");
list($lid, $cid, $ltitle, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);

if (empty($lid)) {
    redirect_header('index.php', 3, _MD_MYLINKS_NORECORDFOUND);
}

switch ($mylinks_can_pdf) {
    case _MD_MYLINKS_MEMBERONLY:
        $can_pdf = $xoopsUser ? _MD_MYLINKS_ALLOW : _MD_MYLINKS_DISALLOW;
    // no break
    case _MD_MYLINKS_ALLOW:
        $can_pdf = _MD_MYLINKS_ALLOW;
        break;
    case _MD_MYLINKS_DISALLOW:
    default:
        $can_pdf = _MD_MYLINKS_DISALLOW;
        break;
}

if (_MD_MYLINKS_DISALLOW == $can_pdf) {
    redirect_header('index.php', 3, _MD_MYLINKS_PDFDISALLOWED);
}

$myts = \MyTextSanitizer::getInstance();
//require_once XOOPSMYLINKPATH . '/fpdf/fpdf.inc.php';
require_once XOOPS_ROOT_PATH . '/class/libraries/vendor/tecnickcom/tcpdf/tcpdf.php';

//$pdf_data['title'] = $myts->htmlSpecialChars($ltitle);
$pdf_data['title']       = $ltitle;
$pdf_data['subtitle']    = '';
$pdf_data['subsubtitle'] = $myts->htmlSpecialChars($url);
$pdf_data['date']        = formatTimestamp($time);
$pdf_data['filename']    = '';
$pdf_data['author']      = '';

// strip out unwanted html code from description
$description         = html_entity_decode($description, ENT_QUOTES, 'UTF-8');
$allowable_tags      = '<br><br/><br /><b><i><u><em><strong><p>';
$description         = strip_tags($description, $allowable_tags);
$pdf_data['content'] = $myts->displayTarea($description, 1);

//Other stuff
$puff   = '<br>';
$puffer = '<br><br><br>';

//create the A4-PDF...
$pdf_config['slogan'] = $xoopsConfig['sitename'] . ' - ' . $xoopsConfig['slogan'];

//$pdf = new PDF();
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, _CHARSET, false);
if (method_exists($pdf, 'encoding')) {
    $pdf->encoding($pdf_data, _CHARSET);
}
$pdf->SetCreator($pdf_config['creator']);
$pdf->SetTitle($pdf_data['title']);
$pdf->SetAuthor($pdf_config['url']);
$pdf->SetSubject($pdf_data['author']);
$out = $pdf_config['url'] . ', ' . $pdf_data['author'] . ', ' . $pdf_data['title'] . ', ' . $pdf_data['subtitle'] . ', ' . $pdf_data['subsubtitle'];
$pdf->SetKeywords($out);
$pdf->SetAutoPageBreak(true, 25);
$pdf->SetMargins($pdf_config['margin']['left'], $pdf_config['margin']['top'], $pdf_config['margin']['right']);
$pdf->Open();

//First page
$pdf->AddPage();
$pdf->SetXY(24, 25);
$pdf->SetTextColor(10, 60, 160);
$pdf->SetFont($pdf_config['font']['slogan']['family'], $pdf_config['font']['slogan']['style'], $pdf_config['font']['slogan']['size']);
$pdf->writeHTML($pdf_config['slogan'], $pdf_config['scale']);
//$pdf->Image($pdf_config['logo']['path'],$pdf_config['logo']['left'],$pdf_config['logo']['top'],$pdf_config['logo']['width'],$pdf_config['logo']['height'],'',$pdf_config['url']);
$pdf->Line(25, 30, 190, 30);
$pdf->SetXY(25, 35);
$pdf->SetFont($pdf_config['font']['title']['family'], $pdf_config['font']['title']['style'], $pdf_config['font']['title']['size']);
$pdf->writeHTML($pdf_data['title'], $pdf_config['scale']);

if ('' != $pdf_data['subtitle']) {
    $pdf->writeHTML($puff, $pdf_config['scale']);
    $pdf->SetFont($pdf_config['font']['subtitle']['family'], $pdf_config['font']['subtitle']['style'], $pdf_config['font']['subtitle']['size']);
    $pdf->writeHTML($pdf_data['subtitle'], $pdf_config['scale']);
}
if ('' != $pdf_data['subsubtitle']) {
    $pdf->writeHTML($puff, $pdf_config['scale']);
    $pdf->SetFont($pdf_config['font']['subsubtitle']['family'], $pdf_config['font']['subsubtitle']['style'], $pdf_config['font']['subsubtitle']['size']);
    $pdf->writeHTML($pdf_data['subsubtitle'], $pdf_config['scale']);
}

$pdf->writeHTML($puff, $pdf_config['scale']);
$pdf->SetFont($pdf_config['font']['author']['family'], $pdf_config['font']['author']['style'], $pdf_config['font']['author']['size']);
$out = '';
$out .= $pdf_data['author'];
$pdf->writeHTML($out, $pdf_config['scale']);
$pdf->writeHTML($puff, $pdf_config['scale']);
$out = _DATE . ':';
$out .= $pdf_data['date'];
$pdf->writeHTML($out, $pdf_config['scale']);
$pdf->writeHTML($puff, $pdf_config['scale']);

$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTML($puffer, $pdf_config['scale']);

$pdf->SetFont($pdf_config['font']['content']['family'], $pdf_config['font']['content']['style'], $pdf_config['font']['content']['size']);
$pdf->writeHTML($pdf_data['content'], $pdf_config['scale']);

//$pdf->Output($pdf_data['filename'],'');
$pdf->Output();
