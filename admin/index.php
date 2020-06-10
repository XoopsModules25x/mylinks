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
 * @author        Thatware - http://thatware.org/
 */
require_once __DIR__ . '/admin_header.php';
xoops_cp_header();

/**
 * Defined via inclusion of ./admin/admin_header.php
* @var \Xmf\Module\Admin $adminObject
*/

// Temporarily 'homeless' links (to be revised in admin.php breakup)
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_broken') . ' ');
list($totalBrokenLinks) = $xoopsDB->fetchRow($result);
if ($totalBrokenLinks > 0) {
    $totalBrokenLinks = "<span style='color: #ff0000; font-weight: bold'>{$totalBrokenLinks}</span>";
}
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_mod') . ' ');
list($totalModRequests) = $xoopsDB->fetchRow($result);
if ($totalModRequests > 0) {
    $totalModRequests = "<span style='color: #ff0000; font-weight: bold'>{$totalModRequests}</span>";
}
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE status='0'");
list($totalNewLinks) = $xoopsDB->fetchRow($result);
if ($totalNewLinks > 0) {
    $totalNewLinks = "<span style='color: #ff0000; font-weight: bold;'>{$totalNewLinks}</span>";
}
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_links') . ' WHERE status>0');
list($activeLinks) = $xoopsDB->fetchRow($result);

$adminObject->addInfoBox(_MD_MYLINKS_WEBLINKSCONF);

if (0 == $totalNewLinks) {
    //$adminObject->addLineLabel(sprintf( _MD_MYLINKS_LINKSWAITING, $totalNewLinks), '', 'Green');
    $adminObject->addInfoBoxLine(sprintf(_MD_MYLINKS_LINKSWAITING, $totalNewLinks), '', 'Green');
} else {
    $adminObject->addInfoBoxLine(sprintf(_MD_MYLINKS_LINKSWAITING, $totalNewLinks), '', 'Red');
}

if (0 == $totalBrokenLinks) {
    $adminObject->addInfoBoxLine(sprintf(_MD_MYLINKS_BROKENREPORTS, $totalBrokenLinks), '', 'Green');
} else {
    $adminObject->addInfoBoxLine(sprintf(_MD_MYLINKS_BROKENREPORTS, $totalBrokenLinks), '', 'Red');
}

if (0 == $totalModRequests) {
    $adminObject->addInfoBoxLine(sprintf(_MD_MYLINKS_MODREQUESTS, $totalModRequests), '', 'Green');
} else {
    $adminObject->addInfoBoxLine(sprintf(_MD_MYLINKS_MODREQUESTS, $totalModRequests), '', 'Red');
}

$adminObject->addInfoBoxLine(sprintf(_MD_MYLINKS_THEREARE, $activeLinks), '');
//------------------------------

$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayIndex();

require_once __DIR__ . '/admin_footer.php';
