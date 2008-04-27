=== WP-SpamFree ===
Contributors: WebGeek
Donate link: http://www.hybrid6.com/spamfree-donate
Tags: spam, antispam, anti-spam, comments, comment, wp-spamfree, plugin, security, wordpress, javascript
Tested up to: 2.5.1
Stable tag: 1.7.5

A powerful anti-spam plugin that virtually eliminates automated comment spam from bots. Finally, you can enjoy a spam-free WordPress blog!

== Description ==

= A Powerful Weapon Against Comment Spam =
Comment spam has been a huge problem for bloggers since the inception of blogs, and it just doesn't seem to go away. The worst kind, and most prolific, is automated spam that comes from bots. Well, finally there is an effective solution, without CAPTCHA's, challenge questions, or other inconvenience to site visitors. **WP-SpamFree virtually eliminates automated comment spam from bots, including trackback and pingback spam.**

= Key Features =
1. Virtually eliminates automated comment spam from bots. It ensures that your commenters are in fact, human.
2. A counter on your dashboard to keep track of all the spam it's blocking. The numbers will show how effective this plugin is.
3. No CAPTCHA's, challenge questions or other inconvenience to site visitors - it works silently in the background.
4. No false positives, which leads to fewer frustrated readers, and less work for you.
5. You won't have to waste valuable time sifting through your Akismet queue anymore, because there won't be much there.
6. Now with Trackback and Pingback spam protection.
7. Easy to install - truly plug and play. Just upload and activate. (Installation Status on the plugin admin page to let you know if plugin is installed correctly.)
8. The beauty of this plugin is the methods of blocking spam. It takes a different approach than most and stops spam at the door.  
9. The code is has an extremely low bandwidth overhead and won't slow down your blog (very light database access), unlike some other anti-spam plugins.
10. Completely compatible with all cache plugins, including WP Cache and WP Super Cache. Not all anti-spam plugins can say that.
11. Options to completely disable trackbacks and/or pingbacks if they become an excessive nuisance. While doing so can reduce the connectivity and community feel of the blogosphere, it has been much requested since the glitch in 1.3 that inadvertently blocked trackbacks and pingbacks. Many people actually liked this. So, the choice has been given back to you.

= Background =
Before I developed this plugin, our team and clients experienced the same frustration you do with comment spam on your blog. Every blog we manage had comment moderation enabled, Akismet and various other anti-spam plugins installed, but we still had a ton of comments tagged as spam by Akismet that we had to sort through. This wasted a lot of valuable time, and we all know, time is money. We needed a solution.

Comment spam stems from an older problem - automated spamming of email contact forms on web sites. I developed a successful fix for this a while ago, and later applied it to our WordPress blogs. It was so effective, that I decided to add a few modifications and turn it into a WordPress plugin to be freely distributed. Blogs we manage used to get an excessive number of spam comments show up on the Akismet Spam page each day - now the daily average is zero spam comments.

To further the development of this plugin, I now study thousands and thousands of potential spam comments from many test blogs and contributors. I use a special diagnostic version of the plugin, which provides much more information on each of these spam comments than what is shown in WordPress. By analyzing patterns and behaviors consistent with spam, I can continually improve the plugin and ensure future accuracy.

= How It Works =
Most of the spam hitting your blog originates from bots. Few bots can process JavaScript (JS). Few bots can process cookies. Fewer still, can handle both. In a nutshell, this plugin uses a dynamic combo of JavaScript and cookies to weed out the humans from spambots, preventing 99%+ of automated spam from ever getting to your site. Almost 100% of web site visitors will have these turned on by default, so this type of solution works silently in the background, with no inconveniences. There may be a few users (less than 2%) that have JavaScript and/or cookies turned off by default, but they will be prompted to simply turn those back on to post their comment. Overall, the few might be inconvenienced because they have JS and cookies turned off will be far fewer than the 100% who would be annoyed by CAPTCHA's, challenge questions, and other validation methods.

Some would argue that using JS and cookies is too simplistic an approach. Traditionally, programmers prefer using some type of basic AI to fight bots by trying to figure out if a comment is spam. While that isn't a bad idea, when used alone this method falls short because no machine AI can ever accurately judge whether a comment is spam - many spam comments get through that could easily have been stopped, and there are many false positives where non-spam comments get flagged as spam. Others may argue that some spammers have programmed their bots to read JavaScript, etc. In reality, the percentage of bots with these capabilities is still extremely low - less than 1%. It's simply a numbers game. Statistics tell us that an effective solution would involve using a technology that few bots can handle, therefore eliminating their ability to spam your site. The important thing in fighting spam is that we create a solution that can reduce spam noticeably and improve the user experience, and a 99%+ reduction in spam would definitely make a difference for most bloggers and site visitors.

Even so, it's important to know that the particular JS and cookies solution used in WP-SpamFree has evolved quite a bit, and is no longer simple at all. It utilizes randomly generated keys, and is algorithmically enhanced to ensure that spambots won't beat it. Now it even includes a powerful algorithm to eliminate trackback/pingback spam as well. And, it does all that without hindering legitimate comments and trackbacks. The bottom line, is that this plugin just plain works, and is a **powerful weapon against spam**.

