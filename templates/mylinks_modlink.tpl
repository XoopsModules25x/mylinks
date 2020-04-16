<{if $mylinksadcodes.all}>
    <{$mylinksadcodes.all}>
<{elseif $mylinksadcodes.modlink}>
    <{$mylinksadcodes.modlink}>
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

<form action='modlink.php' method='post'>
    <table class='width80' style='margin: auto;'>
        <tr>
            <td class='itemHead right' nowrap='nowrap' colspan='2'>
                <div class='left bold'><{$lang_requestmod}></div>
            </td>
        </tr>
        <tr>
            <td class='head right'><{$lang_linkid}></td>
            <td class='even bold'><{$link.id}></td>
        </tr>
        <tr>
            <td class='head right'><{$lang_sitetitle}></td>
            <td class='odd'><input type='text' name='title' size='50' maxlength='100' value='<{$link.title}>'></td>
        </tr>
        <tr>
            <td class='head right'><{$lang_siteurl}></td>
            <td class='even'><input type='text' name='url' size='50' maxlength='100' value='<{$link.url}>'></td>
        </tr>
        <tr>
            <td class='head right'><{$lang_category}></td>
            <td class='odd'><{$category_selbox}></td>
        </tr>
        <{*  <tr>
            <td class='even' colspan='2'>&nbsp;</td>
          </tr> *}>
        <tr>
            <td class='head right aligntop'><{$lang_description}></td>
            <td class='odd'><textarea name='description' cols='60' rows='5'><{$link.description}></textarea></td>
        </tr>
        <tr>
            <td class='even center' colspan='2'>
                <br>
                <input type='hidden' name='logourl' value='<{$link.logourl}>'>
                <input type='hidden' name='lid' value='<{$link.id}>'>
                <input type='submit' name='submit' value='<{$lang_sendrequest}>'>&nbsp;
                <input type=button value='<{$lang_cancel}>' onclick='javascript:history.go(-1)'>
            </td>
        </tr>
    </table>
</form>
