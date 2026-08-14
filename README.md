# wpMM-AzRuToLatin

A modern WordPress plugin that converts Azerbaijani and Russian characters in post, page, term and media slugs to Latin characters.

## Requirements

- PHP 7.4 or later
- WordPress 6.6 or later

## Examples

| Before                     | After                       |
| -------------------------- | --------------------------- |
| `максим`                   | `maksim`                    |
| `əhməd`                    | `ehmed`                     |
| `Праздничный праздник.docx` | `prazdnichnyj-prazdnik.docx` |

## Installation

1. Copy the `wpmm-azrutolatin` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** menu in WordPress.

## Developer filters

- `wpmm_azrutolatin_transliteration_table` — customize or replace the transliteration map.
- `wpmm_azrutolatin_should_transliterate` — enable or disable transliteration for a given string and context.

## License

GPLv2 or later. See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for details.
