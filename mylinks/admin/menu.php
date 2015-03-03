<?php
// $Id: menu.php 8574 2011-12-27 02:45:39Z beckmi $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

$dirname = basename(dirname(dirname(__FILE__)));
$module_handler = xoops_gethandler('module');
$module = $module_handler->getByDirname($dirname);
$pathIcon32 = $module->getInfo('icons32');

//xoops_loadLanguage('admin', $dirname);

$adminmenu = array();

$i = 1;
$adminmenu[$i]['title'] = _MYLINKS_ADMIN_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['desc']  = _MYLINKS_ADMIN_HOME_DESC;
$adminmenu[$i]['icon']  = $pathIcon32.'//home.png';
$i++;
$adminmenu[$i]['title'] = _MI_MYLINKS_ADMENU2;
$adminmenu[$i]['link']  = 'admin/main.php?op=linksConfigMenu';
$adminmenu[$i]['desc']  = _MI_MYLINKS_ADMENU2_DESC;
$adminmenu[$i]['icon']  = $pathIcon32.'/addlink.png';
$i++;
$adminmenu[$i]['title'] = _MI_MYLINKS_ADMENU3;
$adminmenu[$i]['link']  = 'admin/main.php?op=listNewLinks';
$adminmenu[$i]['desc']  = _MI_MYLINKS_ADMENU3_DESC;
$adminmenu[$i]['icon']  = $pathIcon32.'/submittedlink.png';
$i++;
$adminmenu[$i]['title'] = _MI_MYLINKS_ADMENU4;
$adminmenu[$i]['link']  = 'admin/main.php?op=listBrokenLinks';
$adminmenu[$i]['desc']  = _MI_MYLINKS_ADMENU4_DESC;
$adminmenu[$i]['icon']  = $pathIcon32.'/brokenlink.png';
$i++;
$adminmenu[$i]['title'] = _MI_MYLINKS_ADMENU5;
$adminmenu[$i]['link']  = 'admin/main.php?op=listModReq';
$adminmenu[$i]['desc']  = _MI_MYLINKS_ADMENU5_DESC;
$adminmenu[$i]['icon']  = $pathIcon32.'/modifiedlink.png';
$i++;
$adminmenu[$i]['title'] = _MI_MYLINKS_ADMENU6;  //'Block/Group Admin';
$adminmenu[$i]['link']  = 'admin/myblocksadmin.php';
$adminmenu[$i]['desc']  = _MI_MYLINKS_ADMENU6_DESC;
$adminmenu[$i]['icon']  = $pathIcon32.'/permissions.png';
$i++;
$adminmenu[$i]['title'] = _MI_MYLINKS_ADMENU7; //'Template Admin';
$adminmenu[$i]['link']  = 'admin/mytplsadmin.php';
$adminmenu[$i]['desc']  = _MI_MYLINKS_ADMENU7_DESC;
$adminmenu[$i]['icon']  = $pathIcon32.'/administration.png';
$i++;
$adminmenu[$i]['title'] = _MYLINKS_ADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['desc']  = _MYLINKS_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon']  = $pathIcon32.'/about.png';
