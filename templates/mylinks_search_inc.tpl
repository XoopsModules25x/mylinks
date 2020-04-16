<div class='mylinks_search'>
    <form action='<{$xoops_url}>/search.php' method='get'>
        <input type='text' id='query' name='query' size='30' maxlength='255' value=''>
        <select id='andor' name='andor' size='1'>
            <option value='AND' selected='selected'><{$lang_all}></option>
            <option value='OR'><{$lang_any}></option>
            <option value='exact'><{$lang_exact}></option>
        </select>
        <input type='hidden' name='mids[]' value='<{$module_id}>'>
        <input type='hidden' id='action' name='action' value='results'>
        <input type='submit' class='formButton' name='submit' id='submit' value='<{$lang_search}>'>
    </form>
</div>
