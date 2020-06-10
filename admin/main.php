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
 * @author        Thatware - http://thatware.org/
 */

//use GorHill\FineDiff\FineDiff;
//use GorHill\FineDiff\FineDiffHTML;
//use Horde\Diff;
use XoopsModules\Mylinks;
use XoopsModules\Mylinks\Utility;

require_once __DIR__ . '/admin_header.php';

//soops_loadLanguage('main', $xoopsModule->getVar('dirname'));
// require_once  dirname(__DIR__) . '/class/Utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));

require_once XOOPS_ROOT_PATH . '/class/tree.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
require_once XOOPS_ROOT_PATH . '/include/xoopscodes.php';
//require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

/** Defined via inclusion of ./admin/admin_header.php
 * @var \XoopsModules\Mylinks\Helper $helper
 */

if (!isset($GLOBALS['xoTheme']) || !is_object($GLOBALS['xoTheme'])) {
    require_once $GLOBALS['xoops']->path('class/theme.php');
    $GLOBALS['xoTheme'] = new \xos_opal_Theme();
}
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/gwiki/assets/css/module.css');

$myts = \MyTextSanitizer::getInstance();
//$eh = new ErrorHandler;

$categoryHandler = $helper->getHandler('Category');
$catObjs           = $categoryHandler->getAll();
$myCatTree         = new \XoopsObjectTree($catObjs, 'cid', 'pid');

