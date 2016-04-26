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
 * @copyright::  {@link http://sourceforge.net/projects/xoops/ The XOOPS Project}
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @subpackage:: admin
 * @since:       2.5.0
 * @author::     XOOPS Module Dev Team
**/
echo "<div class='adminfooter'>\n"
   . "  <div class='txtcenter'>\n"
   . "    <a href='" . $GLOBALS['xoopsModule']->getInfo('author_website_url') . "' target='_blank'><img src='{$pathIcon32}/xoopsmicrobutton.gif' alt='" . $GLOBALS['xoopsModule']->getInfo('author_website_name') . "' title='" . $GLOBALS['xoopsModule']->getInfo('author_website_name') . "'></a>\n"
   . "  </div>\n"
   . "  <div class='center smallsmall italic pad5'>\n"
   . "    " . _AM_MYLINKS_MAINTAINED_BY
   . " <a class='tooltip' rel='external' href='http://" . $GLOBALS['xoopsModule']->getInfo('module_website_url') . "' "
   . "title='" . _AM_MYLINKS_MAINTAINED_TITLE . "'>" . _AM_MYLINKS_MAINTAINED_TEXT . "</a>\n"
   . "  </div>\n"
   . "</div>\n";
xoops_cp_footer();
