<?php

namespace Sharzhukov\LabUi;

use Illuminate\Support\ServiceProvider;

class LabUiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lab');
    }
}
