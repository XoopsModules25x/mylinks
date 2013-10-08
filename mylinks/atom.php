<?php

include '../../mainfile.php';
include_once XOOPS_ROOT_PATH . '/class/template.php';
error_reporting(0);

$modulename = basename(dirname(__FILE__));
include_once XOOPS_ROOT_PATH . "/modules/{$modulename}/include/feedfunc.new.php";

$param_array = array('show'  => 10,
                     'image' => 1);

// for debug
$cache = 0;

$new_array = mylinks_get_new($param_array);

// logo image
$logo          = 'images/logo.gif';
$template      = XOOPS_ROOT_PATH . "/modules/{$modulename}/templates/mylinks_atom.html";
$ATOM_DESC_MAX = 1000;

//not really needed any more since now PHP5 only
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
        $link_alt  = XOOPS_URL . "/";
        $link_self = XOOPS_URL . "/modules/{$modulename}/atom.php";
        // site tag
        $site_tag    = 'mylinks';
        $site_author = wani_utf8_encode(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES));
        $year        = date("Y");
        $copyright   = "Copyright $year, $site_author";
        $feed_id     = "tag:$site_tag,$year://1";

        $updated   = wani_iso8601_date(time());
        $tpl->assign('xml_lang', _LANGCODE);
        $tpl->assign('feed_updated', wani_utf8_encode($updated));
        $tpl->assign('feed_generator', XOOPS_VERSION);
        $tpl->assign('feed_generator_uri', 'http://www.xoops.org/');
        $tpl->assign('feed_link_alt', wani_utf8_encode( $link_alt ));
        $tpl->assign('feed_link_self', wani_utf8_encode( $link_self ));
        $tpl->assign('feed_author_uri', wani_utf8_encode( $link_alt ));
        $tpl->assign('feed_author_name', $site_author);
        $tpl->assign('feed_title', wani_utf8_encode(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
        $tpl->assign('feed_rights', $copyright);
        $tpl->assign('feed_id', $feed_id);

        foreach ($new_array as $new) {

            $updated   = wani_iso8601_date(time());
            $published = wani_iso8601_date(time());
            $created   = '';
            if (isset($new['time'])) {
                $created   = wani_iso8601_date($new['time']);
                $updated   = wani_iso8601_date($new['time']);
                $published = wani_iso8601_date($new['time']);
            }

            $title       = wani_utf8_encode(wani_make_html_title($new['title']));
            $link        = $new['link'];
            $description = '';
            if (isset($new['description'])) {
                $description = $new['description'];
                $description = wani_make_html_summary($description, $ATOM_DESC_MAX);
                $description = wani_utf8_encode($description);
            }
            $mid = '';
            $aid = '';
            if (isset($new['mod_id'])) {
                $mid = $new['mod_id'];
            }
            if (isset($new['id'])) {
                $aid = $new['id'];
            }

            $year = date('Y');
            if (empty($mid) && empty($aid)) {
                $atom_id  = "tag:{$site_tag},{$year}://1" . time();
            } else {
                $atom_id  = "tag:{$site_tag},{$year}://1.{$mid}.{$aid}";
            }
            $tpl->append('entrys', array('author_name'  => $site_author,
                                       'updated'      => wani_utf8_encode( $updated ),
                                       'published'    => wani_utf8_encode( $published ),
                                       'author_uri'   => '',
                                       'author_email' => '',
                                       'title'        => $title,
                                       'summary'      => $description,
                                       'category'     => '',
                                       'content'      => $description,
                                       'link'         => $link,
                                       'id'           => $atom_id));
        }
    }
}

$tpl->display("file:{$template}");
exit();
