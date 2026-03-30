<!-- Toast Notification Component -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="globalToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="toast-header">
            <img src="<?php echo e(asset('images/icon-message.png')); ?>" class="rounded me-2" width="20" height="20" alt="Notification">
            <strong class="me-auto" id="toastTitle">Notification</strong>
            <small class="text-muted" id="toastTime">just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMessage">
            This is a notification message
        </div>
    </div>
</div>

<!-- Audio for notification (optional) -->
<audio id="globalNotificationSound" preload="auto" style="display:none;">
    <source src="<?php echo e(asset('sounds/notification.mp3')); ?>" type="audio/mpeg">
</audio>

<!-- Global Toast JavaScript Functions -->
<script>
    // Global toast functions that can be called from anywhere
    window.showToast = function(message, title = 'Notification', type = 'info', duration = 5000) {
        const toastEl = document.getElementById('globalToast');
        if (!toastEl) return;
        
        // Set title and message
        document.getElementById('toastTitle').textContent = title;
        document.getElementById('toastMessage').textContent = message;
        
        // Set time
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
        document.getElementById('toastTime').textContent = timeString;
        
        // Change toast color based on type
        toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'text-white');
        
        switch(type) {
            case 'success':
                toastEl.classList.add('bg-success', 'text-white');
                break;
            case 'error':
                toastEl.classList.add('bg-danger', 'text-white');
                break;
            case 'warning':
                toastEl.classList.add('bg-warning');
                break;
            case 'info':
                toastEl.classList.add('bg-info');
                break;
            default:
                // Default styling
                break;
        }
        
        // Show toast
        const toast = new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: duration
        });
        toast.show();
    };
    
    // Play notification sound
    window.playNotificationSound = function() {
        const sound = document.getElementById('globalNotificationSound');
        if (sound) {
            sound.play().catch(e => console.log('Sound play failed:', e));
        }
    };
    
    // Show success toast
    window.showSuccess = function(message, title = 'Success') {
        showToast(message, title, 'success');
        playNotificationSound();
    };
    
    // Show error toast
    window.showError = function(message, title = 'Error') {
        showToast(message, title, 'error');
        playNotificationSound();
    };
    
    // Show warning toast
    window.showWarning = function(message, title = 'Warning') {
        showToast(message, title, 'warning');
        playNotificationSound();
    };
    
    // Show info toast
    window.showInfo = function(message, title = 'Info') {
        showToast(message, title, 'info');
        playNotificationSound();
    };
</script>

