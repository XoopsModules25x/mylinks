<?php
// ------------------------------------------------------------------------- //
//                              mytplsadmin.php                              //
//               - XOOPS templates admin for each modules -                  //
//                          GIJOE <http://www.peak.ne.jp>                   //
// ------------------------------------------------------------------------- //

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once __DIR__ . '/admin_header.php';
//require_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/class/admin.php";
//require_once  dirname(__DIR__) . '/include/gtickets.php';
require_once XOOPS_ROOT_PATH . '/class/template.php';

// initials
$xoops_system_path = XOOPS_ROOT_PATH . '/modules/system';
$db                = \XoopsDatabaseFactory::getDatabaseConnection();
$myts              = \MyTextSanitizer::getInstance();

// determine language
$language = $xoopsConfig['language'];
if (!file_exists("{$xoops_system_path}/language/{$language}/admin/tplsets.php")) {
    $language = 'english';
}

// load language constants
// to prevent from notice that constants already defined
$error_reporting_level = error_reporting(0);
require_once "{$xoops_system_path}/constants.php";
require_once "{$xoops_system_path}/language/{$language}/admin.php";
require_once "{$xoops_system_path}/language/{$language}/admin/tplsets.php";
error_reporting($error_reporting_level);

// check $xoopsModule
if (!is_object($xoopsModule)) {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

// set target_module if specified by $_GET['dirname']
/** @var \XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
if (!empty($_GET['dirname'])) {
    $target_module = $moduleHandler->getByDirname($_GET['dirname']);
}

if (!empty($target_module) && is_object($target_module)) {
    // specified by dirname (for tplsadmin as an independent module)
    $target_mid         = $target_module->getVar('mid');
    $target_dirname     = $target_module->getVar('dirname');
    $target_dirname4sql = addslashes($target_dirname);
    $target_mname       = $target_module->getVar('name') . '&nbsp;' . sprintf('(%2.2f)', $target_module->getVar('version') / 100.0);
    $query4redirect     = '?dirname=' . urlencode(strip_tags($_GET['dirname']));
} else {
    // not specified by dirname (for 3rd party modules as mytplsadmin)
    $target_mid         = $xoopsModule->getVar('mid');
    $target_dirname     = $xoopsModule->getVar('dirname');
    $target_dirname4sql = addslashes($target_dirname);
    $target_mname       = $xoopsModule->getVar('name');
    $query4redirect     = '';
}

// check access right (needs system_admin of tplset)
$grouppermHandler = xoops_getHandler('groupperm');
if (!$grouppermHandler->checkRight('system_admin', XOOPS_SYSTEM_TPLSET, $xoopsUser->getGroups())) {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

//**************//
// POST stages  //
//**************//

// Newly DB template clone (all of module)
if (!empty($_POST['clone_tplset_do']) && !empty($_POST['clone_tplset_from']) && !empty($_POST['clone_tplset_to'])) {
    // Ticket Check
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(XOOPS_URL . '/', 3, $GLOBALS['xoopsSecurity']->getErrors());
    }

    $tplset_from = $myts->stripSlashesGPC($_POST['clone_tplset_from']);
    $tplset_to   = $myts->stripSlashesGPC($_POST['clone_tplset_to']);

    //TODO: move text strings to language files
    // check tplset_name "from" and "to"
    if (!preg_match('/^[0-9A-Za-z_-]{1,16}$/', $_POST['clone_tplset_from'])) {
        exit('A wrong template name is specified.');
    }
    if (!preg_match('/^[0-9A-Za-z_-]{1,16}$/', $_POST['clone_tplset_to'])) {
        exit('A wrong template name is specified.');
    }
    list($is_exist) = $db->fetchRow($db->query('SELECT COUNT(*) FROM ' . $db->prefix('tplfile') . " WHERE tpl_tplset='" . addslashes($tplset_to) . "'"));
    if ($is_exist) {
        exit('The template already exists.');
    }
    list($is_exist) = $db->fetchRow($db->query('SELECT COUNT(*) FROM ' . $db->prefix('tplset') . " WHERE tplset_name='" . addslashes($tplset_to) . "'"));
    if ($is_exist) {
        exit('The template already exists.');
    }
    // insert tplset table
    $db->query('INSERT INTO ' . $db->prefix('tplset') . " SET tplset_name='" . addslashes($tplset_to) . "', tplset_desc='Created by tplsadmin', tplset_created=UNIX_TIMESTAMP()");
    copy_templates_db2db($tplset_from, $tplset_to, "tpl_module='$target_dirname4sql'");
    redirect_header("mytplsadmin.php?dirname={$target_dirname}", 1, _MD_MYLINKS_DBUPDATED);
}

