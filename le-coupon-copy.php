<?php
/**
 * Plugin Name: lecouponcopy
 * Plugin URI:  https://www.lezaiyun.com/lecouponcopy.html
 * Description: 一个简单的优惠码复制插件，支持纯文本复制和带跳转链接的复制功能。
 * Version: 1.2.2
 * Author: 老蒋
 * Author URI: https://www.laojiang.me
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: lecouponcopy
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

define('LE_COUPON_COPY_VERSION', '1.2.2');
define('LE_COUPON_COPY_SHORTCODE', 'le_coupon_copy');
define('LE_COUPON_COPY_LANG_DIR', dirname(plugin_basename(__FILE__)) . '/languages/');

class LeCouponCopy {
    private static $instance = null;

    /** @var bool */
    private static $frontend_assets_enqueued = false;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_shortcode(LE_COUPON_COPY_SHORTCODE, array($this, 'coupon_shortcode'));
        add_action('admin_init', array($this, 'add_editor_button'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_editor_assets'));
    }

    public function load_textdomain() {
        load_plugin_textdomain('lecouponcopy', false, LE_COUPON_COPY_LANG_DIR);
    }

    public function activate() {
        $default_options = array(
            'text_color'        => '#333333',
            'button_text_color' => '#FFFFFF',
            'button_bg_color'   => '#2196F3',
            'code_color'        => '#666666',
            'text_size'         => '14',
            'button_size'       => '14',
            'code_size'         => '14',
            'border_color'      => '#E0E0E0',
        );
        add_option('le_coupon_copy_options', $default_options);
    }

    public function deactivate() {
    }

    public function add_admin_menu() {
        add_options_page(
            __('Coupon Copy Settings', 'lecouponcopy'),
            __('Coupon Copy', 'lecouponcopy'),
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
            'text_color'        => '#333333',
            'button_text_color' => '#FFFFFF',
            'button_bg_color'   => '#2196F3',
            'code_color'        => '#666666',
            'border_color'      => '#E0E0E0',
            'text_size'         => 14,
            'button_size'       => 14,
            'code_size'         => 14,
        );
        $sanitized = array();
        foreach (array('text_color', 'button_text_color', 'button_bg_color', 'code_color', 'border_color') as $key) {
            $val               = isset($input[ $key ]) ? sanitize_hex_color($input[ $key ]) : '';
            $sanitized[ $key ] = $val ? $val : $defaults[ $key ];
        }
        foreach (array('text_size', 'button_size', 'code_size') as $key) {
            $val               = isset($input[ $key ]) ? absint($input[ $key ]) : $defaults[ $key ];
            $sanitized[ $key ] = max(10, min(30, $val));
        }
        return $sanitized;
    }

    /**
     * Register and enqueue frontend assets (idempotent). Called from shortcode and wp_enqueue_scripts.
     */
    private function enqueue_frontend_assets() {
        if (self::$frontend_assets_enqueued) {
            return;
        }
        self::$frontend_assets_enqueued = true;

        wp_enqueue_style(
            'le-coupon-copy-style',
            plugins_url('assets/css/style.css', __FILE__),
            array(),
            LE_COUPON_COPY_VERSION
        );

        wp_enqueue_script(
            'clipboard'
        );

        wp_enqueue_script(
            'le-coupon-copy-script',
            plugins_url('assets/js/script.js', __FILE__),
            array('clipboard'),
            LE_COUPON_COPY_VERSION,
            true
        );

        wp_localize_script(
            'le-coupon-copy-script',
            'leCouponCopy',
            array(
                'copied_text'      => __('已复制!', 'lecouponcopy'),
                'copy_button_text' => __('复制', 'lecouponcopy'),
                'success_message'  => __('优惠码已复制！', 'lecouponcopy'),
                'error_message'    => __('复制失败，请手动复制优惠码。', 'lecouponcopy'),
            )
        );
    }

    public function coupon_shortcode($atts) {
        $atts = shortcode_atts(
            array(
                'code' => '',
                'text' => '',
                'url'  => '',
            ),
            $atts,
            LE_COUPON_COPY_SHORTCODE
        );

        $code = sanitize_text_field((string) $atts['code']);
        $text_raw = trim((string) $atts['text']);
        $has_display_text = ($text_raw !== '');
        $display_text     = $has_display_text ? sanitize_text_field($text_raw) : $code;

        $url = '';
        $url_raw = trim((string) $atts['url']);
        if ($url_raw !== '') {
            $maybe = esc_url_raw($url_raw);
            if ($maybe && wp_http_validate_url($maybe)) {
                $url = $maybe;
            }
        }

        if ($code === '') {
            return '';
        }

        $this->enqueue_frontend_assets();

        $options = get_option('le_coupon_copy_options');
        if (!is_array($options)) {
            $options = array();
        }
        /* 旧版仅保存 button_color 时表示复制按钮文字颜色 */
        if (!isset($options['button_text_color']) && !empty($options['button_color'])) {
            $options['button_text_color'] = $options['button_color'];
        }
        $options = array_merge(
            array(
                'text_color'        => '#333333',
                'button_text_color' => '#FFFFFF',
                'button_bg_color'   => '#2196F3',
                'code_color'        => '#666666',
                'border_color'      => '#E0E0E0',
                'text_size'         => '14',
                'button_size'       => '14',
                'code_size'         => '14',
            ),
            $options
        );

        /* 前端只显示一块文字：填了「显示文本」则仅显示该文案，否则显示优惠码；真实优惠码仅用于复制按钮 data-clipboard-text */
        $html  = '<span class="le-coupon-container">';
        $html .= '<span class="le-coupon-copy-wrapper" style="border: 1px solid ' . esc_attr($options['border_color']) . ';">';
        if ($has_display_text) {
            $html .= '<span class="le-coupon-text" style="color:' . esc_attr($options['text_color']) . ';font-size:' . esc_attr((string) $options['text_size']) . 'px;">' . esc_html($display_text) . '</span>';
        } else {
            $html .= '<span class="le-coupon-text le-coupon-code" style="color:' . esc_attr($options['code_color']) . ';font-size:' . esc_attr((string) $options['code_size']) . 'px;">' . esc_html($display_text) . '</span>';
        }
        $html .= '<button type="button" class="le-coupon-copy-btn" data-clipboard-text="' . esc_attr($code) . '" data-url="' . esc_attr($url) . '" style="color:' . esc_attr($options['button_text_color']) . ';background-color:' . esc_attr($options['button_bg_color']) . ';font-size:' . esc_attr((string) $options['button_size']) . 'px;">' . esc_html__('复制', 'lecouponcopy') . '</button>';
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

    public function enqueue_admin_editor_assets($hook_suffix) {
        if (!in_array($hook_suffix, array('post.php', 'post-new.php'), true)) {
            return;
        }
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }
        wp_enqueue_style(
            'le-coupon-copy-mce',
            plugins_url('assets/css/admin-mce.css', __FILE__),
            array(),
            LE_COUPON_COPY_VERSION
        );

        wp_enqueue_script(
            'le-coupon-copy-quicktags',
            plugins_url('assets/js/admin-quicktags.js', __FILE__),
            array('quicktags'),
            LE_COUPON_COPY_VERSION,
            true
        );

        wp_localize_script(
            'le-coupon-copy-quicktags',
            'leCouponCopyAdmin',
            array(
                'shortcodeTag'   => LE_COUPON_COPY_SHORTCODE,
                'buttonText'     => __('Insert Coupon', 'lecouponcopy'),
                'promptCode'     => __('Please enter coupon code:', 'lecouponcopy'),
                'promptText'     => __('Please enter display text (optional, leave empty to use coupon code):', 'lecouponcopy'),
                'promptUrl'      => __('Please enter redirect URL (optional):', 'lecouponcopy'),
            )
        );
    }

    public function add_tinymce_plugin($plugin_array) {
        $editor_i18n = array(
            'buttonTitle' => __('Insert Coupon', 'lecouponcopy'),
            'buttonText'  => __('Coupon', 'lecouponcopy'),
            'modalTitle'  => __('Insert Coupon', 'lecouponcopy'),
            'labelCode'   => __('Coupon Code', 'lecouponcopy'),
            'labelText'   => __('Display Text (Optional)', 'lecouponcopy'),
            'labelUrl'    => __('Redirect URL (Optional)', 'lecouponcopy'),
        );
        $plugin_array['le_coupon_copy'] = esc_url(
            add_query_arg(
                array(
                    'ver'     => rawurlencode(LE_COUPON_COPY_VERSION),
                    'i18n'    => rawurlencode(wp_json_encode($editor_i18n)),
                ),
                plugins_url('assets/js/editor-plugin.js', __FILE__)
            )
        );
        return $plugin_array;
    }

    public function register_editor_button($buttons) {
        array_push($buttons, 'le_coupon_copy');
        return $buttons;
    }

}

function le_coupon_copy_init() {
    LeCouponCopy::get_instance();
}
add_action('plugins_loaded', 'le_coupon_copy_init');

register_activation_hook(__FILE__, array(LeCouponCopy::get_instance(), 'activate'));
register_deactivation_hook(__FILE__, array(LeCouponCopy::get_instance(), 'deactivate'));
