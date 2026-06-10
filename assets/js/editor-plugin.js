(function() {
    function leCouponShortcodeEscape(v) {
        return String(v).replace(/\\/g, '\\\\').replace(/"/g, '\\"');
    }

    tinymce.create('tinymce.plugins.LeCouponCopy', {
        init: function(ed) {
            ed.addButton('le_coupon_copy', {
                title: '插入优惠码',
                /* 工具栏直接显示「券」，避免 TinyMCE 加载外链 SVG/图片失败；经典区块 iframe 内同样可见 */
                text: '券',
                classes: 'le-coupon-copy-mce-btn',
                onclick: function() {
                    ed.windowManager.open({
                        title: '插入优惠码',
                        body: [
                            {
                                type: 'textbox',
                                name: 'code',
                                label: '优惠码'
                            },
                            {
                                type: 'textbox',
                                name: 'text',
                                label: '显示文本（可选）'
                            },
                            {
                                type: 'textbox',
                                name: 'url',
                                label: '跳转链接（可选）'
                            }
                        ],
                        onsubmit: function(e) {
                            var shortcode = '[le_coupon_copy';
                            if (e.data.code) {
                                shortcode += ' code="' + leCouponShortcodeEscape(e.data.code) + '"';
                            }
                            if (e.data.text) {
                                shortcode += ' text="' + leCouponShortcodeEscape(e.data.text) + '"';
                            }
                            if (e.data.url) {
                                shortcode += ' url="' + leCouponShortcodeEscape(e.data.url) + '"';
                            }
                            shortcode += ']';
                            ed.insertContent(shortcode);
                        }
                    });
                }
            });
        },
        createControl: function() {
            return null;
        }
    });
    tinymce.PluginManager.add('le_coupon_copy', tinymce.plugins.LeCouponCopy);
})();