// DB to DB template copy (checked templates)
if (is_array(@$_POST['copy_do'])) {
    foreach ($_POST['copy_do'] as $tplset_from_tmp => $val) {
        if (!empty($val)) {
            // Ticket Check
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header(XOOPS_URL . '/', 3, $GLOBALS['xoopsSecurity']->getErrors());
            }

            $tplset_from = $myts->stripSlashesGPC($tplset_from_tmp);
            if (empty($_POST['copy_to'][$tplset_from]) || $_POST['copy_to'][$tplset_from] == $tplset_from) {
                exit('Specify valid tplset.');
            }
            if (empty($_POST["{$tplset_from}_check"])) {
                exit('No template is specified');
            }
            $tplset_to = $myts->stripSlashesGPC($_POST['copy_to'][$tplset_from]);
            foreach ($_POST["{$tplset_from}_check"] as $tplfile_tmp => $val) {
                if (empty($val)) {
                    continue;
                }
                $tplfile = $myts->stripSlashesGPC($tplfile_tmp);
                copy_templates_db2db($tplset_from, $tplset_to, "tpl_file='" . addslashes($tplfile) . "'");
            }
            redirect_header("mytplsadmin.php?dirname={$target_dirname}", 1, _MD_MYLINKS_DBUPDATED);
        }
    }
}

// File to DB template copy (checked templates)
if (!empty($_POST['copyf2db_do'])) {
    // Ticket Check
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(XOOPS_URL . '/', 3, $GLOBALS['xoopsSecurity']->getErrors());
    }

    if (empty($_POST['copyf2db_to'])) {
        exit('Specify valid tplset.');
    }
    if (empty($_POST['basecheck'])) {
        exit('No template is specified');
    }
    $tplset_to = $myts->stripSlashesGPC($_POST['copyf2db_to']);
    foreach ($_POST['basecheck'] as $tplfile_tmp => $val) {
        if (empty($val)) {
            continue;
        }
        $tplfile = $myts->stripSlashesGPC($tplfile_tmp);
        copy_templates_f2db($tplset_to, "tpl_file='" . addslashes($tplfile) . "'");
    }
    redirect_header('mytplsadmin.php?dirname=' . $target_dirname, 1, _MD_MYLINKS_DBUPDATED);
}

// DB template remove (checked templates)
if (is_array(@$_POST['del_do'])) {
    foreach ($_POST['del_do'] as $tplset_from_tmp => $val) {
        if (!empty($val)) {
            // Ticket Check
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header(XOOPS_URL . '/', 3, $GLOBALS['xoopsSecurity']->getErrors());
            }

            $tplset_from = $myts->stripSlashesGPC($tplset_from_tmp);
            if ('default' === $tplset_from) {
                exit("You can't remove 'default' template.");
            }
            foreach ($_POST["{$tplset_from}_check"] as $tplfile_tmp => $val) {
                if (empty($val)) {
                    continue;
                }
                $tplfile = $myts->stripSlashesGPC($tplfile_tmp);
                $result  = $db->query('SELECT tpl_id FROM ' . $db->prefix('tplfile') . " WHERE tpl_tplset='" . addslashes($tplset_from) . "' AND tpl_file='" . addslashes($tplfile) . "'");
                while (list($tpl_id) = $db->fetchRow($result)) {
                    $tpl_id = (int)$tpl_id;
                    $db->query('DELETE FROM ' . $db->prefix('tplfile') . " WHERE tpl_id=$tpl_id");
                    $db->query('DELETE FROM ' . $db->prefix('tplsource') . " WHERE tpl_id=$tpl_id");
                    //          xoops_template_touch( $tpl_id ); // TODO
                }
            }
            redirect_header('mytplsadmin.php?dirname=' . $target_dirname, 1, _MD_MYLINKS_DBUPDATED);
        }
    }
}

//************//
// GET stage  //
//************//

