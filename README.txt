=== Jimmy Codeviewer ===
Contributors: kenjmk7r9merchant
Plugin Name: Jimmy Codeviewer
Plugin URI: http://electronics.jimmykenmerchant.com/jimmy-codeviewer/
Tags: code, svg, text, script, viewer, loader, layout, magazine
Author: Kenta Ishii
Author URI: http://electronics.jimmykenmerchant.com
Requires at least: 4.7
Tested up to: 4.9
Stable tag: 1.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Jimmy Codeviewer is a shortcode library to load text, SVG (Scalable Vector Graphics) and other scripts to WordPress pages. By using this plugin, you can reduce quantity of your code, e.g., if you want to put a proportional sample of programming code in your page, you just type one shortcode, then you get the sample with line numbers and colored words which you intended. In addition, you can make pages with layout similar to magazines on paper by using "magazine", a theme template.

= Introduction =

In my first mind, I purposed to make a viewer for programming code for my site that introduces my articles. It was OK and named this plugin as "Jimmy Codeviewer". But in making "Jimmy Codeviewer", I think this could be a multipurpose text viewer. On this time, many news sites have very simple layout for their contents. You could watch magazines or papers at a news-stand everyday, and these are so colorful and design-riches. I just want these on Internet. Colorful design-riches actually make us some attention and affection. Web browsers are growing their rendering ability right now. This challenge — making magazines or newspapers on Internet — not a dream, but a real on Internet. In addition, I tried to change WordPress to SVG-Free. SVG (Scalable Vector Graphics) is one of vector graphics containers. It's just like HTML and JavaScrpt. This is exactly the reason why WordPress Community prohibits to upload SVG Files by Media Uploader. If SVGs are programming codes, these should be stored as scripts in pages. But "Posts" and "Pages" are having their own purposes as public pages. So I decided to make "jArticles", inner pages and store texts, SVGs and scripts to "jArticles". For loading "jArticles" on "Posts", I made several WordPress shortcodes.

Jimmy Codeviewer consists of three departments which have several WordPress shortcodes and functions.

I. Code Viewer

a. Shortcodes: [codeview_byid] and [codeview_byname] to show text in "Posts".

b. Edit Instructions: `(edit(exam-ple))` to make HTML markup or other escaped literal codes in "jArticles" pages.

c. Style Sheet: CSS Style Sheet to make web layout easier with Code Viewer.

II. Article Loader

a. Shortcodes: [articleloader_byid] and [articleloader_byname] to show SVGs or other scripts in "Posts".

III. Color and Style Changer

a. Shortcodes: [init_spansearch], [spansearch] and [spansearch_all] to change the text color and other styles. [divsearch] to change the row styles.

b. JavaSctipt: 'spanSearch' and its family, the engine to provide the above shortcodes to function.

= Copyright =

The Jimmy Codeviewer, A WordPress Plugin, Copyright 2017 Kenta Ishii
Jimmy Codeviewer is distributed under the terms of the GNU GPL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

== Screenshots ==
1. Usage sample of shortcodes, 'codeview' series.
2. Usage sample of shortcodes, 'spansearch' series and 'articleloader' series.

== Installation ==

From "Plugins" of your admin page, just search and install "Jimmy Codeviewer". Make sure to activate "Jimmy Codeviewer" in "Installed Plugins", a "Plugins" sub menu.

You can download and test the latest version of this plugin from GitHub public repository. <https://github.com/JimmyKenMerchant/jimmy-codeviewer/>

This Plugin uses several text domains. Names of shortcodes may conflict with shortcodes in other plugins. The name of post type, "jArticle" is considering its unique naming, but even "jArticle", this name may conflict with other names. LATEX, a renowned digital document preparation system, uses "jarticle" as a Japanese document class. But I think, in WordPress, "jArticle" as one of post types is unique naming. Before activating this plugin, make sure to check naming conflict between this plugin and others. Embedded CSS in this plugin uses several names for HTML ids and classes, such as `magazine-content`. If you meet any naming conflict in whole HTML ids or classes in your page, change these names to save each unique naming. Changing names of ids and classes in `style-codeviewer.css` does not affect functions of shortcodes in this plugin.

