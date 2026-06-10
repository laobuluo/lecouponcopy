(function() {
    'use strict';

    if (typeof QTags === 'undefined' || typeof leCouponCopyAdmin === 'undefined') {
        return;
    }

    function leCouponShortcodeEscape(v) {
        return String(v).replace(/\\/g, '\\\\').replace(/"/g, '\\"');
    }

    QTags.addButton('le_coupon_copy', '插入优惠码', function() {
        var code = prompt('请输入优惠码：', '');
        if (code === null || code === '') {
            return;
        }
        var text = prompt('请输入显示文本（可选，留空则使用优惠码）：', '');
        var url = prompt('请输入跳转链接（可选）：', '');
        var tag = leCouponCopyAdmin.shortcodeTag;
        var shortcode = '[' + tag + ' code="' + leCouponShortcodeEscape(code) + '"';
        if (text && text !== '') {
            shortcode += ' text="' + leCouponShortcodeEscape(text) + '"';
        }
        if (url && url !== '') {
            shortcode += ' url="' + leCouponShortcodeEscape(url) + '"';
        }
        shortcode += ']';
        QTags.insertContent(shortcode);
    });
})();