// get tplsets
$sql             = 'SELECT DISTINCT tpl_tplset FROM ' . $db->prefix('tplfile') . " ORDER BY tpl_tplset='default' DESC,tpl_tplset";
$srs             = $db->query($sql);
$tplsets         = [];
$tplsets_th4disp = '';
$tplset_options  = "<option value=''>----</option>\n";
while (list($tplset) = $db->fetchRow($srs)) {
    $tplset4disp     = htmlspecialchars($tplset, ENT_QUOTES);
    $tplsets[]       = $tplset;
    $th_style        = $tplset == $xoopsConfig['template_set'] ? "style='color: yellow;'" : '';
    $tplsets_th4disp .= "<th $th_style><input type='checkbox' onclick=\"with(document.MainForm){for (i=0;i<length;i++) {if(elements[i].type=='checkbox'&&elements[i].name.indexOf('{$tplset4disp}_check')>=0) {elements[i].checked=this.checked;}}}\">DB-{$tplset4disp}</th>";
    $tplset_options  .= "<option value='{$tplset4disp}'>{$tplset4disp}</option>\n";
}

// get tpl_file owned by the module
$sql = 'SELECT tpl_file,tpl_desc,tpl_type,COUNT(tpl_id) FROM ' . $db->prefix('tplfile') . " WHERE tpl_module='{$target_dirname4sql}' GROUP BY tpl_file ORDER BY tpl_type, tpl_file";
$frs = $db->query($sql);

xoops_cp_header();

$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

if (file_exists('./mymenu.php')) {
    require_once __DIR__ . '/mymenu.php';
}

echo "<h3 style='text-align:left;'>" . _AM_MYLINKS_TPLSETS . ": {$target_mname}</h3>\n";

// beginning of table & form
echo "<form name='MainForm' action='?dirname="
     . htmlspecialchars($target_dirname, ENT_QUOTES)
     . "' method='post'>\n"
     . '  '
     . $GLOBALS['xoopsSecurity']->getTokenHTML()
     . "\n"
     . "  <table class='outer'>\n"
     . "    <tr>\n"
     . '      <th>'
     . _AM_MYLINKS_FILENAME
     . "</th>\n"
     . "      <th>type</th>\n"
     . "      <th><input type='checkbox' onclick=\"with(document.MainForm){for (i=0;i<length;i++) {if(elements[i].type=='checkbox'&&elements[i].name.indexOf('basecheck')>=0) {elements[i].checked=this.checked;}}}\">file</th>\n"
     . "        {$tplsets_th4disp}\n"
     . "    </tr>\n";

// STYLE for distinguishing fingerprints
$fingerprint_styles = [
    '',
    'background-color:#00FF00',
    'background-color:#00CC88',
    'background-color:#00FFFF',
    'background-color:#0088FF',
    'background-color:#FF8800',
    'background-color:#0000FF',
    'background-color:#FFFFFF',
];

// template ROWS
while (list($tpl_file, $tpl_desc, $type, $count) = $db->fetchRow($frs)) {
    $evenodd                 = 'even' === @$evenodd ? 'odd' : 'even';
    $fingerprint_style_count = 0;

    // information about the template
    echo "    <tr>\n"
         . "      <td class='{$evenodd}'>\n"
         . "        <dl>\n"
         . '          <dt>'
         . htmlspecialchars($tpl_file, ENT_QUOTES)
         . "</dt>\n"
         . '          <dd>'
         . htmlspecialchars($tpl_desc, ENT_QUOTES)
         . "</dd>\n"
         . "        </dl>\n"
         . "      </td>\n"
         . "      <td class='{$evenodd}'>{$type}<br>({$count})</td>\n";

    // the base file template column
    $basefilepath = XOOPS_ROOT_PATH . "/modules/{$target_dirname}/templates/" . ('block' === $type ? 'blocks/' : '') . $tpl_file;
    if (file_exists($basefilepath)) {
        $fingerprint                = get_fingerprint(file($basefilepath));
        $fingerprints[$fingerprint] = 1;
        echo "      <td class='{$evenodd}'>" . formatTimestamp(filemtime($basefilepath), 'm') . '<br>' . mb_substr($fingerprint, 0, 16) . '' . "<br><input type='checkbox' name='basecheck[$tpl_file]' value='1'></td>\n";
    } else {
        echo "      <td class='{$evenodd}'><br></td>";
    }

    // db template columns
    foreach ($tplsets as $tplset) {
        $tplset4disp = htmlspecialchars($tplset, ENT_QUOTES);

        // query for templates in db
        $drs     = $db->query('SELECT * FROM ' . $db->prefix('tplfile') . ' f NATURAL LEFT JOIN ' . $db->prefix('tplsource') . " s WHERE tpl_file='" . addslashes($tpl_file) . "' AND tpl_tplset='" . addslashes($tplset) . "'");
        $numrows = $db->getRowsNum($drs);
        $tpl     = $db->fetchArray($drs);
        if (empty($tpl['tpl_id'])) {
            echo "      <td class='{$evenodd}'>($numrows)</td>\n";
        } else {
            $fingerprint = get_fingerprint(explode("\n", $tpl['tpl_source']));
            if (isset($fingerprints[$fingerprint])) {
                $style = $fingerprints[$fingerprint];
            } else {
                ++$fingerprint_style_count;
                $style                      = $fingerprint_styles[$fingerprint_style_count];
                $fingerprints[$fingerprint] = $style;
            }
            echo "      <td class='$evenodd' style='$style'>" . formatTimestamp($tpl['tpl_lastmodified'], 'm') . '<br>' . mb_substr($fingerprint, 0, 16) . "<br><input type='checkbox' name='{$tplset4disp}_check[{$tpl_file}]' value='1'> &nbsp; <a href='mytplsform.php?tpl_file=" . htmlspecialchars(
                    $tpl['tpl_file'],
                    ENT_QUOTES
                ) . '&amp;tpl_tplset=' . htmlspecialchars($tpl['tpl_tplset'], ENT_QUOTES) . "'>" . _EDIT . "</a> ($numrows)</td>\n";
        }
    }

    echo "    </tr>\n";
}