= Blogging Without Spam =
How does it feel to blog without being bombarded by automated comment spam? If you're happy with WP-SpamFree, please let others know by giving it a rating!

== Installation ==

= Installation Instructions =
1. After downloading, unzip file and upload the enclosed `wp-spamfree` directory to your WordPress plugins directory: `/wp-content/plugins/`.

2. As always, **activate** the plugin on your WordPress plugins page.

3. Check to make sure the plugin is installed properly. 99.9% of all support requests for this plugin originate from improper installation and can be easily prevented. To check proper installation status, go to the WP-SpamFree page in your Admin. It's a submenu link on the Plugins page. Go the the 'Installation Status' area near the top and it will tell you if the plugin is installed correctly. If it tells you that the plugin is not installed correctly, please double-check what directory you have installed WP-SpamFree in, delete any WP-SpamFree files you have uploaded to your server, re-read the Installation Instructions, and start the Installation process over from step 1. If it is installed correctly, then move on to the next step.

4. Select desired configuration options. Due to popular request, I've added the option to block trackbacks and pingbacks if the user feels they are excessive. I'd recommend not doing this, but the choice is yours.

5. If you are using front-end anti-spam plugins (CAPTCHA's, challenge questions, etc), be sure they are disabled since there's no longer a need for them, and these could likely conflict. (Back-end anti-spam plugins like Akismet are fine, although unnecessary.)

You're done! Sit back and see what it feels like to live without comment spam!

= Upgrading from Version 1.0 =
Simply undo any edits you made to your `header.php` and `wp-comments-post.php` files when installing Version 1.0. Then install the most recent version!

= For Best Results =
WP-SpamFree was created specifically to stop automated comment spam (which accounts for over 99% of comment spam), and recently we have added some features that help combat human comment spam, as well as trackback/pingback spam. Unfortunately, no plugin can perfectly detect human comment spam. As other experts will tell you, the most effective strategy for blocking spam involves applying a variety of techniques. For best results, enable comment moderation, and if you desire a backup, feel free to use Akismet, as the two plugins are compatible.

== Other Notes ==

= Troubleshooting =
If you're having trouble getting things to work after installing the plugin, here are a few things to check:

1. If you haven't yet, please upgrade to the latest version.

2. Check to make sure the plugin is installed properly. 99.9% of all errors and support requests for this plugin originate from improper installation and can be easily prevented. To check proper installation status, go to the WP-SpamFree page in your Admin. It's a submenu link on the Plugins page. Go the the 'Installation Status' area near the top and it will tell you if the plugin is installed correctly. If it tells you that the plugin is not installed correctly, please double-check what directory you have installed WP-SpamFree in, delete any WP-SpamFree files you have uploaded to your server, re-read the Installation Instructions, and start the Installation process over from step 1.

3. Clear your browser's cache, clear your cookies, and restart your browser. Then reload the page.

4. Make sure JavaScript and cookies are enabled. (JavaScript is different from Java. Java is not required.)

5. Check the options you have selected to make sure they are not disabling a feature you want to use.

6. Make sure that you are not using other front-end anti-spam plugins (CAPTCHA's, challenge questions, etc) since there's no longer a need for them, and these could likely conflict. (Back-end anti-spam plugins like Akismet are fine, although unnecessary.)

7. Visit http://www.yourblog.com/wp-content/plugins/wp-spamfree/js/wpSpamFreeJS.php (where yourblog.com is your blog url) and check two things. First, see if the file comes up normally or if it comes up blank or with errors. That would indicate a problem. Submit a support request (see last troubleshooting step) and copy and past any error messages on the page into your message. Second, check for a 403 Forbidden error. That means there is a problem with your file permissions. If the files in the wp-spamfree folder don't have standard permissions (at least 644 or higher) they won't work. This usually only happens by manual modification, but strange things do happen.

8. If have checked these, and still can't quite get it working, please submit a support request at the [WP-SpamFree Support Page](http://www.hybrid6.com/webgeek/plugins/wp-spamfree/support).

= Changelog =

Version 1.7.5, released 04/26/08: 

* Improved trackback/pingback spam protection.

Version 1.7.3, released 04/25/08: 

* Improved trackback/pingback spam protection.
* Minor cosmetic dashboard change in WP 2.5+ blogs.

Version 1.7.2, released 04/18/08: 

* Improved trackback/pingback spam protection.

Version 1.7.1, released 04/17/08: 

* Improved trackback/pingback spam protection, and overall spam protection.
* Improved compatibility with WordPress 2.5.

Version 1.6.9, released 04/16/08: 

* Minor modification to improve compatibility with certain PHP installations.

Version 1.6.8, released 04/13/08: 

* Modified plugin to not run tests if user is logged in with admin privileges. This fixes a conflict with the Absolute Comments plugin so the two will now work together.

Version 1.6.7, released 04/13/08: 

* Improved trackback/pingback spam protection.
* Minor bug fix.

Version 1.6.6, released 04/12/08: 

* Improved comment spam protection.
* Improved trackback/pingback spam protection.

Version 1.6.3, released 04/08/08: 

* Improved trackback/pingback spam protection.

Version 1.6.1, released 04/07/08: 

* Improved trackback/pingback spam protection.

Version 1.6, released 04/06/08: 

* Improved comment spam protection.
* Improved trackback and pingback spam protection.

Version 1.5.8, released 03/30/08: 

* Modified to work with WordPress 2.5. WordPress 2.5 broke many plugins and themes. If you have any problems with 1.5.8, please submit a support request.
* Now compatible with WP super Cache gzip compression.

Version 1.5.7, released 03/27/08: 

* Improved compatibility with WP Super Cache. Ironically, to do this I removed WP Super Cache compatibility mode. Several users reported having trouble with that feature, and after dialog with several users and further testing, we found it worked better without. (One of the joys of programming - sometimes you think you're fixing one problem and you end up creating a new one. It's fixed now though.) Seems to be working fine with WP Super Cache now, but if any of you have conflicts with WP super Cache and version 1.5.7, please submit a support request so we can look into it ASAP. (See Troubleshooting for more info.)
* Improved spam protection.

Version 1.5.6, released 03/22/08: 

* Addition of Installation Status on plugin admin page to let site owner know if plugin has been installed correctly.
* Minor code efficiency improvements.

Version 1.5.4, released 03/15/08: 

* Addition of configuration option to Disable Trackbacks and/or Pingbacks if spam through these channels proves excessive.
* Addition of WP Super Cache compatibility mode, which can be turned on in the Options section of admin page.

Version 1.5.3, released 02/27/08: 

* Minor upgrade that slightly improves compatibility and code efficiency.

Version 1.5, released 02/25/08: 

* Improved spam protection!
* A counter on your WordPress Dashboard so you can see how many spammers WP-SpamFree has kicked in the head!
* Added advanced verification methods that make WP-SpamFree tougher to beat by potential evolutions in spambots.
* It now creates multiple randomly generated verification keys, across several methods, including random cookie values (so bots can't just set a value and hit the page), along a few other tricks that make it extremely difficult for spambots to bypass.
* Now uses WordPress's database to store important data. Don't worry, though - we're still keeping the overhead light so it doesn't slow down your blog.
* Even more improvements are in the works for future releases. Stay tuned!

Version 1.3.1, released 01/22/08: 

* This release is a bug fix. It was brought to my attention that one of the recent feature upgrades in version 1.3 disabled a blog's ability to receive trackbacks and pingbacks. This is now fixed.

Version 1.3, released 01/20/08: 

* This is a major upgrade!!
* Super-simple installation - truly plug and play. No need to edit external files!! I've been working on making this possible since version 1.01 and finally got the bugs worked out.
* [UPDATE - The following is rolled back in 1.3.1, because of compatibility issues, but will be re-released in a future version.]Added advanced verification methods that enable WP-SpamFree to beat potential evolutions in spambots. It now creates multiple randomly generated verification keys, and a few other tricks that make it extremely difficult for comment spambots to bypass.[/UPDATE]

Version 1.2, released 01/17/08: 

* Improved JavaScript compatibility with Internet Explorer 6 and 7. Even though everything worked perfectly in all browsers, it triggered a JavaScript error icon in the bottom of the Internet Explorer browser window due to IE's lack of standards compliance. This worried a few users, so I took care of it.

Version 1.1, released 01/13/08: 

* Improved security by preventing site visitors from browsing contents of private directories. 
* Improved SEO by ensuring plugin pages don't get indexed in search engines. You don't want backend pages indexed for a number of reason, including security. 

Version 1.03, released 12/01/07: 

* Improved compatibility and minor bug fixes.
* Fixes a problem that some people had when their blog uses "Fancy Permalinks". 

Version 1.02, released 11/14/07: 

* While 1.01 fixed several of the problems with 1.0, it somehow interfered with comment moderation. To fix it I begrudgingly had to go back to manually editing the wp-comments-post.php file. I was trying to make the installation process as simple as possible for users. That's one of the frustrating things in development - you fix one problem and another pops up. C'est la vie. I'll keep working on eliminating the external editing for future versions.
* The installation process is still very easy.

Version 1.01, released 11/13/07: 

* Simplified installation. No need to edit external files as in Version 1.0.
* Improved compatibility.

= Updates / Documentation =
For updates and documentation, visit the [homepage of the WP-SpamFree Comment Spam Plugin for WordPress](http://www.hybrid6.com/webgeek/plugins/wp-spamfree).

= WordPress Security Note =
As with any WordPress plugin, for security reasons, you should only download plugins from the author's site and from official WordPress repositories. When other sites host a plugin that is developed by someone else, they may inject code into that could compromise the security of your blog. We cannot endorse a version of this that you may have downloaded from another site. If you have downloaded the "WP-SpamFree" plugin from another site, please download the current release from the [official WP-SpamFree site](http://www.hybrid6.com/webgeek/plugins/wp-spamfree) or from the [official WP-SpamFree page on WordPress.org](http://wordpress.org/extend/plugins/wp-spamfree/).