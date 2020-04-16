<{if $mylinksadcodes.all}>
    <{$mylinksadcodes.all}>
<{elseif $mylinksadcodes.submit}>
    <{$mylinksadcodes.submit}>
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

<table style='width: 100%; margin: 1px; padding: 4px; border-width: 0px;'>
    <tr>
        <td>
            <ul>
                <li><{$lang_submitonce}></li>
                <li><{$lang_allpending}></li>
                <li><{$lang_dontabuse}></li>
                <li><{$lang_wetakeshot}></li>
            </ul>
            <form action='submit.php' method='post'>
                <table style='width: 80%; margin: auto;'>
                    <tr>
                        <td class='itemHead' style='text-align: right;' nowrap='nowrap' colspan='2'>
                            <div style='text-align: left; font-weight: bold;'><{$lang_submitlinkh}></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='head' style='text-align: right;' nowrap='nowrap'>
                            <div style='text-align: left; font-weight: bold;'><{$lang_sitetitle}></div>
                        </td>
                        <td class='even'>
                            <input type='text' name='title' size='50' maxlength='100'>
                        </td>
                    </tr>
                    <tr>
                        <td class='head' style='text-align: right;' nowrap='nowrap'>
                            <div style='text-align: left; font-weight: bold;'><{$lang_siteurl}></div>
                        </td>
                        <td class='odd'>
                            <input type='text' name='url' size='50' maxlength='255' value='http://'>
                        </td>
                    </tr>
                    <tr>
                        <td class='head' style='text-align: right;' nowrap='nowrap'>
                            <div style='text-align: left; font-weight: bold;'><{$lang_category}></div>
                        </td>
                        <td class='even'>
                            <{$category_selbox}>
                        </td>
                    </tr>
                    <tr>
                        <td class='head' style='text-align: right; vertical-align: top;' nowrap='nowrap'>
                            <div style='text-align: left; font-weight: bold;'><{$lang_description}></div>
                        </td>
                        <td class='odd'>
                            <{$xoops_codes}><{$xoops_smilies}>
                        </td>
                    </tr>
                    <tr>
                        <td class='head' style='text-align: right; vertical-align: top;'>
                            <div style='text-align: left; font-weight: bold;'><{$lang_options}></div>
                        </td>
                        <td class='even'>
                            <{if $notify_show}>
                                <input type='checkbox' name='notify' value='1'>
                                <{$lang_notify}>
                            <{/if}>
                        </td>
                    </tr>
                </table>
                <br>
                <div class='center;'><input type='submit' name='submit' class='button'
                                                        value='<{$lang_submit}>'>&nbsp;<input type='button'
                                                                                               value='<{$lang_cancel}>'
                                                                                               onclick='javascript:history.go(-1)'>
                </div>
            </form>
        </td>
    </tr>
</table>
