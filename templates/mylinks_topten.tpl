<{if $mylinksadcodes.all}>
    <{$mylinksadcodes.all}>
<{elseif $mylinksadcodes.topten}>
    <{$mylinksadcodes.topten}>
<{/if}>
<br><br>
<{if $mylinksshowlogo}>
    <div class='center;'><{$mylinkslogoimage}></div>
    <br>
<{/if}>
<{if $mylinksshowsearch}>
    <{include file='db:mylinks_search_inc.tpl'}>
<{/if}>
<{if $catarray.toolbar}>
    <div class='toolbar'><{$catarray.toolbar}></div>
    <br>
<{/if}>
<{if $mylinksshowthemechanger}>
    <table style='margin: 0px; width: 100%;'>
        <tr>
            <td style='text-align: right;'>
                <form action='<{$xoops_requesturi}>' method='post'>
                    <strong><{$lang_themechanger}></strong><{$mylinksthemeoption}>
                </form>
            </td>
        </tr>
    </table>
<{/if}>
<{if !empty($rankings) }>
    <br>
    <div style='text-align: right;'>
        <a id='itemtop'>
            <a href='#itembottom'><img src='<{$mylinks_imgurl}>/icons/bottom.gif' alt='<{$lang_gotobottom}>'
                                       title='<{$lang_gotobottom}>'></a>
    </div>
    <!-- Start ranking loop -->
    <{foreach name=mlloop item=ranking from=$rankings}>
        <table class='outer'>
            <tr>
                <th class='center;'><{$ranking.title}> (<{$lang_sortby}>)</th>
                <th style='width: 8%; text-align: center;'>
                    <a href="javascript:mltoggleEffect('<{$mylinks_imgurl}>/icons', 'resizemltop10block<{$smarty.foreach.mlloop.iteration}>', 'mlsizetop10image<{$smarty.foreach.mlloop.iteration}>')"><img
                                id='mlsizetop10image<{$smarty.foreach.mlloop.iteration}>'
                                src='<{$mylinks_imgurl}>/icons/minimize.gif' alt='<{$lang_minimizeblock}>'
                                title='<{$lang_minimizeblock}>'></a>
                </th>
            </tr>
            <tr>
                <td colspan='2'>
                    <div id="resizemltop10block<{$smarty.foreach.mlloop.iteration}>" style="display: block;">
                        <table style='width: 100%;'>
                            <tr>
                                <td class="head" style='width: 7%;'><{$lang_rank}></td>
                                <td class="head" style='width: 28%;'><{$lang_title}></td>
                                <td class="head" style='width: 40%;'><{$lang_category}></td>
                                <td class="head" style='width: 8%; text-align: center;'><{$lang_hits}></td>
                                <td class="head" style='width: 9%; text-align: center;'><{$lang_rating}></td>
                                <td class="head" style='width: 8%; text-align: right;'><{$lang_vote}></td>
                            </tr>
                            <!-- Start links loop -->
                            <{foreach item=link from=$ranking.links}>
                                <tr>
                                    <td class="even"><{$link.rank}></td>
                                    <td class="odd"><a href='singlelink.php?lid=<{$link.id}>'><{$link.title}></a></td>
                                    <td class="even"><{$link.category}></td>
                                    <td class="odd" class='center;'><{$link.hits}></td>
                                    <td class="even" class='center;'><{$link.rating}></td>
                                    <td class="odd" style='text-align: right;'><{$link.votes}></td>
                                </tr>
                            <{/foreach}>
                            <!-- End links loop-->
                        </table>
                </td>
            </tr>
        </table>
        <br>
    <{/foreach}>
    <!-- End ranking loop -->
    <div style='text-align: right;'>
        <a id='itembottom'>
            <a href='#itemtop'><img src='<{$mylinks_imgurl}>/icons/top.gif' alt='<{$lang_gototop}>'
                                    title='<{$lang_gototop}>'></a>
    </div>
<{else}>
    <div style='font-weight: bold; font-size: larger; text-align: center; margin: 4em 0em;'><{$smarty.const._MD_MYLINKS_NOTOP10}><{$lang_sortby}></div>
<{/if}>
