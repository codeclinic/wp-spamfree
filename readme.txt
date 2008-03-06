=== WP-SpamFree ===
Contributors: WebGeek
Donate link: http://www.hybrid6.com/spamfree-donate
Tags: spam, antispam, anti-spam, comments, comment, wp-spamfree, plugin, security, wordpress, javascript
Tested up to: 2.3.3
Stable tag: 1.5.3

A powerful anti-spam plugin that virtually eliminates automated comment spam from bots. One of the most effective spam plugins available for WordPress. Finally, you can enjoy a spam-free WordPress blog!

== Description ==

= A Powerful Weapon Against Comment Spam =
Comment spam has been a problem for bloggers since the inception of blogs, and it just doesn't seem to go away. The worst kind, and most prolific, is automated spam that comes from bots. Well, finally there is a solution, without CAPTCHA's, challenge questions, or other inconvenience to site visitors. **The WP-SpamFree plugin virtually eliminates automated comment spam from bots.**

= Features =
1. Virtually eliminates automated comment spam from bots. It ensures that your commenters are in fact, human.
2. A counter on your dashboard to keep track of all the spam it's blocking. The numbers will show how effective this plugin is.
3. No CAPTCHA's, challenge questions or other inconvenience to site visitors - it works silently in the background.
4. No false positives, which leads to fewer frustrated readers, and less work for you.
5. You won't have to waste valuable time sifting through your Akismet queue anymore, because there won't be much there.
6. The beauty of this plugin is the method of blocking spam. It takes a different approach than most and stops spam at the door.  
7. The code is has an extremely low bandwidth overhead and won't slow down your blog. (Very light database access.)
8. Completely compatible with all cache plugins, including WP-Cache. Not all anti-spam plugins can say that.
9. Easy to install - truly plug and play. Just upload and activate.

= Background =
Before I developed this plugin, our team and clients experienced the same frustration you do with comment spam on your blog. Every blog we manage had comment moderation enabled, Akismet and various other anti-spam plugins installed, but we still had a ton of comments tagged as spam by Akismet that we had to sort through. This wasted a lot of valuable time, and we all know, time is money. We needed a solution.

Comment spam stems from an older problem - automated spamming of email contact forms on web sites. I developed a fix for this a while ago that had a 100% success rate. Earlier this year, I applied it to our WordPress blogs. It was so effective, that I decided to turn it into a WordPress plugin to be freely distributed. Blogs we manage used to get an excessive number of spam comments show up on the Akismet Spam page each day - now the daily average is zero spam comments.

= Blogging Without Spam =
How does it feel to blog without being bombarded by automated comment spam? If you're happy with WP-SpamFree, please let others know and give it a star rating below. 

== Installation ==
1. After downloading, unzip file and upload the enclosed `wp-spamfree` directory to your WordPress plugins directory: `/wp-content/plugins/`.

2. As always, **activate** the plugin on your WordPress plugins page.

You're done! Sit back and see what it feels like to live without comment spam!

= Upgrading from Version 1.0 =
Simply undo any edits you made to your `header.php` and `wp-comments-post.php` files when installing Version 1.0. Then install the most recent version!

= For Best Results =
WP-SpamFree was created specifically to stop automated comment spam (which accounts for over 95% of comment spam), not human comment spam, trackback spam or pingback spam. Akismet is able to recognize the latter three fairly well, so instead of re-inventing the wheel, we recommend using the two plugins in tandem. As other experts will tell you, the most effective strategy for blocking spam involves applying a variety of techniques. For best results, enable comment moderation, coupled with the Akismet plugin.

== How It Works ==

= How Does WP-SpamFree Work? =
Most of the spam hitting your blog originates from bots. Few bots can process JavaScript. Few bots can process cookies. Fewer still, can handle both. This plugin uses a combo of JavaScript and cookies, since most bots choke on them, to weed out the humans from bots, preventing 99% of automated spam from ever getting to your site. Almost 100% of web site visitors will have these turned on by default, so this type of solution works silently in the background, with no inconveniences. There may be a few users (approx 2%) that have JavaScript and/or cookies turned off by default, but they will be prompted to turn those back on to post their comment. Overall, the few might be inconvenienced because they have JS and cookies turned off will be far fewer than the 100% who would be annoyed by CAPTCHA's, challenge questions, and other validation methods.

As of Version 1.5, WP-SpamFree has multiple randomly generated keys across several methods that further decrease the likelihood of an automated spam comment getting through.

Some would argue that this is too simplistic an approach. Many programmers prefer using soem type of rough AI to fight bots by trying to figure out if a comment is spam. The problem with this is that no machine can ever accurately judge whether a comment is spam, so there are many false positives, and many non-spam comments get flagged as spam. Others would argue that some spammers have programmed their bots to read JavaScript, etc. In reality, the percentage of bots with these capabilities is still extremely low - less than 1%. It's simply a numbers game. Statistics tell us that an effective solution would involve using a technology that few bots can handle, therefore eliminating their ability to spam your site. The important thing in fighting spam is that we create a solution that can reduce spam noticeably and improve the user experience, and a 99% reduction in spam would definitely make a difference for most bloggers and site visitors. :) The bottom line, is that this plugin just plain works, and is a powerful weapon against spam. Sometimes the best solutions are the simplest ones! 

== Other Notes ==

= Troubleshooting =
If you're having trouble getting things to work after installing the plugin, here are a few things to check:

1. If you haven't yet, please upgrade to the latest version.

2. Clear your browser's cache, clear your cookies, and restart your browser. Then reload the page.

3. Make sure JavaScript and cookies are enabled. (JavaScript is different from Java. Java is not required.)

4. If have checked these, and still can't quite get it working, please post a support request in the comments section of the [WP-SpamFree release announcement blog post](http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php).

= Changelog =
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
For updates and documentation, visit the [homepage of the WP-SpamFree Comment Spam Plugin for WordPress](http://www.hybrid6.com/webgeek/plugins/wp-spamfree/).

= WordPress Security Note =
As with any WordPress plugin, for security reasons, you should only download plugins from the author's site and from official WordPress repositories. When other sites host a plugin that is developed by someone else, they may inject code into that could compromise the security of your blog. We cannot endorse a version of this that you may have downloaded from another site. If you have downloaded the "WP-SpamFree" plugin from another site, please download the current release from the [official WP-SpamFree site](http://www.hybrid6.com/webgeek/plugins/wp-spamfree/) or from the [official WP-SpamFree page on WordPress.org](http://wordpress.org/extend/plugins/wp-spamfree/).