// command submit ROW
echo "    <tr>\n"
     . "      <td class='head'>\n"
     . '         '
     . _CLONE
     . ": <br>\n"
     . "         <select name='clone_tplset_from'>{$tplset_options}</select>-><input type='text' name='clone_tplset_to' size='8'><input type='submit' name='clone_tplset_do' value='"
     . _AM_MYLINKS_GENERATE
     . "'>\n"
     . "      </td>\n"
     . "      <td class='head'></td>\n"
     . "      <td class='head'>\n"
     . "        <input name='copyf2db_do' type='submit' value='copy to->'><br>\n"
     . "        <select name='copyf2db_to'>{$tplset_options}</select>\n"
     . "      </td>\n";

foreach ($tplsets as $tplset) {
    $tplset4disp = htmlspecialchars($tplset, ENT_QUOTES);
    echo "      <td class='head'>\n"
         . '        '
         . ('default' === $tplset ? '' : "<input name='del_do[{$tplset4disp}]' type='submit' value='" . _DELETE . "' onclick='return confirm(\"" . _DELETE . " OK?\");'><br>")
         . "\n"
         . "        <input name='copy_do[{$tplset4disp}]' type='submit' value='copy to->'><br>\n"
         . "        <select name='copy_to[{$tplset4disp}]'>$tplset_options</select>\n"
         . "      </td>\n";
}

echo "    </tr>\n" . "  </table>\n" . "</form>\n";
// end of table & form
require_once __DIR__ . '/admin_footer.php';

/**
 * @param $lines
 * @return string
 */
function get_fingerprint($lines)
{
    $str = '';
    foreach ($lines as $line) {
        if (trim($line)) {
            $str .= md5(trim($line));
        }
    }

    return md5($str);
}

/**
 * @param        $tplset_from
 * @param        $tplset_to
 * @param string $whr_append
 */
