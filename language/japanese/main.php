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
 * @version::    $Id: main.php 11819 2013-07-09 18:21:40Z zyspec $
 */

define("_MD_MYLINKS_THANKSFORINFO","����򤢤꤬�Ȥ��������ޤ��������������ꥯ�����ȤϤ�����Ĵ�����ޤ���");
define("_MD_MYLINKS_THANKSFORHELP","���Υǥ��쥯�ȥ�ݻ��ˤ����Ϥ����������꤬�Ȥ��������ޤ���");
define("_MD_MYLINKS_FORSECURITY","�������ƥ����ΰ٤˰��Ū�ˤ��ʤ��Υ桼��̾��IP���ɥ쥹��Ͽ�����Ƥ��������ޤ���");

define("_MD_MYLINKS_SEARCHFOR","����"); //-no use
define("_MD_MYLINKS_ANY","�ɤ줫");
define("_MD_MYLINKS_SEARCH","����");

define("_MD_MYLINKS_MAIN","�ᥤ��");
define("_MD_MYLINKS_SUBMITLINK","�����Ͽ");
define("_MD_MYLINKS_SUBMITLINKHEAD","��󥯥ե��������Ͽ");
define("_MD_MYLINKS_POPULAR","�͵�");
define("_MD_MYLINKS_TOPRATED","�ȥåץ졼��");

define("_MD_MYLINKS_NEWTHISWEEK","�����κǿ�������");
define("_MD_MYLINKS_UPTHISWEEK","�����ι���������");

define("_MD_MYLINKS_POPULARITYLTOM","�͵� (�ҥåȿ�ξ��ʤ���)");
define("_MD_MYLINKS_POPULARITYMTOL","�͵� (�ҥåȿ��¿����)");
define("_MD_MYLINKS_TITLEATOZ","�����ȥ� (A to Z)");
define("_MD_MYLINKS_TITLEZTOA","�����ȥ� (Z to A)");
define("_MD_MYLINKS_DATEOLD","���� (��Ͽ���θŤ���)");
define("_MD_MYLINKS_DATENEW","���� (��Ͽ���ο�������)");
define("_MD_MYLINKS_RATINGLTOH","ɾ�� (ɾ�����㤤��)");
define("_MD_MYLINKS_RATINGHTOL","ɾ�� (ɾ���ι⤤��)");

define("_MD_MYLINKS_NOSHOTS","�����꡼�󥷥�åȤʤ�");
define("_MD_MYLINKS_EDITTHISLINK","���Υ�󥯤��Խ�");

define("_MD_MYLINKS_DESCRIPTIONC","������");
define("_MD_MYLINKS_EMAILC","Email: ");
define("_MD_MYLINKS_CATEGORYC","���ƥ���: ");
define("_MD_MYLINKS_LASTUPDATEC","�ǽ�������: ");
define("_MD_MYLINKS_HITSC","�ҥåȿ�: ");
define("_MD_MYLINKS_RATINGC","ɾ��: ");
define("_MD_MYLINKS_ONEVOTE","��ɼ�� 1");
define("_MD_MYLINKS_NUMVOTES","��ɼ�� %s ");
define("_MD_MYLINKS_RATETHISSITE","���Υ����Ȥ�ɾ������");
define("_MD_MYLINKS_MODIFY","����");
define("_MD_MYLINKS_REPORTBROKEN","����ڤ����");
define("_MD_MYLINKS_TELLAFRIEND","ͧã�˾Ҳ�");

define("_MD_MYLINKS_THEREARE","���ߥǡ����١����ˤ�<b>%s</b>��Υ�󥯤���Ͽ����Ƥ��ޤ���");
define("_MD_MYLINKS_LATESTLIST","�ǿ��ꥹ��");

define("_MD_MYLINKS_REQUESTMOD","��󥯽����ꥯ������");
define("_MD_MYLINKS_LINKID","��� ID: ");
define("_MD_MYLINKS_SITETITLE","�����֥�����̾: ");
define("_MD_MYLINKS_SITEURL","�����֥����� URL: ");
define("_MD_MYLINKS_OPTIONS", '���ץ����');
define("_MD_MYLINKS_NOTIFYAPPROVE", '���Υ�󥯤���ǧ���줿�������Τ���');
define("_MD_MYLINKS_SHOTIMAGE","�����꡼�󥷥�åȲ���: ");
define("_MD_MYLINKS_SENDREQUEST","�ꥯ�����Ȥ�����");

