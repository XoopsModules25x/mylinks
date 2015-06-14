<?php
/**
 * Mylinks Random Term Block
 *
 * Xoops Mylinks - a links module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright::  &copy; The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @subpackage:: blocks
 * @author::     hsalazar
 * @author::     zyspec (owners@zyspec)
 * @version::    $Id: mylinks_rand.php 11239 2013-03-16 04:08:34Z zyspec $
 * @since::      File available since Release 3.11
 */

function b_mylinks_random_show()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xoopsUser;
    $mylinksDir = basename(dirname(dirname(__FILE__)));
    $myts =& MyTextSanitizer::getInstance();

    $block = array();

    $result = $xoopsDB->query("SELECT l.lid, l.cid, l.title, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description FROM " . $xoopsDB->prefix("mylinks_links") . " l, " . $xoopsDB->prefix("mylinks_text") . " t WHERE l.lid=t.lid AND status>0 ORDER BY RAND() LIMIT 0,1");
    if ($result) {
        list($lid, $cid, $ltitle, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);
        $link        = $myts->displayTarea(ucfirst($myts->stripSlashesGPC($ltitle)));
        $description = $myts->displayTarea(mb_substr($myts->stripSlashesGPC($description), 0, 100)) . "...";

        $mylinksCatHandler = xoops_getmodulehandler('category', $mylinksDir);
        $catObj = $mylinksCatHandler->get($cid);
        if (is_object($catObj) && !empty($catObj)) {
            $categoryName = $catObj->getVar('title');
            $categoryName = $myts->displayTarea($categoryName);
        } else {
            $cid = 0;
            $categoryName = '';
        }
        $block['title'] = _MB_MYLINKS_RANDOMTITLE;
        $block['content'] = "<div style=\"font-size: 12px; font-weight: bold; background-color: #ccc; padding: 4px; margin: 0;\"><a href=\"" . XOOPS_URL . "/modules/{$mylinksDir}/viewcat.php?cid={$cid}\">{$categoryName}</a></div>";
        $block['content'] .= "<div style=\"padding: 4px 0 0 0; color: #456;\"><h5 style=\"margin: 0;\"><a href=\"".XOOPS_URL."/modules/{$mylinksDir}/singlelink.php?lid={$lid}\">{$link}</a></h5></div><div>{$description}</div>";
        unset($catObj, $mylinksCatHandler);
        $block['content'] .= "<div style=\"text-align: right; font-size: x-small;\"><a href=\"" . XOOPS_URL . "/modules/{$mylinksDir}/index.php\">" . _MB_MYLINKS_SEEMORE . "</a></div>";
    }

    return $block;
}
