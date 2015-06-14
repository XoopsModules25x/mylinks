<?php
/*
 mylinks - MODULE FOR XOOPS
 XOOPS - PHP Content Management System
 Copyright (c) 2000 XOOPS.org
 <http://www.xoops.org/>
 ------------------------------------------------------------------------
 XOOPS Korean (translated by wanikoo[ wani@wanisys.net ])
 <http://www.wanisys.net/>
 ------------------------------------------------------------------------
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting
 source code which is considered copyrighted (c) material of the
 original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */
/**
 * Mylinks
 *
 * @copyright::  {@link http://www.xoops.org XOOPS Content Management System}
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @author::     wanikoo <wani@wanisys.net>
 * @version::    $Id: modinfo.php 11819 2013-07-09 18:21:40Z zyspec $
 */

// The name of this module
define("_MI_MYLINKS_NAME","ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â§Ã¢â‚¬Ëœ");

// A brief description of this module
define("_MI_MYLINKS_DESC","ÃƒÂ¬Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ÃƒÂ­Ã…Â Ã‚Â¸ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂªÃ‚Â³Ã‚ÂµÃƒÂ¬Ã…â€œÃ‚Â /ÃƒÂ­Ã¯Â¿Â½Ã¢â‚¬Â°ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â  ÃƒÂ¬Ã‹â€ Ã‹Å“ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ«Ã…Â Ã¢â‚¬ï¿½ ÃƒÂ¬Ã¢â‚¬Å¾Ã…â€œÃƒÂ«Ã‚Â¹Ã¢â‚¬Å¾ÃƒÂ¬Ã…Â Ã‚Â¤ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ¬Ã‚Â Ã…â€œÃƒÂªÃ‚Â³Ã‚ÂµÃƒÂ­Ã¢â‚¬Â¢Ã‚Â©ÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.");

// Names of blocks for this module (Not all module has blocks)
define("_MI_MYLINKS_BNAME1","ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬");
define('_MI_MYLINKS_BNAME1DESC','Shows recently added web links');
define("_MI_MYLINKS_BNAME2","ÃƒÂ«Ã‚Â²Ã‚Â ÃƒÂ¬Ã…Â Ã‚Â¤ÃƒÂ­Ã…Â Ã‚Â¸ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬");
define('_MI_MYLINKS_BNAME2DESC','Shows most visited web links');
define('_MI_MYLINKS_BNAME3','Random Link');
define('_MI_MYLINKS_BNAME3DESC','Shows a random link');

// Sub menu titles
define("_MI_MYLINKS_SMNAME1","ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½");
define("_MI_MYLINKS_SMNAME2","ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸ÃƒÂªÃ‚Â¸Ã‚Â° ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬");
define("_MI_MYLINKS_SMNAME3","ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ­Ã¯Â¿Â½Ã¢â‚¬Â°ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬");
define('_MI_MYLINKS_SMNAME4','Most Recent');

// Names of admin menu items
define("_MI_MYLINKS_ADMENU2","ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ¬Ã‚Â¶Ã¢â‚¬ï¿½ÃƒÂªÃ‚Â°Ã¢â€šÂ¬/ÃƒÂ­Ã…Â½Ã‚Â¸ÃƒÂ¬Ã‚Â§Ã¢â‚¬Ëœ");
define("_MI_MYLINKS_ADMENU3","ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â  ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´");
define("_MI_MYLINKS_ADMENU4","ÃƒÂ«Ã¯Â¿Â½Ã…Â ÃƒÂ¬Ã¢â‚¬â€œÃ‚Â´ÃƒÂ¬Ã‚Â§Ã¢â‚¬Å¾ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â³Ã‚Â ");
define("_MI_MYLINKS_ADMENU5","ÃƒÂ¬Ã‹â€ Ã‹Å“ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´");
define("_MI_MYLINKS_ADMENU6","ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ ÃƒÂ¬Ã‚Â²Ã‚Â´ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬");
define('_MI_MYLINKS_ADMENU7','Template Admin');

