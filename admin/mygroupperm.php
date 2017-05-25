<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit;
}

/**
 * @param      $DB
 * @param      $gperm_modid
 * @param null $gperm_name
 * @param null $gperm_itemid
 * @return bool
 */
function myDeleteByModule($DB, $gperm_modid, $gperm_name = null, $gperm_itemid = null)
{
    $criteria = new CriteriaCompo(new Criteria('gperm_modid', (int)$gperm_modid));
    if (isset($gperm_name)) {
        $criteria->add(new Criteria('gperm_name', $gperm_name));
        if (isset($gperm_itemid)) {
            $criteria->add(new Criteria('gperm_itemid', (int)$gperm_itemid));
        }
    }
    $sql    = 'DELETE FROM ' . $DB->prefix('group_permission') . ' ' . $criteria->renderWhere();
    $result = $DB->query($sql);
    $result = $result ? true : false;

    return $result;
}

$modid = isset($_POST['modid']) ? (int)$_POST['modid'] : 1;

// we dont want system module permissions to be changed here ( 1 -> 0 GIJ)
if ($modid <= 0 || !is_object($xoopsUser) || !$xoopsUser->isAdmin($modid)) {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
    exit();
}
$moduleHandler = xoops_getHandler('module');
$module         = $moduleHandler->get($modid);
if (!is_object($module) || !$module->getVar('isactive')) {
    redirect_header(XOOPS_URL . '/admin.php', 1, _MODULENOEXIST);
    exit();
}
$memberHandler = xoops_getHandler('member');
$group_list     = $memberHandler->getGroupList();
if (is_array($_POST['perms']) && !empty($_POST['perms'])) {
    $gpermHandler = xoops_getHandler('groupperm');
    foreach ($_POST['perms'] as $perm_name => $perm_data) {
        foreach ($perm_data['itemname'] as $item_id => $item_name) {
            if (false != myDeleteByModule($gpermHandler->db, $modid, $perm_name, $item_id)) {
                if (!empty($perm_data['groups'])) {
                    foreach ($perm_data['groups'] as $group_id => $item_ids) {
                        $selected = isset($item_ids[$item_id]) ? $item_ids[$item_id] : 0;
                        if ($selected == 1) {
                            // make sure that all parent ids are selected as well
                            if ($perm_data['parents'][$item_id] != '') {
                                $parent_ids = explode(':', $perm_data['parents'][$item_id]);
                                foreach ($parent_ids as $pid) {
                                    if ($pid != 0 && !in_array($pid, array_keys($item_ids))) {
                                        // one of the parent items were not selected, so skip this item
                                        $msg[] = sprintf(_MD_AM_PERMADDNG, '<strong>' . $perm_name . '</strong>', '<strong>' . $perm_data['itemname'][$item_id] . '</strong>', '<strong>' . $group_list[$group_id] . '</strong>') . ' (' . _MD_AM_PERMADDNGP . ')';
                                        continue 2;
                                    }
                                }
                            }
                            $gperm = $gpermHandler->create();
                            $gperm->setVar('gperm_groupid', $group_id);
                            $gperm->setVar('gperm_name', $perm_name);
                            $gperm->setVar('gperm_modid', $modid);
                            $gperm->setVar('gperm_itemid', $item_id);
                            if (!$gpermHandler->insert($gperm)) {
                                $msg[] = sprintf(_MD_AM_PERMADDNG, '<strong>' . $perm_name . '</strong>', '<strong>' . $perm_data['itemname'][$item_id] . '</strong>', '<strong>' . $group_list[$group_id] . '</strong>');
                            } else {
                                $msg[] = sprintf(_MD_AM_PERMADDOK, '<strong>' . $perm_name . '</strong>', '<strong>' . $perm_data['itemname'][$item_id] . '</strong>', '<strong>' . $group_list[$group_id] . '</strong>');
                            }
                            unset($gperm);
                        }
                    }
                }
            } else {
                $msg[] = sprintf(_MD_AM_PERMRESETNG, $module->getVar('name'));
            }
        }
    }
}
