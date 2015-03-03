<?php
// ------------------------------------------------------------------------- //
//                            myblocksadmin.php                              //
//                - XOOPS block admin for each modules -                     //
//                          GIJOE <http://www.peak.ne.jp/>                   //
// ------------------------------------------------------------------------- //

include_once  '../../../include/cp_header.php';
include 'admin_header.php';
//include_once XOOPS_ROOT_PATH."/modules/" . $xoopsModule->getVar("dirname") . "/class/admin.php";

include_once 'mygrouppermform.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsblock.php';
include_once '../include/gtickets.php';// GIJ

$xoops_system_path = XOOPS_ROOT_PATH . '/modules/system';

// language files
$language = $xoopsConfig['language'];
if (!file_exists("{$xoops_system_path}/language/{$language}/admin/blocksadmin.php")) {
    $language = 'english';
}

// to prevent from notice that constants already defined
$error_reporting_level = error_reporting( 0 );
include_once( "{$xoops_system_path}/constants.php" );
include_once( "{$xoops_system_path}/language/{$language}/admin.php" );
include_once( "{$xoops_system_path}/language/{$language}/admin/blocksadmin.php" );
error_reporting( $error_reporting_level );

$group_defs = file( "{$xoops_system_path}/language/{$language}/admin/groups.php" );
foreach ($group_defs as $def) {
    if (strstr($def, '_AM_MYLINKS_ACCESSRIGHTS') || strstr($def, '_AM_MYLINKS_ACTIVERIGHTS')) {
        eval($def);
    }
}

// check $xoopsModule
if (!is_object($xoopsModule)) {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

// set target_module if specified by $_GET['dirname']
$module_handler =& xoops_gethandler('module');

if (!empty($_GET['dirname'])) {
    $target_module =& $module_handler->getByDirname($_GET['dirname']);
}/* else if( ! empty( $_GET['mid'] ) ) {
  $target_module =& $module_handler->get( intval( $_GET['mid'] ) );
}*/

if (!empty($target_module) && is_object($target_module)) {
    // specified by dirname
    $target_mid = $target_module->getVar('mid');
    $target_mname = $target_module->getVar('name') . "&nbsp;" . sprintf( "(%2.2f)", $target_module->getVar('version') / 100.0);
    $query4redirect = '?dirname=' . urlencode(strip_tags($_GET['dirname']));
} elseif (isset($_GET['mid']) && $_GET['mid'] == 0 || $xoopsModule->getVar('dirname') == 'blocksadmin') {
    $target_mid     = 0;
    $target_mname   = '';
    $query4redirect = '?mid=0';
} else {
    $target_mid     = $xoopsModule->getVar( 'mid' );
    $target_mname   = $xoopsModule->getVar( 'name' );
    $query4redirect = '';
}

// check access right (needs system_admin of BLOCK)
$sysperm_handler =& xoops_gethandler('groupperm');
if (!$sysperm_handler->checkRight('system_admin', XOOPS_SYSTEM_BLOCK, $xoopsUser->getGroups())) {
    redirect_header( XOOPS_URL . '/user.php', 1, _NOPERM );
}

// get blocks owned by the module (Imported from xoopsblock.php then modified)
//$block_arr =& XoopsBlock::getByModule( $target_mid );
$db =& XoopsDatabaseFactory::getDatabaseConnection();
$sql = "SELECT * FROM " . $db->prefix("newblocks") . " WHERE mid='{$target_mid}' ORDER BY visible DESC,side,weight";
$result = $db->query($sql);
$block_arr = array();
while ($myrow = $db->fetchArray($result)) {
    $block_arr[] = new XoopsBlock($myrow);
}

function list_groups()
{
    global $target_mid , $target_mname , $block_arr;

    $item_list = array();
    foreach (array_keys($block_arr) as $i) {
        $item_list[ $block_arr[$i]->getVar("bid") ] = $block_arr[$i]->getVar("title");
    }

    $form = new MyXoopsGroupPermForm(_AM_MYLINKS_AGDS, 1, 'block_read', '');
    if ($target_mid > 1) {
        $form->addAppendix('module_admin', $target_mid, $target_mname . ' ' . _AM_MYLINKS_ACTIVERIGHTS);
        $form->addAppendix('module_read', $target_mid, $target_mname . ' ' . _AM_MYLINKS_ACCESSRIGHTS);
    }
    foreach ($item_list as $item_id => $item_name) {
        $form->addItem($item_id, $item_name);
    }
    echo $form->render();
}

if (!empty($_POST['submit'])) {
    if (!$xoopsGTicket->check( true, 'myblocksadmin')) {
        redirect_header(XOOPS_URL.'/', 3, $xoopsGTicket->getErrors());
    }

    include 'mygroupperm.php';
    redirect_header(XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/myblocksadmin.php{$query4redirect}", 1, _MD_MYLINKS_DBUPDATED);
}

xoops_cp_header();
$indexAdmin = new ModuleAdmin();
echo $indexAdmin->addNavigation('myblocksadmin.php');

if (file_exists('./mymenu.php')) {
    include './mymenu.php';
}

list_groups();
include 'admin_footer.php';
