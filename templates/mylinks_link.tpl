<table class='outer width100' style='margin: 0px;'>
    <tr>
        <td class='head left' style='height: 18px;'><{$lang_category}>: <{$link.category}></td>
        <td class='head right' style='width: 10%;'>
            <a href="javascript:mltoggleEffect('<{$mylinks_imgurl}>/icons', 'resizemlblock<{$smarty.section.i.index}>', 'mlsizeimage<{$smarty.section.i.index}>')"><img
                        id='mlsizeimage<{$smarty.section.i.index}>' src='<{$mylinks_imgurl}>/icons/minimize.gif'
                        alt='<{$lang_minimizeblock}>' title='<{$lang_minimizeblock}>'></a>
        </td>
    </tr>
    <tr>
        <td colspan='2'>
            <div id='resizemlblock<{$smarty.section.i.index}>' class='block'>
                <table class='outer width100' style='margin: 0px;'>
                    <tr>
                        <td class='even width60 left alignbottom'><a
                                    href='visit.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>' target='_blank'><img
                                        src='<{$mylinks_imgurl}>/icons/link.gif'
                                        style='border-width: 0px; margin-right: .5em;'
                                        alt='<{$lang_visit}>'
                                        title='<{$lang_visit}>'><strong><{$link.title}></strong></a>
                        </td>
                        <td class='even right'><strong><{$lang_lastupdate}></strong><{$link.updated}></td>
                    </tr>
                    <tr>
                        <td class='odd left' colspan='2'>
                            <div class='justify'>
                                <{*            </div> *}>
                                <{ if $show_screenshot && ('' != $link.shot_img_src)}>
                                <a class='floatleft alignmiddle right' href='<{$link.shot_img_href}>'><img
                                            src='<{$link.shot_img_src}>' target='_blank' alt=''
                                            style='margin: 3px 7px; width: <{$shot_width}>;'></a>
                                <{/if}>
                                <strong><{$lang_description}></strong><br>
                                <div><{$link.description}></div>
                                <br>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class='odd left' colspan='2'>
                            <{$link.adminlink}> <{if $mylinksshowextrafunc == true}>
                                <{if $mylinksshowextrafuncbig == true}>
                                    <{if $mylinksextrafuncprint == true}>
                                        <a target='_blank'
                                           href='<{$mylinks_weburl}>/print.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><img
                                                    src='<{$mylinks_imgurl}>/icons/print_s.png'
                                                    style='border-width: 0px;' alt='<{$lang_print}>'
                                                    title='<{$lang_print}>'></a>
                                    <{/if}>
                                    <{if $mylinksextrafuncpdf == true}>
                                        &nbsp;
                                        <a target='_blank'
                                           href='<{$mylinks_weburl}>/makepdf.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><img
                                                    src='<{$mylinks_imgurl}>/icons/acrobat_s.png'
                                                    style='border-width: 0px;' alt='<{$lang_pdf}>'
                                                    title='<{$lang_pdf}>'></a>
                                    <{/if}>
                                    <{if $mylinksextrafuncqrcode == true}>
                                        &nbsp;
                                        <a target='_blank'
                                           href='<{$mylinks_weburl}>/qrcode.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><img
                                                    src='<{$mylinks_imgurl}>/icons/qrcode_s.gif'
                                                    style='border-width: 0px;' alt='<{$lang_qrcode}>'
                                                    title='<{$lang_qrcode}>'></a>
                                    <{/if}>
                                    <{if $mylinksextrafuncbookmark == true}>
                                        &nbsp;
                                        <a target='_blank'
                                           href='<{$mylinks_weburl}>/bookmark.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><img
                                                    src='<{$mylinks_imgurl}>/icons/bookmark_s.png'
                                                    style='border-width: 0px;' alt='<{$lang_bookmark}>'
                                                    title='<{$lang_bookmark}>'></a>
                                    <{/if}>
                                <{else}>
                                    <a href='singlelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><img
                                                src='<{$mylinks_imgurl}>/icons/text.png' style='border-width: 0px;'
                                                alt='<{$lang_fullview}>'
                                                title='<{$lang_fullview}>'></a>
                                    <{if $mylinksextrafuncprint == true}>
                                        &nbsp;
                                        <a target='_blank'
                                           href='<{$mylinks_weburl}>/print.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><img
                                                    src='<{$mylinks_imgurl}>/icons/print_s.png'
                                                    style='border-width: 0px;' alt='<{$lang_print}>'
                                                    title='<{$lang_print}>'></a>
                                    <{/if}>
                                    <{if $mylinksextrafuncpdf == true}>
                                        &nbsp;
                                        <a target='_blank'
                                           href='<{$mylinks_weburl}>/makepdf.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><img
                                                    src='<{$mylinks_imgurl}>/icons/acrobat_s.png'
                                                    style='border-width: 0px;' alt='<{$lang_pdf}>'
                                                    title='<{$lang_pdf}>'></a>
                                    <{/if}>
                                    <{if $mylinksextrafuncqrcode == true}>
                                        &nbsp;
                                        <a target='_blank'
                                           href='<{$mylinks_weburl}>/qrcode.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><img
                                                    src='<{$mylinks_imgurl}>/icons/qrcode_s.gif'
                                                    style='border-width: 0px;' alt='<{$lang_qrcode}>'
                                                    title='<{$lang_qrcode}>'></a>
                                    <{/if}>
                                    <{if $mylinksextrafuncbookmark == true}>
                                        &nbsp;
                                        <a target='_blank'
                                           href='<{$mylinks_weburl}>/bookmark.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><img
                                                    src='<{$mylinks_imgurl}>/icons/bookmark_s.png'
                                                    style='border-width: 0px;' alt='<{$lang_bookmark}>'
                                                    title='<{$lang_bookmark}>'></a>
                                    <{/if}>
                                <{/if}>
                            <{/if}>
                        </td>
                    </tr>
                    <{if $mylinksshowsiteinfo == true}>
                        <tr>
                            <td class='odd center' colspan='2'>
                                <a href='http://www.alexa.com/data/details/traffic_details?url=<{$link.url}>'
                                   target='_blank'>*Traffic Rank</a>&nbsp;
                                <a href='http://web.archive.org/web/*/<{$link.url}>' target='_blank'>*Web Archive</a>&nbsp;
                                <a href='http://www.google.com/search?hl=<{$xoops_langcode}>&amp;q=site:<{$link.url|escape:"url"}>'
                                   target='_blank'>*Google SiteSearch</a>&nbsp;
                            </td>
                        </tr>
                    <{/if}>
                    <tr>
                        <td class='even center' colspan='2'><strong><{$lang_hits}></strong><{$link.hits}> <strong>&nbsp;&nbsp;<{$lang_rating}></strong>&nbsp;<{$link.rating}>
                            (<{$link.votes}>)
                        </td>
                    </tr>
                    <tr>
                        <td class='foot center' colspan='2'>
                            <a href='<{$mylinks_weburl}>/ratelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><{$lang_ratethissite}></a>
                            |&nbsp;
                            <{if $xoops_isuser}>
                                <a href='<{$mylinks_weburl}>/modlink.php?lid=<{$link.id}>'><{$lang_modify}></a>
                                |&nbsp;
                            <{/if}>
                            <a href='<{$mylinks_weburl}>/brokenlink.php?lid=<{$link.id}>'><{$lang_reportbroken}></a> |&nbsp;
                            <{if $xoops_isuser || $anontellafriend}>
                                <a href='<{$mylinks_weburl}>/contact.php?lid=<{$link.id}>'><{$lang_tellafriend}></a>
                                |&nbsp;
                                <{*            <a href='mailto:?subject=<{$link.mail_subject}>&amp;body=<{$link.mail_body}>'><{$lang_tellafriend}></a> |&nbsp; *}>
                            <{/if}>
                            <a href='<{$mylinks_weburl}>/singlelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>'><{$lang_comments}>
                                (<{$link.comments}>)</a>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
<br>
