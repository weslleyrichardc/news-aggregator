<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command(
    'news:fetch-articles',
    fn() => Log::log('debug', 'Fetching Articles from API')
)->daily();
