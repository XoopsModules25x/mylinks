<{if $mylinksadcodes.all}>
    <{$mylinksadcodes.all}>
<{elseif $mylinksadcodes.ratelink}>
    <{$mylinksadcodes.ratelink}>
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
    <div class='width100'>
        <form action='<{$xoops_requesturi}>' method='post'>
            <label for='mylinks_theme_select'><{$lang_themechanger}></label>
            <{$mylinksthemeoption}>
        </form>
    </div>
<{/if}>
<hr class='bnone' style='height: 1px; color: gray; background-color: gray;'>
<table class='bnone width80' style='padding: 1px; margin: auto;'>
    <tr>
        <td>
            <h4><{$link.title}></h4>
            <ul>
                <li><{$lang_voteonce}></li>
                <li><{$lang_ratingscale}></li>
                <li><{$lang_beobjective}></li>
                <li><{$lang_donotvote}></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td class='center'>
            <form method='post' action='ratelink.php'>
                <input type='hidden' name='lid' value='<{$link.id}>'>
                <input type='hidden' name='cid' value='<{$link.cid}>'>
                <select name='rating'>
                    <option>--</option>
                    <option>10</option>
                    <option>9</option>
                    <option>8</option>
                    <option>7</option>
                    <option>6</option>
                    <option>5</option>
                    <option>4</option>
                    <option>3</option>
                    <option>2</option>
                    <option>1</option>
                </select>&nbsp;&nbsp;
                <input type='submit' name='submit' value='<{$lang_rateit}>'>
                <input type=button value='<{$lang_cancel}>'
                       onclick='location="<{$mylinks_weburl}>/singlelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>"'>
            </form>
        </td>
    </tr>
</table>
