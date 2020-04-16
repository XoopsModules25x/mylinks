<?php
// comment callback functions

/**
 * @param $link_id
 * @param $total_num
 */
function mylinks_com_update($link_id, $total_num)
{
    $link_id   = isset($link_id) ? (int)$link_id : 0;
    $total_num = (isset($total_num) && ((int)$total_num > 0)) ? (int)$total_num : 0;
    if ($link_id > 0) {
        $db  = \XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'UPDATE ' . $db->prefix('mylinks_links') . " SET comments={$total_num} WHERE lid={$link_id}";
        $db->query($sql);
    }
}

/**
 * @param $comment
 */
function mylinks_com_approve(&$comment)
{
    // notification mail here
}
