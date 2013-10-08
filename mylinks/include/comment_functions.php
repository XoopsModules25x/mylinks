<?php
// comment callback functions

function mylinks_com_update($link_id, $total_num)
{
    $link_id = isset($link_id) ? intval($link_id) : 0;
    $total_num = (isset($total_num) && (intval($total_num) > 0)) ? intval($total_num) : 0;
    if ($link_id > 0) {
        $db =& XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "UPDATE " . $db->prefix('mylinks_links') . " SET comments={$total_num} WHERE lid={$link_id}";
        $db->query($sql);
    }
}

function mylinks_com_approve(&$comment)
{
  // notification mail here
}