define("_MD_MYLINKS_VOTEAPPRE","���ʤ�����ɼ��ȿ�Ǥ���ޤ���");
define("_MD_MYLINKS_THANKURATE","%s�ˤ����Ϥ��꤬�Ȥ��������ޤ���");
define("_MD_MYLINKS_VOTEFROMYOU","���ʤ�����ɼ��¾�Υ桼������󥯤������Ƚ�Ǵ�����Ω���ޤ���");
define("_MD_MYLINKS_VOTEONCE","Ʊ�쥵���Ȥ��Ф�����ɼ�Ǥ���Τϣ���¤�Ȥ����Ƥ��������ޤ���");
define("_MD_MYLINKS_RATINGSCALE","ɾ����1��10�δ֤��餪���Ӥ���������������礭���ۤ�ɾ�����⤤���Ȥ򼨤��ޤ���");
define("_MD_MYLINKS_BEOBJECTIVE","������Ƚ�Ǥˤ����ɼ�򤪴ꤤ�פ��ޤ�");
define("_MD_MYLINKS_DONOTVOTE","��ʬ���ȤΥ����Ȥ��Ф��Ƥ���ɼ�ϤǤ��ޤ���");
define("_MD_MYLINKS_RATEIT","ɾ������");

define("_MD_MYLINKS_INTRESTLINK","%s�Ǥζ�̣���������֥����ȥ��"); // %s is your site name
define("_MD_MYLINKS_INTLINKFOUND","%s�ˤƤȤƤⶽ̣���������֥����Ȥ򸫤Ĥ��ޤ�����"); // %s is your site name

define("_MD_MYLINKS_RECEIVED","�����֥����Ⱦ������դ��ޤ��������꤬�Ȥ��������ޤ���");
define("_MD_MYLINKS_WHENAPPROVED","��󥯾���ϡ��������ȥ����åդˤ�뾵ǧ��������ǺܤȤʤ뤳�Ȥ�λ������������");
define("_MD_MYLINKS_SUBMITONCE","Ʊ��Υ����ϣ��󤷤���Ͽ�Ǥ��ޤ���");
define("_MD_MYLINKS_ALLPENDING","��󥯾���ϰ�ö����Ͽ���졢�����åդˤ���ǧ���������ޤ���");
define("_MD_MYLINKS_DONTABUSE","���ʤ��Υ桼��̾��IP ���ɥ쥹�ϵ�Ͽ����ޤ��Τǡ������ʤɤϤ��ߤ᤯��������");
define("_MD_MYLINKS_TAKESHOT","���ʤ��Υ����֥����ȤΥ����꡼�󥷥�åȤ��뤫�⤷��ޤ��󡢤ޤ������Ͽ�˻��֤��������礬���뤫�⤷��ޤ���ͽ�ᤴλ������������");

define("_MD_MYLINKS_RANK","���");
define("_MD_MYLINKS_CATEGORY","���ƥ���");
define("_MD_MYLINKS_HITS","�ҥåȿ�");
define("_MD_MYLINKS_RECENT","Most Recent");
define("_MD_MYLINKS_RATING","ɾ��");
define("_MD_MYLINKS_VOTE","��ɼ��");
define("_MD_MYLINKS_TOP10","%s �ȥå� 10"); // %s is a link category title

define("_MD_MYLINKS_SEARCHRESULTS","�������: <b>%s</b>:"); // %s is search keywords
define("_MD_MYLINKS_SORTBY","�����Ƚ�:");
define("_MD_MYLINKS_TITLE","�����ȥ�");
define("_MD_MYLINKS_DATE","����");
define("_MD_MYLINKS_POPULARITY","�͵�");
define("_MD_MYLINKS_CURSORTEDBY","���ߤΥ����Ƚ祵����: %s");
define("_MD_MYLINKS_PREVIOUS","���Υڡ���");
define("_MD_MYLINKS_NEXT","���Υڡ���");
define("_MD_MYLINKS_NOMATCH","���פ���ǡ����ϸ��Ĥ���ޤ���Ǥ�����");

//define("_MD_MYLINKS_SUBMIT","����");
//define("_MD_MYLINKS_CANCEL","���");

