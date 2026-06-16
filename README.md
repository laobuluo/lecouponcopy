# lecouponcopy

[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![WordPress](https://img.shields.io/badge/WordPress-6.1%2B-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4.svg)](https://www.php.net/)

一个轻量级的 WordPress 优惠码复制插件。通过短代码在文章中展示优惠码，访客可一键复制，并支持复制后跳转到指定链接。

A lightweight WordPress plugin for displaying coupon codes with one-click copy and optional redirect support.

![](wechat.png)


## 功能特点

- 一键复制优惠码
- 可自定义按钮、文本、边框颜色与字号
- 支持复制成功后跳转链接
- 响应式布局，兼容多数主题
- 经典编辑器 TinyMCE 工具栏插入按钮
- 文本模式 Quicktags 快捷插入
- 后台「设置 → 优惠码复制」可视化样式配置

## 环境要求

| 项目 | 版本 |
| --- | --- |
| WordPress | 6.1+ |
| PHP | 7.4+ |

## 安装

### 从 GitHub 安装

```bash
cd wp-content/plugins
git clone https://github.com/laobuluo/lecouponcopy.git lecouponcopy
```

然后在 WordPress 后台 **插件** 页面启用 **lecouponcopy**。

### 手动安装

1. 下载本仓库 ZIP 包并解压
2. 将 `lecouponcopy` 文件夹上传到 `/wp-content/plugins/`
3. 在后台启用插件

### 启用后

1. 进入 **设置 → 优惠码复制** 调整样式
2. 在文章或页面中插入短代码，或使用编辑器工具栏按钮

## 短代码用法

基础用法（仅优惠码）：

```
[le_coupon_copy code="COUPON123"]
```

完整参数（显示文本 + 跳转链接）：

```
[le_coupon_copy code="COUPON123" text="点击复制优惠码" url="https://example.com"]
```

| 参数 | 说明 |
| --- | --- |
| `code` | 要复制的优惠码（必填） |
| `text` | 前台显示文本（可选，默认显示 `code`） |
| `url` | 复制成功后跳转链接（可选） |

同一页面可插入多个短代码。

## 目录结构

```
lecouponcopy/
├── admin/
│   └── settings.php          # 后台设置页
├── assets/
│   ├── css/                  # 前台与编辑器样式
│   ├── images/               # 图标与公众号二维码等资源
│   └── js/                   # 前台复制、编辑器与 Quicktags 脚本
├── le-coupon-copy.php        # 插件主文件
├── uninstall.php             # 卸载清理
├── readme.txt                # WordPress.org 插件说明
├── README.md                 # GitHub 项目说明
└── LICENSE                   # GPL-2.0 许可证
```

## 开发说明

本插件遵循 WordPress 编码规范：

- 前台与后台资源通过 `wp_enqueue_style()` / `wp_enqueue_script()` 加载
- 函数、选项、短代码等使用 `le_coupon_copy` 前缀，避免与其他插件冲突
- 短代码标签：`le_coupon_copy`

本地调试时，将仓库放在 WordPress 的 `wp-content/plugins/lecouponcopy/` 目录即可。

## 更新日志

### 1.2.2

- 新增三套语言包：英文（`en_US`）、简体中文（`zh_CN`）、繁体中文（`zh_TW`）
- 增加插件文本域加载，后台设置页与编辑器交互文案全部国际化

### 1.2.1

- 短代码由 `[lecoupon]` 更名为 `[le_coupon_copy]`，符合 WordPress.org 命名规范
- Quicktags 后台脚本改为通过 `wp_enqueue_script` 加载

### 1.0.0

- 首次发布
- 短代码、TinyMCE 按钮、Quicktags 按钮与样式设置

完整记录见 [readme.txt](readme.txt)。

## 许可证

本项目基于 [GPL-2.0](LICENSE) 或更高版本发布。

## 链接

- Official Site: https://www.lezaiyun.com/lecouponcopy.html
- Developer Blog: https://www.laojiang.me/
- WordPress Plugin Directory: https://wordpress.org/plugins/lecouponcopy/
