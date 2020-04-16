<ul>
    <{foreach item=link from=$block.links}>
        <li>
        zzz    <a href="<{$block.mylinks_weburl}>/singlelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>"><{$link.title}></a>
            (<{$link.date}>)
        </li>
    <{/foreach}>
</ul>
zzzz
