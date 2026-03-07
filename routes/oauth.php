<?php

use App\Http\Controllers\OAuthGoogleController;

Route::get('/oauth/google/redirect', [OAuthGoogleController::class, 'redirect']);

Route::get('/oauth/google/callback', [OAuthGoogleController::class, 'callback']);