function listNewLinks()
{
    global $xoopsDB, $myts, $myCatTree, $xoopsModule;
    // List links waiting for validation
    $linkimg_array = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/images/shots/');
    $result        = $xoopsDB->query('SELECT lid, cid, title, url, logourl, submitter FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE status='0' ORDER BY date DESC");
    $numrows       = $xoopsDB->getRowsNum($result);
    xoops_cp_header();

    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=listNewLinks');

    //@TODO: change to use XoopsForm
    echo "<table  class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n" . "  <tr><th colspan='7'>" . sprintf(_MD_MYLINKS_LINKSWAITING, $numrows) . "<br></th></tr>\n";
    if ($numrows > 0) {
        while (list($lid, $cid, $title, $url, $logourl, $submitterid) = $xoopsDB->fetchRow($result)) {
            $result2 = $xoopsDB->query('SELECT description FROM ' . $xoopsDB->prefix('mylinks_text') . " WHERE lid='{$lid}'");
            list($description) = $xoopsDB->fetchRow($result2);
            $title = $myts->htmlSpecialChars($title);
            $url   = $myts->htmlSpecialChars($url);
            //      $url = urldecode($url);
            //      $logourl = $myts->htmlSpecialChars($logourl);
            //      $logourl = urldecode($logourl);
            $description = $myts->htmlSpecialChars($description);
            $submitter   = \XoopsUser::getUnameFromId($submitterid);
            echo "  <tr><td>\n"
                 . "    <form action='main.php' method='post'>\n"
                 . "        <table style='width: 80%;'>\n"
                 . "          <tr><td style='text-align: right; nowrap='nowrap'>"
                 . _MD_MYLINKS_SUBMITTER
                 . "</td>\n"
                 . '            <td><a href="'
                 . XOOPS_URL
                 . '/userinfo.php?uid='
                 . $submitterid
                 . "\">$submitter</a></td>\n"
                 . "          </tr>\n"
                 . "          <tr><td style='text-align: right;' nowrap='nowrap'>"
                 . _MD_MYLINKS_SITETITLE
                 . "</td>\n"
                 . "            <td><input type='text' name='title' size='50' maxlength='100' value='{$title}'></td>\n"
                 . "          </tr>\n"
                 . "          <tr><td style='text-align: right;' nowrap='nowrap'>"
                 . _MD_MYLINKS_SITEURL
                 . "</td>\n"
                 . "            <td><input type='text' name='url' size='50' maxlength='250' value='{$url}'>&nbsp;\n"
                 . "              [&nbsp;<a href='"
                 . preg_replace('/javascript:/si', 'java script:', $url)
                 . "' target='_blank'>"
                 . _MD_MYLINKS_VISIT
                 . "</a>&nbsp;]\n"
                 . "            </td>\n"
                 . "          </tr>\n"
                 . "          <tr><td style='text-align: right;' nowrap'nowrap'>"
                 . _MD_MYLINKS_CATEGORYC
                 . "</td>\n"
                 . '            <td>'
                 . $myCatTree->makeSelBox('cid', 'title', '- ', $cid)
                 . "</td>\n"
                 . "          </tr>\n"
                 . "        <tr><td style='text-align: right; vertical-align: top;' nowrap='nowrap'>"
                 . _MD_MYLINKS_DESCRIPTIONC
                 . "</td>\n"
                 . "          <td><textarea name='description' cols='60' rows='5'>{$description}</textarea></td>\n"
                 . "        </tr>\n"
                 . "        <tr><td style='text-align: right; nowrap='nowrap'>"
                 . _MD_MYLINKS_SHOTIMAGE
                 . "</td>\n"
                 . "            <td><select size='1' name='logourl'><option value=' '>------</option>";
            foreach ($linkimg_array as $image) {
                echo "<option value='{$image}'>{$image}</option>";
            }
            $shotdir = '<strong>' . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/images/shots/</strong>';
            echo "</select></td>\n"
                 . "        </tr>\n"
                 . '        <tr><td></td><td>'
                 . sprintf(_MD_MYLINKS_SHOTMUST, $shotdir)
                 . "</td></tr>\n"
                 . "      </table>\n"
                 . "      <br><input type='hidden' name='op' value='approve'>\n"
                 . "      <input type='hidden' name='lid' value='{$lid}'>\n"
                 . "      <input type='submit' value='"
                 . _MD_MYLINKS_APPROVE
                 . "'>\n"
                 . "    </form>\n";
            echo "    <form action='main.php?op=delNewLink&amp;lid={$lid}' method='post'><input type='submit' value='" . _DELETE . "'></form>\n" . "    <br><br>\n" . "  </td></tr>\n";
        }
    } else {
        echo "  <tr><td colspan='7' class='odd bold italic'>" . _MD_MYLINKS_NOSUBMITTED . "</td></tr>\n";
    }
    echo "</table>\n";

    require_once __DIR__ . '/admin_footer.php';
}

function linksConfigMenu()
{
    global $xoopsDB, $myts, $myCatTree, $xoopsModule;
    /** @var \XoopsModules\Mylinks\Helper $helper */
    $helper            = \XoopsModules\Mylinks\Helper::getInstance();
    $categoryHandler = $helper->getHandler('Category');
    $catCount          = $categoryHandler->getCount();
    $linkimg_array     = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/images/shots/');

    xoops_cp_header();
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=linksConfigMenu');

    //    echo "<h4>" . _MD_MYLINKS_WEBLINKSCONF . "</h4>\n";

    // If there is a category, display add a New Link table
    //@TODO:  change to use XoopsForm
    if ($catCount) {
        echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
             . "  <tr><th style='font-size: larger;'>"
             . _MD_MYLINKS_ADDNEWLINK
             . "</th></tr>\n"
             . "  <tr class='odd'><td style='padding: 0 10em;'>\n"
             . "    <form method='post' action='main.php'>\n"
             . "      <table style='width: 80%;'>\n"
             . "        <tr>\n"
             . "          <td style='text-align: right;'>"
             . _MD_MYLINKS_SITETITLE
             . "</td>\n"
             . "            <td><input type='text' name='title' size='50' maxlength='100'></td>\n"
             . "          </tr>\n"
             . "        <tr>\n"
             . "          <td style='text-align: right;' nowrap='nowrap'>"
             . _MD_MYLINKS_SITEURL
             . "</td>\n"
             . "          <td><input type='text' name='url' size='50' maxlength='250' value='http://'></td>\n"
             . "        </tr>\n"
             . "        <tr>\n"
             . "          <td style='text-align: right;' nowrap='nowrap'>"
             . _MD_MYLINKS_CATEGORYC
             . "</td>\n"
             . "          <td>\n"
             . '            '
             . $myCatTree->makeSelBox('cid', 'title')
             . "\n"
             . "            </td>\n"
             . "          </tr>\n"
             . "          <tr>\n"
             . "          <td style='text-align: right; vertical-align: top;' nowrap='nowrap'>"
             . _MD_MYLINKS_DESCRIPTIONC
             . "</td>\n"
             . '          <td>';
        xoopsCodeTarea('descarea', 60, 8);
        xoopsSmilies('descarea');
        echo "          </td>\n" . "        </tr>\n" . "        <tr>\n" . "          <td style='text-align: right; nowrap='nowrap'>" . _MD_MYLINKS_SHOTIMAGE . "</td>\n" . "          <td><select size='1' name='logourl'><option value=' '>------</option>";
        foreach ($linkimg_array as $image) {
            echo "<option value='{$image}'>{$image}</option>";
        }
        echo "</select></td>\n" . "        </tr>\n";
        $shotdir = '<strong>' . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/images/shots/</strong>';
        echo '        <tr><td></td><td>'
             . sprintf(_MD_MYLINKS_SHOTMUST, $shotdir)
             . "</td></tr>\n"
             . "      </table><br>\n"
             . "      <div class='center;'>\n"
             . "        <input type='hidden' name='op' value='addLink'>\n"
             . "        <input type='submit' class='button' value='"
             . _ADD
             . "'>\n"
             . "      </div>\n"
             . "    </form>\n"
             . "  </td></tr>\n"
             . "</table>\n"
             . "<br>\n";

        // Modify Link
        $result2 = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_links') . '');
        list($numLinks) = $xoopsDB->fetchRow($result2);
        if ($numLinks) {
            echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
                 . "  <tr><th style='font-size: larger;'>"
                 . _MD_MYLINKS_MODLINK
                 . "</th></tr>\n"
                 . "  <tr class='odd'><td class='center;'>\n"
                 . "    <form method='get' action='main.php'>\n"
                 . '      '
                 . _MD_MYLINKS_LINKID
                 . "\n"
                 . "      <input type='text' name='lid' size='12' maxlength='11'>\n"
                 . "      <input type='hidden' name='fct' value='mylinks'>\n"
                 . "      <input type='hidden' name='op' value='modLink'><br><br>\n"
                 . "      <input type='submit' value='"
                 . _MD_MYLINKS_MODIFY
                 . "'>\n"
                 . "    </form>\n"
                 . "  </td></tr>\n"
                 . '</table>';
        }
    }

    // Add a New Main Category
    echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
         . "  <tr><th style='font-size: larger;'>"
         . _MD_MYLINKS_ADDMAIN
         . "</th></tr>\n"
         . "  <tr class='odd'><td class='center;'>\n"
         . "    <form method='post' action='main.php'>\n"
         . '      '
         . _MD_MYLINKS_TITLEC
         . "\n"
         . "      <input type='text' name='title' size='30' maxlength='50'><br>\n"
         . '      '
         . _MD_MYLINKS_IMGURL
         . "<br>\n"
         . "      <input type='text' name='imgurl' size='100' maxlength='150' value='http://'><br><br>\n"
         . "      <input type='hidden' name='cid' value='0'>\n"
         . "      <input type='hidden' name='op' value='addCat'>\n"
         . "      <input type='submit' value='"
         . _ADD
         . "'><br>\n"
         . "    </form>\n"
         . "  </td></tr>\n";
    if (!$catCount) {
        echo "  <tr><th style='font-size: larger;'>"
             . _MD_MYLINKS_IMPORTCATHDR
             . "</th></tr>\n"
             . "  <tr class='even'><td class='center;'>\n"
             . "    <form method='post' action='main.php'>\n"
             . '      '
             . _MD_MYLINKS_IMPORTCATS
             . "<br>\n"
             . "      <input type='hidden' name='op' value='importCats'>\n"
             . "      <input type='hidden' name='ok' value='0'>\n"
             . "      <input style='margin: .5em 0em;' type='submit' value='"
             . _SUBMIT
             . "'><br>\n"
             . "    </form>\n"
             . '  </td></tr>'
             . "</table>\n"
             . "<br>\n";
    }
    // Add a New Sub-Category
    if ($catCount) {
        echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
             . "  <tr><th style='font-size: larger;'>"
             . _MD_MYLINKS_ADDSUB
             . "</th></tr>\n"
             . "  <tr class='odd'><td class='center;'>\n"
             . "    <form method='post' action='main.php'>\n"
             . '      '
             . _MD_MYLINKS_TITLEC
             . "\n"
             . "      <input type='text' name='title' size='30' maxlength='50'>&nbsp;"
             . _MD_MYLINKS_IN
             . "&nbsp;\n"
             . '      '
             . $myCatTree->makeSelBox('pid', 'title')
             . "\n"
             . "      <input type='hidden' name='op' value='addCat'><br><br>\n"
             . "      <input type='submit' value='"
             . _ADD
             . "'><br>\n"
             . "    </form>\n"
             . "  </td></tr>\n"
             . "</table>\n"
             . '<br>';
    }

    // Modify Category Table Display
    if ($catCount) {
        echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n"
             . "  <tr><th style='font-size: larger;'>"
             . _MD_MYLINKS_MODCAT
             . "</th></tr>\n"
             . "  <tr class='odd'><td class='center;'>\n"
             . "    <form method='get' action='main.php'>\n"
             //            ."      <h4>" . _MD_MYLINKS_MODCAT . "</h4><br>\n"
             . '      '
             . _MD_MYLINKS_CATEGORYC
             . "\n"
             . '      '
             . $myCatTree->makeSelBox('cid', 'title')
             . "\n"
             . "      <br><br>\n"
             . "      <input type='hidden' name='op' value='modCat'>\n"
             . "      <input type='submit' value='"
             . _MD_MYLINKS_MODIFY
             . "'>\n"
             . "    </form>\n"
             . "  </td></tr>\n"
             . "</table>\n"
             . "<br>\n";
    }
    require_once __DIR__ . '/admin_footer.php';
}

function modLink()
{
    global $xoopsDB, $myts, $myCatTree, $xoopsModule;

    $linkimg_array = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/images/shots/');
    $lid           = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);
    $bknrptid      = Mylinks\Utility::cleanVars($_GET, 'bknrptid', 0, 'int', ['min' => 0]);

    xoops_cp_header();

    $result = $xoopsDB->query('SELECT cid, title, url, logourl FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE lid={$lid}");
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    list($cid, $title, $url, $logourl) = $xoopsDB->fetchRow($result);

    $title   = $myts->htmlSpecialChars($myts->stripSlashesGPC($title));
    $url     = $myts->htmlSpecialChars($myts->stripSlashesGPC($url));
    $logourl = $myts->htmlSpecialChars($myts->stripSlashesGPC($logourl));
    //$url                    = urldecode($url);
    //$logourl                = urldecode($logourl);
    $result2 = $xoopsDB->query('SELECT description FROM ' . $xoopsDB->prefix('mylinks_text') . " WHERE lid={$lid}");
    list($description) = $xoopsDB->fetchRow($result2);
    $GLOBALS['description'] = $myts->htmlSpecialChars($myts->stripSlashesGPC($description));

    echo '<h4>'
         . _MD_MYLINKS_WEBLINKSCONF
         . '</h4>'
         . "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>"
         . "  <tr><th colspan='2'>"
         . _MD_MYLINKS_MODLINK
         . "</th></tr>\n"
         . "  <tr class='odd'>\n"
         . "    <td>\n"
         . "      <form method='post' action='main.php' style='display: inline;'>\n"
         . "        <table>\n"
         . '          <tr><td>'
         . _MD_MYLINKS_LINKID
         . "</td><td style='font-weight: bold;'>{$lid}</td></tr>\n"
         . '          <tr><td>'
         . _MD_MYLINKS_SITETITLE
         . "</td><td><input type='text' name='title' value='{$title}' size='50' maxlength='100'></td></tr>\n"
         . '          <tr><td>'
         . _MD_MYLINKS_SITEURL
         . "</td><td><input type='text' name='url' value='{$url}' size='50' maxlength='250'></td></tr>\n"
         . "          <tr><td style='vertical-align: top;'>"
         . _MD_MYLINKS_DESCRIPTIONC
         . '</td><td>';
    xoopsCodeTarea('description', 60, 8);
    xoopsSmilies('description');
    echo "</td></tr>\n"
         . '          <tr><td>'
         . _MD_MYLINKS_CATEGORYC
         . '</td><td>'
         . ''
         . $myCatTree->makeSelBox('cid', 'title', '- ', $cid)
         . ''
         . "          </td></tr>\n"
         . '          <tr><td>'
         . _MD_MYLINKS_SHOTIMAGE
         . '</td><td>'
         . "<select size='1' name='logourl'>"
         . "<option value=' '>------</option>";
    foreach ($linkimg_array as $image) {
        $opt_selected = ($image == $logourl) ? ' selected' : '';
        echo "<option value='{$image}'{$opt_selected}>{$image}</option>";
    }
    echo '</select>' . "</td></tr>\n";

    $shotdir = '<strong>' . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/images/shots/</strong>';
    echo '          <tr><td>&nbsp;</td><td>'
         . sprintf(_MD_MYLINKS_SHOTMUST, $shotdir)
         . "</td></tr>\n"
         . '        </table>'
         . "        <br><br><input type='hidden' name='lid' value='{$lid}'>\n"
         . "        <input type='hidden' name='bknrptid' value='{$bknrptid}'>\n"
         . "        <input type='hidden' name='op' value='modLinkS'>\n"
         . "        <input type='submit' value='"
         . _MD_MYLINKS_MODIFY
         . "'>"
         . "      </form>\n"
         . "      <form action='main.php?op=delLink&amp;lid={$lid}' method='post' style='margin-left: 1em; display: inline;'><input type='submit' value='"
         . _DELETE
         . "'></form>\n"
         . "      <form action='main.php?op=linksConfigMenu' method='post' style='margin-left: 1em; display: inline;'><input type='submit' value='"
         . _CANCEL
         . "'></form>\n"
         . '      <hr>';

    $result5 = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_votedata') . " WHERE lid='{$lid}'");
    list($totalvotes) = $xoopsDB->fetchRow($result5);
    echo "      <table style='width: 100%;'>\n" . "        <tr><td colspan='7' style='font-weight: bold;'>" . sprintf(_MD_MYLINKS_TOTALVOTES, $totalvotes) . "<br><br></td></tr>\n";
    // Show Registered Users Votes
    $result5 = $xoopsDB->query('SELECT ratingid, ratinguser, rating, ratinghostname, ratingtimestamp FROM ' . $xoopsDB->prefix('mylinks_votedata') . " WHERE lid='{$lid}' AND ratinguser >0 ORDER BY ratingtimestamp DESC");
    $votes   = $xoopsDB->getRowsNum($result5);
    echo "        <tr><td colspan='7' style='font-weight: bold;'><br><br>" . sprintf(_MD_MYLINKS_USERTOTALVOTES, $votes) . "<br><br></td></tr>\n";
    echo "        <tr>\n"
         . '          <th>'
         . _MD_MYLINKS_USER
         . "  </th>\n"
         . '          <th>'
         . _MD_MYLINKS_IP
         . "  </th>\n"
         . '          <th>'
         . _MD_MYLINKS_RATING
         . "  </th>\n"
         . '          <th>'
         . _MD_MYLINKS_USERAVG
         . "  </th>\n"
         . '          <th>'
         . _MD_MYLINKS_TOTALRATE
         . "  </th>\n"
         . '          <th>'
         . _MD_MYLINKS_DATE
         . "  </th>\n"
         . '          <th>'
         . _DELETE
         . "</td>\n"
         . "        </tr>\n";
    if (0 == $votes) {
        echo "        <tr><td class='center' colspan='7'>" . _MD_MYLINKS_NOREGVOTES . "<br></td></tr>\n";
    }

    $x           = 0;
    $colorswitch = '#DDDDDD';

    while (list($ratingid, $ratinguser, $rating, $ratinghostname, $ratingtimestamp) = $xoopsDB->fetchRow($result5)) {
        //  $ratingtimestamp = formatTimestamp($ratingtimestamp);
        //Individual user information
        //v3.11 changed to let SQL do calculations instead of PHP
        $result2 = $xoopsDB->query('SELECT COUNT(), FORMAT(AVG(rating),2) FROM ' . $xoopsDB->prefix('mylinks_votedata') . " WHERE ratinguser = '$ratinguser'");
        list($uservotes, $useravgrating) = $xoopsDB->fetchRow($result2);
        //$useravgrating = ($rating2) ? sprintf("%01.2f", ($useravgrating / $uservotes)) : 0;
        /*
                $result2=$xoopsDB->query("SELECT rating FROM ".$xoopsDB->prefix("mylinks_votedata")." WHERE ratinguser = '$ratinguser'");
                $uservotes = $xoopsDB->getRowsNum($result2);
                $useravgrating = 0;
                while ( list($rating2) = $xoopsDB->fetchRow($result2) ) {
                    $useravgrating = $useravgrating + $rating2;
                }
                $useravgrating = sprintf("%01.2f", ($useravgrating / $uservotes));
        */
        $ratingusername = \XoopsUser::getUnameFromId($ratinguser);
        echo "        <tr>\n"
             . "          <td style='background-color: {$colorswitch};'>{$ratingusername}</td>\n"
             . "          <td style='background-color: {$colorswitch};'>{$ratinghostname}</td>\n"
             . "          <td style='background-color: {$colorswitch};'>{$rating}</td>\n"
             . "          <td style='background-color: {$colorswitch};'>{$useravgrating}</td>\n"
             . "          <td style='background-color: {$colorswitch};'>{$uservotes}</td>\n"
             . "          <td style='background-color: {$colorswitch};'>{$ratingtimestamp}</td>\n"
             . "          <td style='background-color: {$colorswitch}; text-align: center; font-weight: bold;'>\n"
             . "            <form action='main.php?op=delVote&amp;lid={$lid}&amp;rid={$ratingid}' method='post'><input type='submit' value='X'></form>\n"
             . "          </td>\n"
             . "        </tr>\n";
        ++$x;
        $colorswitch = ('#DDDDDD' === $colorswitch) ? '#FFFFFF' : '#DDDDDD';
    }
    // Show Unregistered Users Votes
    $result5 = $xoopsDB->query('SELECT ratingid, rating, ratinghostname, ratingtimestamp FROM ' . $xoopsDB->prefix('mylinks_votedata') . " WHERE lid ='{$lid}' AND ratinguser='0' ORDER BY ratingtimestamp DESC");
    $votes   = $xoopsDB->getRowsNum($result5);
    echo "        <tr><td colspan='7' style='font-weight: bold;'><br><br>"
         . sprintf(_MD_MYLINKS_ANONTOTALVOTES, $votes)
         . "<br><br></td></tr>\n"
         . "        <tr>\n"
         . "          <th colspan='2'>"
         . _MD_MYLINKS_IP
         . "  </th>\n"
         . "          <th colspan='3' style='font-weight: bold;'>"
         . _MD_MYLINKS_RATING
         . "  </th>\n"
         . "          <th style='font-weight: bold;'>"
         . _MD_MYLINKS_DATE
         . "  </th>\n"
         . "          <th style='text-align: center; font-weight: bold;'>"
         . _DELETE
         . "<br></th>\n"
         . "        </tr>\n";
    if (0 == $votes) {
        echo "        <tr><td colspan='7' class='center'>" . _MD_MYLINKS_NOUNREGVOTES . "<br></td></tr>\n";
    }
    $x           = 0;
    $colorswitch = '#DDDDDD';
    while (list($ratingid, $rating, $ratinghostname, $ratingtimestamp) = $xoopsDB->fetchRow($result5)) {
        $formatted_date = formatTimestamp($ratingtimestamp);
        echo "        <tr>\n"
             . "          <td colspan='2' style='background-color: {$colorswitch}'>{$ratinghostname}</td>\n"
             . "          <td colspan='3' style='background-color: {$colorswitch}'>{$rating}</td>\n"
             . "          <td style='background-color: {$colorswitch}'>{$formatted_date}</td>\n"
             . "          <td style='background-color: {$colorswitch} text-align: center; font-weight: bold;'>\n"
             . "            <form action='main.php?op=delVote&amp;lid={$lid}&amp;rid={$ratingid}' method='post'><input type='submit' value='X'></form>\n"
             . '          </td>'
             . '        </tr>';
        ++$x;
        $colorswitch = ('#DDDDDD' === $colorswitch) ? '#FFFFFF' : '#DDDDDD';
    }
    echo "        <tr><td colspan='7'>&nbsp;<br></td></tr>\n" . "      </table>\n" . "    </td>\n" . "  </tr>\n" . "</table>\n";
    require_once __DIR__ . '/admin_footer.php';
}

function delVote()
{
    global $xoopsDB;
    $lid = Mylinks\Utility::cleanVars($_POST, 'lid', 0, 'int', ['min' => 0]);
    $rid = Mylinks\Utility::cleanVars($_POST, 'rid', 0, 'int', ['min' => 0]);

    $sql    = sprintf('DELETE FROM `%s` WHERE ratingid = %u', $xoopsDB->prefix('mylinks_votedata'), $rid);
    $result = $xoopsDB->query($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    updaterating($lid);
    redirect_header('index.php', 2, _MD_MYLINKS_VOTEDELETED);
}

function listBrokenLinks()
{
    global $xoopsDB, $xoopsModule, $pathIcon16, $myts;

    $result           = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('mylinks_broken') . ' GROUP BY lid ORDER BY reportid DESC');
    $totalBrokenLinks = $xoopsDB->getRowsNum($result);
    xoops_cp_header();

    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=listBrokenLinks');
    $GLOBALS['xoTheme']->addStylesheet(Utility::getStylePath('mylinks.css', 'include'));
    //    echo "<link rel='stylesheet' href='" . $GLOBALS['xoops']->url('browse.php?modules/mylinks/include/mylinks.css') . "' type='text/css'>";

    echo "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n" . '  <tr><th>' . sprintf(_MD_MYLINKS_BROKENREPORTS, $totalBrokenLinks) . "<br></th></tr>\n" . "  <tr class='odd'><td>\n";

    if (0 == $totalBrokenLinks) {
        echo "    <span class='italic bold'>" . _MD_MYLINKS_NOBROKEN . '</span>';
    } else {
        $colorswitch = '#DDDDDD';
        echo "<img src='{$pathIcon16}/on.png'> = "
             . _MD_MYLINKS_IGNOREDESC
             . '<br>'
             . "<img src='{$pathIcon16}/edit.png'> = "
             . _MD_MYLINKS_EDITDESC
             . '<br>'
             . "<img src='{$pathIcon16}/delete.png'> = "
             . _MD_MYLINKS_DELETEDESC
             . '<br>'
             . "   <table class='center width100'>\n"
             //           ."      <tr><th colspan='6'>" . _MD_MYLINKS_DELETEDESC . "</th><tr>"
             . "      <tr>\n"
             . '        <th>'
             . _MD_MYLINKS_LINKNAME
             . "</th>\n"
             . '        <th>'
             . _MD_MYLINKS_REPORTER
             . "</th>\n"
             . '        <th>'
             . _MD_MYLINKS_LINKSUBMITTER
             . "</th>\n"
             . '        <th>'
             . _MD_MYLINKS_ACTIONS
             . "</th>\n"
             . "      </tr>\n";

        $formToken = $GLOBALS['xoopsSecurity']->getTokenHTML();

        while (list($reportid, $lid, $sender, $ip) = $xoopsDB->fetchRow($result)) {
            $result2 = $xoopsDB->query('SELECT title, url, submitter FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE lid={$lid}");
            if (0 != $sender) {
                $result3 = $xoopsDB->query('SELECT uname, email FROM ' . $xoopsDB->prefix('users') . " WHERE uid={$sender}");
                list($uname, $email) = $xoopsDB->fetchRow($result3);
            }
            list($title, $url, $ownerid) = $xoopsDB->fetchRow($result2);
            $title = $myts->stripSlashesGPC($title);
            //          $url=urldecode($url);
            $result4 = $xoopsDB->query('SELECT uname, email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='{$ownerid}'");
            list($owner, $owneremail) = $xoopsDB->fetchRow($result4);
            echo "      <tr>\n" . "        <td style='background-color: {$colorswitch}'><a href=$url target='_blank'>{$title}</a></td>\n";
            if ('' == $email) {
                echo "        <td style='background-color: {$colorswitch};'>{$sender} ({$ip})";
            } else {
                echo "        <td style='background-color: {$colorswitch};'><a href='mailto:{$email}'>{$uname}</a> ({$ip})";
            }
            echo "        </td>\n";
            if ('' == $owneremail) {
                echo "        <td style='background-color: {$colorswitch};'>{$owner}";
            } else {
                echo "        <td style='background-color: {$colorswitch};'><a href='mailto:{$owneremail}'>{$owner}</a>\n";
            }
            echo "        <td style='text-align: center; background-color: {$colorswitch};'>\n"
                 //                ."          <a href='main.php?op=ignoreBrokenLinks&amp;lid={$lid}'><img src=". $pathIcon16 ."/on.png alt='" . _AM_MYLINKS_IGNORE . "' title='" . _AM_MYLINKS_IGNORE . "'></a>\n"
                 //                ."          <a href='main.php?op=modLink&amp;lid={$lid}&amp;bknrptid={$reportid}'><img src=". $pathIcon16 ."/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>\n"
                 //                ."          <a href='main.php?op=delBrokenLinks&amp;lid={$lid}'><img src=". $pathIcon16 ."/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>\n"
                 . "          <form class='inline' action='"
                 . $_SERVER['SCRIPT_NAME']
                 . "' method='post'>\n"
                 . "             <input type='hidden' name='op' value='ignoreBrokenLinks'>\n"
                 . "             <input type='hidden' name='bknrptid' value='{$reportid}'>\n"
                 . "            {$formToken}\n"
                 . "            <input type='button' title='"
                 . _MD_MYLINKS_IGNOREDESC
                 . "' alt='"
                 . _AM_MYLINKS_IGNORE
                 . "' id='image-button-on' onclick='this.form.submit();'></input>\n"
                 . "          </form>\n"
                 . "          <form class='inline' action='"
                 . $_SERVER['SCRIPT_NAME']
                 . "'?op=modLink&amp;lid={$lid} method='get'>\n"
                 . "            <input type='hidden' name='op' value='modLink'>\n"
                 . "            <input type='hidden' name='bknrptid' value='{$reportid}'>\n"
                 . "            <input type='hidden' name='lid' value={$lid}>\n"
                 . "            <input type='button' title='"
                 . _MD_MYLINKS_EDITDESC
                 . "' alt='"
                 . _EDIT
                 . "' id='image-button-edit' onclick='this.form.submit();'></input>\n"
                 . "          </form>\n"
                 . "          <form class='inline' action='"
                 . $_SERVER['SCRIPT_NAME']
                 . "' method='post'>\n"
                 . "             <input type='hidden' name='op' value='delBrokenLinks'>\n"
                 . "             <input type='hidden' name='lid' value='{$lid}'>\n"
                 . "            {$formToken}\n"
                 . "            <input type='button' title='"
                 . _MD_MYLINKS_DELETEDESC
                 . "' alt='"
                 . _DELETE
                 . "' id='image-button-delete' onclick='this.form.submit();'></input>\n"
                 . "          </form>\n"
                 . "        </td>\n"
                 . "      </tr>\n";

            $colorswitch = ('#DDDDDD' === $colorswitch) ? '#FFFFFF' : '#DDDDDD';
        }
        echo "    </table>\n";
    }

    echo '</td></tr></table>';
    require_once __DIR__ . '/admin_footer.php';
}

function delBrokenLinks()
{
    global $xoopsDB;

    $lid = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);

    $sql    = sprintf('DELETE FROM `%s` WHERE lid = %u', $xoopsDB->prefix('mylinks_broken'), $lid);
    $result = $xoopsDB->queryF($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_NOBROKEN);
        exit();
    }

    $sql    = sprintf('DELETE FROM `%s` WHERE lid = %u', $xoopsDB->prefix('mylinks_links'), $lid);
    $result = $xoopsDB->queryF($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
    } else {
        Mylinks\Utility::show_message(_MD_MYLINKS_LINKDELETED);
    }
    exit();
}

function ignoreBrokenLinks()
{
    global $xoopsDB;

    $bknrptid = Mylinks\Utility::cleanVars($_POST, 'bknrptid', 0, 'int', ['min' => 0]);
    $sql      = sprintf('DELETE FROM `%s` WHERE reportid = %u', $xoopsDB->prefix('mylinks_broken'), $bknrptid);
    $result   = $xoopsDB->queryF($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
    } else {
        Mylinks\Utility::show_message(_MD_MYLINKS_BROKENDELETED);
    }
    exit();
}

function listModReq()
{
    global $xoopsDB, $myts, $xoopsModule;
    /** @var Mylinks\Helper $helper */
    $helper = Mylinks\Helper::getInstance();
    //    $from = '';
    //    $to = '';

    $result           = $xoopsDB->query('SELECT requestid, lid, cid, title, url, logourl, description, modifysubmitter FROM ' . $xoopsDB->prefix('mylinks_mod') . ' ORDER BY requestid');
    $totalModRequests = $xoopsDB->getRowsNum($result);
    xoops_cp_header();
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=listModReq');

    $categoryHandler = $helper->getHandler('Category');

    //echo "<h4>" . _MD_MYLINKS_WEBLINKSCONF . "</h4>\n";
    echo "<table class='outer' style='width: 100%; border-weight: 0px; margin: 1px;'>\n" . "  <tr class='even'><th>" . sprintf(_MD_MYLINKS_MODREQUESTS, $totalModRequests) . "</th></tr>\n" . "  <tr class='odd'>\n" . "    <td>\n";
    if ($totalModRequests > 0) {
        echo "  <table style='width: 95%;'>\n" . "    <tr>\n" . "      <td>\n";
        $lookup_lid = [];
        while (list($requestid, $lid, $cid, $title, $url, $logourl, $description, $submitterid) = $xoopsDB->fetchRow($result)) {
            $catObj                 = $categoryHandler->get($cid);
            $lookup_lid[$requestid] = $lid;
            $result2                = $xoopsDB->query('SELECT cid, title, url, logourl, submitter FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE lid='{$lid}'");
            list($origcid, $origtitle, $origurl, $origlogourl, $ownerid) = $xoopsDB->fetchRow($result2);
            $origCatObj = $categoryHandler->get($origcid);
            $result2    = $xoopsDB->query('SELECT description FROM ' . $xoopsDB->prefix('mylinks_text') . " WHERE lid='{$lid}'");
            list($origdescription) = $xoopsDB->fetchRow($result2);
            $result7      = $xoopsDB->query('SELECT uname, email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='{$submitterid}'");
            $result8      = $xoopsDB->query('SELECT uname, email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='{$ownerid}'");
            $cidtitle     = $catObj->getVar('title');
            $cidtitle     = $myts->htmlSpecialChars($cidtitle);
            $origcidtitle = $origCatObj->getVar('title');
            $origcidtitle = $myts->htmlSpecialChars($origcidtitle);
            /*
                        $cidtitle     = $catObj->getPathFromID();
                        $origcidtitle = $origCatObj->getPathFromID();
            */
            list($submitter, $submitteremail) = $xoopsDB->fetchRow($result7);
            list($owner, $owneremail) = $xoopsDB->fetchRow($result8);
            $title = $myts->htmlSpecialChars($title);
            $url   = $myts->htmlSpecialChars($url);
            //$url   = urldecode($url);

            // use original image file to prevent users from changing screen shots file
            $origlogourl = $myts->htmlSpecialChars($origlogourl);
            $logourl     = $origlogourl;

            //$logourl     = urldecode($logourl);
            $description = $myts->displayTarea($myts->stripSlashesGPC($description), 0);
            $origurl     = $myts->htmlSpecialChars($origurl);
            //$origurl     = urldecode($origurl);
            //$origlogourl = urldecode($origlogourl);
            $origdescription = $myts->displayTarea($myts->stripSlashesGPC($origdescription), 0);

            $from = $origdescription;
            $to   = $description;

            /* Load the lines of each file. */
            echo '<br><br> ==============================context<br><br>';
            /* Create the Diff object. */
            $diff = new Horde_Text_Diff('auto', [[$origdescription], [$description]]);

            /* Output the diff in unified format. */
            $renderer     = new Horde_Text_Diff_Renderer_Unified();
            $diff0unified = $renderer->render($diff);

            $renderer    = new Horde_Text_Diff_Renderer_Inline();
            $diff0inline = $renderer->render($diff);

            $renderer     = new Horde_Text_Diff_Renderer_Context();
            $diff0context = $renderer->render($diff);

            echo $diff0unified . ' <br><br>----------- unified<br><br>';
            echo $diff0inline . '<br><br>----- inline<br><br>';
            echo $diff0context . '<br><br>------  context<br><br>';

            //diff-multibyte
            /*
                        echo  '<br><br> ======== MULTIBYTE  ==========context<br><br>';
                        $opcodes = FineDiff::getDiffOpcodes($origdescription, $description );
                        $bingo1 =  FineDiffHTML::renderDiffToHTMLFromOpcodes($origdescription, $opcodes);
                        echo '<br>--------------<br>' . $bingo1;
            */
            echo '<br><br> ============== GWIKI ================context<br><br>';
            //gwiki
            $diff2 = new \XoopsModules\Mylinks\Diff\Gwiki\Diff();

            $body = $diff2->printPrettyDiff($origdescription, $description);
            echo $body;

            echo '<br><br> ============== STANDARD ================context<br><br>';

            $owner = ('' == $owner) ? 'administration' : $owner;
            echo "        <table style='border-width: 1px; border-color: black; padding: 5px; margin: auto; text-align: center; width: 800px;'>\n"
                 . "          <tr><td>\n"
                 . "            <table style='width: 100%; background-color: #DDDDDD'>\n"
                 . "              <tr>\n"
                 . "                <td style='vertical-align: top; width: 45%; font-weight: bold;'>"
                 . _MD_MYLINKS_ORIGINAL
                 . "</td>\n"
                 . "                <td rowspan='14' style='vertical-align: top; text-align: left; font-size: small;'><br>"
                 . _MD_MYLINKS_DESCRIPTIONC
                 . "<br>{$origdescription}</td>\n"
                 . "              </tr>\n"
                 . "              <tr><td style='vertical-align: top; width: 45%; font-size: small;'>"
                 . _MD_MYLINKS_SITETITLE
                 . "{$myts->stripSlashesGPC($origtitle)}</td></tr>\n"
                 . "              <tr><td style='vertical-align: top; width: 45%; font-size: small;'>"
                 . _MD_MYLINKS_SITEURL
                 . "{$origurl}</td></tr>\n"
                 . "              <tr><td style='vertical-align= top; width: 45%; font-size: small;'>"
                 . _MD_MYLINKS_CATEGORYC
                 . "{$origcidtitle}</td></tr>\n"
                 . "              <tr><td style='vertical-align: top; width: 45%; font-size: small;'>"
                 . _MD_MYLINKS_SHOTIMAGE
                 . '';
            if ($helper->getConfig('useshots') && !empty($origlogourl)) {
                echo "<img src='" . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/assets/images/shots/{$origlogourl}' style='width: " . $helper->getConfig('shotwidth') . ";'>";
            } else {
                echo '&nbsp;';
            }
            echo "</td></tr>\n"
                 . "        </table>\n"
                 . "      </td></tr>\n"
                 . "      <tr><td>\n"
                 . "        <table style='width: 100%; background-color: #DDDDDD'>\n"
                 . "          <tr>\n"
                 . "            <td style='vertical-align: top; width: 45%; font-weight: bold;'>"
                 . _MD_MYLINKS_PROPOSED
                 . "</td>\n"
                 . "            <td rowspan='14' style='vertical-align: top; text-align: left; font-size: small;'><br>"
                 . _MD_MYLINKS_DESCRIPTIONC
                 . "<br>{$description}<br><br></td>\n"
                 . "          </tr>\n"
                 . "          <tr><td style='vertical-align: top; width: 45%; font-size: small;'>"
                 . _MD_MYLINKS_SITETITLE
                 . "{$title}</td></tr>\n"
                 . "          <tr><td style='vertical-align: top; width: 45%; font-size: small;'>"
                 . _MD_MYLINKS_SITEURL
                 . "{$url}</td></tr>\n"
                 . "          <tr><td style='vertical-align: top; width: 45%; font-size: small;'>"
                 . _MD_MYLINKS_CATEGORYC
                 . "{$cidtitle}</td></tr>\n"
                 . "          <tr><td style='vertical-align: top; width: 45%; font-size: small;'>"
                 . _MD_MYLINKS_SHOTIMAGE
                 . '';
            if (1 == $helper->getConfig('useshots') && !empty($logourl)) {
                echo "<img src='" . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/assets/images/shots/{$logourl}' style='width: " . $helper->getConfig('shotwidth') . ";' alt=''>";
            } else {
                echo '&nbsp;';
            }
            echo "</td></tr>\n" . "        </table>\n" . "      </td></tr>\n" . "    </table>\n" . "    <table style='text-align: center; width: 800px; margin: auto;'>\n" . "      <tr>\n";
            if ('' == $submitteremail) {
                echo "      <td style='text-align: center; font-weight: bold;'>" . _MD_MYLINKS_SUBMITTER . "{$submitter}</td>\n";
            } else {
                echo "      <td style='text-align: center; font-size: small;'>" . _MD_MYLINKS_SUBMITTER . "<a href='mailto:{$submitteremail}'>{$submitter}</a></td>\n";
            }
            if ('' == $owneremail) {
                echo "      <td style='text-align: center; font-size: small;'>" . _MD_MYLINKS_OWNER . "{$owner}</td>\n";
            } else {
                echo "      <td style='text-align: center; font-size: small;'>" . _MD_MYLINKS_OWNER . "<a href='mailto:{$owneremail}'>{$owner}</a></td>\n";
            }
            echo "      <td style='text-align: center; font-size: small;'>\n"
                 //                ."        <form style='display: inline; margin-right: 1.5em;' action='main.php?op=changeModReq&amp;requestid={$requestid}' method='get'>\n"
                 . "        <form style='display: inline; margin-right: 1.5em;' action='main.php' method='post'>\n"
                 . "          <input type='hidden' name='op' value='changeModReq'>\n"
                 . "          <input type='hidden' name='requestid' value='{$requestid}'>\n"
                 . "          <input type='submit' value='"
                 . _MD_MYLINKS_APPROVE
                 . "'>\n"
                 . "        </form>\n"
                 //                ."        <form style='display: inline; margin-right: 1.5em;' action='main.php?op=modLink&amp;lid={$lid}' method='get'>\n"
                 . "        <form style='display: inline; margin-right: 1.5em;' action='main.php' method='get'>\n"
                 . "          <input type='hidden' name='op' value='modLink'>\n"
                 . "          <input type='hidden' name='lid' value='{$lid}'>\n"
                 . "          <input type='submit' value='"
                 . _EDIT
                 . "'></form>\n"
                 //                ."        <form style='display: inline;' action='main.php?op=ignoreModReq&amp;requestid={$requestid}' method='post'><input type='submit' value='" . _MD_MYLINKS_IGNORE . "'></form>\n"
                 . "        <form style='display: inline;' action='main.php' method='post'>\n"
                 . "          <input type='hidden' name='op' value='ignoreModReq'>\n"
                 . "          <input type='hidden' name='requestid' value='{$requestid}'>\n"
                 . "          <input type='submit' value='"
                 . _MD_MYLINKS_IGNORE
                 . "'>\n"
                 . "        </form>\n"
                 . "      </td>\n"
                 . "    </tr>\n"
                 . "  </table><br><br>\n";

            //            $from        = '';
            //            $to          = '';
            $granularity = 2;
            if (isset($_REQUEST['granularity']) && ctype_digit($_REQUEST['granularity'])) {
                $granularity = max(min((int)$_REQUEST['granularity'], 4), 0);
            }
            $rendered_diff = '';
            if (!empty($_REQUEST['from']) || !empty($_REQUEST['to'])) {
                if (!empty($_REQUEST['from'])) {
                    $from = $_REQUEST['from'];
                }
                if (!empty($_REQUEST['to'])) {
                    $to = $_REQUEST['to'];
                }
            } elseif (!empty($_REQUEST['sample'])) { // use sample text?
                // Sample text:
                // http://en.wikipedia.org/w/index.php?title=Universe&action=historysubmit&diff=414830579&oldid=378547111
                $from = file_get_contents('sample_from.txt');
                $to   = file_get_contents('sample_to.txt');
            }

            $from_len        = mb_strlen($from);
            $to_len          = mb_strlen($to);
            $use_stdlib_diff = !empty($_REQUEST['stdlib']) && ctype_digit($_REQUEST['stdlib']) && 1 === (int)$_REQUEST['stdlib'];

            //require_once 'Text/Diff.php';

            $start_time = gettimeofday(true);
            if ($use_stdlib_diff) {
                if ($granularity < 3) {
                    $delimiters = [
                        FineDiff::paragraphDelimiters,
                        FineDiff::sentenceDelimiters,
                        FineDiff::wordDelimiters,
                        FineDiff::characterDelimiters,
                        FineDiff::characterDelimiters,
                    ];
                    function extractFragments($text, $delimiter)
                    {
                        $text      = str_replace(["\n", "\r"], ["\1", "\2"], $text);
                        $delimiter = str_replace(["\n", "\r"], ["\1", "\2"], $delimiter);
                        if (empty($delimiter)) {
                            return str_split($text, 1);
                        }
                        $fragments = [];
                        $start     = $end = 0;
                        for (; ;) {
                            $end += strcspn($text, $delimiter, $end);
                            $end += strspn($text, $delimiter, $end);
                            if ($end === $start) {
                                break;
                            }
                            $fragments[] = mb_substr($text, $start, $end - $start);
                            $start       = $end;
                        }

                        return $fragments;
                    }

                    $from_fragments = extractFragments($from, $delimiters[$granularity]);
                    $to_fragments   = extractFragments($to, $delimiters[$granularity]);
                    $diff           = new Text_Diff('native', [$from_fragments, $to_fragments]);
                    $exec_time      = sprintf('%.3f sec', gettimeofday(true) - $start_time);
                    $edits          = [];
                    ob_start();
                    foreach ($diff->getDiff() as $edit) {
                        if ($edit instanceof Text_Diff_Op_copy) {
                            $orig    = str_replace(["\1", "\2"], ["\n", "\r"], implode('', $edit->orig));
                            $edits[] = new fineDiffCopyOp(mb_strlen($orig));
                            echo htmlentities($orig);
                        } elseif ($edit instanceof Text_Diff_Op_delete) {
                            $orig    = str_replace(["\1", "\2"], ["\n", "\r"], implode('', $edit->orig));
                            $edits[] = new fineDiffDeleteOp(mb_strlen($orig));
                            echo '<del>', htmlentities($orig), '</del>';
                        } elseif ($edit instanceof Text_Diff_Op_add) {
                            $final   = str_replace(["\1", "\2"], ["\n", "\r"], implode('', $edit->final));
                            $edits[] = new fineDiffInsertOp($final);
                            echo '<ins>', htmlentities($final), '</ins>';
                        } elseif ($edit instanceof Text_Diff_Op_change) {
                            $orig    = str_replace(["\1", "\2"], ["\n", "\r"], implode('', $edit->orig));
                            $final   = str_replace(["\1", "\2"], ["\n", "\r"], implode('', $edit->final));
                            $edits[] = new fineDiffReplaceOp(mb_strlen($orig), $final);
                            echo '<del>', htmlentities($orig), '</del>';
                            echo '<ins>', htmlentities($final), '</ins>';
                        }
                    }
                    $rendered_diff  = ob_get_clean();
                    $rendering_time = sprintf('%.3f sec', gettimeofday(true) - $start_time);
                } // character-level granularity not allowed
                else {
                    $edits          = false;
                    $exec_time      = '?';
                    $rendering_time = '?';
                    $rendered_diff  = '<span style="color:gray">Character-level granularity not allowed when using <code>Text_Diff</code>, due to performance issues.</span>';
                }
            } else {
                $granularityStacks = [
                    FineDiff::$paragraphGranularity,
                    FineDiff::$sentenceGranularity,
                    FineDiff::$wordGranularity,
                    FineDiff::$characterGranularity,
                    FineDiff::$characterGranularity,
                ];

                $diff           = new FineDiffHTML($from, $to, $granularityStacks[$granularity]);
                $edits          = $diff->getOps();
                $exec_time      = sprintf('%.3f sec', gettimeofday(true) - $start_time);
                $rendered_diff  = $diff->renderDiffToHTML((4 != $granularity));
                $rendering_time = sprintf('%.3f sec', gettimeofday(true) - $start_time);
            }

            //        $opcodes = FineDiff::getDiffOpcodes($from, $to);
            //        $to_text = FineDiff::renderToTextFromOpcodes($origdescription, $opcodes);

            $diff           = new FineDiffHTML($from, $to, $granularityStacks[$granularity]);
            $edits          = $diff->getOps();
            $exec_time      = sprintf('%.3f sec', gettimeofday(true) - $start_time);
            $rendered_diff  = $diff->renderDiffToHTML((4 != $granularity));
            $rendering_time = sprintf('%.3f sec', gettimeofday(true) - $start_time);

            if (false !== $edits) {
                $opcodes     = [];
                $opcodes_len = 0;
                foreach ($edits as $edit) {
                    $opcode      = $edit->getOpcode();
                    $opcodes_len += mb_strlen($opcode);
                    $opcode      = htmlentities($opcode);
                    if ($edit instanceof FineDiffCopyOp) {
                        $opcodes[] = (string)($opcode);
                    } elseif ($edit instanceof FineDiffDeleteOp) {
                        $opcodes[] = "<span class=\"del\">{$opcode}</span>";
                    } elseif ($edit instanceof FineDiffInsertOp) {
                        $opcodes[] = "<span class=\"ins\">{$opcode}</span>";
                    } else /* if ( $edit instanceof FineDiffReplaceOp ) */ {
                        $opcodes[] = "<span class=\"rep\">{$opcode}</span>";
                    }
                }
                $opcodes     = implode('', $opcodes);
                $opcodes_len = sprintf('%d bytes (%.1f %% of &quot;To&quot;)', $opcodes_len, $to_len ? $opcodes_len * 100 / $to_len : 0);
            } else {
                $opcodes     = '?';
                $opcodes_len = '?';
            }

            //    $granularity = 2;

            echo (string)($opcodes);
            echo '<br><br>=================================================<br><br>';
            echo $opcodes_len;
            echo '<br><br>=================================================<br><br>'; ?>


            <form action="main.php?op=listModReq" method="post">
                <div class="panecontainer"><p>From:</p>
                    <div><textarea name="from" class="pane"><?php

                            //                            $bingo = '<div><pre>';
                            $bingo .= '<span style="color:red">WARNING! Once these categories are set and users have entered data, you should not change them.</span>';
                            $bingo .= $from;
                            //                            $bingo .= '</pre></div>';
                            echo $bingo;

                            //                            echo htmlentities($from);?></textarea></div>

                </div>
                <div class="panecontainer"><p>To:</p>
                    <div><textarea name="to" class="pane"><?php echo htmlentities($to); ?></textarea></div>
                </div>
                <p id="params">Granularity:<input name="granularity" type="radio" value="0"<?php if (0 === $granularity) {
                        echo ' checked="checked"';
                    } ?>>&thinsp;Paragraph/lines&ensp;<input name="granularity" type="radio" value="1"<?php if (1 === $granularity) {
                        echo ' checked="checked"';
                    } ?>>&thinsp;Sentence&ensp;<input name="granularity" type="radio" value="2"<?php if (2 === $granularity) {
                        echo ' checked="checked"';
                    } ?>>&thinsp;Word&ensp;<input name="granularity" type="radio" value="3"<?php if (3 === $granularity) {
                        echo ' checked="checked"';
                    } ?>>&thinsp;Character&ensp;<input name="granularity" type="radio" value="4"<?php if (4 === $granularity) {
                        echo ' checked="checked"';
                    } ?>>&thinsp;Binary&emsp;<!-- <input name="XDEBUG_PROFILE" type="hidden" value=""> --><input type="submit" value="Compute diff">&emsp;<input name="stdlib" type="checkbox" value="1"<?php if ($use_stdlib_diff) {
                        echo ' checked="checked"';
                    } ?>><a href="http://pear.php.net/package/Text_Diff/"><code>Text_Diff</code></a> lib (for comparison purpose) <sup style="font-size:x-small"><a href="#notes">see notes</a></sup></p>
            </form>
            <div class="panecontainer"><p>Diff stats:</p>
                <div>
                    <div class="pane">
                        <b>Diff execution time:</b> <?php echo $exec_time; ?><br>
                        <b>Diff execution + rendering time:</b> <?php echo $rendering_time; ?><br>
                        <b>&quot;From&quot; size:</b> <?php echo $from_len; ?> bytes<br>
                        <b>&quot;To&quot; size:</b> <?php echo $to_len; ?> bytes<br>
                        <b>Diff opcodes size:</b> <?php echo $opcodes_len; ?><br>
                        <b>Diff opcodes (<span style="border:1px solid #ccc;display:inline-block;width:16px">&nbsp;</span>=copy, <span class="del" style="display:inline-block;width:16px">&nbsp;</span>=delete, <span class="ins" style="display:inline-block;width:16px">&nbsp;</span>=insert, <span
                                    class="rep" style="display:inline-block;width:16px">&nbsp;</span>=replace):</b>
                        <div style="margin:2px 0 2px 0;border:0;border-top:1px dotted #aaa;padding-top:4px;word-wrap:break-word"><?php echo $opcodes; ?></div>
                    </div>
                </div>
            </div>
            <div class="panecontainer"><p>Rendered Diff:&emsp;<span style="font-size:smaller">Show <input type="radio" name="htmldiffshow" onclick="setHTMLDiffVisibility('deletions');">Deletions only&ensp;<input type="radio" name="htmldiffshow" checked="checked" onclick="setHTMLDiffVisibility();">All&ensp;<input
                                type="radio" name="htmldiffshow" onclick="setHTMLDiffVisibility('insertions');">Insertions only</span></p>
                <div id="htmldiff">
                    <div class="pane" style="white-space:pre-wrap"><?php echo $rendered_diff; ?></div>
                </div>
            </div>
            <script type="text/javascript">
                <!--
                function setHTMLDiffVisibility(what) {
                    var htmldiffEl = document.getElementById('htmldiff');
                    if (what === 'deletions') {
                        htmldiffEl.className = 'onlyDeletions';
                    } else if (what === 'insertions') {
                        htmldiffEl.className = 'onlyInsertions';
                    } else {
                        htmldiffEl.className = '';
                    }
                }

                // -->
            </script>
            </div>

            <?php
        }

        echo '    </td></tr></table>';
    } else {
        echo '      <em>' . _MD_MYLINKS_NOMODREQ . "</em>\n";
    }
    echo "    </td>\n" . "  </tr>\n" . "</table>\n";

    echo $bingo;
    echo $from;
    echo $to;

    require_once __DIR__ . '/admin_footer.php';
}

function changeModReq()
{
    global $xoopsDB, $myts;

    $requestid = Mylinks\Utility::cleanVars($_POST, 'requestid', 0, 'int', ['min' => 0]);
    $query     = 'SELECT lid, cid, title, url, logourl, description FROM ' . $xoopsDB->prefix('mylinks_mod') . " WHERE requestid='{$requestid}'";
    $result    = $xoopsDB->query($query);
    while (list($lid, $cid, $title, $url, $logourl, $description) = $xoopsDB->fetchRow($result)) {
        $url         = addslashes($url);
        $logourl     = addslashes($logourl);
        $title       = addslashes($title);
        $description = addslashes($description);

        $sql    = sprintf("UPDATE `%s` SET cid = %u, title = '%s', url = '%s', logourl = '%s', status = 1, date = %u WHERE lid = %u", $xoopsDB->prefix('mylinks_links'), $cid, $title, $url, $logourl, time(), $lid);
        $result = $xoopsDB->query($sql);
        if (!$result) {
            Mylinks\Utility::show_message(_MD_MYLINKS_DBNOTUPDATED);
            exit();
        }
        $sql    = sprintf("UPDATE `%s` SET description = '%s' WHERE lid = %u", $xoopsDB->prefix('mylinks_text'), $description, $lid);
        $result = $xoopsDB->query($sql);
        if (!$result) {
            Mylinks\Utility::show_message(_MD_MYLINKS_DBNOTUPDATED);
            exit();
        }
        $sql = sprintf('DELETE FROM `%s` WHERE requestid = %u', $xoopsDB->prefix('mylinks_mod'), $requestid);
        $xoopsDB->query($sql);
        if (!$result) {
            Mylinks\Utility::show_message(_MD_MYLINKS_DBNOTUPDATED);
            exit();
        }
    }
    redirect_header('index.php', 2, _MD_MYLINKS_DBUPDATED);
}

function ignoreModReq()
{
    global $xoopsDB;

    $requestid = Mylinks\Utility::cleanVars($_POST, 'requestid', 0, 'int', ['min' => 0]);
    $sql       = sprintf('DELETE FROM `%s` WHERE requestid = %u', $xoopsDB->prefix('mylinks_mod'), $requestid);
    $result    = $xoopsDB->query($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_DBNOTUPDATED);
    } else {
        Mylinks\Utility::show_message(_MD_MYLINKS_MODREQDELETED);
    }
    exit();
}

function modLinkS()
{
    global $xoopsDB, $myts;

    $cid         = Mylinks\Utility::cleanVars($_POST, 'cid', 0, 'int', ['min' => 0]);
    $lid         = Mylinks\Utility::cleanVars($_POST, 'lid', 0, 'int', ['min' => 0]);
    $bknrptid    = Mylinks\Utility::cleanVars($_POST, 'bknrptid', 0, 'int', ['min' => 0]);
    $url         = Mylinks\Utility::cleanVars($_POST, 'url', '', 'string');
    $logourl     = Mylinks\Utility::cleanVars($_POST, 'logourl', '', 'string');
    $title       = Mylinks\Utility::cleanVars($_POST, 'title', '', 'string');
    $description = Mylinks\Utility::cleanVars($_POST, 'description', '', 'string');
    /*
        $url     = $myts->addSlashes($url);
        $logourl = $myts->addSlashes($_POST['logourl']);
        $title   = $myts->addSlashes($_POST['title']);
        $description = $myts->addSlashes($_POST['description']);
    */
    $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('mylinks_links') . " SET cid='{$cid}', title='{$title}', url='{$url}', logourl='{$logourl}', status='2', date=" . time() . " WHERE lid='{$lid}'");
    $result = $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('mylinks_text') . " SET description='{$description}' where lid='{$lid}'");
    if (!$result) {
        redirect_header('main.php', 2, _MD_MYLINKS_DBNOTUPDATED);
    }
    if ($bknrptid) {
        // edit came after following link from a broken report, so delete broken report too
        $sql    = sprintf('DELETE FROM `%s` WHERE reportid = %u', $xoopsDB->prefix('mylinks_broken'), $bknrptid);
        $result = $xoopsDB->query($sql);
        if (!$result) {
            Mylinks\Utility::show_message(_MD_MYLINKS_DBNOTUPDATED);
            exit();
        }
    }
    redirect_header('index.php', 1, _MD_MYLINKS_DBUPDATED);
}

function delLink()
{
    global $xoopsDB, $xoopsModule;
    $lid = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);

    $dbTables = ['links', 'text', 'votedata', 'broken', 'mod'];
    foreach ($dbTables as $thisTable) {
        $sql    = sprintf('DELETE FROM `%s` WHERE lid = %u', $xoopsDB->prefix("mylinks_{$thisTable}"), $lid);
        $result = $xoopsDB->query($sql);
        if (!$result) {
            Mylinks\Utility::show_message(_MD_MYLINKS_DBNOTUPDATED);
            exit();
        }
    }
    // delete comments & notifications
    xoops_comment_delete($xoopsModule->getVar('mid'), $lid);
    xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'link', $lid);

    redirect_header('index.php', 2, _MD_MYLINKS_LINKDELETED);
}

