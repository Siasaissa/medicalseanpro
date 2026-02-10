import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import { ZegoUIKitPrebuilt } from '@zegocloud/zego-uikit-prebuilt';

async function initCall(bookingId) {
  const res = await fetch(`/api/zego-token?booking_id=${bookingId}`);
  const data = await res.json();

  const kitToken = data.kitToken;

  const zp = ZegoUIKitPrebuilt.create(kitToken);
  zp.joinRoom({
    container: document.getElementById('root'),
    scenario: { mode: ZegoUIKitPrebuilt.OneONoneCall },
  });
}

window.initCall = initCall; // expose globally if needed
