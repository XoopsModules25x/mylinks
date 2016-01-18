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
 * @version::    $Id: main.php 11819 2013-07-09 18:21:40Z zyspec $
 */

define("_MD_MYLINKS_THANKSFORINFO","��ũ������ ������ �ּż� �����մϴ�. ������ Ȯ���� �� �������� ���ó���� �帮�ڽ��ϴ�.");
define("_MD_MYLINKS_THANKSFORHELP","����/������ �ּż� �������� ����帳�ϴ�. ������ Ȯ���� �� �ݿ��ϵ��� �ϰڽ��ϴ�.");
define("_MD_MYLINKS_FORSECURITY","����Ʈ/���� ������ ���� ���� IP�� ���̵� �ӽ������� ���ó���ϴ� �� ���� �ٶ��ϴ�.");

define("_MD_MYLINKS_SEARCHFOR","�˻�");
define("_MD_MYLINKS_ANY","�Ǵ�");
define("_MD_MYLINKS_SEARCH","�˻�");

define("_MD_MYLINKS_MAIN","����");
define("_MD_MYLINKS_SUBMITLINK","��ũ ���");
define("_MD_MYLINKS_SUBMITLINKHEAD","��ũ������ ���");
define("_MD_MYLINKS_POPULAR","�α�");
define("_MD_MYLINKS_TOPRATED","����");

define("_MD_MYLINKS_NEWTHISWEEK","�������̳��� ��ϵǾ�����");
define("_MD_MYLINKS_UPTHISWEEK","�������̳��� ���׷��̵�Ǿ�����");

define("_MD_MYLINKS_POPULARITYLTOM","�α� (�湮�� �����ͺ���)");
define("_MD_MYLINKS_POPULARITYMTOL","�α� (�湮�� �����ͺ���)");
define("_MD_MYLINKS_TITLEATOZ","Ÿ��Ʋ (A to Z)");
define("_MD_MYLINKS_TITLEZTOA","Ÿ��Ʋ (Z to A)");
define("_MD_MYLINKS_DATEOLD","�Ͻ� (������ �ͺ���)");
define("_MD_MYLINKS_DATENEW","�Ͻ� (���ͺ���)");
define("_MD_MYLINKS_RATINGLTOH","�� (�򰡰� ���� �ͺ���)");
define("_MD_MYLINKS_RATINGHTOL","�� (�򰡰� ���� �ͺ���)");

define("_MD_MYLINKS_NOSHOTS","��ũ������ �����ϴ�.");
define("_MD_MYLINKS_EDITTHISLINK","�� ��ũ������ ������");

define("_MD_MYLINKS_DESCRIPTIONC","����: ");
define("_MD_MYLINKS_EMAILC","�����ּ�: ");
define("_MD_MYLINKS_CATEGORYC","ī�װ��: ");
define("_MD_MYLINKS_LASTUPDATEC","���������Ͻ�: ");
define("_MD_MYLINKS_HITSC","�湮��: ");
define("_MD_MYLINKS_RATINGC","��: ");
define("_MD_MYLINKS_ONEVOTE","1 ǥ");
define("_MD_MYLINKS_NUMVOTES","%s ǥ");
define("_MD_MYLINKS_RATETHISSITE","�� ����Ʈ�� ��");
define("_MD_MYLINKS_MODIFY","����");
define("_MD_MYLINKS_REPORTBROKEN","������ ��ũ �Ű�");
define("_MD_MYLINKS_TELLAFRIEND","ģ������ ��õ");

define("_MD_MYLINKS_THEREARE","�� ����Ʈ���� ��<b>%s</b> ���� ��ũ������ �����մϴ�.");
define("_MD_MYLINKS_LATESTLIST","�ű� ��ũ ����Ʈ");

define("_MD_MYLINKS_REQUESTMOD","��ũ������ ���� ��û");
define("_MD_MYLINKS_LINKID","��ũ ID: ");
define("_MD_MYLINKS_SITETITLE","����Ʈ Ÿ��Ʋ: ");
define("_MD_MYLINKS_SITEURL","����Ʈ URL: ");
define("_MD_MYLINKS_OPTIONS","�ɼ�: ");
define("_MD_MYLINKS_NOTIFYAPPROVE","�� ��ũ������ ���ε� ��� ������");
define("_MD_MYLINKS_SHOTIMAGE","��ũ���� �̹���: ");
define("_MD_MYLINKS_SENDREQUEST","������");

