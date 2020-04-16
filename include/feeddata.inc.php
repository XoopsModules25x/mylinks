<?php

/**
 * @param int $limit
 * @param int $offset
 * @return array
 */
function mylinks_feednew($limit = 0, $offset = 0)
{
    global $xoopsDB;

    $myts      = \MyTextSanitizer::getInstance();
    $dirname   = basename(dirname(__DIR__));
    $moduleURL = XOOPS_URL . "/modules/{$dirname}";

    $limit  = ((int)$limit > 0) ? (int)$limit : 0;
    $offset = ((int)$offset > 0) ? (int)$offset : 0;

    if (\Xmf\Request::hasVar('cid', 'GET')) {
        $categoryid = (\Xmf\Request::getInt('cid', 0, 'GET') && (int)($_GET['cid'] > 0)) ? \Xmf\Request::getInt('cid', 0, 'GET') : 0;
        $sql        = 'SELECT l.lid, l.title as ltitle, l.date, l.cid, l.submitter, l.hits, t.description, c.title as ctitle FROM '
                      . $xoopsDB->prefix('mylinks_links')
                      . ' l, '
                      . $xoopsDB->prefix('mylinks_text')
                      . ' t, '
                      . $xoopsDB->prefix('mylinks_cat')
                      . " c WHERE l.cid= {$categoryid} AND t.lid=l.lid AND l.cid=c.cid AND l.status>0 ORDER BY l.date DESC";
    } else {
        $sql = 'SELECT l.lid, l.title AS ltitle, l.date, l.cid, l.submitter, l.hits, t.description, c.title AS ctitle FROM '
               . $xoopsDB->prefix('mylinks_links')
               . ' l, '
               . $xoopsDB->prefix('mylinks_text')
               . ' t, '
               . $xoopsDB->prefix('mylinks_cat')
               . ' c WHERE t.lid=l.lid AND l.cid=c.cid AND l.status>0 ORDER BY l.date DESC';
    }

    $result = $xoopsDB->query($sql, $limit, $offset);

    $i   = 0;
    $ret = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $ret[$i]['link']     = "{$moduleURL}/singlelink.php?lid={$row['lid']}";
        $ret[$i]['cat_link'] = "{$moduleURL}/viewcat.php?cid={$row['cid']}";
        $ret[$i]['title']    = $row['ltitle'];    // link title
        $ret[$i]['time']     = $row['date'];       // date
        //        $ret[$i]['description'] = $row['description'];
        $ret[$i]['id']          = $row['lid'];          // atom feed
        $ret[$i]['description'] = $myts->displayTarea($row['description'], 0);    //no html
        $ret[$i]['cat_name']    = $row['ctitle']; // category
        $ret[$i]['hits']        = $row['hits'];       // counter
        //        $ret[$i]['uid'] = $row['submitter'];   // user name
        ++$i;
    }

    return $ret;
}
