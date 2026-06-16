(function() {
    function leCouponGetMceI18n() {
        var defaults = {
            buttonTitle: 'Insert Coupon',
            buttonText: 'Coupon',
            modalTitle: 'Insert Coupon',
            labelCode: 'Coupon Code',
            labelText: 'Display Text (Optional)',
            labelUrl: 'Redirect URL (Optional)'
        };
        var scripts = document.getElementsByTagName('script');
        var i;
        for (i = 0; i < scripts.length; i++) {
            var src = scripts[i].getAttribute('src') || '';
            if (src.indexOf('editor-plugin.js') === -1 || src.indexOf('i18n=') === -1) {
                continue;
            }
            try {
                var query = src.split('?')[1] || '';
                var params = new URLSearchParams(query);
                var raw = params.get('i18n');
                if (!raw) {
                    return defaults;
                }
                var parsed = JSON.parse(decodeURIComponent(raw));
                return {
                    buttonTitle: parsed.buttonTitle || defaults.buttonTitle,
                    buttonText: parsed.buttonText || defaults.buttonText,
                    modalTitle: parsed.modalTitle || defaults.modalTitle,
                    labelCode: parsed.labelCode || defaults.labelCode,
                    labelText: parsed.labelText || defaults.labelText,
                    labelUrl: parsed.labelUrl || defaults.labelUrl
                };
            } catch (e) {
                return defaults;
            }
        }
        return defaults;
    }

    var leCouponMceI18n = leCouponGetMceI18n();

    function leCouponShortcodeEscape(v) {
        return String(v).replace(/\\/g, '\\\\').replace(/"/g, '\\"');
    }

    tinymce.create('tinymce.plugins.LeCouponCopy', {
        init: function(ed) {
            ed.addButton('le_coupon_copy', {
                title: leCouponMceI18n.buttonTitle,
                /* 工具栏直接显示「券」，避免 TinyMCE 加载外链 SVG/图片失败；经典区块 iframe 内同样可见 */
                text: leCouponMceI18n.buttonText,
                classes: 'le-coupon-copy-mce-btn',
                onclick: function() {
                    ed.windowManager.open({
                        title: leCouponMceI18n.modalTitle,
                        body: [
                            {
                                type: 'textbox',
                                name: 'code',
                                label: leCouponMceI18n.labelCode
                            },
                            {
                                type: 'textbox',
                                name: 'text',
                                label: leCouponMceI18n.labelText
                            },
                            {
                                type: 'textbox',
                                name: 'url',
                                label: leCouponMceI18n.labelUrl
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
