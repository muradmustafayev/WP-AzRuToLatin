=== wpMM-AzRuToLatin ===
Contributors: Murad Mustafayev
Tags: transliteration, slugs, azerbaijani, russian, latin, cyrillic
Requires at least: 6.6
Requires PHP: 7.4
Tested up to: 6.6
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Converts Azerbaijani and Russian characters in WordPress slugs and file names to Latin characters.

== Description ==

wpMM-AzRuToLatin automatically transliterates Azerbaijani (Latin script) and Russian (Cyrillic script) characters used in post, page, term and media slugs into URL-safe Latin characters.

This is useful for Azerbaijani-Russian bilingual WordPress sites, SEO-friendly URLs, and clean file names.

= Features =

* PSR-4 namespaced architecture.
* WordPress-standard `sanitize_title` and `sanitize_file_name` hooks.
* Configurable transliteration table via the `wpmm_azrutolatin_transliteration_table` filter.
* Per-context on/off switch via the `wpmm_azrutolatin_should_transliterate` filter.

== Installation ==

1. Upload the `wpmm-azrutolatin` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** menu in WordPress.

== Changelog ==

= 2.0.0 =
* Complete rewrite using modern WordPress and PHP standards.
* PSR-4 autoloading, namespaced classes, and composer support.
* New `Transliterator` and `Sanitizer` classes.
* Exposes `wpmm_azrutolatin_transliteration_table` and `wpmm_azrutolatin_should_transliterate` filters.

= 1.0 =
* Initial release.