<?php if(auth()->guard()->check()): ?>
<script>
    (function () {
        if (window.globalBrowserNotifierInitialized) return;
        window.globalBrowserNotifierInitialized = true;

        const CONFIG = {
            userId: <?php echo e(auth()->id()); ?>,
            role: <?php echo json_encode(auth()->user()->role ?? '', 15, 512) ?>,
            icon: <?php echo json_encode(asset('images/favicon.png'), 15, 512) ?>,
            messagePollMs: 5000,
            callPollMs: 3000,
            maxBodyLength: 120
        };

        const STORAGE_KEYS = {
            messageLastId: `notif_message_last_id_${CONFIG.userId}`,
            callLastId: `notif_call_last_id_${CONFIG.userId}`,
            shownMessageIds: `notif_shown_message_ids_${CONFIG.userId}`,
            shownCallIds: `notif_shown_call_ids_${CONFIG.userId}`
        };

        let isTabActive = true;

        document.addEventListener('visibilitychange', function () {
            isTabActive = document.visibilityState === 'visible';
        });

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }

        function requestBrowserPermission() {
            if (!('Notification' in window)) return;
            if (Notification.permission === 'default') {
                Notification.requestPermission().catch(() => {});
            }
        }

        function openUrl(url) {
            if (!url) return;
            window.location.href = url;
        }

        function showBrowserNotification(title, body, url) {
            if (!('Notification' in window)) return;
            if (Notification.permission !== 'granted') return;

            const notification = new Notification(title, {
                body: (body || '').slice(0, CONFIG.maxBodyLength),
                icon: CONFIG.icon,
                tag: 'med-sean-global-alert'
            });

            notification.onclick = function () {
                window.focus();
                notification.close();
                openUrl(url);
            };
        }

        async function fetchJson(url) {
            const res = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            if (!res.ok) return null;
            return res.json();
        }

        async function postJson(url, payload = {}) {
            await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
        }

        function updateUnreadBadges(totalUnread) {
            const badges = document.querySelectorAll('[data-chat-unread-badge]');
            const safeCount = Number(totalUnread || 0);
            const badgeText = safeCount > 99 ? '99+' : String(safeCount);

            badges.forEach((badge) => {
                badge.textContent = badgeText;
                if (safeCount > 0) {
                    badge.classList.remove('d-none');
                } else {
                    badge.classList.add('d-none');
                }
            });
        }

        async function pollUnreadCounts() {
            const data = await fetchJson(`<?php echo e(route('chat.unread.counts')); ?>`);
            if (!data || !data.success) return;
            updateUnreadBadges(data.total_unread || 0);
        }

        function readIdSet(storageKey) {
            try {
                const raw = localStorage.getItem(storageKey);
                const list = raw ? JSON.parse(raw) : [];
                return new Set(Array.isArray(list) ? list.map(Number) : []);
            } catch {
                return new Set();
            }
        }

        function writeIdSet(storageKey, idSet) {
            const compact = Array.from(idSet).slice(-300); // keep bounded history
            localStorage.setItem(storageKey, JSON.stringify(compact));
        }

        async function pollMessageNotifications() {
            const lastId = Number(localStorage.getItem(STORAGE_KEYS.messageLastId) || '0');
            const shownMessageIds = readIdSet(STORAGE_KEYS.shownMessageIds);
            const data = await fetchJson(`<?php echo e(route('notifications.messages')); ?>?last_id=${lastId}`);
            if (!data || !data.success || !Array.isArray(data.messages)) return;

            let maxId = lastId;
            data.messages.forEach(msg => {
                const currentId = Number(msg.id || 0);
                maxId = Math.max(maxId, currentId);
                if (shownMessageIds.has(currentId)) return;

                const title = `New message from ${msg.sender_name || 'User'}`;
                const body = msg.message || 'You have a new message';

                if (typeof window.showInfo === 'function') {
                    window.showInfo(body, title);
                }
                if (!isTabActive) {
                    showBrowserNotification(title, body, msg.url);
                }
                shownMessageIds.add(currentId);
            });

            if (maxId > lastId) {
                localStorage.setItem(STORAGE_KEYS.messageLastId, String(maxId));
            }
            writeIdSet(STORAGE_KEYS.shownMessageIds, shownMessageIds);
        }

        async function pollCallNotifications() {
            const lastId = Number(localStorage.getItem(STORAGE_KEYS.callLastId) || '0');
            const shownCallIds = readIdSet(STORAGE_KEYS.shownCallIds);
            const data = await fetchJson(`<?php echo e(route('call.invites.new')); ?>?last_id=${lastId}`);
            if (!data || !data.success || !Array.isArray(data.invites)) return;

            let maxId = lastId;
            for (const invite of data.invites) {
                const inviteId = Number(invite.id || 0);
                maxId = Math.max(maxId, inviteId);
                if (shownCallIds.has(inviteId)) continue;

                const mode = invite.type === 'video' ? 'video call' : 'voice call';
                const title = `Incoming ${mode}`;
                const body = `${invite.sender_name || 'Caller'} is inviting you to join booking #APT000${invite.booking_id}`;

                if (typeof window.showWarning === 'function') {
                    window.showWarning(body, title);
                }
                showBrowserNotification(title, body, invite.url);

                await postJson(`<?php echo e(url('/call/invites')); ?>/${invite.id}/seen`);
                shownCallIds.add(inviteId);
            }

            if (maxId > lastId) {
                localStorage.setItem(STORAGE_KEYS.callLastId, String(maxId));
            }
            writeIdSet(STORAGE_KEYS.shownCallIds, shownCallIds);
        }

        requestBrowserPermission();
        pollUnreadCounts();
        setInterval(pollUnreadCounts, 5000);
        setInterval(pollMessageNotifications, CONFIG.messagePollMs);
        setInterval(pollCallNotifications, CONFIG.callPollMs);

        // Kick once quickly after load.
        setTimeout(pollMessageNotifications, 1200);
        setTimeout(pollCallNotifications, 1400);
    })();
</script>
<?php endif; ?>

<style>
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}

.toast {
    min-width: 300px;
    max-width: 400px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    animation: slideInRight 0.3s ease;
}

.toast.bg-success .toast-header,
.toast.bg-danger .toast-header,
.toast.bg-warning .toast-header,
.toast.bg-info .toast-header {
    background: rgba(255,255,255,0.2);
    color: white;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.toast.bg-success .btn-close,
.toast.bg-danger .btn-close,
.toast.bg-warning .btn-close,
.toast.bg-info .btn-close {
    filter: brightness(0) invert(1);
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/layouts/toast.blade.php ENDPATH**/ ?>