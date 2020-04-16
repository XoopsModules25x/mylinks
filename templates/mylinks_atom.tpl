<?xml version="1.0" encoding="UTF-8" ?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="<{$xml_lang}>">
    <title><{$feed_title}></title>
    <link rel="alternate" type="text/html" href="<{$feed_link_alt}>">
    <link rel="self" type="application/rss+xml" href="<{$feed_link_self}>">
    <id><{$feed_id}></id>
    <updated><{$feed_updated}></updated>
    <{if $feed_generator != ""}>
        <generator uri="<{$feed_generator_uri}>"><{$feed_generator}></generator>
    <{/if}>
    <{if $feed_rights != ""}>
        <rights><{$feed_rights}></rights>
    <{/if}>
    <author>
        <name><{$feed_author_name}></name>
        <{ if $feed_author_uri != ""}>
        <uri><{$feed_author_uri}></uri>
        <{ /if}>
        <{ if $feed_author_email != ""}>
        <email><{$feed_author_email}></email>
        <{ /if}>
    </author>
    <{foreach item=entry from=$entrys}>
        <entry>
            <title type="html"><{$entry.title}></title>
            <link rel="alternate" type="text/html" href="<{$entry.link}>">
            <id><{$entry.id}></id>
            <updated><{$entry.updated}></updated>
            <{ if $entry.published != ""}>
            <published><{$entry.published}></published>
            <{ /if}>
            <{ if $entry.category != ""}>
            <category term="<{$entry.category}>">
            <{ /if}>
            <author>
                <name><{$entry.author_name}></name>
                <{ if $entry.author_uri != ""}>
                <uri><{$entry.author_uri}></uri>
                <{ /if}>
                <{ if $entry.author_email != ""}>
                <email><{$entry.author_email}></email>
                <{ /if}>
            </author>
            <{ if $entry.summary != ""}>
            <summary type="html"><{$entry.summary}></summary>
            <{ /if}>
            <{ if $entry.content != ""}>
            <content type="html">
                <![CDATA[
                <{$entry.content}>
                ]]>
            </content>
            <{ /if}>
        </entry>
    <{/foreach}>
</feed>
