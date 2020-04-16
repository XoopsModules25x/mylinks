<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
    <channel>
        <atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="self" type="application/rss+xml"
                     href="<{$self_link}>">
        <title><{$channel_title}></title>
        <link><{$channel_link}></link>
        <docs>http://backend.userland.com/rss/</docs>
        <{if $channel_desc != ""}>
            <description><{$channel_desc}></description>
        <{/if}>
        <{if $channel_pubdate != ""}>
            <pubDate><{$channel_pubdate}></pubDate>
        <{/if}>
        <{if $channel_lastbuild != ""}>
            <lastBuildDate><{$channel_lastbuild}></lastBuildDate>
        <{/if}>
        <{if $channel_generator != ""}>
            <generator><{$channel_generator}></generator>
        <{/if}>
        <{if $channel_category != ""}>
            <category><{$channel_category}></category>
        <{/if}>
        <{if $channel_editor != ""}>
            <managingEditor><{$channel_editor}></managingEditor>
        <{/if}>
        <{if $channel_webmaster != ""}>
            <webMaster><{$channel_webmaster}></webMaster>
        <{/if}>
        <{if $channel_copyright != ""}>
            <copyright><{$xoops_meta_copyright}></copyright>
        <{/if}>
        <{if $channel_language != ""}>
            <language><{$channel_language}></language>
        <{/if}>
        <{if $image_url != ""}>
            <image>
                <title><{$image_title}></title>
                <url><{$image_url}></url>
                <link><{$image_link}></link>
                <width><{$image_width}></width>
                <height><{$image_height}></height>
            </image>
        <{/if}>
        <{foreach item=item from=$items}>
            <item>
                <title><{$item.title}></title>
                <link><{$item.link}></link>
                <{if $item.description != ""}>
                    <description><{$item.description}></description>
                <{/if}>
                <{if $item.pubdate != ""}>
                    <pubDate><{$item.pubdate}></pubDate>
                <{/if}>
                <{if $item.guid != ""}>
                    <guid><{$item.guid}></guid>
                <{/if}>
                <{if $item.category != ""}>
                    <category><{$item.category}></category>
                <{/if}>
            </item>
        <{/foreach}>
    </channel>
</rss>
