<?php

function mylinks_get_new($param)
{
    $modulename = basename(dirname(dirname(__FILE__)));
    include_once(XOOPS_ROOT_PATH . "/modules/{$modulename}/include/feeddata.inc.php");

    // parameter
    $limit_show = isset($param['show']) ? intval($param['show']) : 10;
    $limit_image = isset($param['image']) ? intval($param['image']) : 1;

    // get new from each module
    $i = 0;
    $result_array = array();
    $time_array = array();

    $limit = $limit_show;

    $res_array = mylinks_feednew($limit);
    $count = count($res_array);
    if (is_array($res_array) && $count > 0) {
        for ($j=0; $j<$count; $j++) {
            $result_array[$i] = $res_array[$j];
            $time_array[$i]   = $res_array[$j]['time'];
            $i++;
        }
    }

    // sort by time
    arsort($time_array);
    $i = 0;
    $new_array = array();

    foreach ($time_array as $num => $time) {
        $new_array[$i++] = $result_array[$num];
        if ($i >= $limit_show) {
            break;
        }
    }

    return $new_array;
}

function wani_make_html_title( $title )
{
    if ( !isset($title) or empty($title) ) {
        return '';
    }
    $title = strip_tags($title);
    $title = ( mb_strlen($title) > 100) ? mb_strimwidth( $title, 0, 100, " ..." ) : $title;
    $title = wani_html_special_chars( $title );

    return $title;
}

function wani_make_html_summary( $sum, $max )
{
    $FLAG_STRIP_CONTROL = 1;
    $FLAG_STRIP_CRLF    = 1;
    $FLAG_STRIP_STYLE   = 1;
    $FLAG_STRIP_SPACE   = 1;
    $FLAG_ADD_SPACE     = 1;
    $FLAG_IMAGE_FORCE   = 1;

    if ($FLAG_STRIP_CONTROL) {
        $sum = wani_strip_control_code($sum);
    }

    if ($FLAG_STRIP_CRLF) {
        $sum = wani_strip_crlf($sum);
    }

    if ($FLAG_STRIP_STYLE) {
        $sum = wani_strip_style_tag($sum);
    }

    if ($FLAG_ADD_SPACE) {
        $sum = wani_add_space($sum);
    }

    $sum = strip_tags($sum);

    if ($FLAG_STRIP_SPACE) {
        $sum = wani_strip_space($sum);
    }

    $sum = (mb_strlen($sum) > $max) ? mb_strimwidth($sum, 0, $max, " ...") : $sum;

    // sanitize
    $sum = wani_html_special_chars($sum);

    return $sum;
}

/////////////
// --------------------------------------------------------
// strip return code
// --------------------------------------------------------
function wani_strip_crlf($text)
{
    $text = preg_replace("/\r/", ' ', $text);
    $text = preg_replace("/\n/", ' ', $text);

    return $text;
}

// --------------------------------------------------------
// strip style tag
// in strip_tags, cannot strip style tag area well
// --------------------------------------------------------
function wani_strip_style_tag($text)
{
    return preg_replace('|<\s*style\s?.*?>(.*)<\s*/\s*style\s*>|is', '', $text);
}

// --------------------------------------------------------
// strip space code
// --------------------------------------------------------
function wani_strip_space($text)
{
    global $xoopsConfig;

    if ( ($xoopsConfig['language'] == 'japanese') && function_exists('mb_convert_kana') ) {
        // zenkaku to hankaku
        $text = mb_convert_kana($text, "s");
    }

    // in MyTextSanitizer, replace "&nbsp;" to "&amp;nbsp;"
    $text = preg_replace("/&amp;nbsp;/i", ' ', $text);
    $text = preg_replace("/&nbsp;/i", ' ', $text);
    $text = preg_replace("/[\x20]+/", ' ', $text);

    return $text;
}

// --------------------------------------------------------
// add space code after end tag
// REQ 3509: put into spacing in a summary
// --------------------------------------------------------
function wani_add_space($text)
{
    $text = preg_replace("/>/", '> ', $text);

    return $text;
}

// --------------------------------------------------------
// convert html_special_chars
// in MyTextSanitizer, replace "&nbsp;" to "&amp;nbsp;"
// in this, not replace "&nbsp;"
//   <  -> &lt;
//   >  -> &gt;
//   "  -> &quot;
//   '  -> &#039;
// --------------------------------------------------------
function wani_html_special_chars($text)
{
    $text = wani_strip_control_code($text);
    $text = wani_conv_js($text);
    $text = htmlspecialchars($text, ENT_QUOTES);
    $text = preg_replace("/'/", '&apos;', $text);
    //$text = preg_replace("/&amp;/i", '&', $text);
    return $text;
}

//---------------------------------------------------------
// convert html_special_chars for url
//   <     -> &lt;
//   >     -> &gt;
//   "     -> &quot;
//   '     -> &#039;
//   &     -> &amp;
//   &amp; -> &amp;
//---------------------------------------------------------
// BUG 3169: need to sanitaize $_SERVER['PHP_SELF']
function wani_html_special_chars_url($text)
{
    $text = wani_strip_control_code($text);
    $text = wani_strip_crlf($text);
    $text = wani_conv_js($text);
    $text = preg_replace('/&amp;/i', '&', $text);
    $text = htmlspecialchars($text, ENT_QUOTES);

    return $text;
}

// BUG 3169: need to sanitaize $_SERVER['PHP_SELF']
function wani_conv_js($text)
{
    $text = preg_replace('/javascript:/si', 'java script:', $text);
    $text = preg_replace('/about:/si', 'about :', $text);

    return $text;
}

// --------------------------------------------------------
// strip control code
// --------------------------------------------------------
function wani_strip_control_code($text)
{
    $text = preg_replace('/[\x00-\x09]/', ' ', $text);
    $text = preg_replace('/[\x0B-\x0C]/', ' ', $text);
    $text = preg_replace('/[\x0E-\x1F]/',' ',$text);
    $text = preg_replace('/[\x7F]/', ' ', $text);

    return $text;
}

//---------------------------------------------------------
// http://www.w3.org/TR/NOTE-datetime
// 2003-12-13T18:30:02+09:00
//
// http://www.php.net/manual/ja/function.date.php
// User Contributed Notes
//---------------------------------------------------------
function wani_iso8601_date($time)
{
    $tzd  = date('O', $time);
    $tzd  = substr(chunk_split( $tzd, 3, ':' ), 0, 6);
    $date = date('Y-m-d\TH:i:s', $time) . $tzd;

    return $date;
}

function wani_utf8_encode($text)
{
    if (1 == XOOPS_USE_MULTIBYTES) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($text, 'UTF-8', _CHARSET);
        }

        return $text;
    }

    return utf8_encode($text);
}