define("_MD_MYLINKS_ALREADYREPORTED","���ʤ�����Υ���ڤ�����ϴ��˼����դ��ޤ�����");
define("_MD_MYLINKS_MUSTREGFIRST","�������������ޤ��󤬤��ʤ��Ϥ��Υڡ����ˤϥ��������Ǥ��ޤ���<br />�ޤ���Ͽ����뤫��������󤷤Ʋ�������");
define("_MD_MYLINKS_NORATING","ɾ�������򤵤�Ƥ��ޤ���");
define("_MD_MYLINKS_CANTVOTEOWN","���ʤ�����Ͽ������󥯤ˤ���ɼ�Ǥ��ޤ���<br />��ɼ�����Ƶ�Ͽ����Ĵ������ޤ���");
define("_MD_MYLINKS_VOTEONCE2","����������ޤ��󤬡�Ʊ���󥯾���ؤ���ɼ�ϰ��¤�Ȥ����Ƥ��������Ƥ��ޤ���");

//%%%%%% Module Name 'MyLinks' (Admin) %%%%%

define("_MD_MYLINKS_WEBLINKSCONF","��󥯽�����");
define("_MD_MYLINKS_GENERALSET","��������");
define("_MD_MYLINKS_ADDMODDELETE","���ƥ��ꤪ��ӥ�󥯾�����ɲá����������");
define("_MD_MYLINKS_LINKSWAITING","��ǧ�Ԥ����");
define("_MD_MYLINKS_BROKENREPORTS","����ڤ����");
define("_MD_MYLINKS_MODREQUESTS","��󥯾������Υꥯ������");
define("_MD_MYLINKS_SUBMITTER","��Ƽ�: ");
define("_MD_MYLINKS_VISIT","ˬ��");
define("_MD_MYLINKS_SHOTMUST","�����꡼�󥷥�åȲ����� %s �ǥ��쥯�ȥ겼�Υե�����̾�ǻ��ꤷ�Ʋ������� (��. shot.gif). �⤷�����ե����뤬�ʤ����϶���ˤ��Ƥ����Ʋ�������");
define("_MD_MYLINKS_APPROVE","��ǧ����");
//define("_MD_MYLINKS_DELETE","���");
define("_MD_MYLINKS_NOSUBMITTED","�����������Ͽ�ο����Ϥ���ޤ���");
define("_MD_MYLINKS_ADDMAIN","�ᥤ�󥫥ƥ����ɲ�");
define("_MD_MYLINKS_TITLEC","�����ȥ�: ");
define("_MD_MYLINKS_IMGURL","���ƥ������URL�ʥ��ץ����Ǥ��������ե�����ι⤵�ϼ�ưŪ��50�ԥ������Ĵ������ޤ����ᥤ�󥫥ƥ����ѡˡ�");
//define("_MD_MYLINKS_ADD","�ɲ�");
define("_MD_MYLINKS_ADDSUB","���֥��ƥ����ɲ�");
define("_MD_MYLINKS_IN","�ƥ��ƥ��ꡧ");
define("_MD_MYLINKS_ADDNEWLINK","����������ɲ�");
define("_MD_MYLINKS_MODCAT","���ƥ��꽤��");
define("_MD_MYLINKS_MODLINK","��󥯽���");
define("_MD_MYLINKS_TOTALVOTES","��󥯤���ɼ�� (��ɼ��ι��: %s)");
define("_MD_MYLINKS_USERTOTALVOTES","��Ͽ�桼���ˤ��ɾ���� (��ɼ��ι��: %s)");
define("_MD_MYLINKS_ANONTOTALVOTES","̤��Ͽ�桼���ˤ��ɾ���� (��ɼ��ι��: %s)");
define("_MD_MYLINKS_USER","�桼��");
define("_MD_MYLINKS_IP","IP ���ɥ쥹");
define("_MD_MYLINKS_USERAVG","�桼����ʿ��ɾ����");
define("_MD_MYLINKS_TOTALRATE","��ɾ��");
define("_MD_MYLINKS_NOREGVOTES","��Ͽ�桼���ˤ��ɾ���Ϥ���ޤ���");
define("_MD_MYLINKS_NOUNREGVOTES","̤��Ͽ�桼���ˤ��ɾ���Ϥ���ޤ���");
define("_MD_MYLINKS_VOTEDELETED","��ɼ�ǡ����Ϻ������ޤ�����");
define("_MD_MYLINKS_NOBROKEN","����ڤ����Ϥ���ޤ���");
define("_MD_MYLINKS_DELETEDESC","������� (<b>���ˤ��ä������֥����ȤΥǡ���</b>��<b>����ڤ����</b>��������)");
define("_MD_MYLINKS_EDITDESC","Edit (Deletes the broken link report and goes to edit the link)");
define("_MD_MYLINKS_IGNOREDESC","̵�뤹�� (<b>����ڤ����</b>������������̵�뤹��)");
define("_MD_MYLINKS_REPORTER","�����ԡ�");
define("_MD_MYLINKS_LINKSUBMITTER","��󥯾����󶡼ԡ�");
define("_MD_MYLINKS_IGNORE","̵��");
define("_MD_MYLINKS_LINKDELETED","��󥯾���������ޤ�����");
define("_MD_MYLINKS_BROKENDELETED","����ڤ����������ޤ�����");
define("_MD_MYLINKS_USERMODREQ","��󥯽����ꥯ�����ȥ桼��");
define("_MD_MYLINKS_ORIGINAL","������");
define("_MD_MYLINKS_PROPOSED","������");
define("_MD_MYLINKS_OWNER","��󥯾����󶡼ԡ�");
define("_MD_MYLINKS_NOMODREQ","��󥯽����ꥯ�����ȤϤ���ޤ���");
define("_MD_MYLINKS_DBUPDATED","�ǡ����١����򹹿����ޤ�����");
define("_MD_MYLINKS_DBNOTUPDATED","ERROR: Database could not be updated with the data supplied!");
define("_MD_MYLINKS_MODREQDELETED","�����ꥯ�����Ȥ������ޤ�����");
define("_MD_MYLINKS_IMGURLMAIN","���ƥ������URL�ʥ��ץ����Ǥ��������ե�����ι⤵�ϼ�ưŪ��50�ԥ������Ĵ������ޤ����ᥤ�󥫥ƥ����ѡˡ�");
define("_MD_MYLINKS_PARENT","�ƥ��ƥ���:");
define("_MD_MYLINKS_SAVE","�ѹ�����¸");
define("_MD_MYLINKS_CATDELETED","���ƥ���������ޤ�����");
define("_MD_MYLINKS_WARNING","���: �����ˤ��Υ��ƥ���ڤӤ���˴�Ϣ�����󥯡������Ȥ������ޤ�����");
//define("_MD_MYLINKS_YES","�Ϥ�");
//define("_MD_MYLINKS_NO","������");
define("_MD_MYLINKS_NEWCATADDED","���ƥ�����ɲä��ޤ�����");
define("_MD_MYLINKS_ERROREXIST","���顼: ���Υ�󥯤ϴ��˥ǡ����١�������Ͽ����Ƥ��ޤ���");
define("_MD_MYLINKS_ERRORTITLE","���顼: �����ȥ�����Ϥ��Ʋ�������");
define("_MD_MYLINKS_ERRORDESC","���顼: �����פ����򤷤Ʋ�������");
define("_MD_MYLINKS_ERRORURL","ERROR: You need to enter a site URL!");
define("_MD_MYLINKS_NEWLINKADDED","��������󥯤ϥǡ����١������ɲä���ޤ�����");
define("_MD_MYLINKS_YOURLINK","Your link submitted at %s"); //[MADA]
define("_MD_MYLINKS_YOUCANBROWSE","%s�Υ�󥯽��ˤ��͡��ʥ����֥����ȤΥ�󥯾�������ˤʤ�ޤ���");
define("_MD_MYLINKS_HELLO","%s���󡢤���ˤ���");
define("_MD_MYLINKS_WEAPPROVED","���ʤ�����Υ����֥�󥯤Υǡ����١����ؤΥ����Ͽ�����Ͼ�ǧ����ޤ�����");
define("_MD_MYLINKS_THANKSSUBMIT","�����Ͽ�������꤬�Ȥ��������ޤ���");
define("_MD_MYLINKS_ISAPPROVED","���ʤ�����Υ����Ͽ�����Ͼ�ǧ����ޤ�����");

