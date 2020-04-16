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
 */

use XoopsModules\Mylinks;

//require_once  dirname(__DIR__) . '/include/common.php';
/** @var Mylinks\Helper $helper */
$helper = Mylinks\Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
}

$adminmenu[] = [
    'title' => _MYLINKS_ADMIN_HOME,
    'link'  => 'admin/index.php',
    'desc'  => _MYLINKS_ADMIN_HOME_DESC,
    'icon'  => $pathIcon32 . '//home.png',
];

$adminmenu[] = [
    'title' => _MI_MYLINKS_ADMENU2,
    'link'  => 'admin/main.php?op=linksConfigMenu',
    'desc'  => _MI_MYLINKS_ADMENU2_DESC,
    'icon'  => $pathIcon32 . '/addlink.png',
];

$adminmenu[] = [
    'title' => _MI_MYLINKS_ADMENU3,
    'link'  => 'admin/main.php?op=listNewLinks',
    'desc'  => _MI_MYLINKS_ADMENU3_DESC,
    'icon'  => $pathIcon32 . '/submittedlink.png',
];

$adminmenu[] = [
    'title' => _MI_MYLINKS_ADMENU4,
    'link'  => 'admin/main.php?op=listBrokenLinks',
    'desc'  => _MI_MYLINKS_ADMENU4_DESC,
    'icon'  => $pathIcon32 . '/brokenlink.png',
];

$adminmenu[] = [
    'title' => _MI_MYLINKS_ADMENU5,
    'link'  => 'admin/main.php?op=listModReq',
    'desc'  => _MI_MYLINKS_ADMENU5_DESC,
    'icon'  => $pathIcon32 . '/modifiedlink.png',
];

$adminmenu[] = [
    'title' => _MI_MYLINKS_ADMENU6,  //'Block/Group Admin',
    'link'  => 'admin/myblocksadmin.php',
    'desc'  => _MI_MYLINKS_ADMENU6_DESC,
    'icon'  => $pathIcon32 . '/permissions.png',
];

$adminmenu[] = [
    'title' => _MI_MYLINKS_ADMENU7, //'Template Admin',
    'link'  => 'admin/mytplsadmin.php',
    'desc'  => _MI_MYLINKS_ADMENU7_DESC,
    'icon'  => $pathIcon32 . '/administration.png',
];

$adminmenu[] = [
    'title' => _MYLINKS_ADMIN_ABOUT,
    'link'  => 'admin/about.php',
    'desc'  => _MYLINKS_ADMIN_ABOUT_DESC,
    'icon'  => $pathIcon32 . '/about.png',
];