define("_MD_MYLINKS_VOTEAPPRE","��(Vote)�� �̷�������ϴ�.");
define("_MD_MYLINKS_THANKURATE","������ ����/���� ����帳�ϴ�.(%s)");
define("_MD_MYLINKS_VOTEFROMYOU","���� �򰡴� Ÿ ȸ������ ��ũ ����Ʈ �湮���θ� ������ ���� �Ǵܱ����� �� ���Դϴ�.");
define("_MD_MYLINKS_VOTEONCE","��ũ������ ���� �򰡴� 1�� 1ȸ�� ���ѵǾ� �ֽ��ϴ�.");
define("_MD_MYLINKS_RATINGSCALE","�򰡴� 1-10�� �������� �����Ͻñ� �ٶ��ϴ�. ���� �����ϼ��� ���� �򰡸� �ǹ��մϴ�.");
define("_MD_MYLINKS_BEOBJECTIVE","������ �򰡸� ��Ź�帳�ϴ�.");
define("_MD_MYLINKS_DONOTVOTE","�ڱ��ڽ��� ��ũ������ ���ؼ� ���Ͻ� �� �����ϴ�.");
define("_MD_MYLINKS_RATEIT","��");

define("_MD_MYLINKS_INTRESTLINK","������ ��ũ����Ʈ������ �߰�(%s)"); // %s is your site name
define("_MD_MYLINKS_INTLINKFOUND","%s ���� �ſ� ������ ��ũ����Ʈ������ �߰��Ͽ����ϴ�."); // %s is your site name

define("_MD_MYLINKS_RECEIVED","��ũ ������ �����Ͽ����ϴ�. �����մϴ�.");
define("_MD_MYLINKS_WHENAPPROVED","�� ��ũ������ �������� ����/��ϵ� ��� ���Ϸ� ������ �帳�ϴ�.");
define("_MD_MYLINKS_SUBMITONCE","������ ��ũ������ �ߺ����� �Ͻ� �� �����ϴ�..");
define("_MD_MYLINKS_ALLPENDING","��� ��ũ������ ����Ȯ���� ���� ����/��Ͽ��θ� �����ϰ� �˴ϴ�.");
define("_MD_MYLINKS_DONTABUSE","���̵�� IP������ ����Ͽ����ϴ�. �ùٸ� �̿��� ��Ź�帳�ϴ�.");
define("_MD_MYLINKS_TAKESHOT","��ũ������ �������� ����/��ϵ� ������ �ణ�� ������ �ɸ����� �ִ� �� ���عٶ��ϴ�.");

define("_MD_MYLINKS_RANK","����");
define("_MD_MYLINKS_CATEGORY","ī�װ��");
define("_MD_MYLINKS_HITS","�湮��");
define("_MD_MYLINKS_RECENT","Most Recent");
define("_MD_MYLINKS_RATING","��");
define("_MD_MYLINKS_VOTE","��ǥ��");
define("_MD_MYLINKS_TOP10","%s Top 10"); // %s is a link category title

define("_MD_MYLINKS_SEARCHRESULTS","�˻����: <b>%s</b>:"); // %s is search keywords
define("_MD_MYLINKS_SORTBY","���ļ�:");
define("_MD_MYLINKS_TITLE","Ÿ��Ʋ");
define("_MD_MYLINKS_DATE","�Ͻ�");
define("_MD_MYLINKS_POPULARITY","�α�");
define("_MD_MYLINKS_CURSORTEDBY","���� ���ļ�: %s");
define("_MD_MYLINKS_PREVIOUS","���� ������");
define("_MD_MYLINKS_NEXT","���� ������");
define("_MD_MYLINKS_NOMATCH","�ش��ϴ� ��ũ������ �������� �ʽ��ϴ�.");

