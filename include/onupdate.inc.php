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
 * @copyright:: XOOPS Project (https://xoops.org)
 * @license  ::    {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package  ::   mylinks
 * @author   ::    zyspec (zyspec@yahoo.com)
 * @since    ::     File available since Release 3.11
 */



$mylinksDir = basename(dirname(__DIR__));

/**
 * @param $xoopsModule
 * @param $prev_version	
 * @return bool
 * @TODO refactor this code without eval() - security risk
 */
function xoops_module_update_mylinks_base(\XoopsObject $xoopsModule, $prev_version)
{
    $minUpgradeFrom = '0.0.0';  //minimum version of module supported for upgrade
    $success        = false;

    $ref = xoops_getenv('HTTP_REFERER');  //referer check
    if ('' == $ref || 0 === mb_strpos($ref, XOOPS_URL . '/modules/system/admin.php')) {
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

    return $success;
}

/**
 * eval functions to support module relocation (directory renaming)
 */
eval(
    'function xoops_module_update_' . $mylinksDir . '($module=NULL, $prev_version)
        {
        return xoops_module_update_mylinks_base($module, $prev_version);
        }
    '
);
