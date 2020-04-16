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
 * @copyright     {@link https://xoops.org/ XOOPS Project}
 * @license       {@link https://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package       mylinks
 * @since
 * @author        XOOPS Development Team
 * @param mixed $queryarray
 * @param mixed $andor
 * @param mixed $limit
 * @param mixed $offset
 * @param mixed $userid
 */

/**
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return array
 */
function mylinks_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    $sql = 'SELECT l.lid,l.cid,l.title,l.submitter,l.date,t.description FROM ' . $xoopsDB->prefix('mylinks_links') . ' l LEFT JOIN ' . $xoopsDB->prefix('mylinks_text') . ' t ON t.lid=l.lid WHERE status>0';
    if (0 != $userid) {
        $sql .= " AND l.submitter={$userid}";
    }
    // because count() returns 1 even if a supplied variable
    // is not an array, we must check if $querryarray is really an array
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((l.title LIKE '%{$queryarray[0]}%' OR t.description LIKE '%{$queryarray[0]}%')";
        for ($i = 1; $i < $count; ++$i) {
            $sql .= " $andor ";
            $sql .= "(l.title LIKE '%{$queryarray[$i]}%' OR t.description LIKE '%{$queryarray[$i]}%')";
        }
        $sql .= ') ';
    }
    $sql    .= ' ORDER BY l.date DESC';
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret    = [];
    $i      = 0;
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[$i]['image'] = 'assets/images/icons/home.gif';
        $ret[$i]['link']  = "singlelink.php?cid={$myrow['cid']}&amp;lid={$myrow['lid']}";
        $ret[$i]['title'] = $myrow['title'];
        $ret[$i]['time']  = $myrow['date'];
        $ret[$i]['uid']   = $myrow['submitter'];
        ++$i;
    }

    return $ret;
}
