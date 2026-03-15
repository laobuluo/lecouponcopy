<?php
if (!defined('ABSPATH')) {
    exit;
}

$le_coupon_copy_options = get_option('le_coupon_copy_options');
if (!is_array($le_coupon_copy_options)) {
    $le_coupon_copy_options = array();
}
$le_coupon_copy_options = array_merge(array(
    'text_color'   => '#333333',
    'button_color' => '#4CAF50',
    'code_color'   => '#666666',
    'border_color' => '#E0E0E0',
    'text_size'    => '14',
    'button_size'  => '14',
    'code_size'    => '14',
), $le_coupon_copy_options);
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <p>
        <?php esc_html_e('在这里，我们根据需要自定义优惠码样式。', 'lecouponcopy'); ?>
        <a href="<?php echo esc_url(' https://www.laojiang.me/6247.html'); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('插件介绍', 'lecouponcopy'); ?></a>
        （<?php esc_html_e('关注公众号：老蒋朋友圈', 'lecouponcopy'); ?>）
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
                <th scope="row"><?php esc_html_e('按钮颜色', 'lecouponcopy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[button_color]" value="<?php echo esc_attr($le_coupon_copy_options['button_color']); ?>">
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
    <p><img width="150" height="150" src="<?php echo esc_url(plugins_url('../assets/images/wechat.png', __FILE__)); ?>" alt="<?php esc_attr_e('扫码关注公众号', 'lecouponcopy'); ?>" /></p>
</div>