//Ver2.0
define("_MD_MYLINKS_BROWSETOTOPIC","Browse Links by alphabetical listing");
define("_MD_MYLINKS_LINKS_LIST","Links list (%s)");

//ver3.0
define("_MD_MYLINKS_FEED","Module Feed ");
define("_MD_MYLINKS_FEED_CAT","Category Feed ");
define("_MD_MYLINKS_RSSFEED","RSS-Module Feed");
define("_MD_MYLINKS_ATOMFEED","ATOM-Module Feed");
define("_MD_MYLINKS_PDAFEED","PDA-Module Feed");
define("_MD_MYLINKS_RSSFEED_CAT","RSS-Category Feed");
define("_MD_MYLINKS_ATOMFEED_CAT","ATOM-Category Feed");
define("_MD_MYLINKS_PDAFEED_CAT","PDA-Category Feed");
define("_MD_MYLINKS_MINIMIZEBLOCK","Click me if you want to minimize this block");
define("_MD_MYLINKS_RESTOREBLOCK","Click me if you want to restore this block");
define("_MD_MYLINKS_GOTOTOP","Go to Top");
define("_MD_MYLINKS_GOTOBOTTOM","Go to Bottom");
define("_MD_MYLINKS_FULLVIEW","detail");
define("_MD_MYLINKS_MAKE_PRINT","print it");
define("_MD_MYLINKS_MAKE_PDF","make pdf");
define("_MD_MYLINKS_MAKE_QRCODE","make QrCode");
define("_MD_MYLINKS_BOOKMARK","bookmark it");
define("_MD_MYLINKS_FEEDSUBSCRIPT","feed subscription");
define("_MD_MYLINKS_FEEDSUBSCRIPT_DESC","Click here to subscribe this feed!");
define("_MD_MYLINKS_WEBBROWSER","Web Browser");
define("_MD_MYLINKS_BROWSERBOOKMARK","# Browser Bookmark");
define("_MD_MYLINKS_QRCODE","QrCode");
define("_MD_MYLINKS_THEMECHANGER","Theme Changer: ");
define("_MD_MYLINKS_INTERNALSEARCH","Internal Search");
define("_MD_MYLINKS_EXTERNALSEARCH","* More Search with External Search Engines *");
define("_MD_MYLINKS_EXTERNALSEARCH_KEYWORD","<br />Keyword => %s (<font color='red'><b>%s</b></font>)");
define("_MD_MYLINKS_BOOKMARK_SERVICE","Social Bookmark Service");
define("_MD_MYLINKS_FEEDSUBSCRIPT_SERVICE","Feed Subscription Service");
define("_MD_MYLINKS_BOOKMARK_ADDTO","Add this website To...");