This plugin wants encoding of the text is UTF-8, otherwise you meet empty return of HTML code. Setting of UTF-8 to `mb_detect_encoding` and `mb_convert_encoding` is useful. Plus, you can use UTF-8 as PHP default, e.g., set `default_charset = UTF-8` in `php.ini` . You may need settings of Multibyte String Extension (php-mbstring) and more to fit UTF-8 encoding. Make sure to set UTF-8 in HTML, e.g., write `<meta charset="UTF-8">` in head tag. In addition, MySQL's Table charset needs `utf8mb4` , collate needs `utf8mb4_unicode_ci` . UTF-8 is ultimatelly in-bytes format for Unicode. If you want to search raw Unicode, you may need utf-16 style Unicode such as `/\x{2010}/u` .

== Frequently Asked Questions ==

= Tutorial I - III =

Visit my site to check layout samples, and actually how to write HTML and shortcodes in your posts. <http://electronics.jimmykenmerchant.com/jimmy-codeviewer/>

I. Brief
First, you publish your text or SVGs in "jArticles". Second, you call these in "Posts" by using shortcodes. If you want to change color or style on some particular string and row, use shortcodes as the instruction below.

II. Publish your text or SVGs in "jArticles"
After activated this plugin, you can see "jArticles" menu on the Admin Side Bar. Click this, then edit your text and publish. Make sure to note the post ID (on URL of the editor page itself) or the slug you made. This "jArticle" can not be shown in your site publicly.

III. Calling "jArticles" in "Posts"
Now you can use shortcodes on "Posts". In use of 'codeview' shorcodes, auto tagging ( `<p>` and/or `<br />` ) for your post will be disabled, and indents for 'codeview' shortcodes will be erased automatically.

a. `[codeview_byid theme="default" id="desc" start="1" count="5"]111(ID of jArticle content)[/codeview_byid]` :
Shows line No.1 and sequenced 5 lines from No.1 in the text of the jArticle, the post ID is "111" and assign each row ID as "desc-(its line number)" and table class as "desc" with default template.

b. `[codeview_byname theme="magazine" id="text" start="4"]some-thing(slug name of jArticle content)[/codeview_byname]` :
Shows line No.4 in the text of the jArticle, the post slug is "some-thing" and assign each row ID as "text-(its line number)" and table class as "text" with magazine template.

'theme="magazine"' means making HTML tags with magazine template, e.g., if you use magazine template, background-color of your text becomes transparent. Besides, if you use default template, the background-color becomes blue.

Styles can change individually on each shortcode. You can use attributes below.

(1) 'id' // ID to add
(2) 'start' // Initial Line Number
(3) 'count' // The number of rows you want to show
(4) 'width' // width of this block
(5) 'number-width' // number width
(6) 'text-align'
(7) 'line-height'
(8) 'color'
(9) 'number-color'
(10) 'background-color'
(11) 'odd-background-color'
(12) 'even-background-color'
(13) 'font-family'
(14) 'font-size'
(15) 'font-style'
(16) 'font-weight'
(17) 'opacity'
(18) 'padding-top'
(19) 'padding-right'
(20) 'padding-bottom'
(21) 'padding-left'
(22) 'white-space' // wrap or line for words) preformatted "pre-wrap", "pre", "normal", "nowrap"
(23) 'title' // Title Name under the code
(24) 'line10-color' // font's color
(25) 'line20-color' // font's color
(26) 'line10-1' // line number (absolute) you want LINE10COL color
(27) 'line10-2' // line number (absolute) you want LINE10COL color
(28) 'line10-3' // line number (absolute) you want LINE10COL color
(29) 'line20-1' // line number (absolute) you want LINE20COL color
(30) 'line20-2' // line number (absolute) you want LINE20COL color
(31) 'line20-3' // line number (absolute) you want LINE20COL color
(32) 'edit-instruction' // If "True" or "true", enables Edit Instructions