function copy_templates_db2db($tplset_from, $tplset_to, $whr_append = '1')
{
    global $db;

    // get tplfile and tplsource
    $result = $db->query(
        "SELECT tpl_refid,tpl_module,'" . addslashes($tplset_to) . "',tpl_file,tpl_desc,tpl_lastmodified,tpl_lastimported,tpl_type,tpl_source FROM " . $db->prefix('tplfile') . ' NATURAL LEFT JOIN ' . $db->prefix('tplsource') . " WHERE tpl_tplset='" . addslashes($tplset_from) . "' AND ($whr_append)"
    );

    while (false !== ($row = $db->fetchArray($result))) {
        $tpl_source = array_pop($row);
        $drs        = $db->query('SELECT tpl_id FROM ' . $db->prefix('tplfile') . " WHERE tpl_tplset='" . addslashes($tplset_to) . "' AND ($whr_append) AND tpl_file='" . addslashes($row['tpl_file']) . "' AND tpl_refid='" . addslashes($row['tpl_refid']) . "'");

        if (!$db->getRowsNum($drs)) {
            // INSERT mode
            $sql = 'INSERT INTO ' . $db->prefix('tplfile') . ' (tpl_refid,tpl_module,tpl_tplset,tpl_file,tpl_desc,tpl_lastmodified,tpl_lastimported,tpl_type) VALUES (';
            foreach ($row as $colval) {
                $sql .= "'" . addslashes($colval) . "',";
            }
            $db->query(mb_substr($sql, 0, -1) . ')');
            $tpl_id = $db->getInsertId();
            $db->query('INSERT INTO ' . $db->prefix('tplsource') . " SET tpl_id='$tpl_id', tpl_source='" . addslashes($tpl_source) . "'");
            xoops_template_touch($tpl_id);
        } else {
            while (list($tpl_id) = $db->fetchRow($drs)) {
                // UPDATE mode
                $db->query(
                    'UPDATE '
                    . $db->prefix('tplfile')
                    . " SET tpl_refid='"
                    . addslashes($row['tpl_refid'])
                    . "',tpl_desc='"
                    . addslashes($row['tpl_desc'])
                    . "',tpl_lastmodified='"
                    . addslashes($row['tpl_lastmodified'])
                    . "',tpl_lastimported='"
                    . addslashes($row['tpl_lastimported'])
                    . "',tpl_type='"
                    . addslashes($row['tpl_type'])
                    . "' WHERE tpl_id='{$tpl_id}'"
                );
                $db->query('UPDATE ' . $db->prefix('tplsource') . " SET tpl_source='" . addslashes($tpl_source) . "' WHERE tpl_id='$tpl_id'");
                xoops_template_touch($tpl_id);
            }
        }
    }
}

/**
 * @param        $tplset_to
 * @param string $whr_append
 */
function copy_templates_f2db($tplset_to, $whr_append = '1')
{
    global $db;

    // get tplsource
    $result = $db->query('SELECT * FROM ' . $db->prefix('tplfile') . "  WHERE tpl_tplset='default' AND ($whr_append)");

    while (false !== ($row = $db->fetchArray($result))) {
        $basefilepath = XOOPS_ROOT_PATH . '/modules/' . $row['tpl_module'] . '/templates/' . ('block' === $row['tpl_type'] ? 'blocks/' : '') . $row['tpl_file'];

        $tpl_source   = rtrim(file_get_contents($basefilepath));
        $lastmodified = filemtime($basefilepath);

        $drs = $db->query('SELECT tpl_id FROM ' . $db->prefix('tplfile') . " WHERE tpl_tplset='" . addslashes($tplset_to) . "' AND ($whr_append) AND tpl_file='" . addslashes($row['tpl_file']) . "' AND tpl_refid='" . addslashes($row['tpl_refid']) . "'");

        if (!$db->getRowsNum($drs)) {
            // INSERT mode
            $sql = 'INSERT INTO ' . $db->prefix('tplfile') . " SET tpl_refid='" . addslashes($row['tpl_refid']) . "',tpl_desc='" . addslashes($row['tpl_desc']) . "',tpl_lastmodified='" . addslashes($lastmodified) . "',tpl_type='" . addslashes($row['tpl_type']) . "',tpl_tplset='" . addslashes(
                    $tplset_to
                ) . "',tpl_file='" . addslashes($row['tpl_file']) . "',tpl_module='" . addslashes($row['tpl_module']) . "'";
            $db->query($sql);
            $tpl_id = $db->getInsertId();
            $db->query('INSERT INTO ' . $db->prefix('tplsource') . " SET tpl_id='{$tpl_id}', tpl_source='" . addslashes($tpl_source) . "'");
            xoops_template_touch($tpl_id);
        } else {
            while (list($tpl_id) = $db->fetchRow($drs)) {
                // UPDATE mode
                $db->query('UPDATE ' . $db->prefix('tplfile') . " SET tpl_lastmodified='" . addslashes($lastmodified) . "' WHERE tpl_id='{$tpl_id}'");
                $db->query('UPDATE ' . $db->prefix('tplsource') . " SET tpl_source='" . addslashes($tpl_source) . "' WHERE tpl_id='{$tpl_id}'");
                xoops_template_touch($tpl_id);
            }
        }
    }
}
