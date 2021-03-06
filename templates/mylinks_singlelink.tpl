<{if $mylinksadcodes.all}>
<{$mylinksadcodes.all}>
<{elseif $mylinksadcodes.singlelink}>
<{$mylinksadcodes.singlelink}>
<{/if}>
<br><br>
<{if $mylinksshowlogo}>
<div class='center'><{$mylinkslogoimage}></div><br>
<{/if}>
<{if $mylinksshowsearch}>
<{includeq file='db:mylinks_search_inc.tpl'}>
<{/if}>
<{if $catarray.letters}>
<div class='itemPermaLink center'><{$catarray.letters}></div><br>
<{/if}>
<{if $catarray.toolbar}>
<div class='toolbar'><{$catarray.toolbar}></div><br>
<{/if}>
<div class='newstitle bnone marg2 pad2'><{$category_path}></div>
<{if $mylinksshowthemechanger}>
<div class='width100'>
    <form action='<{$xoops_requesturi}>' method='post'>
        <label for='mylinks_theme_select'><{$lang_themechanger}></label>
        <{$mylinksthemeoption}>
    </form>
</div>
<{/if}>

<{include file="db:mylinks_link.tpl" link=$link}>

<div class='right alignmiddle'><{$mylinksjumpbox}></div>
<{*
<div class='right' style='margin: 2em 6px -4em 0em;'>
    <a href="javascript:mltoggleEffect('<{$mylinks_imgurl}>/icons', 'resizemlcomblock', 'mlcomsizeimage')"><img id='mlcomsizeimage' src='<{$mylinks_imgurl}>/icons/minimize.gif'
                                                                                                                alt='<{$lang_minimizeblock}>' title='<{$lang_minimizeblock}>'/></a>
</div>
*}>
<div id='resizemlcomblock' class='block'>
    <div class='center pad3 marg3'>
        <{$moremetasearch}>
    </div>
    <div class='center pad3 marg3'>
        <{$commentsnav}>
        <{$lang_notice}>
    </div>

    <div class='marg3 pad3'>
        <!-- start comments loop -->
        <{if $comment_mode == "flat"}>
        <{include file="db:system_comments_flat.tpl"}>
        <{elseif $comment_mode == "thread"}>
        <{include file="db:system_comments_thread.tpl"}>
        <{elseif $comment_mode == "nest"}>
        <{include file="db:system_comments_nest.tpl"}>
        <{/if}>
        <!-- end comments loop -->
    </div>
</div>
<{if $show_screenshot && ('' != $shot_attribution)}>
<div class='center'><{$shot_attribution}></div>
<div class='clear'></div>
<{/if}>
<{include file='db:system_notification_select.tpl'}>
