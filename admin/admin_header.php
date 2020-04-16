<?php
/**
 * MyLinks module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright ::  XOOPS Project (https://xoops.org)
 * @license   ::    {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package   ::    mylinks
 * @subpackage:: admin
 * @since     ::      2.5.0
 * @author    ::     Magic.Shao <magic.shao@gmail.com> - Susheng Yang <ezskyyoung@gmail.com>
 **/

use XoopsModules\Mylinks;

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once $GLOBALS['xoops']->path('www/class/xoopsformloader.php');

// require_once  dirname(__DIR__) . '/class/Utility.php';
require_once dirname(__DIR__) . '/include/common.php';

$moduleDirName = basename(dirname(__DIR__));

/** @var \XoopsModules\Mylinks\Helper $helper */
$helper      = \XoopsModules\Mylinks\Helper::getInstance();
$adminObject = \Xmf\Module\Admin::getInstance();

$pathIcon16    = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32    = \Xmf\Module\Admin::iconUrl('', 32);
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('main');

$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    require_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new \XoopsTpl();
}