//ver3.1x
define("_MD_MYLINKS_BACKTO","Back to ");
define("_MD_MYLINKS_CLOSEFRAME","Close Frame");
define("_MD_MYLINKS_IDERROR","An invalid category or link was entered, please try again.");
define("_MD_MYLINKS_CIDERROR","An invalid category id was entered, please try again.");
define("_MD_MYLINKS_NORECORDFOUND","No records found. Please check category and/or link information!");
define("_MD_MYLINKS_DISALLOW", 0);
define("_MD_MYLINKS_ALLOW", 1);
define("_MD_MYLINKS_MEMBERONLY", 2);
define("_MD_MYLINKS_BOOKMARKDISALLOWED","You are not allowed to create a bookmark.");
define("_MD_MYLINKS_PRINTINGDISALLOWED","You are not allowed to print.");
define("_MD_MYLINKS_PDFDISALLOWED","You are not allowed to create a pdf document.");
define("_MD_MYLINKS_QRCODEDISALLOWED","You are not allowed to create a QrCode.");
define("_MD_MYLINKS_IMPORTCATHDR","Import Default Categories");
define("_MD_MYLINKS_IMPORTCATS","Import default MyLinks categories into the database");
define("_MD_MYLINKS_CATSIMPORTED","New categories successfully imported into the database");
define("_MD_MYLINKS_CATSNOTIMPORTED","There was a problem importing the new categories - import failed");
define("_MD_MYLINKS_IMPORTFILENOTFOUND","Import file (%s) was not found - import failed");
define("_MD_MYLINKS_CATWARNING","Are you sure you want to import these new categories and ALL of subcategories into the database?");
define("_MD_MYLINKS_COPYNOTICE","Copyright (c) %s by %s");
define("_MD_MYLINKS_FROM","From");
define("_MD_MYLINKS_LINKNAME","Link Name");
define("_MD_MYLINKS_LTRCHARS","0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z");
define("_MD_MYLINKS_NOTOP10","There is insufficient user input to show link ");
define("_MD_MYLINKS_ACTIONS","Actions");
define("_MD_MYLINKS_FRIEND","Friend");
define("_MD_MYLINKS_SENDER","Your");
define("_MD_MYLINKS_NAME","Name");
define("_MD_MYLINKS_EMAIL","Email");
define("_MD_MYLINKS_INVALIDEMAIL","Please enter a valid email address.");
define("_MD_MYLINKS_MESSEND","Your message has been sent");
define("_MD_MYLINKS_INVALIDORINACTIVELNK","The link you entered is either invalid or not active.");
define("_MD_MYLINKS_INVALID_SECURITY_TOKEN","Invalid security token. Please try again.");
define("_MD_MYLINKS_EMAIL_SUBJECT","%s link from %s");
