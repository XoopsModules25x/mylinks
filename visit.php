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
 * @copyright    {@link https://xoops.org/ XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use XoopsModules\Mylinks;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));

/** @var Mylinks\Helper $helper */
$helper = Mylinks\Helper::getInstance();

$lid = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);

if (empty($lid)) {
    header('Location: ' . XOOPS_URL . '/');
    exit();
}

$cid = Mylinks\Utility::cleanVars($_GET, 'cid', 0, 'int', ['min' => 0]);

if (!$xoopsUser || (!$xoopsUser->isAdmin($xoopsModule->mid()))
    || ($xoopsUser->isAdmin($xoopsModule->mid())
        && $helper->getConfig('incadmin'))) {
    $sql = sprintf('UPDATE `%s` SET hits = hits+1 WHERE lid = %u AND STATUS > 0', $xoopsDB->prefix('mylinks_links'), $lid);
    $xoopsDB->queryF($sql);
}
$result = $xoopsDB->query('SELECT url FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE lid={$lid} AND status>0");
list($url) = $xoopsDB->fetchRow($result);
if (empty($url)) {
    header('Location: ' . XOOPS_URL . '/');
    exit();
}
$url = htmlspecialchars(preg_replace('/javascript:/si', 'java script:', $url), ENT_QUOTES);
if ('' != $helper->getConfig('frame')) {
    header('Content-Type:text/html; charset=' . _CHARSET);
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    echo "<html><head>\n"
         . '<title>'
         . htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)
         . "</title>\n"
         . "</head>\n"
         . "<frameset rows='70px,100%' cols='*' border='0' frameborder='0' framespacing='0' >\n"
         . "<frame src='myheader.php?url={$url}&amp;cid={$cid}&amp;lid={$lid}' frame name='xoopshead' scrolling='no' target='main' Noresize>\n"
         . "<frame src='{$url}' frame name='main' scrolling='auto' target='Main'>\n"
         . "</frameset></html>\n";
} else {
    echo "<html><head><meta http-equiv=\"Refresh\" content=\"0; URL={$url}\"></meta></head><body></body></html>";
}
exit();