// Template Descriptions
define('_MI_MYLINKS_TPLDESC_BROKEN','Broken Link Template');
define('_MI_MYLINKS_TPLDESC_LINK','Link Template');
define('_MI_MYLINKS_TPLDESC_INDEX','Module Index Template');
define('_MI_MYLINKS_TPLDESC_MODLINK','Link Modification Template');
define('_MI_MYLINKS_TPLDESC_RATELINK','Rate Link Template');
define('_MI_MYLINKS_TPLDESC_SINGLELINK','Single Link Template');
define('_MI_MYLINKS_TPLDESC_SUBMIT','Submit Link Template');
define('_MI_MYLINKS_TPLDESC_TOPTEN','Top Ten Template');
define('_MI_MYLINKS_TPLDESC_VIEWCAT','View Category Template');
define('_MI_MYLINKS_TPLDESC_SEARCHINC','Search form include Template');
define('_MI_MYLINKS_TPLDESC_ATOM','ATOM Feed Template');
define('_MI_MYLINKS_TPLDESC_PDA','PDA Friendly Feed Template');
define('_MI_MYLINKS_TPLDESC_RSS','RSS Feed Template');

// Title of config items
define('_MI_MYLINKS_POPULAR','ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸ÃƒÂªÃ‚Â¸Ã‚Â° ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ«Ã¯Â¿Â½Ã‹Å“ÃƒÂªÃ‚Â¸Ã‚Â° ÃƒÂ¬Ã…â€œÃ¢â‚¬Å¾ÃƒÂ­Ã¢â‚¬Â¢Ã…â€œ ÃƒÂ¬Ã‚ÂµÃ…â€œÃƒÂ¬Ã‚Â Ã¢â€šÂ¬ÃƒÂ«Ã‚Â°Ã‚Â©ÃƒÂ«Ã‚Â¬Ã‚Â¸ÃƒÂ¬Ã‹â€ Ã‹Å“');
define('_MI_MYLINKS_NEWLINKS','ÃƒÂ«Ã‚Â©Ã¢â‚¬ï¿½ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸ÃƒÂ­Ã…Â½Ã‹Å“ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ¬Ã¯Â¿Â½Ã‹Å“ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ­Ã¢â‚¬ËœÃ…â€œÃƒÂ¬Ã¢â‚¬Â¹Ã…â€œÃƒÂ­Ã¢â‚¬Â¢Ã‚Â  ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ¬Ã‹â€ Ã‹Å“');
define('_MI_MYLINKS_PERPAGE','ÃƒÂ­Ã…Â½Ã‹Å“ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¹ ÃƒÂ­Ã¢â‚¬ËœÃ…â€œÃƒÂ¬Ã¢â‚¬Â¹Ã…â€œÃƒÂ­Ã¢â‚¬Â¢Ã‚Â  ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ¬Ã‹â€ Ã‹Å“');
define('_MI_MYLINKS_USESHOTS','ÃƒÂ¬Ã…Â Ã‚Â¤ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ«Ã‚Â¦Ã‚Â°ÃƒÂ¬Ã†â€™Ã‚Â·ÃƒÂ¬Ã¯Â¿Â½Ã¢â‚¬Å¾ ÃƒÂ¬Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¬Ã…Â¡Ã‚Â©ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_USEFRAMES','ÃƒÂ­Ã¢â‚¬ï¿½Ã¢â‚¬Å¾ÃƒÂ«Ã‚Â Ã‹â€ ÃƒÂ¬Ã…Â¾Ã¢â‚¬Å¾ÃƒÂ¬Ã¯Â¿Â½Ã¢â‚¬Å¾ ÃƒÂ¬Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¬Ã…Â¡Ã‚Â©ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_SHOTWIDTH','ÃƒÂ¬Ã…Â Ã‚Â¤ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ«Ã‚Â¦Ã‚Â°ÃƒÂ¬Ã†â€™Ã‚Â·ÃƒÂ¬Ã¯Â¿Â½Ã‹Å“ ÃƒÂªÃ‚Â·Ã‚Â¸ÃƒÂ«Ã‚Â¦Ã‚Â¼ÃƒÂ­Ã…â€™Ã…â€™ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¼ ÃƒÂ­Ã¯Â¿Â½Ã‚Â­');
define('_MI_MYLINKS_SHOTPROVIDER','Select the external screen shot provider');
define('_MI_MYLINKS_DISPATTR', 'Display shot attribution');
define('_MI_MYLINKS_SHOTPUBKEY', 'Shot provider primary key');
define('_MI_MYLINKS_SHOTPRIVKEY', 'Shot provider secondary key');
define('_MI_MYLINKS_ANONPOST','ÃƒÂ¬Ã¢â‚¬Â Ã¯Â¿Â½ÃƒÂ«Ã¢â‚¬Â¹Ã‹Å“ÃƒÂ¬Ã¯Â¿Â½Ã‹Å“ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ­Ã¢â‚¬â€�Ã‹â€ ÃƒÂ¬Ã…Â¡Ã‚Â©ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_AUTOAPPROVE','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ¬Ã…Â¾Ã¯Â¿Â½ÃƒÂ«Ã¯Â¿Â½Ã¢â€žÂ¢ÃƒÂ¬Ã…Â Ã‚Â¹ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_INCADMIN','Include administrator visits in hit counter results?');
define('_MI_MYLINKS_SHOWEXTRAFUNC','Show extra functionality in link display?');
define('_MI_MYLINKS_CANPRINT','Select which users can print links');
define('_MI_MYLINKS_CANPDF','Select which users can create PDF files');
define('_MI_MYLINKS_CANBOOKMARK','Select which users can create a bookmark');
define('_MI_MYLINKS_CANQRCODE','Select which users can create a qrcode (3D barcode)');
define('_MI_MYLINKS_SHOWLOGO','Display the module header logo?');
define('_MI_MYLINKS_SHOWXOOPSSEARCH','Enable XOOPS sitewide search form in module templates?');
define('_MI_MYLINKS_SHOWTOOLBAR','Display horizontal menu at top of module templates?');
define('_MI_MYLINKS_SHOWLETTERS','Display horizontal category letter hyperlink menu at top of module templates?');
define('_MI_MYLINKS_SHOWFEED','Display RSS/Atom feed icons?');
define('_MI_MYLINKS_SHOWSITEINFO','Show site statistics information?');

