<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="newMessageToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
            <div class="toast-header">
                <img src="{{ asset('images/icon-message.png') }}" class="rounded me-2" width="20" height="20" alt="Message">
                <strong class="me-auto" id="toastSender">New Message</strong>
                <small>just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessageContent">
                You have a new message
            </div>
        </div>
    </div>