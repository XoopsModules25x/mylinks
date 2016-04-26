<?php
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

require('japanese.php');

$pdf=new PDF_Japanese();
$pdf->AddSJISFont();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('SJIS','',18);
$pdf->Write(8,'9�����̌��J�e�X�g���o��PHP 3.0��1998�N6���Ɍ����Ƀ����[�X����܂����B');
$pdf->Output();