function modCat()
{
    global $xoopsDB, $myts, $xoopsModule;

    $cid = Mylinks\Utility::cleanVars($_GET, 'cid', 0, 'int', ['min' => 0]);
    xoops_cp_header();

    /** @var \XoopsModules\Mylinks\Helper $helper */
    $helper = \XoopsModules\Mylinks\Helper::getInstance();
    echo '<h4>' . _MD_MYLINKS_WEBLINKSCONF . "</h4>\n" . "<table class='outer' style='width: 100%; border-width: 0px; margin: 1px;'>\n" . '  <tr><th>' . _MD_MYLINKS_MODCAT . "<br></th></tr>\n" . "  <tr class='odd'>\n" . "    <td>\n";
    $categoryHandler = $helper->getHandler('Category');
    $catObj            = $categoryHandler->get($cid);

    if (isset($catObj) && is_object($catObj)) {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('cid', $cid, '!='));
        $catListObjs = $categoryHandler->getAll($criteria);
        $catListTree = new \XoopsObjectTree($catListObjs, 'cid', 'pid');

        $title  = $myts->htmlSpecialChars($catObj->getVar('title'));
        $imgurl = $myts->htmlSpecialChars($catObj->getVar('imgurl'), 'n');
        $pid    = $catObj->getVar('pid');
        echo "      <form action='main.php' method='post'>" . _MD_MYLINKS_TITLEC . "\n" . "        <input type='text' name='title' value='{$title}' size='51' maxlength='50'>\n" . "        <br><br>\n";
        if (0 == $catObj->getVar('pid')) {
            echo '        ' . _MD_MYLINKS_IMGURLMAIN . "<br>\n" . "        <input type='text' name='imgurl' value='{$imgurl}' size='100' maxlength='150'>\n" . "        <br><br>\n";
        }
        echo '        '
             . _MD_MYLINKS_PARENT
             . "&nbsp;\n"
             . '        '
             . $catListTree->makeSelBox('pid', 'title', '- ', $pid, true)
             . "\n"
             . "        <br>\n"
             . "        <input type='hidden' name='cid' value='{$cid}'>\n"
             . "        <input type='hidden' name='op' value='modCatS'><br>\n"
             . "        <input type='submit' value='"
             . _MD_MYLINKS_SAVE
             . "'>\n"
             . "        <input type='button' value='"
             . _DELETE
             . "' onclick=\"location='main.php?pid={$pid}&amp;cid={$cid}&amp;op=delCat'\">&nbsp;\n"
             . "        <input type='button' value='"
             . _CANCEL
             . "' onclick=\"javascript:history.go(-1)\">\n"
             . "      </form>\n";
    } else {
        echo '  <tr><td>' . _MD_MYLINKS_CIDERROR . "</td></tr>\n" . "  <tr><td><input type='button' value='" . _BACK . "' onclick=\"javascript:history.go(-1)\"></td></tr>\n";
    }
    echo "    </td>\n" . "  </tr>\n" . "</table>\n";
    require_once __DIR__ . '/admin_footer.php';
}

