<?php
// $Id: search.inc.php 10003 2012-08-07 16:26:27Z ZySpec $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

function mylinks_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    $sql = "SELECT l.lid,l.cid,l.title,l.submitter,l.date,t.description FROM " . $xoopsDB->prefix("mylinks_links") . " l LEFT JOIN " . $xoopsDB->prefix("mylinks_text") . " t ON t.lid=l.lid WHERE status>0";
    if ( $userid != 0 ) {
        $sql .= " AND l.submitter={$userid}";
    }
    // because count() returns 1 even if a supplied variable
    // is not an array, we must check if $querryarray is really an array
    if ( is_array($queryarray) && $count = count($queryarray) ) {
        $sql .= " AND ((l.title LIKE '%{$queryarray[0]}%' OR t.description LIKE '%{$queryarray[0]}%')";
        for ( $i=1; $i<$count; $i++ ) {
            $sql .= " $andor ";
            $sql .= "(l.title LIKE '%{$queryarray[$i]}%' OR t.description LIKE '%{$queryarray[$i]}%')";
        }
        $sql .= ") ";
    }
    $sql .= " ORDER BY l.date DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret = array();
    $i = 0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$i]['image'] = "images/icons/home.gif";
        $ret[$i]['link']  = "singlelink.php?cid={$myrow['cid']}&amp;lid={$myrow['lid']}";
        $ret[$i]['title'] = $myrow['title'];
        $ret[$i]['time']  = $myrow['date'];
        $ret[$i]['uid']   = $myrow['submitter'];
        $i++;
    }

    return $ret;
}
