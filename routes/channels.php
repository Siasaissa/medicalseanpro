<?php

Broadcast::channel('call.{bookingId}', function ($user, $bookingId) {
    // Check if user belongs to this booking (doctor or patient)
    return true; 
});
