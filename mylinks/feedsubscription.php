<?php

include 'header.php';

xoops_header(false);

$feedtype = (empty($_GET['feedtype'])) ? 'RSS' : trim($_GET['feedtype']);
$feedurl  = (empty($_GET['feedurl'])) ? '' : trim($_GET['feedurl']);

$feedmodname  = $xoopsModule->getVar('name') . "(" . $GLOBALS['modulename'] . ")";
$atom_feedurl = str_replace('rss.php', 'atom.php', $feedurl);
$pda_feedurl  = str_replace('rss.php', 'pda.php', $feedurl);
$feedurl_en   = urlencode($feedurl);

echo ""
  ."<link rel='alternate' type='application/rss+xml' title='RSS' href='{$feedurl}' />\n"
  ."<link rel='alternate' type='application/atom+xml' title='ATOM' href='{$atom_feedurl}' />\n"
  ."</head>\n"
  ."<body>\n"
  ."  <table>\n"
  ."    <tr class='odd'>\n"
  ."      <td style='text-align'center;'><h3>" . _MD_MYLINKS_FEEDSUBSCRIPT_SERVICE . "</h3></td>\n"
  ."    </tr>\n"
  ."    <tr class='head'>\n"
  ."      <td style='text-align: center; font-weight: bold;'>{$feedmodname}</td>\n"
  ."    </tr>\n"
  ."    <tr class='even'>\n"
  ."      <td style='text-align: left;'>\n"
  ."        <br />\n"
  ."        <a target='_blank' title='{$feedurl}' href='{$feedurl}' style='text-decoration:none;'><span style='border:1px solid;border-color:#FC9 #630 #330 #F96;padding:0 3px;font:bold 10px vena,sans-serif;color:#FFF;background:#F60;margin:0;'>{$feedtype} Feed</span></a>&nbsp;\n"
  ."        <a target='_blank' title='{$atom_feedurl}' href='{$atom_feedurl}' style='text-decoration:none;'><span style='border:1px solid;border-color:#FC9 #630 #330 #F96;padding:0 3px;font:bold 10px vena,sans-serif;color:#FFF;background:#F60;margin:0;'>ATOM Feed</span></a>&nbsp;\n"
  ."        <a target='_blank' title='{$pda_feedurl}' href='{$pda_feedurl}' style='text-decoration:none;'><span style='border:1px solid;border-color:#FC9 #630 #330 #F96;padding:0 3px;font:bold 10px vena,sans-serif;color:#FFF;background:#F60;margin:0;'>PDA Feed</span></a>\n"
  ."        <br />\n"
  ."        <br /><a target='_blank' href='http://fusion.google.com/add?feedurl={$feedurl_en}'><img src='http://buttons.googlesyndication.com/fusion/add.gif' alt='Add to Google' style='border-width: 0px;'></a>\n"
  ."        <br /><a target='_blank' href='http://www.ifeedreaders.com/subscribe.php?thefeed={$feedurl_en}&'><img src='http://www.ifeedreaders.com/buttons/button2.gif' alt='Subscribe' style='border-width: 0px;' title='More Subscription Options'/></a>\n"
  ."        <br /><a target='_blank' href='http://add.my.yahoo.com/rss?url={$feedurl_en}'><img src='http://us.i1.yimg.com/us.yimg.com/i/us/my/addtomyyahoo4.gif' style='border-width: 0px;' alt='Add to My Yahoo!'></a>\n"
  ."        <br /><a target='_blank' href='http://www.bloglines.com/sub/{$feedurl_en}'><img src='http://www.bloglines.com/images/sub_modern9.gif' alt='Subscribe with Bloglines' style='border-width: 0px;' /></a>\n"
  ."        <br /><a target='_blank' href='http://www.newsgator.com/ngs/subscriber/subext.aspx?url={$feedurl_en}'><img src='http://www.newsgator.com/images/ngsub1.gif' alt='Subscribe in NewsGator Online' style='border-width: 0px;'></a>\n"
//  ."        <br /><a target='_blank' href='http://www.bitty.com/manual/?contenttype=rssfeed&amp;contentvalue={$feedurl_en}'><img src='http://www.bitty.com/img/bittychicklet_91x17.gif' alt='BittyBrowser' style='border-width: 0px;' /></a>\n"
  ."        <br /><a target='_blank' href='http://feeds.my.aol.com/add.jsp?url={$feedurl_en}'><img src='http://myfeeds.aolcdn.com/vis/myaol_cta1.gif' alt='Add to My AOL' style='border-width: 0px;'/></a>\n"
  ."        <br /><a target='_blank' href='http://rss2pdf.com?url={$feedurl_en}'> <img src='http://rss2pdf.com/images/rss2pdf.png' alt='Convert RSS to PDF' style='border-width: 0px;' /></a>\n"