function modCatS()
{
    global $xoopsDB, $myts, $xoopsModule;
    /** @var \XoopsModules\Mylinks\Helper $helper */
    $helper = \XoopsModules\Mylinks\Helper::getInstance();

    $cid    = Mylinks\Utility::cleanVars($_POST, 'cid', 0, 'int', ['min' => 0]);
    $imgurl = Mylinks\Utility::cleanVars($_POST, 'imgurl', '', 'string');
    $title  = Mylinks\Utility::cleanVars($_POST, 'title', '', 'string');
    //    $title  = $myts->addSlashes($title);

    if (empty($title)) {
        redirect_header('index.php', 3, _MD_MYLINKS_ERRORTITLE);
    }

    //    $imgurl = $myts->addSlashes($imgurl);
    $updateInfo = [
        'pid'    => \Xmf\Request::getInt('pid', 0, 'POST'),
        //                        'title'  =>  $myts->addSlashes($_POST['title']),
        'title'  => $title,
        'imgurl' => $imgurl,
    ];

    $categoryHandler = $helper->getHandler('Category');
    $catObj            = $categoryHandler->get($cid);

    if (isset($catObj) && is_object($catObj)) {
        $catObj->setVars($updateInfo);
        $result = $categoryHandler->insert($catObj);
    } else {
        $result = false;
    }

    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_DBNOTUPDATED);
        exit();
    }
    redirect_header('index.php', 2, _MD_MYLINKS_DBUPDATED);
}

