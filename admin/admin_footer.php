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
 * @copyright::  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @subpackage:: admin
 * @since:       2.5.0
 * @author::     XOOPS Development Team
 * @version::	 $Id $
**/
global $pathIcon32;

echo "<div class='adminfooter'>\n"
    ."  <div style='text-align: center;'>\n"
    ."    <a href='http://www.xoops.org' target='_blank'><img src=" . $pathIcon32."/xoopsmicrobutton.gif alt='XOOPS' title='XOOPS'></a>\n"
    ."  </div>\n"
    ."  " . _AM_MYLINKS_ADMIN_FOOTER . "\n"
    ."</div>";

xoops_cp_footer();
