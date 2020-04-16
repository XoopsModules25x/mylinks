<{if $mylinksadcodes.all}>
    <{$mylinksadcodes.all}>
<{elseif $mylinksadcodes.viewcat}>
    <{$mylinksadcodes.viewcat}>
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

<table class='bnone center' style='width: 97%; margin: 0px; padding: 0px;'>
    <tr>
        <td class='newstitle left bnone' style='margin: 1px; padding: 2px;'>
            <strong><{$category_path}></strong>
        </td>
    </tr>
    <tr>
        <td class='center'>
            <table class='width90'>
                <tr>
                    <{foreach item=subcat from=$subcategories}>
                    <td class='left'><strong><a href='viewcat.php?cid=<{$subcat.id}>'><{$subcat.title}></a></strong>&nbsp;(<{$subcat.totallinks}>
                        )<br><{if !empty($subcat.infercategories)}><span
                                class='subcategories'><{$subcat.infercategories}></span><{/if}></td>
                    <{if $subcat.count % 4 == 0}></tr>
                <tr><{/if}>
                    <{/foreach}>
                </tr>
            </table>
            <br>
            <hr>

            <{if $show_links == true}>

            <{if $show_nav == true}>
                <div>
                    <{$lang_sortby}>&nbsp;&nbsp;<{$lang_title}> (
                    <a href='viewcat.php?cid=<{$category_id}>&amp;orderby=titleA'><img src='assets/images/icons/up.gif'
                                                                                       style='border-width: 0px; vertical-align: middle;'
                                                                                       alt=''></a>
                    <a href='viewcat.php?cid=<{$category_id}>&amp;orderby=titleD'><img
                                src='assets/images/icons/down.gif' style='border-width: 0px; vertical-align: middle;'
                                alt=''></a>
                    )
                    <{$lang_date}>&nbsp;(
                    <a href='viewcat.php?cid=<{$category_id}>&amp;orderby=dateA'><img src='assets/images/icons/up.gif'
                                                                                      style='border-width: 0px; vertical-align: middle;'
                                                                                      alt=''></a>
                    <a href='viewcat.php?cid=<{$category_id}>&amp;orderby=dateD'><img src='assets/images/icons/down.gif'
                                                                                      style='border-width: 0px; vertical-align: middle;'
                                                                                      alt=''></a>
                    )
                    <{$lang_rating}>&nbsp;(
                    <a href='viewcat.php?cid=<{$category_id}>&amp;orderby=ratingA'><img src='assets/images/icons/up.gif'
                                                                                        style='border-width: 0px; vertical-align: middle;'
                                                                                        alt=''></a>
                    <a href='viewcat.php?cid=<{$category_id}>&amp;orderby=ratingD'><img
                                src='assets/images/icons/down.gif' style='border-width: 0px; vertical-align: middle;'
                                alt=''></a>
                    )
                    <{$lang_popularity}>&nbsp;(
                    <a href='viewcat.php?cid=<{$category_id}>&amp;orderby=hitsA'><img src='assets/images/icons/up.gif'
                                                                                      style='border-width: 0px; vertical-align: middle;'
                                                                                      alt=''></a>
                    <a href='viewcat.php?cid=<{$category_id}>&amp;orderby=hitsD'><img src='assets/images/icons/down.gif'
                                                                                      style='border-width: 0px; vertical-align: middle;'
                                                                                      alt=''></a>
                    )
                    <br>
                    <strong><{$lang_cursortedby}></strong>
                </div>
                <hr>
            <{/if}>
            <br>
        </td>
    </tr>
</table>
    <{if ($list_mode != true && $mylinksshowfeed) || ($mylinksshowthemechanger) }>
        <table class='width100' style='margin: 0px;'>
            <tr>
                <{if $list_mode != true && $mylinksshowfeed}>
                    <td class='left'>
                        <a href="javascript:openWithSelfMain('<{$mylinks_weburl}>/feedsubscription.php?feedtype=RSS&feedurl=<{"$mylinks_weburl/rss.php?cid=$category_id"|escape:"url"}>','modulefeedsubscription',300,500);">
                            <img src='<{$mylinks_imgurl}>/icons/feed-icon.gif' alt='<{$lang_feedsubscript}>'
                                 title='<{$lang_feedsubscript_desc}>'></a>
                        <strong><{$lang_categoryfeed}></strong>
                        <a href="<{$mylinks_weburl}>/rss.php?cid=<{$category_id}>" target="_blank">
                            <img src="<{$mylinks_imgurl}>/icons/rss.png" alt="<{$lang_rssfeed_cat}>"
                                 title="<{$lang_rssfeed_cat}>"></a>
                        <a href="<{$mylinks_weburl}>/atom.php?cid=<{$category_id}>" target="_blank">
                            <img src="<{$mylinks_imgurl}>/icons/atom.png" alt="<{$lang_atomfeed_cat}>"
                                 title="<{$lang_atomfeed_cat}>"></a>
                        <a href="<{$mylinks_weburl}>/pda.php?cid=<{$category_id}>" target="_blank">
                            <img src="<{$mylinks_imgurl}>/icons/pda.png" alt="<{$lang_pdafeed_cat}>"
                                 title="<{$lang_pdafeed_cat}>"></a>
                    </td>
                <{/if}>
                <{if $mylinksshowthemechanger}>
                    <td class='right'>
                        <form action='<{$xoops_requesturi}>' method='post'>
                            <strong><{$lang_themechanger}></strong><{$mylinksthemeoption}>
                        </form>
                    </td>
                <{/if}>
            </tr>
        </table>
    <{/if}>
    <div class='center'><{$page_nav}></div>
<br>
    <table class='width100 bnone' style='margin: 0px; padding: 10px;'>
        <tr>
            <td class='width100 right'>
                <a id='itemtop'>
                    <a href='#itembottom'><img src='<{$mylinks_imgurl}>/icons/bottom.gif' alt='<{$lang_gotobottom}>'
                                               title='<{$lang_gotobottom}>'></a>
            </td>
        </tr>
        <tr>
            <td class='width100 center aligntop'>
                <!-- Start link loop -->
                <{section name=i loop=$links}>
                    <{include file="db:mylinks_link.tpl" link=$links[i]}>
                <{/section}>
                <!-- End link loop -->
            </td>
        </tr>
        <tr>
            <td class='width100 right'>
                <a id='itembottom'>
                    <a href='#itemtop'><img src='<{$mylinks_imgurl}>/icons/top.gif' alt='<{$lang_gototop}>'
                                            title='<{$lang_gototop}>'></a>
            </td>
        </tr>
    </table>
<br>
    <div class='center'><{$page_nav}></div>
<br>
    <div class='right'><{$mylinksjumpbox}></div>
<{else}>
    </td>
    </tr>
    </table>
<{/if}>
<{if $list_mode != true}><{$moremetasearch}><{/if}>
<{if $show_screenshot && ('' != $shot_attribution)}>
    <div class='center'><{$shot_attribution}></div>
    <div class='clear'></div>
<{/if}>
<{include file='db:system_notification_select.tpl'}>
