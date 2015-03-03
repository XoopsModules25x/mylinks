<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 *
 * Tell a friend form generator / send email
 *
 * @copyright::  {@link http://sourceforge.net/projects/xoops/ The XOOPS Project}
 * @license::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package::    mylinks
 * @version::    $Id: $
 */
include_once 'header.php';
include_once $GLOBALS['xoops']->path("header.php");
include_once './class/utility.php';
include_once $GLOBALS['xoops']->path('class' . DIRECTORY_SEPARATOR . 'xoopsformloader.php');

xoops_loadLanguage('main', $GLOBALS['xoopsModule']->getVar('dirname'));
$myts =& MyTextSanitizer::getInstance();

if ( !($GLOBALS['xoopsUser'] instanceof XoopsUser) && !$GLOBALS['xoopsModuleConfig']['anontellafriend'] ) {
    redirect_header('index.php', 3, _NOPERM);
    exit();
}

if (!isset($_POST['submit'])) {
    if (!empty($_GET['contents'])) {
        // coming back from failed attempt at filling out form
        $form_contents = unserialize($myts->stripSlashesGPC($_GET['contents']));
        $lid      = !empty($form_contents['lid'])      ? intval($form_contents['lid']) : 0;
        $comments = !empty($form_contents['comments']) ? strip_tags(html_entity_decode($form_contents['comments'])) : '';
        $frname   = !empty($form_contents['frname'])   ? $myts->htmlSpecialChars($form_contents['frname']) : '';
        $fremail  = !empty($form_contents['fremail'])  ? $myts->htmlSpecialChars($form_contents['fremail']) : '';
        $sname    = !empty($form_contents['sname'])    ? $myts->htmlSpecialChars($form_contents['sname']) : '';
        $semail   = !empty($form_contents['semail'])   ? $myts->htmlSpecialChars($form_contents['semail']): '';
    } else {
        $lid = MylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));
        $comments = $frname = $fremail = $sname = $semail = '';
    }

    // make sure that the link the user is sharing is valid & active
    $result = $GLOBALS['xoopsDB']->query("SELECT title FROM {$GLOBALS['xoopsDB']->prefix('mylinks_links')} WHERE `lid` = '{$lid}' AND status>0 LIMIT 0,1");
    if ($result) {
        list($linktitle) = $GLOBALS['xoopsDB']->fetchRow($result);
        $linktitle = $myts->stripSlashesGPC($linktitle);
    } else {
        // invalid (or inactive) link, can't send this to a friend
        redirect_header('index.php', 3, _MD_MYLINKS_INVALIDORINACTIVELNK);
        exit();
    }

    $tfform = new XoopsThemeForm(_MD_MYLINKS_TELLAFRIEND, 'tfform', $_SERVER['PHP_SELF'], 'post', true);
    $tfform->addElement(new XoopsFormText( _MD_MYLINKS_FRIEND . ' ' . _MD_MYLINKS_NAME , 'frname', 50, 50, trim($frname)), TRUE);
    $tfform->addElement(new XoopsFormText( _MD_MYLINKS_FRIEND . ' ' . _MD_MYLINKS_EMAIL, 'fremail', 50, 50, trim($fremail)), TRUE);
    if ( !$GLOBALS['xoopsUser'] instanceof XoopsUser ) {
        $tfform->addElement(new XoopsFormText( _MD_MYLINKS_SENDER . ' ' . _MD_MYLINKS_NAME , 'sname', 50, 50, trim($sname)), TRUE);
        $tfform->addElement(new XoopsFormText( _MD_MYLINKS_SENDER . ' ' . _MD_MYLINKS_EMAIL, 'semail', 50, 50, trim($semail)), TRUE);
    }
    $tfform->addElement(new XoopsFormLabel( _MD_MYLINKS_TITLE, $linktitle ));
    $tfform->addElement(new XoopsFormTextArea(_COMMENTS, 'comments', trim($comments)));
    $tfform->addElement(new XoopsFormHidden('lid', $lid));
    $tfform->addElement(new XoopsFormCaptcha());