// Description of each config items
define('_MI_MYLINKS_POPULARDSC','ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸ÃƒÂªÃ‚Â¸Ã‚Â°ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ«Ã¯Â¿Â½Ã‹Å“ÃƒÂªÃ‚Â¸Ã‚Â°ÃƒÂ¬Ã…â€œÃ¢â‚¬Å¾ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â´ ÃƒÂ­Ã¢â‚¬Â¢Ã¢â‚¬Å¾ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½ÃƒÂ­Ã¢â‚¬Â¢Ã…â€œ ÃƒÂ«Ã‚Â°Ã‚Â©ÃƒÂ«Ã‚Â¬Ã‚Â¸ÃƒÂ¬Ã‹â€ Ã‹Å“ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â´ ÃƒÂ¬Ã‚Â£Ã‚Â¼ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¸ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½!');
define('_MI_MYLINKS_NEWLINKSDSC','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ­Ã¢â‚¬ËœÃ…â€œÃƒÂ¬Ã¢â‚¬Â¹Ã…â€œÃƒÂ­Ã¢â‚¬Â¢Ã‚Â  ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ¬Ã‹â€ Ã‹Å“ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â´ ÃƒÂ¬Ã‚Â£Ã‚Â¼ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¸ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½!');
define('_MI_MYLINKS_PERPAGEDSC','ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ¬Ã…Â Ã‚Â¤ÃƒÂ­Ã…Â Ã‚Â¸ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ÃƒÂ¬Ã¢â‚¬Å¾Ã…â€œ ÃƒÂ­Ã…Â½Ã‹Å“ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¹ ÃƒÂ­Ã¢â‚¬ËœÃ…â€œÃƒÂ¬Ã¢â‚¬Â¹Ã…â€œÃƒÂ­Ã¢â‚¬Â¢Ã‚Â  ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ¬Ã‹â€ Ã‹Å“ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â´ ÃƒÂ¬Ã‚Â£Ã‚Â¼ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¸ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½');
define('_MI_MYLINKS_USEFRAMEDSC','ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ ÃƒÂ­Ã…Â½Ã‹Å“ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ­Ã¢â‚¬ï¿½Ã¢â‚¬Å¾ÃƒÂ«Ã‚Â Ã‹â€ ÃƒÂ¬Ã…Â¾Ã¢â‚¬Å¾ÃƒÂ«Ã¢â‚¬Å¡Ã‚Â´ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ­Ã¢â‚¬ËœÃ…â€œÃƒÂ¬Ã¢â‚¬Â¹Ã…â€œÃƒÂ­Ã¢â‚¬Â¢Ã‚Â ÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â´ ÃƒÂ¬Ã‚Â£Ã‚Â¼ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¸ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½');
define('_MI_MYLINKS_USESHOTSDSC','ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ¬Ã…Â Ã‚Â¤ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ«Ã‚Â¦Ã‚Â°ÃƒÂ¬Ã†â€™Ã‚Â·ÃƒÂ«Ã¯Â¿Â½Ã¢â‚¬Å¾ ÃƒÂ­Ã¢â‚¬ËœÃ…â€œÃƒÂ¬Ã¢â‚¬Â¹Ã…â€œÃƒÂ­Ã¢â‚¬Â¢Ã‚Â  ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â°ÃƒÂ¬Ã¢â‚¬â€�Ã¢â‚¬ï¿½ ÃƒÂ¬Ã‹Å“Ã‹â€ ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â ÃƒÂ­Ã†â€™Ã¯Â¿Â½ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â´ ÃƒÂ¬Ã‚Â£Ã‚Â¼ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¸ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½');
define('_MI_MYLINKS_SHOTWIDTHDSC','ÃƒÂ¬Ã…Â Ã‚Â¤ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ«Ã‚Â¦Ã‚Â°ÃƒÂ¬Ã†â€™Ã‚Â·ÃƒÂ¬Ã…Â¡Ã‚Â© ÃƒÂªÃ‚Â·Ã‚Â¸ÃƒÂ«Ã‚Â¦Ã‚Â¼ÃƒÂ­Ã…â€™Ã…â€™ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¼ÃƒÂ¬Ã¯Â¿Â½Ã‹Å“ ÃƒÂ¬Ã‚ÂµÃ…â€œÃƒÂ«Ã…â€™Ã¢â€šÂ¬ÃƒÂ­Ã¯Â¿Â½Ã‚Â­ÃƒÂ¬Ã¯Â¿Â½Ã¢â‚¬Å¾ ÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â´ ÃƒÂ¬Ã‚Â£Ã‚Â¼ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¸ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½');
define('_MI_MYLINKS_SHOTPROVIDERDSC','Provider for screen shots if images from image directory are not used.');
define('_MI_MYLINKS_DISPATTRDSC', 'Some providers require you display an image attribution<br />Do not disable this unless you are sure.');
define('_MI_MYLINKS_SHOTPUBKEYDSC', 'Enter the primary (or public) key if required by shot provider service.');
define('_MI_MYLINKS_SHOTPRIVKEYDSC', 'Enter the secondary (or private) key if required by shot provider service.');
define('_MI_MYLINKS_AUTOAPPROVEDSC','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ¬Ã…Â¾Ã¯Â¿Â½ÃƒÂ«Ã¯Â¿Â½Ã¢â€žÂ¢ÃƒÂ¬Ã…Â Ã‚Â¹ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸ÃƒÂ¬Ã‚Â²Ã‹Å“ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ­Ã¢â‚¬Â¢Ã‹Å“ÃƒÂ¬Ã¢â‚¬Â¹Ã…â€œÃƒÂ«Ã‚Â Ã‚Â¤ÃƒÂ«Ã‚Â©Ã‚Â´ ÃƒÂ¬Ã‹Å“Ã‹â€ ÃƒÂ«Ã‚Â¥Ã‚Â¼ ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â ÃƒÂ­Ã†â€™Ã¯Â¿Â½ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â´ ÃƒÂ¬Ã‚Â£Ã‚Â¼ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¸ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½');
define('_MI_MYLINKS_INCADMINDSC','');
define('_MI_MYLINKS_SHOWEXTRAFUNCDSC','Allow display of print, pdf, qrcode, bookmark options');
define('_MI_MYLINKS_CANPRINTDSC','');
define('_MI_MYLINKS_CANPDFDSC','');
define('_MI_MYLINKS_CANBOOKMARKDSC','');
define('_MI_MYLINKS_CANQRCODEDSC','Note: QRCODE module must be installed for this option to function');
define('_MI_MYLINKS_SHOWLOGODSC','');
define('_MI_MYLINKS_SHOWXOOPSSEARCHDSC','');
define('_MI_MYLINKS_SHOWTOOLBARDSC','');
define('_MI_MYLINKS_SHOWLETTERSDSC','');
define('_MI_MYLINKS_SHOWFEEDDSC','');
define('_MI_MYLINKS_SHOWSITEINFODSC','Show hyperlink menu to show Alexa, Archive, & Google stats');
define('_MI_MYLINKS_ANONTELLAFRIEND','Allow anonymous users to send tell-a-friend email');
define('_MI_MYLINKS_ANONTELLAFRIENDDSC','Yes will allow anonymous user to tell-a-friend.');

