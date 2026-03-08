<?php

use App\Http\Controllers\OAuthGoogleController;

Route::get('/oauth/{provider}/redirect', [OAuthGoogleController::class, 'redirect']);

Route::get('/oauth/{provider}/callback', [OAuthGoogleController::class, 'callback']);
