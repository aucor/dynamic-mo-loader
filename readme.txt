=== Dynamic MO Loader ===
Contributors: Teemu Suoranta
Tags: WordPress, REST API, WP_Query
Requires at least: 4.7.3
Tested up to: 4.9.8
Requires PHP: 7.0
Stable tag: trunk
License: GPLv2+

Better text domain loading with object cache support

== Description ==
Changing the WordPress site language to any other than English slows down page generation times. A lot. This is caused by the slow and inefficient way of text domain loading. This plugin, based on the excellent work by Björn Ahrens, aims to fix that by loading only the text domains that are used in a page and even more, by caching them.
PO and MO files are designed to be used with PHP Gettext-extension. But since it\'s an extension, it\'s not installed by default on all hosting platforms. To overcome this barrier, WordPress has re-implemented the whole MO file parsing in PHP completely ignoring the possibility to use native gettext, if available. This WordPress\' implementation is a bit slow.
This plugin has another implementation of MO parsing, which is faster than the default one. The plugin also loads only the text domains that are required to generate the current page instead the default behavior of loading every available text domain. As front end pages usually only use strings from few text domains, this leads to a great performance boost in front end.
To boost the performance even more, the plugin also caches the loaded text domains in to the object cache. For optimal performance you need a fast object cache backend like Redis, Memcached or APC(u).

= Links =
* [GitHub](https://github.com/aucor/dynamic-mo-loader)

== Installation ==
Download and activate. That\'s it.

== Changelog ==
= 1.2.0 = 
* WordPress.org release