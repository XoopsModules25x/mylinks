//  <license>
//  Script: Add To Bookmarks
//  Version: 1.1
//  Homepage: http://www.AddToBookmarks.com/
//  Author: Gideon Marken
//  Author Blog: http://www.gideonmarken.com/
//  Author Work: http://www.markenmedia.com/
//  Author Work: http://www.webandaudio.com/
//  Date: July 18, 2007
//  License: Mozilla Public License 1.1 http://www.mozilla.org/MPL/MPL-1.1.html
//  Custom Development: If you need this script modified, or other custom Web development - contact me!
//  </license>

//  ** NOTES - ok to delete
//  AddSite= this will be the url to the social bookmarking site for adding bookmarks
//  AddUrlVar= variable for URL
//  AddTitleVar= variable for TITLE
//  AddNote= the notes or description of the page - we're using the title for this when it's used
//  AddReturn= so far, one site requires a return url to be passed
//  AddOtherVars= some social bookmarking sites require other variables and their values to be passed - if any exist, they'll be set to this var
//  AddToMethod = [0=direct,1=popup]

//  **Release Log
//  v1 = [December 05, 2005] initial release
//  v1.1 = [July 18, 2007] CSS issue in horizontal layout // Google and Furl bookmark link change // safari popup/timer issue fixed

var txtVersion = "1.1";
var addtoInterval = null;
var popupWin = '';

//intervalMgr was added to make the popup and timer work in Safari
function intervalMgr() {
    if (/Safari/i.test(navigator.userAgent)) { //Test for Safari
        var addtoInterval = setInterval(function () {
            if (/loaded|complete/.test(document.readyState)) {
                closeAddTo() // call target function
            }
        }, 1000)
    }
    else {
        var addtoInterval = setInterval("closeAddTo();", 1000);
    }
}

