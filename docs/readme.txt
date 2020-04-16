// ----------------------------------------------------------- //
//                         mylinks-w 3.11                      //
//                The XOOPS Module Development Team            //
//                         https://xoops.org                //
// ----------------------------------------------------------- //
//                         mylinks-w 3.0                       //
//                    Just enjoy! Internet for everyone!!      //
//                      wanikoo <http://www.wanisys.net/>      //
// ----------------------------------------------------------- //
//                Original Module: mylinks 1.10                //
//             XOOPS Project ( https://xoops.org/ )     //
// ----------------------------------------------------------- //


---------------------------------------------
mylinks-w(mylinks wanisys version) ?
----------------------------------------------
Another hacked version of mylinks for XOOPS/XOOPS Cube Legacy(XCL)!

----------------------------------------------
Install/Upgrade/Uninstall
----------------------------------------------
See ./mylinks/docs/install.txt

----------------------------------------------
Known Issues
----------------------------------------------
+ < None >

----------------------------------------------
Advanced Customization
----------------------------------------------
There are some additional customizations available for advanced
administrators.  There are several variables in the ./header.php
file.  Please, read header.php for detail!
For example:
- To enable/disable the display of a module big logo image
  $mylinks_show_logo = true;
- Alphabetical listing
  $mylinks_show_letters = true;
- External search block ( To use this func, you need to install
  the moremetasearch.php from wanikoo [wani@wanisys.net])
  $mylinks_show_externalsearch = false;
- feed icons
  $mylinks_show_feed = true;
- Enable the Extra functions( print, pdf, bookmark, etc...)
  $mylinks_show_extrafunc = true;
====================
Module Theme Changer
====================
  Using the theme changer also requires the systems administrator to create
  custom themes to be used by the module. The custom themes must be located
  in subdirectories under the ./include directory and images in subdirectories
  of the ./images directory.
  1. You must change the configuration variable(s) located in ./header.php
    For example: $mylinks_show_themechanger = true;
           $mylinks_allowed_theme = array("mylinksdefault",
                           "mylinksdefault-RW",
                           "mylinksdefault-LW",
                           "mylinksdefault-BW",
                           "weblinkslike",
                           "weblinkslike-RW",
                           "weblinkslike-LW",
                           "weblinkslike-BW");
      In the case of mylinksdefault-RW theme, just make
      images/mylinksdefault-RW and include/mylinksdefault-RW directories
      and copy your own images and mylinks.js file, mylinks.css file
      into the corresponding directories.  So the partial directory
      tree would look like:
        ./include
          ./mylinksdefault-RW
            mylinks.js
            mylinks.css
        ./images
          ./mylinksdefault-RW
            newred.gif
            pop.gif
            update.gif
            ...
  2. You are required to create these custom themes before they can be used
     by the module. The module defaults to using ./include/mylinks.js and
     ./include/mylinks.css if it cannot find a file in the currently selected
     theme.
  3. The themes must end in one of the following suffixes depending on the
     XOOPS theme supported by the module theme.
    -RW       => do not show right block-section
      -LW       => do not show left block-section
      -BW       => neither right block-section nor left block-section
      no suffix => do nothing

----------------------------------------------
History
----------------------------------------------
-Ver3.11- RC3 [2013/03/25]
+ added language defines to include all defines for 3.11 (most are non-translated)
+ fixed rss and atom feeds so they validate
+ fixed bug for invalid include of utility class (no longer needed)
+ fixed bug in MylinksCategoryHandler::getCatTitles to get title field
+ fixed site link bug in tell-a-friend
+ removed ./language/nederlands/changelog.txt - it was not being used
+ updated ./docs/install.txt and ./docs/readme.txt
+ changed _MD_AM_DBUPDATED with _MD_MYLINKS_DBUPDATED
+ changed revision to RC3
----------------------------
-Ver3.11- RC2 [2013/02/18]
+ added templates to xoopsversion for rss, atom and pda templates
+ added missing files for template administration
+ fixed addSlashes issue for a link's description and title
+ fixed link count per category calculation routine
+ fixed frontside admin link to modify a link (from ./admin/index.php to .admin/main.php)
+ fixed do not allow voting on inactive links
+ fixed approve/edit/ignore action buttons on listModReq form(s) in Admin panel
+ fixed form title on Modified Links page in Admin panel
+ fixed missing '< / div >' in ./templates/mylinks_link.html
+ fixed incorrect url to view category in Random Link block
+ fixed incorrect category displayed when listing Modified Links in Admin panel
+ removed admin templates from xoopsversion. They did not exist and were not being used
+ removed "Make this my Homepage" link, security risk and was only supported in IE
+ improved html template(s)
+ improved html rendering by moving hard coded English strings to language file(s)
+ improved security in forms - many forms now use XoopsSecurity tokens
+ changed Tell-A-Friend to use server mailer form instead of user's email client
+ changed ereg_replace to str_replace in bookmark_qrcode_encoding() function
+ changed revision to RC2
----------------------------
-Ver3.11- RC [2011-04-15]
+ added pre-install check to verify min versions for PHP/MySQL/Xoops
+ added category class to manage categories
+ changed to use XoopsObjectTree instead of deprecated XoopsTree class
+ fixed various english language typos and grammer
+ moved hard coded language strings to language files
+ fixed missing language definition strings in admin
+ modified block/group administration for XOOPS > 2.2
+ improved html/CSS in both admin and front side page display
+ changed deprecated 'TYPE' to 'ENGINE' in /sql/mysql.sql
+ general code cleanup to improve readability
+ fixed bug in ./admin/about.php to display release status
+ removed display of 'Modify' link if user is not logged in
+ moved numerous configuration options from ./header.php to module Preferences
+ input variables sanitized to eliminate SQL injection
+ changed from using xoops_module_header in templates to using xoTheme class
+ fixed bug in ./rating.php where checking for form submitted with no rating selected.
+ added Preferences setting to select which auto screenshot provider to use
+ fixed bug where module couldn't be relocated to alternate directory
+ added Preferences option to include/exclude admin hits in hit counter
+ added Random Listing display block
+ fixed RSS links displayed by ./feedsubscription.php
+ removed additional XOOPS search block in ./singlelink.php display
----------------------------
-Ver3.1-[2011-03-18]
- updated admin menu to XOOPS 2.5 style
----------------------------
-Ver3.0-[2008-11-25]
+ bookmark button
+ bug/typo fix!(Sorry for my stupid mistake!!)
+ Code refined
+ etc.
----------------------------
-Ver2.5-[2008-05-27]
+ minimize/restore button
+ Internal search block
+ enhanced page-navigation
+ etc.
-----------------------------
-Ver2.0-[2008-04-20]
+ Category Jump box
+ print button
+ pdf button
+ qrcode button ( qrcode module needed! )
+ etc.
------------------------------
-Ver1.5-
+ Module Theme changer
+ Search function!
+ Index Browsing
+ Code refined
+ etc.
------------------------------

Support Forum:
https://xoops.org/modules/newbb/viewtopic.php?post_id=352230

From wanikoo [wani@wanisys.net]
the most educational site, wanisys.net [ http://www.wanisys.net  ]

