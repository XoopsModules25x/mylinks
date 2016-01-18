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
 * @version::    $Id: admin.php 11819 2013-07-09 18:21:40Z zyspec $
 * ****************************************************************************
 */
//3.1
$admin_mydirname = basename(dirname(dirname(dirname(__FILE__))));

define('_AM_MYLINKS_ERROR_MODADMIN',"Error: Frameworks \"moduleadmin\" is not installed. Please install this Framework");

// About.php
define("_AM_MYLINKS_ABOUT_AUTHOR","Auteur: ");
define("_AM_MYLINKS_ABOUT_AUTHOR_INFO","Auteur Info");
define("_AM_MYLINKS_ABOUT_AUTHOR_NAME","Auteur naam: ");
define("_AM_MYLINKS_ABOUT_CHANGELOG","Wijzigingen Log");
define("_AM_MYLINKS_ABOUT_CREDITS","Credits: ");
define("_AM_MYLINKS_ABOUT_DESCRIPTION","Omschrijving: ");
define("_AM_MYLINKS_ABOUT_LICENSE","Licentie: ");
define("_AM_MYLINKS_ABOUT_MODULE_INFO","Module Info");
define("_AM_MYLINKS_ABOUT_MODULE_STATUS","Status: ");
define("_AM_MYLINKS_ABOUT_OFFICIAL","Officiele Module:");
define("_AM_MYLINKS_ABOUT_VERSION","Versie:");
define("_AM_MYLINKS_ABOUT_WEBSITE","Website: ");
define("_AM_MYLINKS_ABOUT_RELEASEDATE","Gepubliceerd: ");
define("_AM_MYLINKS_ABOUT_UPDATEDATE","Bijgewerkt: ");

// admin.php
define("_AM_MYLINKS_ADMIN_SYSTEM_CONFIG","Systeem Configuratie");

// index.php
define("_AM_MYLINKS_ADMIN_INDEX","Index");
define("_AM_MYLINKS_ADMIN_ABOUT","Over");
define("_AM_MYLINKS_ADMIN_HELP","Help");
define("_AM_MYLINKS_ADMIN_PAGES","Paginas");
define("_AM_MYLINKS_ADMIN_UPDATE","Bijwerken");
define("_AM_MYLINKS_ADMIN_PREFERENCES","Voorkeuren");

// main.php
define("_AM_MYLINKS_IGNORE","Negeren");

// text in admin footer
define("_AM_MYLINKS_ADMIN_FOOTER","<div class='right smallsmall italic pad5'><strong>{$xoopsModule->getVar('name')}</strong> wordt onderhouden door de <a class='tooltip' rel='external' href='http://xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a></div>");

define('_MYLINKS_ADMIN_'," "); //

//myblocksadmin
define('_AM_MYLINKS_AGDS',"Beheer Groepen");
define('_AM_MYLINKS_BADMIN',"Blokken Beheer");
define('_AM_MYLINKS_TITLE',"Titel");
define('_AM_MYLINKS_SIDE',"Omschrijving");
define('_AM_MYLINKS_WEIGHT',"Belang");

define('_AM_MYLINKS_VISIBLEIN',"Zichtbaar in");
define('_AM_MYLINKS_BCACHETIME',"Cache Tijd");
define('_AM_MYLINKS_ACTION',"Aktie");
define('_AM_MYLINKS_ACTIVERIGHTS',"Beheer Inzending");
define('_AM_MYLINKS_ACCESSRIGHTS',"Rechten Toegang");

//Template Admin
define('_AM_MYLINKS_TPLSETS',"Sjabloon beheer");
define('_AM_MYLINKS_GENERATE',"Genereren");
define('_AM_MYLINKS_FILENAME',"Bestandsnaam");
