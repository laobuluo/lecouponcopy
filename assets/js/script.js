(function($) {
    'use strict';

    $(document).ready(function() {
        // 初始化clipboard.js
        var clipboard = new ClipboardJS('.le-coupon-copy-btn');

        // 复制成功处理
        clipboard.on('success', function(e) {
            var $button = $(e.trigger);
            var url = $button.data('url');

            // 添加复制成功的视觉反馈
            $button.addClass('copied');
            
            // 动态创建并显示成功消息（避免在HTML中插入div导致换行）
            var $message = $('<div class="le-coupon-copy-message">' + leCouponCopy.success_message + '</div>');
            $('body').append($message);
            $message.fadeIn(200);
            setTimeout(function() {
                $message.fadeOut(200, function() {
                    $message.remove();
                });
            }, 2000);

            // 如果设置了URL，则在新窗口中打开
            if (url && url.length > 0) {
                setTimeout(function() {
                    window.open(url, '_blank');
                }, 300);
            }

            // 2秒后恢复按钮状态
            setTimeout(function() {
                $button.removeClass('copied');
            }, 2000);

            e.clearSelection();
        });

        // 复制失败处理
        clipboard.on('error', function(e) {
            console.error('复制失败:', e.action);
            alert('复制失败，请手动复制优惠码。');
        });
    });
})(jQuery);