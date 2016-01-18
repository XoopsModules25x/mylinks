<?php

include '../../mainfile.php';
include_once XOOPS_ROOT_PATH . '/class/template.php';
error_reporting(0);
$modulename = basename(dirname(__FILE__));
include_once XOOPS_ROOT_PATH . "/modules/{$modulename}/include/feedfunc.new.php";

// for debug
$cache = false;

$param_array = array(
  'show'  => 10,
  'image' => 1,
  );

$new_array = mylinks_get_new($param_array);

// logo image
$logo = 'images/logo.gif';
$template = XOOPS_ROOT_PATH . "/modules/{$modulename}/templates/mylinks_pda.html";

$PDA_DESC_MAX = 1000;

// rss output
if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}

header ('Content-Type:text/html');
$tpl = new XoopsTpl();

if ($cache) {
  $tpl->xoops_setCaching(2);
  $tpl->xoops_setCacheTime(3600);
}

if (!$tpl->is_cached("file:{$template}") || !$cache) {
  if (count($new_array) > 0) {
      $tpl->assign('xoops_charset', _CHARSET);
      $tpl->assign('site_url', XOOPS_URL.'/' );
      $tpl->assign('site_name', htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES));
      $tpl->assign('site_desc', htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES));
      $tpl->assign('image_url', XOOPS_URL."/$logo" );

      $i     = 0;
      $block = array();

      foreach ( $new_array as $new ) {
        $line['link'] = $new['link'];
        $line['title'] = wani_make_html_title($new['title']);
        $description = '';
        if ( isset($new['description']) ) {
            $description = $new['description'];
            $description = wani_make_html_summary($description, $PDA_DESC_MAX);
        }
        $line['desc'] = $description;
        $line['date_s'] = formatTimestamp($new['time'], 's');

        $block[] = $line;
        $i ++;
      }

      $tpl->assign('whatsnew', $block);
  }
}

$tpl->display("file:{$template}");
exit();