No.6 to No.22 are similar to HTML style attributes. But if you use spaces in unquoted values, arguments to function spanSearch (JavaScript) will be broken. No.1 to No.5 are the basic of making the table. Make sure to add `%` in the value of `number-width`. No.23 to No.31 are to use in programming code viewing to change font color on particular rows. No.32 is to enable Edit Instructions. In the default theme, it's disabled. Besides, in the magazine theme, it's enabled.

Jimmy Codeviewer never consider of putting same lines on a page several times. Therefore, if you name the same ID to the tables which have the same line numbers, you will meet ID conflict and functional problems on 'spansearch' series and 'divsearch'.

c. `[articleloader_byid"]111(ID of jArticle content)[/articleloader_byid]` :
d. `[articleloader_byname"]some-thing(slug name of jArticle content)[/articleloader_byname]` :
Likewise 'codeview' series, these show jArticles on your posts. But these are not for text but for scripts. SVGs and other scripts can be loaded to particular posts. Unlike 'codeview' series, attributes don't exist.

= Tutorial IV =

IV. Change Color or style on some particular string and row
a. `[init_spansearch]` :
Make sure to add this to use the shortcodes below. If you use `<!--nextpage-->` on your post, add this on all divisions to make each pages.

b. `[spansearch id="desc" start="11" end="14" color="red"]Some Word[/spansearch]` :
Searches the string "Some Word" on lines No.11 to No.14 of id "desc" which named in 'codeview' series then changes "Some Word" font color to red. If some line does not exist between No.11 to No.14, This function will be stopped. If you use this shortcode, make sure to confirm sequenced line numbers between "start" and "end".

c. `[spansearch_all id="text" background-color="blue"]Some String[/spansearch_all]` :
Searches the string "Some String" on all lines of id "text" which named in 'codeview' series then changes "Some String" background-color to blue. This shortcode does not require sequenced line numbers of made tables by 'codeview' series.

From Jimmy Codeviewer Version 1.0.2, the enclosed content (between a shortcode and its slashed shortcode) of 'spansearch' series can contain special characters, `[` , `]` , `"` , `'` , `<` , `>` , `&` . Remember that `<` , `>` , `[` , `]` need to append backslashes like `\<` , `\>` , `\[` , `\]` , because these are special brackets to use HTML, WordPress shortcode and Regular Expression. Shortcode attribute values should not contain several special characters. Read the latest version of <https://codex.wordpress.org/Shortcode_API> . 

If you want to search HTML entities such as `&nbsp;` , use unicode escape characters just as `\xA0` , `\u00A0` or `\u{00A0}` . In the process of JavaScript (Node.textContent), HTML entities translate actual chars.

'spansearch' series have these attributes below.

(1) 'id' // table's id
(2) 'color' // fontcolor of target string
(3) 'background-color' // background-color of target string
(4) 'font-family' // font-size of target string
(5) 'font-size' // font-size of target string
(6) 'font-style' // font-style of target string
(7) 'font-weight' // font-weight of target string
(8) 'vertical-align' // vertical-align of target string
(9) 'regex-enable' // enable Regular Expression ('TRUE' or 'true') or not
(10) 'regex-modifier' // assign "i" and/or "m" modifier on RegExp. "g" will be ignored

'[spansearch]' have these attributes below.

(11) 'start' // line number to start
(12) 'end' // line number to end

If No.9, 'regex-enable', is "TRUE" or "true", 'spansearch' series are searching the word by JavaScript's Regular Expression. Type your search word by JavaScript's rule for Regular Expression without delimiters, and assign "m" (multi-lines modifier for use `^`, `$` on each lines), and/or "i" (ignore cases) in No.10, 'regex-modifier'. Remember "g" is never be used, because this modifier is for replacing all words on one time `String.prototype.replace()`, or get all matching words on one time `String.prototype.match()` .

