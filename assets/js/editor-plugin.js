(function() {
    tinymce.create('tinymce.plugins.LeCouponCopy', {
        init: function(ed, url) {
            ed.addButton('le_coupon_copy', {
                title: '插入优惠码',
                icon: 'coupon',
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
                            var shortcode = '[lecoupon';
                            if (e.data.code) {
                                shortcode += ' code="' + e.data.code + '"';
                            }
                            if (e.data.text) {
                                shortcode += ' text="' + e.data.text + '"';
                            }
                            if (e.data.url) {
                                shortcode += ' url="' + e.data.url + '"';
                            }
                            shortcode += ']';
                            ed.insertContent(shortcode);
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('le_coupon_copy', tinymce.plugins.LeCouponCopy);
})(); 