//define("_MD_MYLINKS_SUBMIT","������");
//define("_MD_MYLINKS_CANCEL","���");

define("_MD_MYLINKS_ALREADYREPORTED","�����κ����� ������ ��ũ�Ű�� �̹� �����Ǿ��� �����Դϴ�.");
define("_MD_MYLINKS_MUSTREGFIRST","��ũ ������ �����Ͻ÷��� ���� ȸ������� �ϼž߸� �մϴ�.");
define("_MD_MYLINKS_NORATING","�������� ���õǾ����� �ʽ��ϴ�.");
define("_MD_MYLINKS_CANTVOTEOWN","�ڱ��ڽ��� ��ũ������ ���ؼ� ���Ͻ� �� �����ϴ�.");
define("_MD_MYLINKS_VOTEONCE2","��ũ������ ���� �򰡴� 1�� 1ȸ�� �����˴ϴ�.");

//%%%%%%	Module Name 'MyLinks' (Admin)	 %%%%%

define("_MD_MYLINKS_WEBLINKSCONF","��ũ ���� ����");
define("_MD_MYLINKS_GENERALSET","�Ϲݼ���");
define("_MD_MYLINKS_ADDMODDELETE","ī�װ��/��ũ������ �߰�/����/����");
define("_MD_MYLINKS_LINKSWAITING","���δ�� ��ũ����");
define("_MD_MYLINKS_BROKENREPORTS","������ ��ũ �Ű�");
define("_MD_MYLINKS_MODREQUESTS","��ũ���� ���� ��û");
define("_MD_MYLINKS_SUBMITTER","������: ");
define("_MD_MYLINKS_VISIT","�湮");
define("_MD_MYLINKS_SHOTMUST","��ũ���� �׸������� %s ���丮���� ������ ����� �ּ���(ex. shot.gif). �׸������� �������� ���� �ÿ��� �׳� �������� �μ���.");
define("_MD_MYLINKS_APPROVE","����");
//define("_MD_MYLINKS_DELETE","����");
define("_MD_MYLINKS_NOSUBMITTED","��ũ������ �ű������ �����ϴ�.");
define("_MD_MYLINKS_ADDMAIN","���� ī�װ�� �ۼ�");
define("_MD_MYLINKS_TITLEC","Ÿ��Ʋ: ");
define("_MD_MYLINKS_IMGURL","ī�װ�� �׸����� URL (�����׸��Դϴ�. �׸����̴� 50�ȼ��� �����˴ϴ�.): ");
//define("_MD_MYLINKS_ADD","�߰�");
define("_MD_MYLINKS_ADDSUB","���� ī�װ�� �ۼ�");
define("_MD_MYLINKS_IN","�θ� ī�װ��");
define("_MD_MYLINKS_ADDNEWLINK","�ű� ��ũ����");
define("_MD_MYLINKS_MODCAT","ī�װ�� ����");
define("_MD_MYLINKS_MODLINK","��ũ���� ����");
define("_MD_MYLINKS_TOTALVOTES","�� �򰡼� (�� �򰡼� : %s)");
define("_MD_MYLINKS_USERTOTALVOTES","���ȸ���� ���� �� (�� �򰡼�: %s)");
define("_MD_MYLINKS_ANONTOTALVOTES","�մԿ� ���� �� (�� �򰡼�: %s)");
define("_MD_MYLINKS_USER","���̵�");
define("_MD_MYLINKS_IP","IP�ּ�");
define("_MD_MYLINKS_USERAVG","��� ����");
define("_MD_MYLINKS_TOTALRATE","�� ����");
define("_MD_MYLINKS_NOREGVOTES","���ȸ���� �򰡰� �����ϴ�.");
define("_MD_MYLINKS_NOUNREGVOTES","�մԿ� ���� �򰡰� �����ϴ�.");
define("_MD_MYLINKS_VOTEDELETED","�� ������ �����Ͽ����ϴ�.");
define("_MD_MYLINKS_NOBROKEN","������ ��ũ�� ���� �Ű�� �����ϴ�.");
define("_MD_MYLINKS_DELETEDESC","���� (������ ��ũ �Ű�� ���� ��ũ������ �Բ� �����մϴ�.)");
define("_MD_MYLINKS_EDITDESC","Edit (Deletes the broken link report and goes to edit the link)");
define("_MD_MYLINKS_IGNOREDESC","���� (������ ��ũ �Ű�� �����ϰ� �� <b>�Ű����</b>���� �����մϴ�.)");
define("_MD_MYLINKS_REPORTER","���� ���:");
define("_MD_MYLINKS_LINKSUBMITTER","��ũ���� ������:");
define("_MD_MYLINKS_IGNORE","����");
define("_MD_MYLINKS_LINKDELETED","��ũ������ �����Ͽ����ϴ�.");
define("_MD_MYLINKS_BROKENDELETED","������ ��ũ �Ű�� �����Ͽ����ϴ�.");
define("_MD_MYLINKS_USERMODREQ","��ũ���� ���� ��û");
define("_MD_MYLINKS_ORIGINAL","������");
define("_MD_MYLINKS_PROPOSED","������");
define("_MD_MYLINKS_OWNER","��ũ���� ������: ");
define("_MD_MYLINKS_NOMODREQ","��ũ���� ������û�� �����ϴ�.");
define("_MD_MYLINKS_DBUPDATED","����Ÿ���̽��� ���������� �����Ͽ����ϴ�!");
define("_MD_MYLINKS_DBNOTUPDATED","ERROR: Database could not be updated with the data supplied!");
define("_MD_MYLINKS_MODREQDELETED","��ũ���� ������û�� �����Ͽ����ϴ�.");
define("_MD_MYLINKS_IMGURLMAIN","ī�װ�� �׸����� URL (�����׸��Դϴ�. �׸��� ���̴� 50�ȼ��� ������,���� ī�װ����): ");
define("_MD_MYLINKS_PARENT","�θ�ī�װ��:");
define("_MD_MYLINKS_SAVE","��������");
define("_MD_MYLINKS_CATDELETED","ī�װ���� �����Ͽ����ϴ�.");
define("_MD_MYLINKS_WARNING","WARNING: ������ �� ī�װ���� �׿� ���� ��ũ���� ����Ÿ�� ��� �����Ͻ� �ǰ���?");
//define("_MD_MYLINKS_YES","��");
//define("_MD_MYLINKS_NO","�ƴϿ�");
define("_MD_MYLINKS_NEWCATADDED","ī�װ���� �߰��Ͽ����ϴ�.");
define("_MD_MYLINKS_ERROREXIST","ERROR: �����Ͻ� ��ũ������ �̹� ��ϵǾ��� �ֽ��ϴ�.");
define("_MD_MYLINKS_ERRORTITLE","ERROR: Ÿ��Ʋ�� �Է��� �ּ���!");
define("_MD_MYLINKS_ERRORDESC","ERROR: ������ �Է��� �ּ���!");
define("_MD_MYLINKS_ERRORURL","ERROR: You need to enter a site URL!");
define("_MD_MYLINKS_NEWLINKADDED","�ű� ��ũ������ �߰��Ͽ����ϴ�.");
define("_MD_MYLINKS_YOURLINK","Your Website Link at %s");
define("_MD_MYLINKS_YOUCANBROWSE","�پ��� ��ũ����Ʈ������ �ֽ��ϴ�. ���� �̿�ٶ��ϴ�. (%s)");
define("_MD_MYLINKS_HELLO","%s ��,�������");
define("_MD_MYLINKS_WEAPPROVED","���� �����Ͻ� ��ũ������ �������� ����/���ó�� �Ǿ����ϴ�.");
define("_MD_MYLINKS_THANKSSUBMIT","������ �ּż� �����մϴ�!");
define("_MD_MYLINKS_ISAPPROVED","���� �����Ͻ� ��ũ������ �������� ����/���ó�� �Ǿ����ϴ�.");

//ver2.0
define("_MD_MYLINKS_BROWSETOTOPIC","���ĺ��� ����");
define("_MD_MYLINKS_LINKS_LIST","��ũ����Ʈ ����Ʈ (%s)");

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

//ver3.1
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