function delCat()
{
    global $xoopsDB, $myCatTree, $xoopsModule, $xoopsUser;
    /** @var \XoopsModules\Mylinks\Helper $helper */
    $helper = \XoopsModules\Mylinks\Helper::getInstance();

    $cid = Mylinks\Utility::cleanVars($_REQUEST, 'cid', 0, 'int', ['min' => 0]);
    $ok  = Mylinks\Utility::cleanVars($_POST, 'ok', 0, 'int', ['min' => 0, 'max' => 1]);

    if (1 == $ok) {
        /**
         * nickname code:
         *
         *  get all subcategories
         *  get all links in these categories/subcategories
         *  get all links in category & subcategories
         *  delete all links in links, text, votedata, broken, & mod db tables that are in any of these categories
         *  delete all comments and notifications for the links that have been deleted
         *  delete category and all subcategories from category db table
         *  delete all notifications for the categories that have been deleted
         */
        $categoryHandler = $helper->getHandler('Category');

        //get all subcategories under the specified category
        $catObjArr = $myCatTree->getAllChild($cid);
        $cidArray  = [];
        foreach ($catObjArr as $catObj) {
            $cidArray[] = $catObj->getVar('cid');
        }

        array_push($cidArray, $cid); //add this category id to the array
        $catIDs   = implode(',', $cidArray);
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('cid', '(' . (int)$cid . ',' . $catIDs . ')', 'IN'));

        // get list ids in any of these categories
        $sql    = sprintf('SELECT lid FROM `%s` WHERE cid IN %s', $xoopsDB->prefix('mylinks_links'), "({$catIDs})");
        $result = $xoopsDB->query($sql);
        if (!$result) {
            Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
            exit();
        }
        $lidArray = $xoopsDB->fetchArray($result);

        // delete any links, link notifications and link comments from the database tables
        if ($lidArray) {
            $linkIDs  = '(' . implode(',', $lidArray) . ')';
            $dbTables = ['links', 'text', 'votedata', 'broken', 'mod'];
            foreach ($dbTables as $thisTable) {
                $sql    = sprintf('DELETE FROM `%s` WHERE lid IN %s', $xoopsDB->prefix("mylinks_{$thisTable}"), $linkIDs);
                $result = $xoopsDB->query($sql);
                if (!$result) {
                    Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
                    exit();
                }
            }
            // remove any notifications and comments for these listings
            foreach ($lidArray as $this_lid) {
                xoops_comment_delete($xoopsModule->getVar('mid'), $this_lid);
                xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'link', $this_lid);
            }
        }
        // delete category and all subcategories from database
        if (!$categoryHandler->deleteAll($criteria)) {
            redirect_header('main.php', 2, _MD_MYLINKS_NORECORDFOUND);
        }

        // delete the notification settings for each (sub)category
        foreach ($cidArray as $key => $id) {
            xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'category', $id);
        }

        redirect_header('index.php', 2, _MD_MYLINKS_CATDELETED);
    } else {
        xoops_cp_header();
        xoops_confirm(['op' => 'delCat', 'cid' => $cid, 'ok' => 1], 'main.php', _MD_MYLINKS_WARNING);
        require_once __DIR__ . '/admin_footer.php';
    }
}

