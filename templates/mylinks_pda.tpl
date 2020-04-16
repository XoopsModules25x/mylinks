<html>
<head>
    <title><{$site_name}></title>
    <meta http-equiv='content-type' content='text/html; charset=<{$xoops_charset}>'>
    <meta name='HandheldFriendly' content='True'>
    <meta name='PalmComputingPlatform' content='True'>
</head>
<body>
<a href='<{$site_url}>'>
    <{ if $image_url != ''}>
    <img src='<{$image_url}>' style='border-width: 0px;' alt='<{$site_name}>'>
    <{ else}>
    <h3><{$site_name}></h3>
    <{ /if}>
</a><br>
<br>
<{$site_desc}><br>
<ul>
    <{foreach item=line from=$whatsnew}>
        <li><a href='<{$line.link}>'><{$line.title}></a> (<{$line.date_s}>) <br>
            <{ if $line.desc}>
            <span style="font-size: smaller; "><{$line.desc}></span><br>
            <{ /if}>

            <{ if $line.image}>
            <a href='<{$line.link}>'>
                <{ if $line.width && $line.height}>
                <img src='<{$line.image}>' style='width: <{$line.width}>; height:<{$line.height}>; border-width: 0px;'
                     alt='image'>
                <{ else}>
                <img src='<{$line.image}>' style='border-width: 0px;' alt='image'>
                <{ /if}>
            </a><br><br>
            <{ /if}>

        </li>
    <{/foreach}>
</ul>
</body>
</html>
