=== lecouponcopy ===
Contributors: laobuluo
Donate link: https://www.lezaiyun.com/
Tags: 优惠码复制, coupon
Requires at least: 6.1
Tested up to: 6.9
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple WordPress coupon copy plugin with shortcode and redirect support.

== Description ==

lecouponcopy 是一款轻量级 WordPress 优惠码复制插件，可在文章或页面中通过短代码展示优惠码，访客一键复制，并可选择复制后跳转到指定链接。

= 功能特点 =

* 优惠码一键复制
* 可自定义复制按钮、文本、边框等样式
* 支持复制后自动跳转链接
* 响应式设计，适配各种主题
* 经典编辑器与古腾堡均支持：工具栏插入短代码按钮（带图标）
* 文本模式下支持快速标签按钮插入短代码
* 后台「设置 → 优惠码复制」中可调整颜色、字号等

= 短代码用法 =

基础用法（仅优惠码）：

`[lecoupon code="COUPON123"]`

完整参数（显示文本 + 跳转链接）：

`[lecoupon code="COUPON123" text="点击复制优惠码" url="https://example.com"]`

* `code`：要复制的优惠码（必填）
* `text`：前台显示的文本（可选，默认与 code 相同）
* `url`：复制后跳转的链接（可选）

== Installation ==

= 自动安装 =

1. 在 WordPress 后台进入「插件 → 安装插件」
2. 搜索「LeCoupon Copy」或「优惠码复制」
3. 点击「现在安装」并启用

= 手动安装 =

1. 下载插件压缩包并解压
2. 将 `lecouponcopy` 文件夹上传到 `/wp-content/plugins/` 目录
3. 在后台「插件」列表中启用「LeCoupon Copy」

= 安装后 =

1. 在「设置 → 优惠码复制」中按需调整样式（颜色、字号、边框等）
2. 在文章或页面中插入短代码 `[lecoupon code="你的优惠码"]`，或使用编辑器工具栏上的优惠码按钮插入

== Frequently Asked Questions ==

= 如何在页面里使用？ =

在编辑器中插入短代码即可，例如：`[lecoupon code="你的优惠码"]`。也可使用编辑器工具栏中的「插入优惠码」按钮（优惠券图标）填写参数后插入。

= 同一页面可以放多个优惠码吗？ =

可以。在同一页面或文章中多次使用 `[lecoupon ...]` 短代码即可展示多个不同的优惠码。

= 复制后如何跳转？ =

在短代码中加上 `url` 参数，例如：`[lecoupon code="ABC" url="https://example.com"]`。用户点击复制后会自动跳转到该链接。

== Screenshots ==

1. 前台优惠码展示与复制按钮
2. 后台「设置 → 优惠码复制」样式设置
3. 编辑器工具栏中的「插入优惠码」按钮

== Changelog ==

= 1.0.0 =
* 初始版本
* 短代码 [lecoupon] 及参数 code、text、url
* 经典编辑器 TinyMCE 插入按钮（带优惠券图标）
* 文本编辑器快速标签按钮
* 后台样式设置：文本/按钮/边框颜色、字号等

== Upgrade Notice ==

= 1.0.0 =
首次发布。支持优惠码短代码、一键复制、复制后跳转及后台样式自定义。
