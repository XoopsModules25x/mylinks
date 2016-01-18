<?php
function mylinks_feednew($limit=0, $offset=0)
{
    global $xoopsDB;

    $myts =& MyTextSanitizer::getInstance();
    $dirname = basename(dirname(dirname(__FILE__)));
    $moduleURL = XOOPS_URL . "/modules/{$dirname}";

    $limit = (intval($limit)>0) ? intval($limit) : 0;
    $offset = (intval($offset)>0) ? intval($offset) : 0;

    if (isset($_GET['cid'])) {
        $categoryid = (intval($_GET['cid']) && intval($_GET['cid'] > 0)) ? intval($_GET['cid']) : 0;
        $sql = "SELECT l.lid, l.title as ltitle, l.date, l.cid, l.submitter, l.hits, t.description, c.title as ctitle FROM ".$xoopsDB->prefix("mylinks_links")." l, ".$xoopsDB->prefix("mylinks_text")." t, ".$xoopsDB->prefix("mylinks_cat")." c WHERE l.cid= {$categoryid} AND t.lid=l.lid AND l.cid=c.cid AND l.status>0 ORDER BY l.date DESC";
    } else {
        $sql = "SELECT l.lid, l.title as ltitle, l.date, l.cid, l.submitter, l.hits, t.description, c.title as ctitle FROM ".$xoopsDB->prefix("mylinks_links")." l, ".$xoopsDB->prefix("mylinks_text")." t, ".$xoopsDB->prefix("mylinks_cat")." c WHERE t.lid=l.lid AND l.cid=c.cid AND l.status>0 ORDER BY l.date DESC";
    }

    $result = $xoopsDB->query($sql, $limit, $offset);

    $i = 0;
    $ret = array();

    while ($row = $xoopsDB->fetchArray($result)) {
        $ret[$i]['link'] = "{$moduleURL}/singlelink.php?lid={$row['lid']}";
        $ret[$i]['cat_link'] = "{$moduleURL}/viewcat.php?cid={$row['cid']}";
        $ret[$i]['title'] = $row['ltitle'];    // link title
        $ret[$i]['time'] = $row['date'];       // date
//        $ret[$i]['description'] = $row['description'];
        $ret[$i]['id'] = $row['lid'];          // atom feed
        $ret[$i]['description'] = $myts->displayTarea( $row['description'], 0 );    //no html
        $ret[$i]['cat_name'] = $row['ctitle']; // category
        $ret[$i]['hits'] = $row['hits'];       // counter
//        $ret[$i]['uid'] = $row['submitter'];   // user name
        $i++;
    }

    return $ret;
}
