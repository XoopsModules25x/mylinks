<?php
/*
 mylinks - MODULE FOR XOOPS
 XOOPS - PHP Content Management System
 Copyright (c) 2000 XOOPS.org
 <http://www.xoops.org/>
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
 * @version::    $Id: modinfo.php 11819 2013-07-09 18:21:40Z zyspec $
 */

// The name of this module
define("_MI_MYLINKS_NAME","��󥯽�");

// A brief description of this module
define("_MI_MYLINKS_DESC","�桼������ͳ�˥�󥯾������Ͽ��������ɾ����Ԥ��륻��������������ޤ���");

// Names of blocks for this module (Not all module has blocks)
define("_MI_MYLINKS_BNAME1","������");
define('_MI_MYLINKS_BNAME1DESC','Shows recently added web links');
define("_MI_MYLINKS_BNAME2","��ɾ�����");
define('_MI_MYLINKS_BNAME2DESC','Shows most visited web links');
define('_MI_MYLINKS_BNAME3','Random Link');
define('_MI_MYLINKS_BNAME3DESC','Shows a random link');

// Sub menu titles
define("_MI_MYLINKS_SMNAME1","��Ͽ����");
define("_MI_MYLINKS_SMNAME2","�͵����");
define("_MI_MYLINKS_SMNAME3","��ɾ�����");
define('_MI_MYLINKS_SMNAME4','Most Recent');

// Names of admin menu items
define("_MI_MYLINKS_ADMENU2","��󥯾�����ɲ� / �Խ�");
define("_MI_MYLINKS_ADMENU3","������ƥ��");
define("_MI_MYLINKS_ADMENU4","����ڤ����");
define("_MI_MYLINKS_ADMENU5","������󥯾���");
define('_MI_MYLINKS_ADMENU6','Permissions');
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
define('_MI_MYLINKS_POPULAR','�ֿ͵���󥯡פˤʤ뤿��Υҥåȿ�');
define('_MI_MYLINKS_NEWLINKS','�ȥåץڡ����Ρֿ����󥯡פ�ɽ��������');
define('_MI_MYLINKS_PERPAGE','���ڡ������ɽ�������󥯤η��');
define('_MI_MYLINKS_USESHOTS','�����꡼�󥷥�åȤ���Ѥ���');
define('_MI_MYLINKS_USEFRAMES','�ե졼�����Ѥ���');
define('_MI_MYLINKS_SHOTWIDTH','�����꡼�󥷥�åȤβ�����');
define('_MI_MYLINKS_SHOTPROVIDER','Select the external screen shot provider');
define('_MI_MYLINKS_DISPATTR', 'Display shot attribution');
define('_MI_MYLINKS_SHOTPUBKEY', 'Shot provider primary key');
define('_MI_MYLINKS_SHOTPRIVKEY', 'Shot provider secondary key');
define('_MI_MYLINKS_ANONPOST','ƿ̾�桼���ˤ���󥯤���Ƥ���Ĥ���');
define('_MI_MYLINKS_AUTOAPPROVE','�����Ԥβ�ߤ��ʤ�������󥯤μ�ư��ǧ');
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
define('_MI_MYLINKS_POPULARDSC','�ֿ͵����ץ�������ɽ������뤿��Υҥåȿ����ꤷ�Ƥ���������');
define('_MI_MYLINKS_NEWLINKSDSC','�ȥåץڡ����Ρֿ����󥯡ץ֥�å���ɽ��������������ꤷ�Ƥ���������');
define('_MI_MYLINKS_PERPAGEDSC','��󥯰���ɽ���ǣ��ڡ����������ɽ��������������ꤷ�Ƥ���������');
define('_MI_MYLINKS_USEFRAMEDSC','��󥯥ڡ�����ե졼�����ɽ�����뤫�ɤ���');
define('_MI_MYLINKS_USESHOTSDSC','��󥯾���˥����꡼�󥷥�åȲ�����ɽ��������ϡ֤Ϥ��פ����򤷤Ƥ���������');
define('_MI_MYLINKS_SHOTWIDTHDSC','�����꡼�󥷥�åȲ����β����κ����ͤ���ꤷ�Ƥ���������');
define('_MI_MYLINKS_SHOTPROVIDERDSC','Provider for screen shots if images from image directory are not used.');
define('_MI_MYLINKS_DISPATTRDSC', 'Some providers require you display an image attribution<br />Do not disable this unless you are sure.');
define('_MI_MYLINKS_SHOTPUBKEYDSC', 'Enter the primary (or public) key if required by shot provider service.');
define('_MI_MYLINKS_SHOTPRIVKEYDSC', 'Enter the secondary (or private) key if required by shot provider service.');
define('_MI_MYLINKS_AUTOAPPROVEDSC','�����Ԥξ�ǧ���ʤ��˿��������Ͽ�ξ�ǧ��Ԥ����ϡ֤Ϥ��פ����򤷤Ƥ���������');
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
define('_MI_MYLINKS_GLOBAL_NOTIFY','�⥸�塼������');
define('_MI_MYLINKS_GLOBAL_NOTIFYDSC','��󥯽��⥸�塼�����Τˤ��������Υ��ץ����');

