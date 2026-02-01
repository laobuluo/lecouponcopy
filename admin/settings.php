<?php
if (!defined('ABSPATH')) {
    exit;
}

$options = get_option('le_coupon_copy_options');
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <p>在这里，我们根据需要自定义优惠码样式。<a href="https://www.lezaiyun.com/866.html" target="_blank">插件介绍</a>（关注公众号：<span style="color: red;">老蒋朋友圈</span>）</p>
    <form method="post" action="options.php">
        <?php
        settings_fields('le_coupon_copy_options');
        do_settings_sections('le_coupon_copy_options');
        ?>
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e('边框颜色', 'le-coupon-copy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[border_color]" value="<?php echo esc_attr($options['border_color']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('文本颜色', 'le-coupon-copy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[text_color]" value="<?php echo esc_attr($options['text_color']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('按钮颜色', 'le-coupon-copy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[button_color]" value="<?php echo esc_attr($options['button_color']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('优惠码颜色', 'le-coupon-copy'); ?></th>
                <td>
                    <input type="color" name="le_coupon_copy_options[code_color]" value="<?php echo esc_attr($options['code_color']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('文本大小 (px)', 'le-coupon-copy'); ?></th>
                <td>
                    <input type="number" name="le_coupon_copy_options[text_size]" value="<?php echo esc_attr($options['text_size']); ?>" min="10" max="30">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('按钮大小 (px)', 'le-coupon-copy'); ?></th>
                <td>
                    <input type="number" name="le_coupon_copy_options[button_size]" value="<?php echo esc_attr($options['button_size']); ?>" min="10" max="30">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('优惠码大小 (px)', 'le-coupon-copy'); ?></th>
                <td>
                    <input type="number" name="le_coupon_copy_options[code_size]" value="<?php echo esc_attr($options['code_size']); ?>" min="10" max="30">
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
    <p><img width="150" height="150" src="<?php echo plugins_url('../assets/images/wechat.png', __FILE__); ?>" alt="扫码关注公众号" /></p>
</div>