//  ."        <br /><a target='_blank' href='http://www.multirss.com/rss/{$feedurl_en}'><img src='http://www.multirss.com/button.gif' alt='MultiRSS' style='border-width: 0px;' /></a>\n"
  ."        <br /><a target='_blank' href='http://www.r-mail.org/bm.aspx?rss={$feedurl_en}' style='background-color: #fff; font-weight: bold; color:#000; border:1px solid #000; font-size: 11px; padding: 2px; text-decoration: none; font-family: sans-serif;'><span style='color:#F76615'>R</span>|Mail</a>\n"
//  ."        <br /><a target='_blank' href='http://www.rssfwd.com/rssfwd/preview?url='{$feedurl_en}'><img src='http://www.rssfwd.com/subscribe_via_rssfwd.png' alt='Rss fwd' style='border-width: 0px;' /></a>\n"
//  ."        <br /><a target='_blank' href='http://www.blogarithm.com/subrequest.php?BlogURL={$feedurl_en}'> <img src='http://www.blogarithm.com/images/external/techno-add.gif' alt='Blogarithm' style='border-width: 0px;' /></a>\n"
//  ."        <br /><a target='_blank' href='http://www.eskobo.com/?AddToMyPage={$feedurl_en}'><img src='http://www.eskobo.com/images/eneskobo.gif' alt='Eskobo' style='border-width: 0px;' /></a>\n"
//  ."        <br /><a target='_blank' href='http://www.simpy.com/simpy/LinkAdd.do?href={$feedurl_en}&amp;title={$feedtype}'><img src='http://www.simpy.com/img/chicklet-simpy-orange.png' alt='Simpify!' style='border-width: 0px;'/></a>\n"
  ."        <br /><a target='_blank' href='http://technorati.com/faves?add={$feedurl_en}'><img src='http://static.technorati.com/pix/fave/tech-fav-5.gif' alt='Add to Technorati Favorites!' style='border-width: 0px;' /></a>\n"
  ."        <br /><a target='_blank' href='http://www.netvibes.com/subscribe.php?url={$feedurl_en}'><img alt='Add to netvibes' src='http://www.netvibes.com/img/add2netvibes.gif' style='border-width: 0px;' /></a>\n"
  ."        <br /><a target='_blank' href='http://www.protopage.com/add-button-site?url={$feedurl_en}&amp;label={$feedtype}&amp;type=feed'><img alt='Add this site to your Protopage' src='http://www.protopage.com/web/images/buttons/add-site-to-protopage.gif' style='border-width: 0px;' /></a>\n"
  ."        <br /><a target='_blank' href='http://www.newsburst.com/Source/?add={$feedurl_en}'><img src='http://news.com.com/i/newsbursts/btn/newsburst3.gif' style='border-width: 0px;' /></a>\n"
//  ."        <br /><a target='_blank' href='http://www.newsalloy.com/?rss={$feedurl_en}'><img src='http://www.newsalloy.com/subrss4.gif' style='border-width: 0px;' alt='Subscribe in NewsAlloy' title='Subscribe in NewsAlloy' /></a>\n"
  ."        <br /><a target='_blank' href='http://reader.earthlink.net/feed/add?url={$feedurl_en}'><img src='http://my.eimg.net/img/logo_myeln.gif' style='width: 91px; height: 20px; border-width: 0px;' alt='Subscribe in myEarthlink' title='Subscribe in myEarthlink !You must already be logged into your Earthlink account.' /></a>\n"
//  ."        <br /><a target='_blank' href='http://plusmo.com/add?url={$feedurl_en}'><img src='http://plusmo.com/res/graphics/fbplusmo.gif' style='border-width: 0px;' alt='Add to your phone' title='Add to your phone' /></a>\n"
  ."        <br /><a target='_blank' href='http://www.live.com/?add={$feedurl_en}'><img style='width: 92px; height: 17px; border-width: 0px;' src='http://tkfiles.storage.msn.com/x1pHd9OYNP16fmmfqJHji7qY0yYomKrFzGROBps3O6qHF0JRlVV8xH6X4cfsptw0fftk5oJYFpTKP6I-i91-se8TaoO7R9oiPVoxDEG_LEZW_XhegHxASvHJYsSxNjf526t' /></a>\n"
  ."      </td>\n"
  ."    </tr>\n"
  ."    <tr class='head'>\n"
  ."      <td style='text-align: center; font-weight: bold;'>{$feedmodname}</td>\n"
  ."    </tr>\n"
  ."  </table>\n"
  ."<br /><br />\n";

xoops_footer();
