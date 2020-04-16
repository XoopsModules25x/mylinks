<{if $mylinksadcodes.all}>
    <{$mylinksadcodes.all}>
<{elseif $mylinksadcodes.brokenlink}>
    <{$mylinksadcodes.brokenlink}>
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

<div>
    <h4><{$lang_reportbroken}></h4>
    <form action='brokenlink.php' method='post'>
        <input type='hidden' name='lid' value='<{$link_id}>'>
        <{$lang_thanksforhelp}><br>
        <{$lang_forsecurity}><br><br>
        <input type='submit' name='submit' value='<{$lang_reportbroken}>'>&nbsp;
        <input type=button value='<{$lang_cancel}>' onclick='javascript:history.go(-1)'>
    </form>
</div>

<br>
