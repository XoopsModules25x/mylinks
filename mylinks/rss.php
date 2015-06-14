<?php

include '../../mainfile.php';
include_once XOOPS_ROOT_PATH . '/class/template.php';
error_reporting(0);
$modulename = basename(dirname(__FILE__));
include_once XOOPS_ROOT_PATH . "/modules/{$modulename}/include/feedfunc.new.php";

$param_array = array(
  'show'  => 10,
  'image' => 1,
  );

// for debug
$cache = 0;

$new_array = mylinks_get_new($param_array);

// logo image
$logo = 'images/logo.gif';
$template = XOOPS_ROOT_PATH . "/modules/{$modulename}/templates/mylinks_rss.html";
$RSS_DESC_MAX = 1000;

// rss output
if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}

header ('Content-Type:text/xml; charset=utf-8');
$tpl = new XoopsTpl();

if ($cache) {
    $tpl->xoops_setCaching(2);
    $tpl->xoops_setCacheTime(3600);
}

if (!$tpl->is_cached('file:'.$template) || !$cache) {
    if (count($new_array) > 0) {
        $tpl->assign('channel_title', wani_utf8_encode(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
        $tpl->assign('self_link', XOOPS_URL . "/modules/{$modulename}/rss.php");
        $tpl->assign('channel_link', XOOPS_URL . '/');
        $tpl->assign('channel_desc', wani_utf8_encode(htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)));
        $tpl->assign('channel_lastbuild', wani_utf8_encode(date("r")));
        $tpl->assign('channel_webmaster', $xoopsConfig['adminmail'] . '(' . $xoopsConfig['sitename'] . ')');
        $tpl->assign('channel_editor', $xoopsConfig['adminmail'] . '(' . $xoopsConfig['sitename'] . ')');
        $tpl->assign('channel_category', 'New Contents of Mylinks');
        $tpl->assign('channel_generator', XOOPS_VERSION);
        $tpl->assign('channel_language', _LANGCODE);
        $tpl->assign('image_url', XOOPS_URL."/$logo");
        $tpl->assign('channel_pubdate', wani_utf8_encode(date("r")));
//        $tpl->assign('channel_copyright', 'wanisys' );

        $dimention = getimagesize(XOOPS_ROOT_PATH . "/{$logo}");

        $width  = (empty($dimention[0])) ? 88 : ($dimention[0] > 144) ? 144 : $dimention[0];
        $height = (empty($dimention[1])) ? 31 : ($dimention[1] > 400) ? 400 : $dimention[1];

        $tpl->assign('image_title', wani_utf8_encode(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
        $tpl->assign('image_width', $width);
        $tpl->assign('image_height', $height);
        $tpl->assign('image_link', XOOPS_URL . '/');

        foreach ($new_array as $new) {
            $title = wani_utf8_encode(wani_make_html_title($new['title']));
            $link    = $new['link'];
            $pubdate = '';
            if ( isset($new['time']) ) {
                $pubdate = wani_utf8_encode(date("r", $new['time']));
            }
            $description = '';
            if (isset($new['description'])) {
                $description = $new['description'];
                $description = wani_make_html_summary($description, $RSS_DESC_MAX);
                $description = wani_utf8_encode($description);
            }

            $tpl->append('items', array('title'       => $title,
                                      'link'        => $link,
                                      'guid'        => $link,
                                      'pubdate'     => $pubdate,
                                      'description' => $description));
        }
    }
}

$tpl->display("file:{$template}");
exit();
