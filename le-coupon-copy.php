<?php
/**
 * Plugin Name: lecouponcopy
 * Plugin URI:  https://www.lezaiyun.com/866.html
 * Description: 一个简单的优惠码复制插件，支持纯文本复制和带跳转链接的复制功能。公众号：<span style="color: red;">老蒋朋友圈</span>
 * Version: 1.0.0
 * Author: 老蒋和他的小伙伴
 * Author URI: https://www.lezaiyun.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: lecouponcopy
 */

if (!defined('ABSPATH')) {
    exit;
}

class LeCouponCopy {
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('lecoupon', array($this, 'coupon_shortcode'));
        add_action('admin_init', array($this, 'add_editor_button'));
        add_action('admin_print_footer_scripts', array($this, 'add_quicktags_button'));
    }

    public function activate() {
        // 激活插件时的操作
        $default_options = array(
            'text_color' => '#333333',
            'button_color' => '#4CAF50',
            'code_color' => '#666666',
            'text_size' => '14',
            'button_size' => '14',
            'code_size' => '14',
            'border_color' => '#E0E0E0'
        );
        add_option('le_coupon_copy_options', $default_options);
    }

    public function deactivate() {
        // 停用插件时的操作
    }

    public function uninstall() {
        // 删除插件时的操作
        delete_option('le_coupon_copy_options');
    }

    public function add_admin_menu() {
        add_options_page(
            '优惠码复制设置',
            '优惠码复制',
            'manage_options',
            'le-coupon-copy',
            array($this, 'admin_page')
        );
    }

    public function register_settings() {
        register_setting(
            'le_coupon_copy_options',
            'le_coupon_copy_options',
            array(
                'type'              => 'array',
                'sanitize_callback' => array($this, 'sanitize_options'),
            )
        );
    }

    /**
     * Sanitize options before saving.
     *
     * @param array $input Raw option values.
     * @return array Sanitized options.
     */
    public function sanitize_options($input) {
        if (!is_array($input)) {
            return array();
        }
        $defaults = array(
            'text_color'   => '#333333',
            'button_color' => '#4CAF50',
            'code_color'   => '#666666',
            'border_color' => '#E0E0E0',
            'text_size'    => 14,
            'button_size'  => 14,
            'code_size'    => 14,
        );
        $sanitized = array();
        foreach (array('text_color', 'button_color', 'code_color', 'border_color') as $key) {
            $val = isset($input[ $key ]) ? sanitize_hex_color($input[ $key ]) : '';
            $sanitized[ $key ] = $val ? $val : $defaults[ $key ];
        }
        foreach (array('text_size', 'button_size', 'code_size') as $key) {
            $val = isset($input[ $key ]) ? absint($input[ $key ]) : $defaults[ $key ];
            $sanitized[ $key ] = max(10, min(30, $val));
        }
        return $sanitized;
    }

    public function enqueue_scripts() {
        $asset_version = '1.0.0';
        wp_enqueue_style('le-coupon-copy-style', plugins_url('assets/css/style.css', __FILE__), array(), $asset_version);

        // 添加 clipboard.js 库
        wp_enqueue_script('clipboard', 'https://cdn.bootcdn.net/ajax/libs/clipboard.js/2.0.11/clipboard.min.js', array('jquery'), '2.0.11', true);

        // 确保我们的脚本在 clipboard.js 之后加载
        wp_enqueue_script('le-coupon-copy-script', plugins_url('assets/js/script.js', __FILE__), array('jquery', 'clipboard'), $asset_version, true);

        wp_localize_script('le-coupon-copy-script', 'leCouponCopy', array(
            'copied_text'       => __('已复制!', 'lecouponcopy'),
            'copy_button_text'  => __('复制', 'lecouponcopy'),
            'success_message'   => __('优惠码已复制！', 'lecouponcopy'),
        ));
    }

    public function coupon_shortcode($atts) {
        $atts = shortcode_atts(array(
            'code' => '',
            'text' => '',
            'url' => ''
        ), $atts, 'lecoupon');

        $options = get_option('le_coupon_copy_options');
        if (!is_array($options)) {
            $options = array();
        }
        $options = array_merge(array(
            'text_color'   => '#333333',
            'button_color' => '#4CAF50',
            'code_color'   => '#666666',
            'border_color' => '#E0E0E0',
            'text_size'    => '14',
            'button_size'  => '14',
            'code_size'    => '14',
        ), $options);
        $code = !empty($atts['code']) ? $atts['code'] : '';
        $text = !empty($atts['text']) ? $atts['text'] : $code;
        $url = !empty($atts['url']) ? $atts['url'] : '';

        // 使用完全内联的结构，使其可以融入内容中
        // 消息提示将通过JavaScript动态创建，不在这里输出，避免影响文档流
        $html = '<span class="le-coupon-container">';
        $html .= '<span class="le-coupon-copy-wrapper" style="border: 1px solid ' . esc_attr($options['border_color']) . ';">';
        $html .= '<span class="le-coupon-text" style="color:' . esc_attr($options['text_color']) . ';font-size:' . esc_attr($options['text_size']) . 'px;">' . esc_html($text) . '</span>';
        $html .= '<button class="le-coupon-copy-btn" data-clipboard-text="' . esc_attr($code) . '" data-url="' . esc_url($url) . '" style="color:' . esc_attr($options['button_color']) . ';font-size:' . esc_attr($options['button_size']) . 'px;">' . esc_html__('复制', 'lecouponcopy') . '</button>';
        $html .= '</span>';
        $html .= '</span>';

        return $html;
    }

    public function admin_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
    }

    public function add_editor_button() {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }
        if ('true' == get_user_option('rich_editing')) {
            add_filter('mce_external_plugins', array($this, 'add_tinymce_plugin'));
            add_filter('mce_buttons', array($this, 'register_editor_button'));
        }
    }

    public function add_tinymce_plugin($plugin_array) {
        $plugin_array['le_coupon_copy'] = esc_url(plugins_url('assets/js/editor-plugin.js', __FILE__));
        return $plugin_array;
    }

    public function register_editor_button($buttons) {
        array_push($buttons, 'le_coupon_copy');
        return $buttons;
    }

    /**
     * 添加传统编辑器（文本模式）的快速标签按钮
     */
    public function add_quicktags_button() {
        // 检查是否有编辑权限
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }
        
        // 只在编辑文章/页面时显示
        $screen = get_current_screen();
        if (!$screen || !in_array($screen->base, array('post', 'page'))) {
            return;
        }
        
        ?>
        <script type="text/javascript">
        if (typeof QTags !== 'undefined') {
            QTags.addButton('le_coupon_copy', '插入优惠码', function() {
                var code = prompt('请输入优惠码：', '');
                if (code === null || code === '') {
                    return;
                }
                
                var text = prompt('请输入显示文本（可选，留空则使用优惠码）：', '');
                var url = prompt('请输入跳转链接（可选）：', '');
                
                var shortcode = '[lecoupon code="' + code + '"';
                if (text && text !== '') {
                    shortcode += ' text="' + text + '"';
                }
                if (url && url !== '') {
                    shortcode += ' url="' + url + '"';
                }
                shortcode += ']';
                
                QTags.insertContent(shortcode);
            });
        }
        </script>
        <?php
    }
}

// 初始化插件
function le_coupon_copy_init() {
    $plugin = LeCouponCopy::get_instance();
}
add_action('plugins_loaded', 'le_coupon_copy_init');

// 注册激活、停用和卸载钩子
register_activation_hook(__FILE__, array(LeCouponCopy::get_instance(), 'activate'));
register_deactivation_hook(__FILE__, array(LeCouponCopy::get_instance(), 'deactivate'));
register_uninstall_hook(__FILE__, array(LeCouponCopy::get_instance(), 'uninstall'));