<?php

// 2005-10-01 K.OHWADA
// category, counter

// 2005-03-28 K.OHWADA
// bug fix: forget to declare $myts

// 2004/08/20 K.OHWADA
// atom feed

//================================================================
// What's New Module
// get links from module
// for mylinks 1.10 <https://xoops.org>
// 2003.12.20 K.OHWADA
//================================================================

/**
 * @param int $limit
 * @param int $offset
 * @return array
 */
function mylinks_new($limit = 0, $offset = 0)
{
    global $xoopsDB;

    $myts      = \MyTextSanitizer::getInstance();
    $dirname   = basename(dirname(__DIR__));
    $moduleURL = XOOPS_URL . "/modules/{$dirname}";

    $limit  = ((int)$limit > 0) ? (int)$limit : 0;
    $offset = ((int)$offset > 0) ? (int)$offset : 0;

    $sql    = 'SELECT l.lid, l.title AS ltitle, l.date, l.cid, l.submitter, l.hits, t.description, c.title AS ctitle FROM '
              . $xoopsDB->prefix('mylinks_links')
              . ' l, '
              . $xoopsDB->prefix('mylinks_text')
              . ' t, '
              . $xoopsDB->prefix('mylinks_cat')
              . ' c WHERE t.lid=l.lid AND l.cid=c.cid AND l.status>0 ORDER BY l.date DESC';
    $result = $xoopsDB->query($sql, $limit, $offset);

    $i   = 0;
    $ret = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $ret[$i]['link']     = "{$moduleURL}/singlelink.php?lid={$row['lid']}";
        $ret[$i]['cat_link'] = "{$moduleURL}/viewcat.php?cid={$row['cid']}";
        $ret[$i]['title']    = $row['ltitle'];
        $ret[$i]['time']     = $row['date'];
        //        $ret[$i]['description'] = $row['description'];

        // atom feed
        $ret[$i]['id']          = $row['lid'];
        $ret[$i]['description'] = $myts->displayTarea($row['description'], 0);    //no html
        $ret[$i]['cat_name']    = $row['ctitle'];   // category
        $ret[$i]['hits']        = $row['hits'];         // counter
        //        $ret[$i]['uid'] = $row['submitter'];   // show user name
        ++$i;
    }

    return $ret;
}

/**
 * @return int
 */
function mylinks_num()
{
    global $xoopsDB;

    $sql   = 'SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_links') . ' WHERE status>0 ORDER BY lid';
    $array = $xoopsDB->fetchRow($xoopsDB->query($sql));
    $num   = $array[0];
    if (empty($num)) {
        $num = 0;
    }

    return $num;
}

/**
 * @param int $limit
 * @param int $offset
 * @return array
 */
function mylinks_data($limit = 0, $offset = 0)
{
    global $xoopsDB;
    $dirname = basename(dirname(__DIR__));

    $limit  = ((int)$limit > 0) ? (int)$limit : 0;
    $offset = ((int)$offset > 0) ? (int)$offset : 0;

    $sql    = 'SELECT lid, title, date FROM ' . $xoopsDB->prefix('mylinks_links') . ' WHERE status>0 ORDER BY lid';
    $result = $xoopsDB->query($sql, $limit, $offset);

    $i   = 0;
    $ret = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $id               = $row['lid'];
        $ret[$i]['id']    = $id;
        $ret[$i]['link']  = XOOPS_URL . "/modules/{$dirname}/singlelink.php?lid={$id}";
        $ret[$i]['title'] = $row['title'];
        $ret[$i]['time']  = $row['date'];
        ++$i;
    }

    return $ret;
}
