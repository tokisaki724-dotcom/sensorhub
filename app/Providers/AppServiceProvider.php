<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Illuminate\Mail\MailManager;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->resolving(MailManager::class, function (MailManager $manager) {
            $manager->extend('brevo', function () {
                $factory = new BrevoTransportFactory();
                return $factory->create(
                    new \Symfony\Component\Mailer\Transport\Dsn(
                        'brevo+api',
                        'default',
                        config('services.brevo.key')
                    )
                );
            });
        });
    }
}