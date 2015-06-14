<?php

include 'header.php';
include_once './class/utility.php';
//xoops_load('utility', $xoopsModule->getVar('dirname'));
$lid = mylinksUtility::mylinks_cleanVars($_GET, 'lid', 0, 'int', array('min'=>0));
$cid = mylinksUtility::mylinks_cleanVars($_GET, 'cid', 0, 'int', array('min'=>0));
if (empty($lid) || empty($cid)) {
    redirect_header('index.php', 3, _MD_MYLINKS_IDERROR);
}
/*
$lid = isset($_GET['lid']) ? intval($_GET['lid']) : 0;
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
if ( empty($lid) ) {
  die("No lid!");
} elseif ( empty($cid) ) {
  die("No cid!");
}
*/
$result = $xoopsDB->query("SELECT l.lid, l.cid, l.title, l.url FROM " . $xoopsDB->prefix("mylinks_links") . " l, ".$xoopsDB->prefix("mylinks_text") . " t where l.lid={$lid} AND l.lid=t.lid AND status>0");
if (!$result) {
    redirect_header('index.php', 3, _MD_MYLINKS_NORECORDFOUND);
    exit();
}
list($lid, $cid, $ltitle, $url) = $xoopsDB->fetchRow($result);

//bookmark func
switch ($mylinks_can_bookmark) {
    case _MD_MYLINKS_MEMBERONLY:
        $can_bookmark = ($xoopsUser) ? _MD_MYLINKS_ALLOW : _MD_MYLINKS_DISALLOW;
        break;
    case _MD_MYLINKS_ALLOW:
        $can_bookmark = _MD_MYLINKS_ALLOW;
        break;
    case _MD_MYLINKS_DISALLOW:
    default:
        $can_bookmark = _MD_MYLINKS_DISALLOW;
        break;
}
if ( _MD_MYLINKS_DISALLOW == $can_bookmark ) {
    redirect_header('index.php', 3, _MD_MYLINKS_BOOKMARKDISALLOWED);
    exit();
}

/*
$can_bookmark = 0;
if ( $mylinks_can_bookmark == 0 ) {
  $can_bookmark = 0;
}
else if ( $mylinks_can_bookmark == 1) {
  $can_bookmark = 1;
}
else if ( $mylinks_can_bookmark == 2) {
  if ( $xoopsUser ) {
  $can_bookmark =1;
  }
  else {
  $can_bookmark =0;
  }
}
else {
  $can_bookmark = 0;
}

if ( empty($can_bookmark) ) {
  die("Not allowed now!");
}

$can_qrcode = 0;
if ( $mylinks_can_qrcode == 0 ) {
  $can_qrcode = 0;
}
else if ( $mylinks_can_qrcode == 1) {
  $can_qrcode = 1;
}
else if ( $mylinks_can_qrcode == 2) {
  if ( $xoopsUser ) {
  $can_qrcode =1;
  }
  else {
  $can_qrcode =0;
  }
}
else {
  $can_qrcode = 0;
}

if ( empty($can_qrcode) ) {
  die("Not allowed now!");
}
*/

xoops_header(false);

$myts =& MyTextSanitizer::getInstance();

$sitetitle = $myts->htmlSpecialChars($myts->stripSlashesGPC($ltitle));
$siteurl = $myts->htmlSpecialChars($url);

$siteurl_en   = urlencode(mb_convert_encoding($siteurl, "UTF-8", _CHARSET));
$sitetitle_en = urlencode(mb_convert_encoding($sitetitle, "UTF-8", _CHARSET));

function bookmark_convert_encoding($str, $to = 'SJIS', $from = _CHARSET)
{
    if (function_exists('mb_convert_encoding')) {
        if (is_array($str)) {
            foreach ($str as $key=>$val) {
                $str[$key] = bookmark_convert_encoding($val, $to, $from);
            }

            return $str;
        } else {
            return mb_convert_encoding($str, $to, $from);
        }
    } else {
        return $str;
    }
}

