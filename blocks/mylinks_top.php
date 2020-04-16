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
 * @param mixed $options
 */

/******************************************************************************
 * Function: b_mylinks_top_show
 * Input   : $options[0] = date for the most recent links
 *                         hits for the most popular links
 *           $block['content'] = The optional above content
 *           $options[1]   = How many reviews are displayed
 * Output  : Returns the desired most recent or most popular links
 *****************************************************************************
 * @param $options
 * @return array
 */
function b_mylinks_top_show($options)
{
    global $xoopsDB;
    $block = [];
    //ver2.5
    $modulename = basename(dirname(__DIR__));
    $myts       = \MyTextSanitizer::getInstance();
    $result     = $xoopsDB->query('SELECT lid, cid, title, date, hits FROM ' . $xoopsDB->prefix('mylinks_links') . ' WHERE status>0 ORDER BY ' . $options[0] . ' DESC', $options[1], 0);
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $link  = [];
        $title = $myts->htmlSpecialChars($myts->stripSlashesGPC($myrow['title']));
        //        if (!XOOPS_USE_MULTIBYTES) {
        if (mb_strlen($title) >= $options[2]) {
            $title = mb_substr($title, 0, $options[2] - 1) . '...';
        }
        //        }
        $link['id']    = $myrow['lid'];
        $link['cid']   = $myrow['cid'];
        $link['title'] = $title;
        if ('date' === $options[0]) {
            $link['date'] = formatTimestamp($myrow['date'], 's');
        } elseif ('hits' === $options[0]) {
            $link['hits'] = $myrow['hits'];
        }
        $block['links'][] = $link;
    }
    if (!empty($block)) {  // only show block if there's data to display
        $block['mylinks_weburl'] = XOOPS_URL . "/modules/{$modulename}";
    }

    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_mylinks_top_edit($options)
{
    $form = '' . _MB_MYLINKS_DISP . '&nbsp;';
    $form .= "<input type='hidden' name='options[]' value='";
    if ('date' === $options[0]) {
        $form .= "date'";
    } else {
        $form .= "hits'";
    }
    $form .= '>';
    $form .= "<input type='text' name='options[]' value='" . $options[1] . "'>&nbsp;" . _MB_MYLINKS_LINKS . '';
    $form .= '&nbsp;<br>' . _MB_MYLINKS_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "'>&nbsp;" . _MB_MYLINKS_LENGTH . '';

    return $form;
}
