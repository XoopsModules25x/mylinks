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

/** @var Mylinks\Helper $helper */
$helper = Mylinks\Helper::getInstance();

//wanikoo
$mylinks_theme         = 'mylinksdefault';
$mylinks_allowed_theme = [
    'mylinksdefault',
    'mylinksdefault-RW',
    'mylinksdefault-LW',
    'mylinksdefault-BW',
    'weblinkslike',
    'weblinkslike-RW',
    'weblinkslike-LW',
    'weblinkslike-BW',
];

if (!empty($_POST['mylinks_theme_select']) && in_array($_POST['mylinks_theme_select'], $mylinks_allowed_theme)) {
    $mylinks_theme                = $_POST['mylinks_theme_select'];
    $_SESSION['mylinksUserTheme'] = $_POST['mylinks_theme_select'];
} elseif (!empty($_SESSION['mylinksUserTheme']) && in_array($_SESSION['mylinksUserTheme'], $mylinks_allowed_theme)) {
    $mylinks_theme = $_SESSION['mylinksUserTheme'];
}

//wanikoo
if (in_array($mylinks_theme, $mylinks_allowed_theme)) {
    $valid_theme = true;
} else {
    $valid_theme = false;
}

$mylinks_wide_theme       = false;
$mylinks_right_wide_theme = false;
$mylinks_left_wide_theme  = false;
$mylinks_both_wide_theme  = false;

if (true === $valid_theme) {
    if (mb_strpos($mylinks_theme, '-RW') || mb_strpos($mylinks_theme, '-w')) {
        $mylinks_wide_theme       = true;
        $mylinks_right_wide_theme = true;
    } elseif (mb_strpos($mylinks_theme, '-LW')) {
        $mylinks_wide_theme      = true;
        $mylinks_left_wide_theme = true;
    } elseif (mb_strpos($mylinks_theme, '-BW')) {
        $mylinks_wide_theme      = true;
        $mylinks_both_wide_theme = true;
    }
}
//wanikoo
$modulename = basename(__DIR__);

define('XOOPSMYLINKURL', XOOPS_URL . "/modules/{$modulename}");
define('XOOPSMYLINKPATH', XOOPS_ROOT_PATH . "/modules/{$modulename}");
define('XOOPSMYLINKINCURL', XOOPSMYLINKURL . '/include');
define('XOOPSMYLINKINCPATH', XOOPSMYLINKPATH . '/include');
define('XOOPSMYLINKIMGURL', XOOPSMYLINKURL . '/assets/images');
define('XOOPSMYLINKIMGPATH', XOOPSMYLINKPATH . '/assets/images');

//wanikoo
$mylinks_show_siteinfo  = $helper->getConfig('showsiteinfo') ? true : false;
$mylinks_show_extrafunc = $helper->getConfig('showextrafunc') ? true : false;
if (mb_strpos($GLOBALS['xoopsRequestUri'], 'singlelink.php')) {
    $mylinks_show_extrafunc_big = true;
} else {
    $mylinks_show_extrafunc_big = false;
}
//ver3.11
$mylinks_shot_provider = $helper->getConfig('shotprovider');

//ver3.0
//$mylinks_show_externalsearch = false;
$mylinks_show_feed = $helper->getConfig('showfeed') ? true : false;

//ver2.0
$mylinks_show_logo    = $helper->getConfig('showlogo') ? true : false;
$mylinks_show_letters = $helper->getConfig('showletters') ? true : false;
$mylinks_show_toolbar = $helper->getConfig('showtoolbar') ? true : false;
$mylinks_show_search  = $helper->getConfig('showxoopssearch') ? true : false;

/* v3.11 changed theme changer to not display by default
 * since there are no themes included with module and adds
 * complexity for new users/admins
 */
$mylinks_show_themechanger = false;

$mylinks_adcodes               = [];
$mylinks_adcodes['all']        = '';
$mylinks_adcodes['index']      = '';
$mylinks_adcodes['singlelink'] = '';
$mylinks_adcodes['viewcat']    = '';
$mylinks_adcodes['topten']     = '';
$mylinks_adcodes['recent']     = '';
$mylinks_adcodes['ratelink']   = '';
$mylinks_adcodes['modlink']    = '';
$mylinks_adcodes['brokenlink'] = '';
$mylinks_adcodes['submit']     = '';

//wanikoo
// disallow=0, allow =1, memberonly =2
$mylinks_can_print    = $helper->getConfig('canprint');
$mylinks_can_pdf      = $helper->getConfig('canpdf');
$mylinks_can_bookmark = $helper->getConfig('canbookmark');

//if qrcode module exists
if (file_exists(XOOPS_ROOT_PATH . '/modules/qrcode/qrcode_image.php')) {
    // disallow=0, allow =1, memberonly =2
    $mylinks_can_qrcode = $helper->getConfig('canqrcode');
} else {
    //no qrcode module
    $mylinks_can_qrcode = 0;
}

//logo
if ($mylinks_show_logo && !is_dir(XOOPSMYLINKIMGPATH . "/{$mylinks_theme}/icons/logo.gif")
    && file_exists(XOOPSMYLINKIMGPATH . "/{$mylinks_theme}/icons/logo.gif")) {
    $logoimage = "<a href='" . XOOPSMYLINKURL . "/index.php'><img src='" . XOOPSMYLINKIMGURL . "/{$mylinks_theme}/icons/logo.gif' style='border-width: 0px;' alt=''></a>";
} elseif ($mylinks_show_logo && !is_dir(XOOPSMYLINKIMGPATH . '/icons/logo.gif')
          && file_exists(XOOPSMYLINKIMGPATH . '/icons/logo.gif')) {
    $logoimage = "<a href='" . XOOPSMYLINKURL . "/index.php'><img src='" . XOOPSMYLINKIMGURL . "/icons/logo.gif' style='border-width: 0px' alt=''></a>";
} else {
    $logoimage = '';
}