function bookmark_qrcode_encoding($data="")
{
    $data = bookmark_convert_encoding($data);
    $data = rawurlencode($data);
    $data = str_replace("%20", "+", $data);

    return $data;
}

$qrcodedata_url = bookmark_qrcode_encoding($siteurl);
$siteqrcode = "<img alt='".$siteurl."' title='".$siteurl."'src='".XOOPS_URL."/modules/qrcode/qrcode_image.php?d=$qrcodedata_url&amp;e=M&amp;s=4&amp;v=0&amp;t=P&amp;rgb=000000' />\n";

/*
$qrcodedata_docomo_bookmark = bookmark_qrcode_encoding("MEBKM:TITLE:".$sitetitle.";URL:".$siteurl.";;");
$bookmarkqrcode_docomo = "<img alt='docomo' title='docomo'src='".XOOPS_URL."/modules/qrcode/qrcode_image.php?d=$qrcodedata_docomo_bookmark&amp;e=M&amp;s=4&amp;v=0&amp;t=P&amp;rgb=000000' />\n";

$qrcodedata_softbank_bookmark = bookmark_qrcode_encoding("TITLE:".$sitetitle."\r\nURL:".$siteurl."\r\n");
$bookmarkqrcode_softbank = "<img alt='softbank and au' title='softbank and au'src='".XOOPS_URL."/modules/qrcode/qrcode_image.php?d=$qrcodedata_softbank_bookmark&amp;e=M&amp;s=4&amp;v=0&amp;t=P&amp;rgb=000000' />\n";

$qrcodedata_bookmark = bookmark_qrcode_encoding("TITLE:\r\n".$sitetitle."\r\nURL:\r\n".$siteurl."\r\n");
$bookmarkqrcode = "<img alt='title and url' title='title and url'src='".XOOPS_URL."/modules/qrcode/qrcode_image.php?d=$qrcodedata_bookmark&amp;e=M&amp;s=4&amp;v=0&amp;t=P&amp;rgb=000000' />\n";
*/

//google pagerank
define('GOOGLE_MAGIC', 0xE6359A60);

function zeroFill($a, $b)
{
    $z = hexdec(80000000);
    if ($z & $a) {
        $a = ($a>>1);
        $a &= (~$z);
        $a |= 0x40000000;
        $a = ($a>>($b-1));
    } else {
        $a = ($a>>$b);
    }

    return $a;
}

function mix($a, $b, $c)
{
  $a -= $b; $a -= $c; $a ^= (zeroFill($c, 13));
  $b -= $c; $b -= $a; $b ^= ($a<<8);
  $c -= $a; $c -= $b; $c ^= (zeroFill($b, 13));
  $a -= $b; $a -= $c; $a ^= (zeroFill($c, 12));
  $b -= $c; $b -= $a; $b ^= ($a<<16);
  $c -= $a; $c -= $b; $c ^= (zeroFill($b, 5));
  $a -= $b; $a -= $c; $a ^= (zeroFill($c, 3));
  $b -= $c; $b -= $a; $b ^= ($a<<10);
  $c -= $a; $c -= $b; $c ^= (zeroFill($b, 15));

  return array($a, $b, $c);
}

function GoogleCH($url, $length=null, $init=GOOGLE_MAGIC)
{
    if (is_null($length)) {
        $length = sizeof($url);
    }
    $a = $b = 0x9E3779B9;
    $c = $init;
    $k = 0;
    $len = $length;
    while ($len >= 12) {
        $a += ($url[$k+0] +($url[$k+1]<<8) +($url[$k+2]<<16) +($url[$k+3]<<24));
        $b += ($url[$k+4] +($url[$k+5]<<8) +($url[$k+6]<<16) +($url[$k+7]<<24));
        $c += ($url[$k+8] +($url[$k+9]<<8) +($url[$k+10]<<16)+($url[$k+11]<<24));
        $mix = mix($a, $b, $c);
        $a = $mix[0]; $b = $mix[1]; $c = $mix[2];
        $k += 12;
        $len -= 12;
    }

    $c += $length;
    switch($len)
    {
        case 11: $c+=($url[$k+10]<<24);
        case 10: $c+=($url[$k+9]<<16);
        case 9 : $c+=($url[$k+8]<<8);
        case 8 : $b+=($url[$k+7]<<24);
        case 7 : $b+=($url[$k+6]<<16);
        case 6 : $b+=($url[$k+5]<<8);
        case 5 : $b+=($url[$k+4]);
        case 4 : $a+=($url[$k+3]<<24);
        case 3 : $a+=($url[$k+2]<<16);
        case 2 : $a+=($url[$k+1]<<8);
        case 1 : $a+=($url[$k+0]);
    }
    $mix = mix($a, $b, $c);

    return $mix[2];
}

