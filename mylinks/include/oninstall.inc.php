<?php
/**
 * Mylinks install functions.php
 *
 * LICENSE
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * @copyright:: The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::   mylinks
 * @author::    zyspec (owners@zyspec.com)
 * @version::   $Id: oninstall.inc.php 8574 2011-12-27 02:45:39Z beckmi $
 * @since::     File available since Release 3.11
 */

$mylinksDir = basename(dirname(dirname(__FILE__)));

function xoops_module_pre_install_mylinks_base(&$xoopsModule) {
    global $xoopsDB;
    $retVal = true;

    $minPHPVersion   = $xoopsModule->getInfo('min_php');
    $minSQLVersion   = $xoopsModule->getInfo('min_sql');
    $minXoopsVersion = $xoopsModule->getInfo('min_xoops');

    /*
     * Error Messages
     */
    $phpErrMsg   = "<span style='color: red; font-weight: bold;'>YOUR PHP VERSION MUST BE UPGRADED TO AT LEAST VERSION {$minPHPVersion} TO USE THIS MODULE</span>";
    $mysqlErrMsg = "<span style='color: red; font-weight: bold;'>YOUR MYSQL DATABASE VERSION MUST BE UPGRADED TO AT LEAST VERSION {$minSQLVersion} TO USE THIS MODULE</span>";
    $xoopsErrMsg = "<span style='color: red; font-weight: bold;'>YOUR XOOPS VERSION MUST BE UPGRADED TO AT LEAST VERSION {$minXoopsVersion} TO USE THIS MODULE</span>";

    // Check if PHP version is supported
    if (version_compare(PHP_VERSION, $minPHPVersion) < 0) {
        $retVal = false;
        $xoopsModule->setErrors($phpErrMsg);
    } else {
        // Check if MySQL version is supported
        $minSQLSupported = explode('.', $minSQLVersion);
        $sql = $xoopsDB->query("SELECT version() AS sqlver");
        $result = $xoopsDB->fetchObject($sql);
        $currSQLVer = $result->sqlver;
        $sqlVerArray = explode('.', $currSQLVer);
        $sqlVerArray = array_map('intval', $sqlVerArray); //strip off non-integer revision chars

        if ($sqlVerArray[0] < $minSQLSupported[0]) {
            $retVal = false;
            $xoopsModule->setErrors($mysqlErrMsg);
        } elseif ( ($sqlVerArray[0] ==  $minSQLSupported[0]) ) {
            if ($sqlVerArray[1] <  $minSQLSupported[1]) {
                $retVal = false;
                $xoopsModule->setErrors($mysqlErrMsg);
            } elseif (($sqlVerArray[1] ==  $minSQLSupported[1]) && ($sqlVerArray[2] <  $minSQLSupported[2])) {
                $retVal = false;
                $xoopsModule->setErrors($mysqlErrMsg);
            }
        }

        if ($retVal) {
            // Check if this XOOPS version is supported
            $minSupportedVersion = explode('.', $minXoopsVersion);
            $curXoopsVersion = substr(XOOPS_VERSION, 6);
            $currentVersion = explode('.', $curXoopsVersion );

//            $xoopsErrMsg = "<span style='color: red; font-weight: bold;'>YOUR XOOPS VERSION ({$curXoopsVersion}) MUST BE UPGRADED TO AT LEAST VERSION {$minXoopsVersion} TO USE THIS MODULE</span>";
            if ($currentVersion[0] < $minSupportedVersion[0]) {
                $retVal = false;
                $xoopsModule->setErrors($xoopsErrMsg);
            } elseif ($currentVersion[0] == $minSupportedVersion[0]) {
                if ($currentVersion[1] < $minSupportedVersion[1]) {
                    $retVal = false;
                    $xoopsModule->setErrors($xoopsErrMsg);
                } elseif (($currentVersion[1] == $minSupportedVersion[1]) && ($currentVersion[2] < $minSupportedVersion[2])) {
                    $retVal = false;
                    $xoopsModule->setErrors($xoopsErrMsg);
                }
            }
        }
    }

    return $retVal;
}

function xoops_module_install_mylinks_base(&$xoopsModule)
{
    return true;
}
/**
 * eval functions to support module relocation (directory renaming)
 */
eval( 'function xoops_module_install_' . $mylinksDir . '(&$module=NULL)
        {
        return xoops_module_install_mylinks_base($module);
        }
    ' );
eval( 'function xoops_module_pre_install_' . $mylinksDir . '(&$module=NULL)
        {
        return xoops_module_pre_install_mylinks_base($module);
        }
    ' );