//    $tfform->addElement(new XoopsFormCaptcha(null, null, false, array('maxattempts'=>4)));
    $tfform->addElement(new XoopsFormButtonTray('submit', _SUBMIT));
    $tfform->display();
    include_once $GLOBALS['xoops']->path("footer.php");
} else {
    if ( ($GLOBALS['xoopsSecurity'] instanceof XoopsSecurity) ) {
        if ( !$GLOBALS['xoopsSecurity']->check() ) {
            // failed xoops security check
            redirect_header('index.php', 3, $GLOBALS['xoopsSecurity']->getErrors(true));
            exit();
        }
    } else {
        redirect_header('index.php', 3, _MD_MYLINKS_INVALID_SECURITY_TOKEN);
    }

    $lid      = MylinksUtility::mylinks_cleanVars($_POST, 'lid', 0, 'int', array('min'=>0));
    $comments = strip_tags(html_entity_decode($myts->stripSlashesGPC($_POST['comments'])));
    $frname   = MylinksUtility::mylinks_cleanVars($_POST, 'frname', '', 'string');
    $fremail  = MylinksUtility::mylinks_cleanVars($_POST, 'fremail', '', 'email');
    $sname    = MylinksUtility::mylinks_cleanVars($_POST, 'sname', '', 'string');
    $semail   = MylinksUtility::mylinks_cleanVars($_POST, 'semail', '', 'email');

    //Check captcha
    xoops_load('XoopsCaptcha');
    $xoopsCaptcha =& XoopsCaptcha::getInstance();
    if ( !$xoopsCaptcha->verify() ) {
        if ( $_SESSION["xoopscaptcha_attempt"] < $_SESSION["_maxattempts"] ) {
            $form_contents = array('lid' => $lid,
                                'frname' => $frname,
                               'fremail' => $fremail,
                                 'sname' => $sname,
                                'semail' => $semail,
                              'comments' => $comments
            );
            $contents = serialize($form_contents);
            redirect_header($_SERVER['PHP_SELF'] . "?contents={$contents}", 2, $xoopsCaptcha->getMessage());
            exit();
        } else {
            redirect_header('index.php', 2, $xoopsCaptcha->getMessage());
            exit();
        }
    }

    $xadminmail = $GLOBALS['xoopsConfig']['adminmail'];    //setting from to server in case of SPF=>will admin config this as well
    $xsitename  = $GLOBALS['xoopsConfig']['sitename'];     //adding site title as sender (mod config this?)

    // set from name / email for registered user
    if ( $GLOBALS['xoopsUser'] instanceof XoopsUser ) {
        $semail = $GLOBALS['xoopsUser']->getVar('email');
        $sname = ucfirst($GLOBALS['xoopsUser']->getVar('uname'));
        $sname = ( '' == $sname ) ? $GLOBALS['xoopsUser']->getVar('name') :  $sname;
    }
    // check to see if email for recipient and sender are 'sane'
    if ( !filter_var($fremail, FILTER_VALIDATE_EMAIL) || !filter_var($semail, FILTER_VALIDATE_EMAIL) ) {
        redirect_header('index.php', 2, _MD_MYLINKS_INVALIDEMAIL);
    }
    // set the url to the link
    if ( $lid > 0 ) {
        $linkurl = $GLOBALS['xoops']->url("modules/" . $GLOBALS['xoopsModule']->getVar('dirname') . "/singlelink.php?lid={$lid}");
        // now check to make sure that the link the user is sharing is valid
        $result = $GLOBALS['xoopsDB']->query("SELECT title FROM {$GLOBALS['xoopsDB']->prefix( 'mylinks_links' )} WHERE `lid` = '{$lid}' AND status>0 LIMIT 0,1");
        if ($result) {
            list($linktitle) = $GLOBALS['xoopsDB']->fetchRow($result);
            $linktitle = $myts->stripSlashesGPC($linktitle);
        } else {
            // invalid (or inactive) link, can't send this to a friend
            redirect_header('index.php', 3, _MD_MYLINKS_INVALIDORINACTIVELNK);
            exit();
        }
    } else {
        redirect_header('index.php', 3, _MD_MYLINKS_INVALIDORINACTIVELNK);
        exit();
    }

    $subject = sprintf(_MD_MYLINKS_EMAIL_SUBJECT, $xsitename, $sname);

    //now send mail to friend
    $xMailer =& xoops_getMailer();
    $xMailer->useMail(); // Set it to use email (as opposed to PM)
    $xMailer->setTemplateDir( $GLOBALS['xoops']->path("modules" . DIRECTORY_SEPARATOR
                                . DIRECTORY_SEPARATOR . $GLOBALS['xoopsModule']->getVar('dirname')
                                . DIRECTORY_SEPARATOR . 'language'
                                . DIRECTORY_SEPARATOR . $GLOBALS['xoopsConfig']['language']
                                . DIRECTORY_SEPARATOR . 'mail_template' . DIRECTORY_SEPARATOR
                                )
    );
    $xMailer->setTemplate('tellafriend_mail.tpl');

    // set common mail template variables
    $xMailer->assign(array('SNAME' => $sname,
                          'SEMAIL' => $semail,
                     'X_ADMINMAIL' => $xadminmail,
                      'X_SITENAME' => $xsitename,
                       'X_SITEURL' => $GLOBALS['xoops']->url("/"),
                    'X_LINK_TITLE' => strip_tags(html_entity_decode($linktitle)),
                          'X_LINK' => $linkurl,
                          'FRNAME' => $frname,
                        'COMMENTS' => strip_tags(html_entity_decode($comments)))
    );

    $xMailer->setToEmails($fremail);
    $xMailer->setFromEmail($xadminmail);
    $xMailer->setFromName($xsitename);
    $xMailer->setSubject($subject);

    if ($xMailer->send()) {
        //send was successful
        redirect_header('index.php', 2, _MD_MYLINKS_MESSEND);
        exit();
    } else {
        redirect_header('index.php', 2, $xMailer->getErrors(true));
        exit();
    }
}
