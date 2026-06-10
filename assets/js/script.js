(function() {
    'use strict';

    function fadeIn(el) {
        el.style.opacity = '0';
        el.style.display = 'block';
        requestAnimationFrame(function() {
            el.style.transition = 'opacity 0.2s ease';
            el.style.opacity = '1';
        });
    }

    function fadeOutRemove(el) {
        el.style.transition = 'opacity 0.2s ease';
        el.style.opacity = '0';
        setTimeout(function() {
            if (el.parentNode) {
                el.parentNode.removeChild(el);
            }
        }, 200);
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof ClipboardJS === 'undefined' || typeof leCouponCopy === 'undefined') {
            return;
        }

        var clipboard = new ClipboardJS('.le-coupon-copy-btn');

        clipboard.on('success', function(e) {
            var button = e.trigger;
            var url = button.getAttribute('data-url') || '';

            button.classList.add('copied');

            var message = document.createElement('div');
            message.className = 'le-coupon-copy-message';
            message.textContent = leCouponCopy.success_message;
            document.body.appendChild(message);
            fadeIn(message);
            setTimeout(function() {
                fadeOutRemove(message);
            }, 2000);

            if (url.length > 0 && /^https?:\/\//i.test(url)) {
                setTimeout(function() {
                    window.open(url, '_blank', 'noopener,noreferrer');
                }, 300);
            }

            setTimeout(function() {
                button.classList.remove('copied');
            }, 2000);

            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            if (typeof console !== 'undefined' && console.error) {
                console.error('复制失败:', e.action);
            }
            alert(leCouponCopy.error_message);
        });
    });
})();
