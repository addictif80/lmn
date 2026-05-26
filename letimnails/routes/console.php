<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(collect([
        'La beauté est dans les détails.',
        'Des ongles sublimes, 100% personnalisables.',
        'Fabriqués main avec amour.',
    ])->random());
})->purpose('Display an inspiring quote');
