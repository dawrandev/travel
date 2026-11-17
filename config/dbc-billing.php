<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DBC CRM API endpoint
    |--------------------------------------------------------------------------
    |
    | Base URL of the DBC CRM. The client appends "/api/billing/..." to it.
    |
    */
    'url' => env('DBC_BILLING_URL'),

    /*
    |--------------------------------------------------------------------------
    | Subscription API token
    |--------------------------------------------------------------------------
    |
    | Plaintext token issued by the CRM when a Subscription is created.
    | Use the "Regenerate token" action in the CRM to rotate it.
    |
    */
    'token' => env('DBC_BILLING_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Status cache TTL (seconds)
    |--------------------------------------------------------------------------
    |
    | How long the app caches the CRM status before asking again. One hour keeps
    | the app fast and the CRM lightly loaded; a paid renewal is reflected within
    | this window (or instantly on the Click return route, which forgets it).
    |
    */
    'cache_ttl' => env('DBC_BILLING_CACHE_TTL', 3600),

    /*
    |--------------------------------------------------------------------------
    | Auth guard
    |--------------------------------------------------------------------------
    |
    | When the CRM marks a subscription as "auth_only", the widget is rendered
    | only for users authenticated against this guard.
    |
    */
    'guard' => env('DBC_BILLING_GUARD', 'web'),

    /*
    |--------------------------------------------------------------------------
    | Auto-inject the widget
    |--------------------------------------------------------------------------
    |
    | When true (default), the widget is appended to every HTML response
    | automatically — no need to add @dbcBilling to your layout. Set to false
    | if you prefer to place @dbcBilling manually.
    |
    */
    'auto_inject' => env('DBC_BILLING_AUTO_INJECT', true),

    /*
    |--------------------------------------------------------------------------
    | Widget language
    |--------------------------------------------------------------------------
    |
    | Default language for the widget texts: "ru" (default), "uz", "kaa"
    | (Karakalpak) or "en". Any other value falls back to Russian. Visitors can
    | switch the language inside the widget; their choice is remembered.
    |
    */
    'locale' => env('DBC_BILLING_LOCALE', 'ru'),

    /*
    |--------------------------------------------------------------------------
    | HTTP timeout (seconds)
    |--------------------------------------------------------------------------
    */
    'timeout' => env('DBC_BILLING_TIMEOUT', 5),

    /*
    |--------------------------------------------------------------------------
    | HTTP connect timeout (seconds)
    |--------------------------------------------------------------------------
    |
    | How long to wait just for the TCP connection to the CRM. Kept short so a
    | dead host fails fast instead of hanging until the full request timeout.
    |
    */
    'connect_timeout' => env('DBC_BILLING_CONNECT_TIMEOUT', 2),

    /*
    |--------------------------------------------------------------------------
    | Failure cache TTL (seconds)
    |--------------------------------------------------------------------------
    |
    | When the CRM is unreachable, the failure is cached for this long so we do
    | not retry on every request and block the app. The last known good status
    | is still served meanwhile (fail-open).
    |
    */
    'failure_ttl' => env('DBC_BILLING_FAILURE_TTL', 30),

    /*
    |--------------------------------------------------------------------------
    | Hard-block view
    |--------------------------------------------------------------------------
    |
    | Blade view rendered by the EnforceBilling middleware when the
    | subscription state is `blocked`. Use the bundled view or your own.
    |
    */
    'block_view' => env('DBC_BILLING_BLOCK_VIEW', 'dbc-billing::blocked'),

];
