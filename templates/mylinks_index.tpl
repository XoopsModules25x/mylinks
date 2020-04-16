<{if $mylinksadcodes.all}>
    <{$mylinksadcodes.all}>
<{elseif $mylinksadcodes.index}>
    <{$mylinksadcodes.index}>
<{/if}>
<br><br>
<{if $mylinksshowlogo}>
    <div class='center' style='margin-bottom: 1em;'><{$mylinkslogoimage}></div>
<{/if}>
<{if $mylinksshowsearch}>
    <{include file='db:mylinks_search_inc.tpl'}>
<{/if}>
<{if $catarray.letters}>
    <div class='itemPermaLink center'><{$catarray.letters}></div>
    <br>
<{/if}>
<{if $catarray.toolbar}>
    <div class='toolbar'><{$catarray.toolbar}></div>
    <br>
<{/if}>
<br>
<{if $categories|is_array && count($categories) > 0}>
    <div><h3 class='inline'><{$smarty.const._MD_MYLINKS_CATEGORY}></h3>
        <div class='right'>
            <a href="javascript:mltoggleEffect('<{$mylinks_imgurl}>/icons', 'resizemlcatblock', 'mlsizecatimage')"><img
                        id='mlsizecatimage' src='<{$mylinks_imgurl}>/icons/minimize.gif'
                        alt='<{$lang_minimizeblock}>' title='<{$lang_minimizeblock}>'></a>
        </div>
    </div>
    <hr>
    <div id='resizemlcatblock' class='block'>
        <table class='center bnone marg5' style='padding: 0px;'>
            <tr>
                <!-- Start category loop -->
                <{foreach item=category from=$categories}>

                <td class='aligntop'>
                    <{if $category.image != ''}>
                        <a href='<{$mylinks_weburl}>/viewcat.php?cid=<{$category.id}>'><img src='<{$category.image}>'
                                                                                            style='height: 50px; border-width: 0px;'
                                                                                            alt=''></a>
                    <{/if}>
                </td>
                <td class='aligntop width30'><a
                            href='<{$mylinks_weburl}>/viewcat.php?cid=<{$category.id}>'><strong><{$category.title}></strong></a>&nbsp;(<{$category.totallink}>
                    )<br><{$category.subcategories}></td>

                <{if $category.count % 3 == 0}>
            </tr>
            <tr>
                <{/if}>
                <{/foreach}>
                <!-- End category loop -->
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div><{$lang_thereare}></div>
    <table class='width100' style='margin: 0px;'>
        <tr>
            <td class='left'>
                <{if $mylinksshowfeed}>
                    <a href="javascript:openWithSelfMain('<{$mylinks_weburl}>/feedsubscription.php?feedtype=RSS&feedurl=<{$mylinks_weburl|cat:"/rss.php"|escape:"url"}>','modulefeedsubscription',300,500);">
                        <img src='<{$mylinks_imgurl}>/icons/feed-icon.gif' alt='<{$lang_feedsubscript}>'
                             title='<{$lang_feedsubscript_desc}>'></a>
                    <strong><{$lang_feed}></strong>
                    <a href='<{$mylinks_weburl}>/rss.php' target='_blank'>
                        <img src='<{$mylinks_imgurl}>/icons/rss.png' alt='<{$lang_rssfeed}>' title='<{$lang_rssfeed}>'></a>
                    <a href='<{$mylinks_weburl}>/atom.php' target='_blank'>
                        <img src='<{$mylinks_imgurl}>/icons/atom.png' alt='<{$lang_atomfeed}>'
                             title='<{$lang_atomfeed}>'></a>
                    <a href='<{$mylinks_weburl}>/pda.php' target='_blank'>
                        <img src='<{$mylinks_imgurl}>/icons/pda.png' alt='<{$lang_pdafeed}>' title='<{$lang_pdafeed}>'></a>
                <{/if}>
            </td>
            <td class='right'>
                <{if $mylinksshowthemechanger}>
                    <form action='<{$xoops_requesturi}>' method='post'>
                        <strong><{$lang_themechanger}></strong><{$mylinksthemeoption}>
                    </form>
                <{/if}>
            </td>
        </tr>
    </table>
    <hr>
    <br>
<{/if}>
<{if $links != ''}>
    <h3><{$lang_latestlistings}></h3>
    <table class='width100 bnone' style='margin: 0px; padding: 10px;'>
        <tr>
            <td class='right width100'>
                <a id='itemtop'>
                    <a href='#itembottom'><img src='<{$mylinks_imgurl}>/icons/bottom.gif' alt='<{$lang_gotobottom}>'
                                               title='<{$lang_gotobottom}>'></a>
            </td>
        </tr>
        <tr>
            <td class='center width100 aligntop'>

                <!-- Start new link loop -->
                <{section name=i loop=$links}>
                    <{include file='db:mylinks_link.tpl' link=$links[i]}>
                <{/section}>
                <!-- End new link loop -->
            </td>
        </tr>
        <tr>
            <td class='right width100'>
                <a id='itembottom'>
                    <a href='#itemtop'><img src='<{$mylinks_imgurl}>/icons/top.gif' alt='<{$lang_gototop}>'
                                            title='<{$lang_gototop}>'></a>
            </td>
        </tr>
    </table>
    <{if $show_screenshot && ('' != $shot_attribution)}>
        <div class='center'><{$shot_attribution}></div>
        <div class='clear'></div>
    <{/if}>
<{/if}>
<{include file='db:system_notification_select.tpl'}>