function strord($string)
{
    for ($i=0; $i<strlen($string); $i++) {
        $result[$i] = ord($string{$i});
    }

    return $result;
}

function getrank($url)
{
    $pagerank = "0";
    $ch = "6" . GoogleCH(strord("info:" . $url));

    $fp = fsockopen("www.google.com", 80, $errno, $errstr, 30);
    if (!$fp) {
        $pagerank = "-1";
        //echo "$errstr ($errno)<br />\n";
    } else {
        $out = "GET /search?client=navclient-auto&ch=". $ch .  "&features=Rank&q=info:" . $url . " HTTP/1.1\r\n";
        $out .= "Host: www.google.com\r\n";
        $out .= "Connection: Close\r\n\r\n";

        fwrite($fp, $out);

        while (!feof($fp)) {
            $data = fgets($fp, 128);
            $pos = strpos($data, "Rank_");
            if($pos === false){} else{
                $pagerank = substr($data, $pos + 9);
            }
        }
        fclose($fp);
    }

    return $pagerank;
}
//

echo '
<script type="text/javascript">
<!--//
/***********************************************
* Bookmark site script-Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
/* Modified to support Opera */
function bookmarksite(title,url){
if (window.sidebar) // firefox
  window.sidebar.addPanel(title, url, "");
else if(window.opera && window.print){ // opera
  var elem = document.createElement("a");
  elem.setAttribute("href",url);
  elem.setAttribute("title",title);
  elem.setAttribute("rel","sidebar");
  elem.click();
}
else if(document.all)// ie
  window.external.AddFavorite(url, title);
}
//-->
</script>
</head>
<body>
<script type="text/javascript">
<!--//
var addtoMethod=0;
//-->
</script>
<script src="'.XOOPSMYLINKINCURL.'/addto-multi.js" type="text/javascript"></script>

  <table style="width: 95%; margin: auto;" class="outer">
    <tr><td colspan="2" style="text-align: center;"><h3>'._MD_MYLINKS_BOOKMARK_SERVICE.'</h3></td></tr>
    <tr><td class="head" style="text-align: center; font-weight: bold;">' . _MD_MYLINKS_SITETITLE . '</td><td class="even" style="text-align: center;">'.$sitetitle.'</td></tr>
    <tr><td class="head" style="text-align: center; font-weight: bold;">' . _MD_MYLINKS_SITEURL . '</td><td class="even" style="text-align: center;"><a href="'.$siteurl.'" target="_blank">'.$siteurl.'</a><br />(&nbsp;<strong>Google PageRank :</strong>&nbsp;<img src="'.XOOPSMYLINKIMGURL.'/addto/pr'.getrank($siteurl).'.gif" alt="pagerank" />&nbsp;)</td></tr>';
if ( $mylinks_can_qrcode ) {
            echo '<tr><td  class="head" style="text-align: center; font-weight: bold;">' . _MD_MYLINKS_QRCODE . '<br />(' . _MD_MYLINKS_SITEURL . ')</td><td class="even" style="text-align: center;">'.$siteqrcode.'</td></tr>';
}
  echo '
    <tr><td class="head" style="text-align: center; font-weight: bold;">' . _MD_MYLINKS_WEBBROWSER . '</td><td  class="even" style="text-align: center;">
      <a href="javascript:void(0);" onclick="bookmarksite(\''.$sitetitle.'\', \''.$siteurl.'\');">' . _MD_MYLINKS_BROWSERBOOKMARK . '</a>
    </td></tr>
  </table>
  <br /><br />