// Values for config items
define('_MI_MYLINKS_DISALLOW', 0);
define('_MI_MYLINKS_ALLOW', 1);
define('_MI_MYLINKS_MEMBERONLY', 2);
define('_MI_MYLINKS_ALLOWDSC','Allow all users');
define('_MI_MYLINKS_DISALLOWDSC','Disallow all users');
define('_MI_MYLINKS_MEMBERONLYDSC','Registered users only');

// Text for notifications
define('_MI_MYLINKS_GLOBAL_NOTIFY','ÃƒÂ«Ã‚ÂªÃ‚Â¨ÃƒÂ«Ã¢â‚¬Å“Ã‹â€ ÃƒÂ¬Ã‚Â Ã¢â‚¬Å¾ÃƒÂ¬Ã‚Â²Ã‚Â´');
define('_MI_MYLINKS_GLOBAL_NOTIFYDSC','ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤ÃƒÂ¬Ã…Â¡Ã‚Â´ÃƒÂ«Ã‚Â¡Ã…â€œÃƒÂ«Ã¢â‚¬Å“Ã…â€œ ÃƒÂ«Ã‚ÂªÃ‚Â¨ÃƒÂ«Ã¢â‚¬Å“Ã‹â€  ÃƒÂ¬Ã‚Â Ã¢â‚¬Å¾ÃƒÂ¬Ã‚Â²Ã‚Â´ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ«Ã…â€™Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã…â€œ ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ¬Ã‹Å“Ã‚ÂµÃƒÂ¬Ã¢â‚¬Â¦Ã‹Å“');