function addtoWin(addtoFullURL) {
    if (!popupWin.closed && popupWin.location) {
        popupWin.location.href = addtoFullURL;
        intervalMgr();
    }
    else {
        popupWin = window.open(addtoFullURL, 'addtoPopUp', 'width=770px,height=500px,status=0,location=0,resizable=1,scrollbars=1,left=0,top=100');
        if (!popupWin.opener) popupWin.opener = self;
        intervalMgr();
        //var addtoInterval = setInterval("closeAddTo();",1500);
    }
    if (window.focus) {
        popupWin.focus()
    }
    return false;
}
// closes the popupWin
function closeAddTo() {
    if (!popupWin.closed && popupWin.location) {
        if (popupWin.location.href == AddURL)   //if it's the same url as what was bookmarked, close the win
            popupWin.close();
        clearInterval(addtoInterval)
    }
    else {    //if it's closed - clear the timer
        clearInterval(addtoInterval)
        return true
    }
}
//main addto function - sets the variables for each Social Bookmarking site
function addto(addsite, AddURL, AddTitle) {
    var AddURL = AddURL;
    var AddTitle = AddTitle;
    switch (addsite) {
        case 0: //  AddToBookmarks.com ID:0 - an educational page on what Social Bookmarking is
            var AddSite = "http://www.addtobookmarks.com/socialbookmarking.htm?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 1: //  Blink ID:1
            var AddSite = "http://www.blinklist.com/index.php?Action=Blink/addblink.php";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "description";
            var AddReturnVar = "";
            var AddOtherVars = "&Action=Blink/addblink.php";
            break
        case 2: //  Del.icio.us ID:2 &v=3&noui=yes&jump=close
            var AddSite = "http://del.icio.us/post?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 3: //  Digg ID:3
            var AddSite = "http://digg.com/submit?";
            var AddUrlVar = "url";
            var AddTitleVar = "";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "&phase=2";
            break
        case 4: //  Furl ID:4
            var AddSite = "http://www.furl.net/savedialog.jsp?";
            var AddUrlVar = "u";
            var AddTitleVar = "t";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 5: //  GOOGLE ID:5
            var AddSite = "http://www.google.com/bookmarks/mark?op=add&";
            var AddUrlVar = "bkmk";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 6: //  Simpy ID:6
            var AddSite = "http://simpy.com/simpy/LinkAdd.do?";
            var AddUrlVar = "href";
            var AddTitleVar = "title";
            var AddNoteVar = "note";
            var AddReturnVar = "_doneURI";
            var AddOtherVars = "&v=6&src=bookmarklet";
            break
        case 7: //  Yahoo ID: 7
            var AddSite = "http://myweb2.search.yahoo.com/myresults/bookmarklet?";
            var AddUrlVar = "u";
            var AddTitleVar = "t";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "&d=&ei=UTF-8";
            break
        case 8: //  Spurl ID: 8     d.selection?d.selection.createRange().text:d.getSelection()
            var AddSite = "http://www.spurl.net/spurl.php?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "blocked";
            var AddReturnVar = "";
            var AddOtherVars = "&v=3";
            break
        case 9: //  Blue Dot ID: 9
            var AddSite = "http://bluedot.us/Authoring.aspx?";
            var AddUrlVar = "u";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 10://  Blogmarks Dot ID: 10
            var AddSite = "http://blogmarks.net/my/new.php?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "&mini=1&simple=1";
            break
        case 11://  Bookmarktracker Dot ID: 11
            var AddSite = "http://www.bookmarktracker.com/frame_add.cfm?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 12://  FC2 Bookmark Dot ID: 12
            var AddSite = "http://bookmark.fc2.com/user/post?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 13://  Hatena Dot ID: 13
            var AddSite = "http://b.hatena.ne.jp/add?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "&mode=confirm";
            break
        case 14://  Livedoor Clip Dot ID: 14
            var AddSite = "http://clip.livedoor.com/redirect?";
            var AddUrlVar = "link";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 15://  Magnolia Dot ID: 15
            var AddSite = "http://ma.gnolia.com/bookmarklet/add?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 16://  Netscape Dot ID: 16
            var AddSite = "http://www.netscape.com/submit/?";
            var AddUrlVar = "U";
            var AddTitleVar = "T";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 17://  Nifty Clip Dot ID: 17
            var AddSite = "http://clip.nifty.com/create?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 18://  Newsvine Dot ID: 18
            var AddSite = "http://www.newsvine.com/_wine/save?";
            var AddUrlVar = "u";
            var AddTitleVar = "h";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 19://  Pookmark Dot ID: 19
            var AddSite = "http://pookmark.jp/post?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 20://  Reddit Dot ID: 20
            var AddSite = "http://reddit.com/submit?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 21://  Tailrank ID: 21
            var AddSite = "http://tailrank.com/share/?";
            var AddUrlVar = "link_href";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "";
            break
        case 22://  Windows Live ID: 22
            var AddSite = "https://favorites.live.com/quickadd.aspx?";
            var AddUrlVar = "url";
            var AddTitleVar = "title";
            var AddNoteVar = "";
            var AddReturnVar = "";
            var AddOtherVars = "&marklet=1&mkt=en-us&top=1";
            break
        //   case 23://    technorati ID: 22
        //     var AddSite = "http://www.technorati.com/faves?";
        //     var AddUrlVar = "add";
        //     var AddTitleVar = "";
        //     var AddNoteVar = "";
        //     var AddReturnVar = "";
        //     var AddOtherVars = "";
        //    break
        default:
    }

//  Build the URL
    var addtoFullURL = AddSite + AddUrlVar + "=" + AddURL + "&" + AddTitleVar + "=" + AddTitle + AddOtherVars;
    if (AddNoteVar != "") {
        var addtoFullURL = addtoFullURL + "&" + AddNoteVar + "=" + AddTitle;
    }
    if (AddReturnVar != "") {
        var addtoFullURL = addtoFullURL + "&" + AddReturnVar + "=" + AddURL;
    }
//  Checking AddToMethod, to see if it opens in new window or not
    switch (addtoMethod) {
        case 0: // 0=direct link
            self.location = addtoFullURL
            break
        case 1: // 1=popup
            addtoWin(addtoFullURL);
            break
        default:
    }
    return true;
}
//  checking across domains causes errors - this is to supress these
function handleError() {
    return true;
}
window.onerror = handleError;