<table style="width: 90%; margin: auto;">
<tr class="foot"><td colspan="2" style="text-align: center; font-weight: bold;">'._MD_MYLINKS_BOOKMARK_ADDTO.'...</td></tr>
<tr><td class="even">
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Blink"><a style="cursor:pointer;" onclick="addto(1,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Blink.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Blink" /> Blink</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Delicious"><a style="cursor:pointer;" onclick="addto(2,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Delicious.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Del.icio.us" /> Del.icio.us</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Digg"><a style="cursor:pointer;" onclick="addto(3,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Digg.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Digg" /> Digg</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Furl"><a style="cursor:pointer;" onclick="addto(4,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Furl.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Furl" /> Furl</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Blue Dot"><a style="cursor:pointer;" onclick="addto(9,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Bluedot.png" style="width: 16px; height: 16px; border-width: 0px;" alt="Bluedot" /> Blue Dot</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' BookmarkTracker"><a style="cursor:pointer;" onclick="addto(11,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Bookmarktracker.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Bookmarktracker" /> BookmarkTracker</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Hatena"><a style="cursor:pointer;" onclick="addto(13,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Hatena.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Hatena" /> Hatena</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Magnolia"><a style="cursor:pointer;" onclick="addto(15,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Magnolia.png" style="width: 16px; height: 16px; border-width: 0px;" alt="Magnolia" /> Magnolia</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Nifty Clip"><a style="cursor:pointer;" onclick="addto(17,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Niftyclip.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Nifty Clip" /> Nifty Clip</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Pookmark"><a style="cursor:pointer;" onclick="addto(19,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Pookmark.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Pookmark" /> Pookmark</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Tailrank"><a style="cursor:pointer;" onclick="addto(21,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Tailrank.png" style="width: 16px; height: 16px; border-width: 0px;" alt="Tailrank" /> Tailrank</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Technorati"><a style="cursor:pointer;" onclick="addto(23,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Technorati.png" style="width: 16px; height: 16px; border-width: 0px;" alt="Technorati" /> Technorati</a></span>

  </td>
  <td class="odd">
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Google"><a style="cursor:pointer;" onclick="addto(5,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Google.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Google" /> Google</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Simpy"><a style="cursor:pointer;" onclick="addto(6,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Simpy.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Simpy" /> Simpy</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Spurl"><a style="cursor:pointer;" onclick="addto(8,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Spurl.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Spurl" /> Spurl</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Yahoo! MyWeb"><a style="cursor:pointer;" onclick="addto(7,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Yahoo.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Y!MyWeb" /> Y! MyWeb</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Blogmarks"><a style="cursor:pointer;" onclick="addto(10,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Blogmarks.png" style="width: 16px; height: 16px; border-width: 0px;" alt="Blogmarks" /> Blogmarks</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' FC2"><a style="cursor:pointer;" onclick="addto(12,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_FC2.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="FC2" /> FC2 Bookmark</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Livedoor Clip"><a style="cursor:pointer;" onclick="addto(14,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Livedoorclip.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Livedoor Clip" /> Livedoor Clip</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Netscape"><a style="cursor:pointer;" onclick="addto(16,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Netscape.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Netscape" /> Netscape</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Newsvine"><a style="cursor:pointer;" onclick="addto(18,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Newsvine.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Newsvine" /> Newsvine</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Reddit"><a style="cursor:pointer;" onclick="addto(20,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Reddit.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Reddit" /> Reddit</a></span>
<br />
<span title="' . _MD_MYLINKS_BOOKMARK_ADDTO . ' Windows Live"><a style="cursor:pointer;" onclick="addto(22,\''.$siteurl_en.'\', \''.$sitetitle_en.'\')">
<img src="'.XOOPSMYLINKIMGURL.'/addto/AddTo_Windowslive.gif" style="width: 16px; height: 16px; border-width: 0px;" alt="Windows Live" /> Windows Live</a></span>
  </td>
  </tr></table>
<br /><br />
';

xoops_footer();