d. `[divsearch id="title" start="3" end="7" text-align="center" line-height="1.6em"]` :
Searches lines No.3 to No.7 of id "title" which named in 'codeview' series then changes these text-align to center, and line-height to 1.6em. If some line does not exist between No.11 to No.14, This function will be stopped. If you use this shortcode, make sure to confirm sequenced line numbers between "start" and "end".

'[divsearch]' have these attributes below.

(1) 'id' // table's id
(2) 'start' // line number to start
(3) 'end' // line number to end
(4) 'text-align' // align property
(5) 'line-height' // line-height of target line(s)
(6) 'color' // color of target line(s)
(7) 'background-color' // background-color of target line(s)
(8) 'font-family' // font-size of target target line(s)
(9) 'font-size' // background-color of target line(s)
(10) 'font-style' // background-color of target line(s)
(11) 'font-weight' // background-color of target line(s)

= Tutorial V - VI =

V. Capabilities of editing "jArticles"
On activation of this plugin, "Adiministor" and "Editor" are added full capabilities to edit and publish "jArticles". "jFellow" role, which has limited capabilities to edit "jArticle", added to admin system. On deactivation of this plugin, capabilities for "jArticles" and "jFellow" role will be erased.

VI. Edit Instructions
In text of "jArticles" to use 'codeview' series, you can use Edit Instructions to put HTML tags for ruby, newline, etc. In 'codeview', HTML special characters and some entities changes to HTML escapes such as `&lt;` (for `<`). Therefore, you need to use Edit Instructions to put HTML tags. Plus, to function 'spansearch' series, each children tag needs to be named. To take easy of these work, Edit Instructions exist. Plus, if you want newlines in one line on "jArticles", you can use `(edit(new-line))` .

Actual Edit Instructions are below.

(1) `(edit(hard-hyphen))` :
To put Actual Hyphen and have newline.

(2) `(edit(soft-hyphen))` :
To put a HTML entity `&shy;` to use `hyphens: manual;` in CSS.

(3) `(edit(new-line))` :
To have newline.

(4) `(edit(br-tag))` :
To put `<br />` (XHTML Style) tag.

(5) `(edit(ruby-tag))` :
To put `<ruby>` tag for ruby.

(6) `(edit(end-ruby))` :
To put `</ruby>` tag for ruby.

(7) `(edit(rb-tag))` :
To put `<rb>` tag for ruby.

(8) `(edit(end-rb))` :
To put `</rb>` tag for ruby.

(9) `(edit(rt-tag))` :
To put `<rt>` tag for ruby.

(10) `(edit(end-rt))` :
To put `</rt>` tag for ruby.

(11) `(edit(color-tag-somecolor))` :
To Color the string between this Instruction and `(end-color)`.
This Instruction is a little special. If you want to color the string to red, use `(edit(color-tag-red))` . Besides, `(edit(color-tag-#09abcd))` means the string colored to hexadecimal `#09abcd`. Capital letters are recognized as well as small letters.

(12) `(edit(end-color))` :
To end color-tag.

= When I used a 'codeview' shortcode, an error message was displayed on my post instead of the text I wanted. What's this? =

'codeview' series and 'articleloader' series display error messages on several situations, e.g., if you use these shortcodes with incorrect post IDs or Slugs, error messages emerge with error numbers. Each error number is assigned to know where the error occurs. If you want to see meaning of each error number, check `jimmy-codeviewer.php` and `article-loader.php` .

= Why can't I get correct searching in 'spansearch' series? =

In WordPress, several characters automatically converted. This function may cause incorrect searching. It's in `wp-includes/formatting.php`. I'm trying to suppress these conversions. If you find a malfunction of searching process caused by any automatic converted character, please note it in the support forum of this plugin.

= Compatibility =