define('_MI_MYLINKS_CATEGORY_NOTIFY','ÃƒÂ­Ã‹Å“Ã¢â‚¬Å¾ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬');
define('_MI_MYLINKS_CATEGORY_NOTIFYDSC','ÃƒÂ­Ã‹Å“Ã¢â‚¬Å¾ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ«Ã…â€™Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã…â€œ ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ¬Ã‹Å“Ã‚ÂµÃƒÂ¬Ã¢â‚¬Â¦Ã‹Å“');

define('_MI_MYLINKS_LINK_NOTIFY','ÃƒÂ­Ã‹Å“Ã¢â‚¬Å¾ÃƒÂ¬Ã…Â¾Ã‚Â¬ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬');
define('_MI_MYLINKS_LINK_NOTIFYDSC','ÃƒÂ­Ã‹Å“Ã¢â‚¬Å¾ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ«Ã…â€™Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã…â€œ ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ¬Ã‹Å“Ã‚ÂµÃƒÂ¬Ã¢â‚¬Â¦Ã‹Å“');

define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFY','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYCAP','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¤ÃƒÂ«Ã¯Â¿Â½Ã…â€œ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYDSC','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¤ÃƒÂ«Ã¯Â¿Â½Ã…â€œ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â©ÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂ¬Ã¢â‚¬Å¾Ã‚Â¤ÃƒÂ«Ã¯Â¿Â½Ã‹Å“ÃƒÂ¬Ã¢â‚¬â€�Ã‹â€ ÃƒÂ¬Ã…Â Ã‚ÂµÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');

define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFY','ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ¬Ã‹â€ Ã‹Å“ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½ÃƒÂ¬Ã‚Â²Ã‚Â­');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYCAP','ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ¬Ã‹â€ Ã‹Å“ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½ÃƒÂ¬Ã‚Â²Ã‚Â­ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ«Ã…Â Ã¢â‚¬ï¿½ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYDSC','ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ¬Ã‹â€ Ã‹Å“ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½ÃƒÂ¬Ã‚Â²Ã‚Â­ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ«Ã…Â Ã¢â‚¬ï¿½ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â©ÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ«Ã…â€™Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã…â€œ ÃƒÂ¬Ã‹â€ Ã‹Å“ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ¬Ã…Â¡Ã¢â‚¬ï¿½ÃƒÂ¬Ã‚Â²Ã‚Â­ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ¬Ã¢â‚¬â€�Ã‹â€ ÃƒÂ¬Ã…Â Ã‚ÂµÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');

