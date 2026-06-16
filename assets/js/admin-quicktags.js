(function() {
    'use strict';

    if (typeof QTags === 'undefined' || typeof leCouponCopyAdmin === 'undefined') {
        return;
    }

    function leCouponShortcodeEscape(v) {
        return String(v).replace(/\\/g, '\\\\').replace(/"/g, '\\"');
    }

    QTags.addButton('le_coupon_copy', leCouponCopyAdmin.buttonText, function() {
        var code = prompt(leCouponCopyAdmin.promptCode, '');
        if (code === null || code === '') {
            return;
        }
        var text = prompt(leCouponCopyAdmin.promptText, '');
        var url = prompt(leCouponCopyAdmin.promptUrl, '');
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
