<?php
/*
 * ****************************************************************************
 * mylinks - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * @copyright::  {@link http://www.instant-zero.com Hervé Thouzard of Instant Zero}
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @author::     {@link http://www.instant-zero.com Hervé Thouzard of Instant Zero}
 * @version::    $Id: admin.php 11239 2013-03-16 04:08:34Z zyspec $
 * ****************************************************************************
 */
//3.1
$admin_mydirname = basename(dirname(dirname(dirname(__FILE__))));

define('_AM_MYLINKS_ERROR_MODADMIN',"Error: Frameworks \"moduleadmin\" is not installed. Please install this Framework");

// About.php
define("_AM_MYLINKS_ABOUT_AUTHOR","Author: ");
define("_AM_MYLINKS_ABOUT_AUTHOR_INFO","Author Info");
define("_AM_MYLINKS_ABOUT_AUTHOR_NAME","Author name: ");
define("_AM_MYLINKS_ABOUT_CHANGELOG","Change Log");
define("_AM_MYLINKS_ABOUT_CREDITS","Credits: ");
define("_AM_MYLINKS_ABOUT_DESCRIPTION","Description: ");
define("_AM_MYLINKS_ABOUT_LICENSE","License: ");
define("_AM_MYLINKS_ABOUT_MODULE_INFO","Module Info");
define("_AM_MYLINKS_ABOUT_MODULE_STATUS","Status: ");
define("_AM_MYLINKS_ABOUT_OFFICIAL","Official Module:");
define("_AM_MYLINKS_ABOUT_VERSION","Version:");
define("_AM_MYLINKS_ABOUT_WEBSITE","Website: ");
define("_AM_MYLINKS_ABOUT_RELEASEDATE","Released: ");
define("_AM_MYLINKS_ABOUT_UPDATEDATE","Updated: ");

// admin.php
define("_AM_MYLINKS_ADMIN_SYSTEM_CONFIG","System Configuration");

// index.php
define("_AM_MYLINKS_ADMIN_INDEX","Index");
define("_AM_MYLINKS_ADMIN_ABOUT","About");
define("_AM_MYLINKS_ADMIN_HELP","Help");
define("_AM_MYLINKS_ADMIN_PAGES","Pages");
define("_AM_MYLINKS_ADMIN_UPDATE","Update");
define("_AM_MYLINKS_ADMIN_PREFERENCES","Settings");

// text in admin footer
define("_AM_MYLINKS_ADMIN_FOOTER","<div class='center smallsmall italic pad5'><strong>{$admin_mydirname}</strong> is maintained by the <a class='tooltip' rel='external' href='http://xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a></div>");

define('_MYLINKS_ADMIN_'," "); //

//myblocksadmin
define('_AM_MYLINKS_AGDS',"Admin Groups");
define('_AM_MYLINKS_BADMIN',"Blocks Admin");
define('_AM_MYLINKS_TITLE',"Title");
define('_AM_MYLINKS_SIDE',"Description");
define('_AM_MYLINKS_WEIGHT',"Weight");

define('_AM_MYLINKS_VISIBLEIN',"Visible in");
define('_AM_MYLINKS_BCACHETIME',"Cache Time");
define('_AM_MYLINKS_ACTION',"Action");
define('_AM_MYLINKS_ACTIVERIGHTS',"Admin Rights");
define('_AM_MYLINKS_ACCESSRIGHTS',"Access Rights");

//Template Admin
define('_AM_MYLINKS_TPLSETS',"Template Management");
define('_AM_MYLINKS_GENERATE',"Generate");
define('_AM_MYLINKS_FILENAME',"File Name");

//main.php
define("_AM_MYLINKS_IGNORE","Ignore");