define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFY','ÃƒÂ«Ã¯Â¿Â½Ã…Â ÃƒÂ¬Ã¢â‚¬â€œÃ‚Â´ÃƒÂ¬Ã‚Â§Ã¢â‚¬Å¾ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â³Ã‚Â ');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYCAP','ÃƒÂ«Ã¯Â¿Â½Ã…Â ÃƒÂ¬Ã¢â‚¬â€œÃ‚Â´ÃƒÂ¬Ã‚Â§Ã¢â‚¬Å¾ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ«Ã…Â Ã¢â‚¬ï¿½ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYDSC','ÃƒÂ«Ã¯Â¿Â½Ã…Â ÃƒÂ¬Ã¢â‚¬â€œÃ‚Â´ÃƒÂ¬Ã‚Â§Ã¢â‚¬Å¾ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ«Ã…Â Ã¢â‚¬ï¿½ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â©ÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : ÃƒÂ«Ã¯Â¿Â½Ã…Â ÃƒÂ¬Ã¢â‚¬â€œÃ‚Â´ÃƒÂ¬Ã‚Â§Ã¢â‚¬Å¾ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ¬Ã¢â‚¬â€�Ã‹â€ ÃƒÂ¬Ã…Â Ã‚ÂµÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');

define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFY','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â ');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYCAP','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂ¬Ã¯Â¿Â½Ã‹Å“ ÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ«Ã…Â Ã¢â‚¬ï¿½ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYDSC','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂ¬Ã¯Â¿Â½Ã‹Å“ ÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ«Ã…Â Ã¢â‚¬ï¿½ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂ¬Ã¯Â¿Â½Ã‹Å“ ÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã…Â¾Ã‹â€ ÃƒÂ¬Ã¢â‚¬â€�Ã‹â€ ÃƒÂ¬Ã…Â Ã‚ÂµÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');

define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFY','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYCAP','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½ÃƒÂ«Ã¯Â¿Â½Ã‹Å“ÃƒÂ¬Ã¢â‚¬â€œÃ‚Â´ÃƒÂ¬Ã‚Â§Ã¢â‚¬Å¾ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYDSC','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½ÃƒÂ«Ã¯Â¿Â½Ã‹Å“ÃƒÂ¬Ã¢â‚¬â€œÃ‚Â´ÃƒÂ¬Ã‚Â§Ã¢â‚¬Å¾ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â©ÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ¬Ã¢â‚¬Â¹Ã¯Â¿Â½ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½ÃƒÂ«Ã¯Â¿Â½Ã‹Å“ÃƒÂ¬Ã¢â‚¬â€�Ã‹â€ ÃƒÂ¬Ã…Â Ã‚ÂµÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');

define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFY','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â (ÃƒÂ­Ã…Â Ã‚Â¹ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ«Ã¢â‚¬Å¡Ã‚Â´)');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYCAP','ÃƒÂ­Ã‹Å“Ã¢â‚¬Å¾ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã¯Â¿Â½Ã…â€œ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYDSC','ÃƒÂ­Ã‹Å“Ã¢â‚¬Å¾ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã¯Â¿Â½Ã…â€œ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â©ÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ«Ã¢â‚¬Å¡Ã‚Â´ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ­Ã‹â€ Ã‚Â¬ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã¯Â¿Â½Ã‹Å“ÃƒÂ¬Ã¢â‚¬â€œÃ‚Â´ÃƒÂ¬Ã‚Â¡Ã…â€™ÃƒÂ¬Ã…Â Ã‚ÂµÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');