function delNewLink()
{
    global $xoopsDB, $xoopsModule;
    $lid = Mylinks\Utility::cleanVars($_GET, 'lid', 0, 'int', ['min' => 0]);

    $sql    = sprintf('DELETE FROM `%s` WHERE lid = %u', $xoopsDB->prefix('mylinks_links'), $lid);
    $result = $xoopsDB->query($sql);
    if (!$result) {
        redirect_header('main.php', 2, _MD_MYLINKS_NORECORDFOUND);
    }
    $sql    = sprintf('DELETE FROM `%s` WHERE lid = %u', $xoopsDB->prefix('mylinks_text'), $lid);
    $result = $xoopsDB->query($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    // delete comments
    xoops_comment_delete($xoopsModule->getVar('mid'), $lid);
    // delete notifications
    xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'link', $lid);
    redirect_header('index.php', 2, _MD_MYLINKS_LINKDELETED);
}

function addCat()
{
    global $xoopsDB, $myts, $xoopsModule;
    /** @var \XoopsModules\Mylinks\Helper $helper */
    $helper = \XoopsModules\Mylinks\Helper::getInstance();

    $pid    = Mylinks\Utility::cleanVars($_POST, 'pid', 0, 'int', ['min' => 0]);
    $title  = Mylinks\Utility::cleanVars($_POST, 'title', '', 'string');
    $imgurl = Mylinks\Utility::cleanVars($_POST, 'imgurl', '', 'string');
    /*
        $title  = $myts->addSlashes($title);
        $imgurl = $myts->addSlashes($imgurl);
    */
    if (empty($title)) {
        redirect_header('index.php', 2, _MD_MYLINKS_ERRORTITLE);
    }

    $newCatVars = [
        'pid'    => $pid,
        'title'  => $title,
        'imgurl' => $imgurl,
    ];

    $categoryHandler = $helper->getHandler('Category');
    $newCatObj         = $categoryHandler->create();
    $newCatObj->setVars($newCatVars);
    $newCatId = $categoryHandler->insert($newCatObj);
    if ($newCatId) {
        //now update notification handler & trigger new cat added event
        $tags                  = [];
        $tags['CATEGORY_NAME'] = $title;
        $tags['CATEGORY_URL']  = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/viewcat.php?cid=' . $newCatId;
        $notificationHandler   = xoops_getHandler('notification');
        $notificationHandler->triggerEvent('global', 0, 'new_category', $tags);
        redirect_header('index.php', 2, _MD_MYLINKS_NEWCATADDED);
    } else {
        redirect_header('index.php', 2, _MD_MYLINKS_DBNOTUPDATED);
    }
}

