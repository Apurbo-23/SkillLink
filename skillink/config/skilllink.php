<?php

return [

    // Flat credit cost to send a swap request. Held from the requester
    // when the request is sent, refunded if it's rejected/cancelled,
    // and paid out to the provider once the swap is completed.
    'swap_request_cost' => env('SKILLLINK_SWAP_COST', 5),

    // Credits a brand new user starts with.
    'starting_credits' => env('SKILLLINK_STARTING_CREDITS', 20),

];