define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFY','ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½(ÃƒÂ­Ã…Â Ã‚Â¹ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ«Ã¢â‚¬Å¡Ã‚Â´)');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYCAP','ÃƒÂ­Ã‹Å“Ã¢â‚¬Å¾ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œÃƒÂ«Ã‚Â¡Ã…â€œ ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ¬Ã¢â‚¬Â¹Ã¯Â¿Â½ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½ÃƒÂ«Ã¯Â¿Â½Ã…â€œ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYDSC','ÃƒÂ­Ã‹Å“Ã¢â‚¬Å¾ ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œÃƒÂ«Ã‚Â¡Ã…â€œ ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ¬Ã¢â‚¬Â¹Ã¯Â¿Â½ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½ÃƒÂ«Ã¯Â¿Â½Ã…â€œ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â©ÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : ÃƒÂ¬Ã‚Â¹Ã‚Â´ÃƒÂ­Ã¢â‚¬Â¦Ã…â€™ÃƒÂªÃ‚Â³Ã‚Â ÃƒÂ«Ã‚Â¦Ã‚Â¬ÃƒÂ¬Ã¢â‚¬â€�Ã¯Â¿Â½ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã¢â‚¬Â¹Ã‚Â ÃƒÂªÃ‚Â·Ã…â€œÃƒÂ«Ã‚Â¡Ã…â€œ ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ¬Ã¢â‚¬Â¹Ã¯Â¿Â½ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½ÃƒÂ«Ã¯Â¿Â½Ã‹Å“ÃƒÂ¬Ã¢â‚¬â€�Ã‹â€ ÃƒÂ¬Ã…Â Ã‚ÂµÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');

define('_MI_MYLINKS_LINK_APPROVE_NOTIFY','ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ ÃƒÂ¬Ã…Â Ã‚Â¹ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYCAP','ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã…Â Ã‚Â¹ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸ÃƒÂ«Ã¯Â¿Â½Ã…â€œ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â¨');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYDSC','ÃƒÂ¬Ã¯Â¿Â½Ã‚Â´ ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã…Â Ã‚Â¹ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸ÃƒÂ«Ã¯Â¿Â½Ã…â€œ ÃƒÂªÃ‚Â²Ã‚Â½ÃƒÂ¬Ã…Â¡Ã‚Â° ÃƒÂ­Ã¢â‚¬Â Ã‚ÂµÃƒÂ¬Ã‚Â§Ã¢â€šÂ¬ÃƒÂ­Ã¢â‚¬Â¢Ã‚Â©ÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : ÃƒÂ«Ã‚Â§Ã¯Â¿Â½ÃƒÂ­Ã¯Â¿Â½Ã‚Â¬ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ«Ã‚Â³Ã‚Â´ÃƒÂªÃ‚Â°Ã¢â€šÂ¬ ÃƒÂ¬Ã‚Â Ã¢â‚¬Â¢ÃƒÂ¬Ã¢â‚¬Â¹Ã¯Â¿Â½ ÃƒÂ¬Ã…Â Ã‚Â¹ÃƒÂ¬Ã¯Â¿Â½Ã‚Â¸/ÃƒÂ«Ã¢â‚¬Å“Ã‚Â±ÃƒÂ«Ã‚Â¡Ã¯Â¿Â½ÃƒÂ«Ã¯Â¿Â½Ã‹Å“ÃƒÂ¬Ã¢â‚¬â€�Ã‹â€ ÃƒÂ¬Ã…Â Ã‚ÂµÃƒÂ«Ã¢â‚¬Â¹Ã‹â€ ÃƒÂ«Ã¢â‚¬Â¹Ã‚Â¤.');

// index.php
define('_MYLINKS_ADMIN_HOME','Home');
define('_MYLINKS_ADMIN_INDEX','FAQ');
define('_MYLINKS_ADMIN_ABOUT','About');
define('_MYLINKS_ADMIN_HELP','Help');
define('_MYLINKS_ADMIN_SLIDES','Slides');
define('_MYLINKS_ADMIN_PREFERENCES','Preferences');

define('_MYLINKS_ADMIN_HOME_DESC','Home');
define('_MI_MYLINKS_ADMENU2_DESC','Add/Edit Links');
define('_MI_MYLINKS_ADMENU3_DESC','Submitted Links');
define('_MI_MYLINKS_ADMENU4_DESC','Broken Links');
define('_MI_MYLINKS_ADMENU5_DESC','Modified Links');
define('_MI_MYLINKS_ADMENU6_DESC','Blocks/Group Admin');
define('_MI_MYLINKS_ADMENU7_DESC','Template Admin');
define('_MYLINKS_ADMIN_ABOUT_DESC','Info About the Module');
define('_MYLINKS_ADMIN_HELP_DESC','Help');
