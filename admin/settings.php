<?php
if (!defined('ABSPATH')) {
    exit;
}

$le_coupon_copy_options = get_option('le_coupon_copy_options');
if (!is_array($le_coupon_copy_options)) {
    $le_coupon_copy_options = array();
}
if (!isset($le_coupon_copy_options['button_text_color']) && !empty($le_coupon_copy_options['button_color'])) {
    $le_coupon_copy_options['button_text_color'] = $le_coupon_copy_options['button_color'];
}
$le_coupon_copy_options = array_merge(array(
    'text_color'        => '#333333',
    'button_text_color' => '#FFFFFF',
    'button_bg_color'   => '#2196F3',
    'code_color'        => '#666666',
    'border_color'      => '#E0E0E0',
    'text_size'         => '14',
    'button_size'       => '14',
    'code_size'         => '14',
), $le_coupon_copy_options);
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <p>
        <?php esc_html_e('在这里，我们根据需要自定义优惠码样式。', 'lecouponcopy'); ?>
        <a href="<?php echo esc_url('https://www.lezaiyun.com/lecouponcopy.html'); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('插件详情发布介绍', 'lecouponcopy'); ?></a>
        （<?php esc_html_e('关注公众号：lezaiyun', 'lecouponcopy'); ?>）
    </p>
    <form method="post" action="options.php">
        <?php
        settings_fields('le_coupon_copy_options');
        do_settings_sections('le_coupon_copy_options');
        ?>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('边框颜色', 'lecouponcopy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[border_color]" value="<?php echo esc_attr($le_coupon_copy_options['border_color']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('文本颜色', 'lecouponcopy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[text_color]" value="<?php echo esc_attr($le_coupon_copy_options['text_color']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('复制按钮文字颜色', 'lecouponcopy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[button_text_color]" value="<?php echo esc_attr($le_coupon_copy_options['button_text_color']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('复制按钮背景颜色', 'lecouponcopy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[button_bg_color]" value="<?php echo esc_attr($le_coupon_copy_options['button_bg_color']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('优惠码颜色', 'lecouponcopy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[code_color]" value="<?php echo esc_attr($le_coupon_copy_options['code_color']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('文本大小 (px)', 'lecouponcopy'); ?></th>
                <td>
                    <input type="number" name="le_coupon_copy_options[text_size]" value="<?php echo esc_attr($le_coupon_copy_options['text_size']); ?>" min="10" max="30">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('按钮大小 (px)', 'lecouponcopy'); ?></th>
                <td>
                    <input type="number" name="le_coupon_copy_options[button_size]" value="<?php echo esc_attr($le_coupon_copy_options['button_size']); ?>" min="10" max="30">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('优惠码大小 (px)', 'lecouponcopy'); ?></th>
                <td>
                    <input type="number" name="le_coupon_copy_options[code_size]" value="<?php echo esc_attr($le_coupon_copy_options['code_size']); ?>" min="10" max="30">
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>

    <div class="le-coupon-copy-settings-footer" style="margin-top:32px;padding-top:24px;border-top:1px solid #c3c4c7;text-align:center;max-width:480px;">
        <?php
        $le_coupon_plugin_root = dirname(__DIR__);
        $le_coupon_wechat_rel   = 'assets/images/wechat.png';
        $le_coupon_wechat_path  = $le_coupon_plugin_root . '/' . $le_coupon_wechat_rel;
        if (is_readable($le_coupon_wechat_path)) :
            $le_coupon_wechat_url = plugins_url($le_coupon_wechat_rel, $le_coupon_plugin_root . '/le-coupon-copy.php');
            ?>
            <p style="margin:0 0 12px;">
                <img src="<?php echo esc_url($le_coupon_wechat_url); ?>" width="150" height="150" alt="<?php esc_attr_e('扫码关注公众号', 'lecouponcopy'); ?>" style="display:inline-block;border:1px solid #dcdcde;border-radius:4px;padding:4px;background:#fff;" />
            </p>
        <?php endif; ?>
        <p style="margin:0 0 16px;font-size:14px;color:#1d2327;">
            <?php esc_html_e('📢 关注乐在云，获取插件教程、更新通知。', 'lecouponcopy'); ?>
        </p>
        <p class="description" style="margin:0;font-size:13px;"> 2026 &copy;
            <a href="<?php echo esc_url('https://www.lezaiyun.com/'); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('乐在云工作室', 'lecouponcopy'); ?></a>
            <span aria-hidden="true"> · </span>
            <?php esc_html_e('By', 'lecouponcopy'); ?>
            <a href="<?php echo esc_url('https://www.laojiang.me/'); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('老蒋', 'lecouponcopy'); ?></a>
        </p>
    </div>
</div>