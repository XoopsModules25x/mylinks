<?php
/**
 * mylinks install functions.php
 *
 * LICENSE
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * @copyright:: {@link http://xoops.org/ XOOPS Project}
 * @license  ::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package  ::   mylinks
 * @author   ::    zyspec (owners@zyspec.com)
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

$moduleDirName = basename(dirname(__DIR__));

/**
 * @param XoopsModule $xoopsModule
 * @param $prev_version
 * @return bool
 */
function xoops_module_update_mylinks_base(XoopsModule $xoopsModule, $prev_version)
{
    $minUpgradeFrom = '0.0.0';  //minimum version of module supported for upgrade
    $success        = false;

    $ref = xoops_getenv('HTTP_REFERER');  //referer check
    if ($ref == '' || strpos($ref, XOOPS_URL . '/modules/system/admin.php') === 0) {
        /* module specific part */
        $minValueArray       = explode('.', $minUpgradeFrom);
        $installedVersion    = (int)$prev_version;
        $minSupportedVersion = ($minValueArray[0] * 100) + ($minValueArray[1] * 10) + $minValueArray[2];
        $modErrMsg           = "<span style='color: red; font-weight: bold;'>This module cannot be upgraded from version {$installedVersion}.</span>";

        if ($installedVersion < $minSupportedVersion) {
            $success = false;
            $xoopsModule->setErrors($modErrMsg);
        } else {
            require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/include/oninstall.inc.php';
            $success = xoops_module_pre_install_mylinks($xoopsModule);
        }
    }

    global $xoopsDB;
    if ($prev_version < 312) {
        // delete old html template files
        $templateDirectory = $GLOBALS['xoops']->path('modules/' . $xoopsModule->getVar('dirname', 'n') . '/templates/');
        $templateList      = array_diff(scandir($templateDirectory), array('..', '.'));
        foreach ($templateList as $k => $v) {
            $fileInfo = new SplFileInfo($templateDirectory . $v);
            if ($fileInfo->getExtension() === 'html' && $fileInfo->getFilename() !== 'index.html') {
                if (file_exists($templateDirectory . $v)) {
                    unlink($templateDirectory . $v);
                }
            }
        }
        // delete old block html template files
        $templateDirectory = $GLOBALS['xoops']->path('modules/' . $xoopsModule->getVar('dirname', 'n') . '/templates/blocks/');
        $templateList      = array_diff(scandir($templateDirectory), array('..', '.'));
        foreach ($templateList as $k => $v) {
            $fileInfo = new SplFileInfo($templateDirectory . $v);
            if ($fileInfo->getExtension() === 'html' && $fileInfo->getFilename() !== 'index.html') {
                if (file_exists($templateDirectory . $v)) {
                    unlink($templateDirectory . $v);
                }
            }
        }

        //delete .html entries from the tpl table
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('tplfile') . " WHERE `tpl_module` = '" . $xoopsModule->getVar('dirname', 'n') . "' AND `tpl_file` LIKE '%.html%'";
        $xoopsDB->queryF($sql);
    }

    return $success;
}

/**
 * eval functions to support module relocation (directory renaming)
 */
eval('function xoops_module_update_' . $moduleDirName . '($module=NULL, $prev_version)
        {
        return xoops_module_update_mylinks_base($module, $prev_version);
        }
    ');