I. Themes
On WordPress Team's "Twenty Seventeen", this Plugin works but you may need to customize "Twenty Seventeen" or this plugin to fit on display. Some themes such as "Twenty Seventeen" are having style flexibility between mobile devices and personal computers. Nowadays, rendering power of displays on both mobiles and personals are close to each other. Small displays can work as well as big displays by high density pixels. So I now recommend to trash flexibility between both. This gives us concentration of manpower to one layout in one site and grows quality of the site design. 

II. Web Browsers
Firefox, Chrome, Opera, IE and Edge work on this plugin. Other browsers have not been tested. This plugin never guarantee to work SVG, JavaScript or other scripts in browsers. Even though you can load scripts using 'articleloader' series, these may not work properly.

= Security Notice =

Both 'codeview' series and 'articleloader' series do not support loading by post titles. Because post titles can not be guaranteed for unique naming, cross-site scripting attacks may occur by rewriting contents of "jArticles" on junior graded users (such as "jFellow"). Post ID and post slug have its unique naming. In extending or modifying this plugin, make sure NOT to use post titles for loading "jArticles". This plugin prohibit to load "jArticles" which don't be published by senior graded users (such as "Editor"). Senior graded users should pay attention to investigate SVGs, JavaScript and other scripts in "jArticles" for stopping any malicious activities before publishing "jArticles".

In PHP, `0`, `''`, `""`, `'0'`, `"0"`, `array()` and null means FALSE in boolean check, TRUE in empty check, `empty()` . Besides, `"\0"` stores null character in String. This means no empty. C language recognizes null character such as null terminator (recognized as End of String). This difference between PHP and C language is used by hackers. To prevent possible null byte injection, I added a method to erase every null character in every relevant shortcode.

Every attribute in shortcodes seems like to be String type. Check shortcode_parse_atts in shortcodes.php in wp-includes. This function uses a set of shorcode attributes as a text. Therefore, for example, if you want some number as Integer type, you need cast the value to Integer type. PHP's integer cast uses `atoi()`, a C language function.

= What will you do here in the future? =

I'm thinking of making a GUI tool in this plugin. If you have some curious, please note it in the support forum of this plugin.

== Upgrade Notice ==
= 1.0.6 =
Please upgrade because of fixing bugs and having new futures: Confirmed Compatibility with WordPress Version 4.9.

== Changelog ==

= 1.0.6 =
* Confirmed Compatibility with WordPress Version 4.9
: April 26, 2018

= 1.0.5 =
* Modified README.txt
: June 22, 2017

= 1.0.4 =
* Modified 'codeview' shortcodes detecting process to cancel auto tagging and/or remove indents
: June 22, 2017

= 1.0.3 =
* Capsulation of JavaScript by objectification to 'JIMMY_CODEVIEWER'
* Confirmed Compatibility with WordPress Version 4.8
: June 10, 2017

= 1.0.2 =
* Enabled to use special characters in enclosed contents in 'spansearch' series.
: April 24, 2017

= 1.0.1 =
* Added an attribute whether Edit Instruction will be enabled or disabled on 'codeview' series
* Added minimized files of JavaScript
: April 17, 2017

= 1.0 =
* Release in WordPress.org
: April 17, 2017

= 0.9.8 Beta =
* Reviewed the security of 'codeview' series and 'articleloader' series | Modified README.txt and comments
: April 9, 2017

= 0.9.7 Beta =
* Modified README.txt and comments
: April 8, 2017

= 0.9.6 Beta =
* Reviewed the security of 'spansearch' series, typically handling special characters
: April 2, 2017

= 0.9.5 Beta =
* Added Variable Modifiers of Regular Expression Search | Reviewed Text Domain
: April 1, 2017

= 0.9.4 Beta =
* Changed the Post Type Name "article" to "jarticle" for unique naming
: March 31, 2017

= 0.9.3 Beta =
* Added Regular Expression Search to 'spansearch' series
: March 30, 2017

= 0.9.2 Beta =
* Shorcodes using post titles are deprecated because of a security reason. Please see Securiy Notice above
: March 29, 2017

= 0.9.1 Beta =
* Released: March 26, 2017
