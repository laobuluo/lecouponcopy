=== lecouponcopy ===
Contributors: laobuluo
Donate link: https://www.lezaiyun.com/donate/
Tags: coupon, coupon copy, shortcode
Requires at least: 6.1
Tested up to: 7.0
Stable tag: 1.2.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple WordPress coupon copy plugin with shortcode and redirect support.

== Description ==

LeCouponCopy is a lightweight WordPress plugin that displays coupon codes with a shortcode. Visitors can copy a coupon code with one click, and you can optionally redirect users to a target URL after the copy action.

This plugin is developed by **Lezaiyun Studio** and maintained by LaoJiang.

🔗 Official product page: https://www.lezaiyun.com/lecouponcopy.html
👤 Developer Blog: https://www.laojiang.me

= Features =

* One-click coupon copy
* Customizable button, text, and border styles
* Optional redirect URL after copy
* Responsive layout compatible with most themes
* Supports Classic Editor and Gutenberg with an insert-shortcode toolbar button
* Supports Quicktags insertion in text mode
* Color and font-size options available in Settings

= Shortcode Usage =

Basic usage (coupon code only):

`[le_coupon_copy code="COUPON123"]`

Full parameters (display text + redirect URL):

`[le_coupon_copy code="COUPON123" text="点击复制优惠码" url="https://example.com"]`

* `code`: Coupon code to copy (required)
* `text`: Frontend display text (optional, defaults to `code`)
* `url`: Redirect URL after copy (optional)

== Installation ==

= Automatic Installation =

1. In WordPress admin, go to Plugins -> Add New.
2. Search for "LeCoupon Copy".
3. Click Install Now and activate the plugin.

= Manual Installation =

1. Download and extract the plugin package.
2. Upload the `lecouponcopy` folder to `/wp-content/plugins/`.
3. Activate "LeCoupon Copy" from the Plugins page.

= After Activation =

1. Go to Settings -> Coupon Copy and adjust styles as needed.
2. Insert `[le_coupon_copy code="YOURCODE"]` in a post or page, or use the editor toolbar button.

== Frequently Asked Questions ==

= How do I use it in a page? =

Insert a shortcode such as `[le_coupon_copy code="YOURCODE"]` in the editor. You can also use the "Insert Coupon" toolbar button to generate the shortcode.

= Can I place multiple coupon codes on one page? =

Yes. You can use multiple `[le_coupon_copy ...]` shortcodes in the same post or page.

= How can I redirect users after copying? =

Add the `url` parameter in the shortcode, for example: `[le_coupon_copy code="ABC" url="https://example.com"]`.

== Screenshots ==

1. Frontend coupon display with copy button
2. Style settings page in WordPress admin
3. "Insert Coupon" button in the editor toolbar

== Changelog ==

= 1.2.1 =
* Renamed shortcode from `[lecoupon]` to `[le_coupon_copy]` for WordPress.org naming guidelines
* Moved Quicktags admin JavaScript to enqueued script file

= 1.0.0 =
* Initial release
* Added `[le_coupon_copy]` shortcode with `code`, `text`, and `url` parameters
* Added TinyMCE insert button for Classic Editor
* Added Quicktags button in text mode
* Added style settings for text, button, border colors, and font sizes

== Upgrade Notice ==

= 1.2.1 =
Shortcode renamed to `[le_coupon_copy]`. Update existing shortcodes and re-submit with enqueued admin scripts.

= 1.0.0 =
First public release with coupon shortcode, one-click copy, redirect support, and style customization.