function importCats()
{
    global $xoopsDB, $xoopsModule, $xoopsConfig, $myts;
    /** @var \XoopsModules\Mylinks\Helper $helper */
    $helper = \XoopsModules\Mylinks\Helper::getInstance();

    $ok = Mylinks\Utility::cleanVars($_POST, 'ok', 0, 'int', ['min' => 0, 'max' => 1]);
    if (1 == $ok) {
        if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/sql/mylinks_cat.dat')) {
            $importFile = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/sql/mylinks_cat.dat';
        } else {
            $importFile = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/english/sql/mylinks_cat.dat';
        }

        if (file_exists($importFile)) {
            /* the following will not work on some shared servers even though it's the most efficient
            $sql = "LOAD DATA INFILE '{$importFile}' INTO TABLE " . $xoopsDB->prefix('mylinks_cat') . " FIELDS TERMINATED BY ',' IGNORE 1 LINES";
            $result = $xoopsDB->query($sql);
            */

            if (false !== ($handle = fopen($importFile, 'r'))) {
                // set 1000 to 0 in the following line if input line is truncated
                while (false !== ($data = fgetcsv($handle, 1000, ','))) {
                    $sql    = sprintf("INSERT INTO `%s` (cid, pid, title, imgurl) VALUES (%u, %u, '%s', '%s')", $xoopsDB->prefix('mylinks_cat'), (int)$data[0], (int)$data[1], $myts->addSlashes($data[2]), $myts->addSlashes($data[3]));
                    $result = $xoopsDB->query($sql);
                    if (!$result) {
                        Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
                        exit();
                    }
                }
                fclose($handle);
                redirect_header('index.php', 2, _MD_MYLINKS_CATSIMPORTED);
            } else {
                // problem importing categories
                $categoryHandler = $helper->getHandler('Category');
                $result            = $categoryHandler->getAll();
                if (count($result)) {
                    $result = $categoryHandler->deleteAll();  // empty the dB table from partial import
                }
                redirect_header('index.php', 2, _MD_MYLINKS_CATSNOTIMPORTED);
            }
        } else {  //exit somewhat gracefully if import file not found
            redirect_header('index.php', 2, sprintf(_MD_MYLINKS_IMPORTFILENOTFOUND, $importFile));
        }
        exit();
    }
    xoops_cp_header();
    xoops_confirm(['op' => 'importCats', 'ok' => 1], 'main.php', _MD_MYLINKS_CATWARNING);
    require_once __DIR__ . '/admin_footer.php';
}

