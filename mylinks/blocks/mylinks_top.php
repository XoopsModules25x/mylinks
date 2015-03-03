<?php
// $Id: mylinks_top.php 11062 2013-02-18 23:44:30Z zyspec $
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
/******************************************************************************
 * Function: b_mylinks_top_show
 * Input   : $options[0] = date for the most recent links
 *                         hits for the most popular links
 *           $block['content'] = The optional above content
 *           $options[1]   = How many reviews are displayed
 * Output  : Returns the desired most recent or most popular links
 ******************************************************************************/
function b_mylinks_top_show($options)
{
    global $xoopsDB;
    $block = array();
    //ver2.5
    $modulename = basename(dirname(dirname(__FILE__)));
    $myts =& MyTextSanitizer::getInstance();
    $result = $xoopsDB->query("SELECT lid, cid, title, date, hits FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE status>0 ORDER BY " . $options[0] . " DESC",$options[1],0);
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $link = array();
        $title = $myts->htmlSpecialChars($myts->stripSlashesGPC($myrow['title']));
//        if ( !XOOPS_USE_MULTIBYTES ) {
            if (mb_strlen($title) >= $options[2]) {
                $title = mb_substr($title,0,($options[2] -1)) . "...";
            }
//        }
        $link['id']    = $myrow['lid'];
        $link['cid']   = $myrow['cid'];
        $link['title'] = $title;
        if ($options[0] == "date") {
            $link['date'] = formatTimestamp($myrow['date'],'s');
        } elseif ($options[0] == "hits") {
            $link['hits'] = $myrow['hits'];
        }
        $block['links'][] = $link;
    }
    if (!empty($block)) {  // only show block if there's data to display
        $block['mylinks_weburl'] = XOOPS_URL . "/modules/{$modulename}";
    }

    return $block;
}

function b_mylinks_top_edit($options)
{
    $form = "" . _MB_MYLINKS_DISP . "&nbsp;";
    $form .= "<input type='hidden' name='options[]' value='";
    if ($options[0] == "date") {
        $form .= "date'";
    } else {
        $form .= "hits'";
    }
    $form .= " />";
    $form .= "<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . _MB_MYLINKS_LINKS . "";
    $form .= "&nbsp;<br />" . _MB_MYLINKS_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_MYLINKS_LENGTH . "";

    return $form;
}