define('_MI_MYLINKS_CATEGORY_NOTIFY','ɽ����Υ��ƥ���');
define('_MI_MYLINKS_CATEGORY_NOTIFYDSC','ɽ����Υ��ƥ�����Ф������Υ��ץ����');

define('_MI_MYLINKS_LINK_NOTIFY','ɽ����Υ��');
define('_MI_MYLINKS_LINK_NOTIFYDSC','ɽ����Υ�󥯤��Ф������Υ��ץ����');

define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFY','�������ƥ���');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYCAP','�������ƥ��꤬�������줿�������Τ���');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYDSC','�������ƥ��꤬�������줿�������Τ���');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : �������ƥ��꤬��������ޤ����ʥ�󥯽���');

define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFY','��󥯽����Υꥯ������');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYCAP','��󥯽����Υꥯ�����Ȥ����ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYDSC','��󥯽����Υꥯ�����Ȥ����ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE}: ��󥯽����Υꥯ�����Ȥ�����ޤ���');

define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFY','����ڤ����');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYCAP','����ڤ����𤬤��ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYDSC','����ڤ����𤬤��ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE}: ����ڤ����𤬤���ޤ���');

define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFY','����������');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYCAP','������󥯤���Ƥ����ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYDSC','������󥯤���Ƥ����ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE}: ������󥯤���Ƥ�����ޤ���');

define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFY','������󥯷Ǻ�');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYCAP','������󥯤��Ǻܤ��줿�������Τ���');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYDSC','������󥯤��Ǻܤ��줿�������Τ���');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE}: ������󥯤��Ǻܤ���ޤ���');

define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFY','���������ơ����ꥫ�ƥ����');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYCAP','���Υ��ƥ���ˤ����ƿ�����󥯤���Ƥ��줿�������Τ���');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYDSC','���Υ��ƥ���ˤ����ƿ�����󥯤���Ƥ��줿�������Τ���');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE}: ������󥯤���Ƥ�����ޤ���');

define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFY','������󥯷Ǻܡ����ꥫ�ƥ����');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYCAP','���Υ��ƥ���ˤ����ƿ�����󥯤��Ǻܤ��줿�������Τ���');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYDSC','���Υ��ƥ���ˤ����ƿ�����󥯤��Ǻܤ��줿�������Τ���');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE}: ������󥯤��Ǻܤ���ޤ���');

define('_MI_MYLINKS_LINK_APPROVE_NOTIFY','��󥯾�ǧ');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYCAP','���Υ�󥯤���ǧ���줿�������Τ���');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYDSC','���Υ�󥯤���ǧ���줿�������Τ���');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE}: ��󥯤���ǧ����ޤ���');

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