function addLink()
{
    global $xoopsDB, $myts, $xoopsUser, $xoopsModule;

    /** @var \XoopsModules\Mylinks\Helper $helper */
    $helper = \XoopsModules\Mylinks\Helper::getInstance();

    $cid         = Mylinks\Utility::cleanVars($_POST, 'cid', 0, 'int', ['min' => 0]);
    $url         = Mylinks\Utility::cleanVars($_POST, 'url', '', 'string');
    $logourl     = Mylinks\Utility::cleanVars($_POST, 'logourl', '', 'string');
    $title       = Mylinks\Utility::cleanVars($_POST, 'title', '', 'string');
    $description = Mylinks\Utility::cleanVars($_POST, 'descarea', '', 'string');
    /*
        $url           = $myts->addSlashes($url);
        $logourl       = $myts->addSlashes($logourl);
        $title         = $myts->addSlashes($title);
        $description   = $myts->addSlashes($description);
    */
    $submitter = $xoopsUser->uid();
    $result    = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('mylinks_links') . " WHERE url='{$url}'");
    list($numrows) = $xoopsDB->fetchRow($result);
    $errormsg = [];
    $error    = false;
    if ($numrows > 0) {
        $errormsg[] = "<h4 style='color: #FF0000'>" . _MD_MYLINKS_ERROREXIST . '</h4>';
        $error      = true;
    }
    if ('' == $title) {  // check if title exists
        $errormsg[] = "<h4 style='color: #FF0000'>" . _MD_MYLINKS_ERRORTITLE . '</h4>';
        $error      = true;
    }
    if ('' == $url) {  // check if url exists
        $errormsg[] = "<h4 style='color: #FF0000'>" . _MD_MYLINKS_ERRORURL . '</h4>';
        $error      = true;
    }
    if ('' == $description) { // check if description exists
        $errormsg[] = "<h4 style='color: #FF0000'>" . _MD_MYLINKS_ERRORDESC . '</h4>';
        $error      = true;
    }
    if ($error) {
        xoops_cp_header();
        $displayMsg = implode('<br>', $errormsg);
        echo "<div class='center;'><fieldset>{$displayMsg}</fieldset></div>\n";
        xoops_cp_footer();
        exit();
    }

    $newid  = $xoopsDB->genId($xoopsDB->prefix('mylinks_links') . '_lid_seq');
    $sql    = sprintf("INSERT INTO `%s` (lid, cid, title, url, logourl, submitter, STATUS, DATE, hits, rating, votes, comments) VALUES (%u, %u, '%s', '%s', '%s', %u, %u, %u, %u, %u, %u, %u)", $xoopsDB->prefix('mylinks_links'), $newid, $cid, $title, $url, $logourl, $submitter, 1, time(), 0, 0, 0, 0);
    $result = $xoopsDB->query($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    if (0 == $newid) {
        $newid = $xoopsDB->getInsertId();
    }
    $sql    = sprintf("INSERT INTO `%s` (lid, description) VALUES (%u, '%s')", $xoopsDB->prefix('mylinks_text'), $newid, $description);
    $result = $xoopsDB->query($sql);
    if (!$result) {
        Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    $tags              = [];
    $tags['LINK_NAME'] = $title;
    $tags['LINK_URL']  = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/singlelink.php?cid={$cid}&amp;lid={$newid}";

    $categoryHandler     = $helper->getHandler('Category');
    $catObj                = $categoryHandler->get($cid);
    $tags['CATEGORY_NAME'] = $catObj->getVar('title');
    unset($catObj, $categoryHandler);

    $tags['CATEGORY_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/viewcat.php?cid={$cid}";
    $notificationHandler  = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('global', 0, 'new_link', $tags);
    $notificationHandler->triggerEvent('category', $cid, 'new_link', $tags);
    redirect_header('main.php?op=linksConfigMenu', 2, _MD_MYLINKS_NEWLINKADDED);
}

function approve()
{
    global $xoopsDB, $myts, $xoopsModule;
    /** @var \XoopsModules\Mylinks\Helper $helper */
    $helper = \XoopsModules\Mylinks\Helper::getInstance();

    $lid         = Mylinks\Utility::cleanVars($_POST, 'lid', 0, 'int', ['min' => 0]);
    $cid         = Mylinks\Utility::cleanVars($_POST, 'cid', 0, 'int', ['min' => 0]);
    $title       = Mylinks\Utility::cleanVars($_POST, 'title', '', 'string');
    $url         = Mylinks\Utility::cleanVars($_POST, 'url', '', 'string');
    $logourl     = Mylinks\Utility::cleanVars($_POST, 'logourl', '', 'string');
    $description = Mylinks\Utility::cleanVars($_POST, 'description', '', 'string');
    /*
        $url         = $myts->addSlashes($url);
        $logourl     = $myts->addSlashes($logourl);
        $title       = $myts->addSlashes($title);
        $description = $myts->addSlashes($description);
    */
    $query  = 'UPDATE ' . $xoopsDB->prefix('mylinks_links') . " set cid='{$cid}', title='{$title}', url='{$url}', logourl='{$logourl}', status='1', date=" . time() . " WHERE lid='{$lid}'";
    $result = $xoopsDB->query($query);
    if ($result) {
        $query  = 'UPDATE ' . $xoopsDB->prefix('mylinks_text') . " SET description='{$description}' WHERE lid='{$lid}'";
        $result = $xoopsDB->query($query);
        if (!$result) {
            Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
            exit();
        }
    } else {
        Mylinks\Utility::show_message(_MD_MYLINKS_NORECORDFOUND);
        exit();
    }
    $tags              = [];
    $tags['LINK_NAME'] = $title;
    $tags['LINK_URL']  = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/singlelink.php?cid={$cid}&amp;lid={$lid}";
    $categoryHandler = $helper->getHandler('Category');
    $catObj            = $categoryHandler->get($cid);
    /*
    $sql = "SELECT title FROM " . $xoopsDB->prefix("mylinks_cat") . " WHERE cid=" . $cid;
    $result = $xoopsDB->query($sql);
    $row = $xoopsDB->fetchArray($result);
    $tags['CATEGORY_NAME'] = $row['title'];
    */
    if ($catObj) {
        $tags['CATEGORY_NAME'] = $catObj->getVar('title');
        $tags['CATEGORY_URL']  = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/viewcat.php?cid={$cid}";
        $notificationHandler   = xoops_getHandler('notification');
        $notificationHandler->triggerEvent('global', 0, 'new_link', $tags);
        $notificationHandler->triggerEvent('category', $cid, 'new_link', $tags);
        $notificationHandler->triggerEvent('link', $lid, 'approve', $tags);
        redirect_header('index.php', 2, _MD_MYLINKS_NEWLINKADDED);
    } else {
        redirect_header('index.php', 2, _MD_MYLINKS_DBNOTUPDATED);
    }
}

$op = Mylinks\Utility::cleanVars($_REQUEST, 'op', 'main', 'string');

switch ($op) {
    case 'delNewLink':
        delNewLink();
        break;
    case 'approve':
        approve();
        break;
    case 'addCat':
        addCat();
        break;
    case 'importCats':
        importCats();
        break;
    case 'addLink':
        addLink();
        break;
    case 'listBrokenLinks':
        listBrokenLinks();
        break;
    case 'delBrokenLinks':
        delBrokenLinks();
        break;
    case 'ignoreBrokenLinks':
        ignoreBrokenLinks();
        break;
    case 'listModReq':
        listModReq();
        break;
    case 'changeModReq':
        changeModReq();
        break;
    case 'ignoreModReq':
        ignoreModReq();
        break;
    case 'delCat':
        delCat();
        break;
    case 'modCat':
        modCat();
        break;
    case 'modCatS':
        modCatS();
        break;
    case 'modLink':
        modLink();
        break;
    case 'modLinkS':
        modLinkS();
        break;
    case 'delLink':
        delLink();
        break;
    case 'delVote':
        delVote();
        break;
    case 'linksConfigMenu':
    default:
        linksConfigMenu();
        break;
    case 'listNewLinks':
        listNewLinks();
        break;
    case 'main':
        break;
}
