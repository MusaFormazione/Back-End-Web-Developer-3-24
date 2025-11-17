# 06 — Service Provider: creare, registrare binding/singleton, metodo boot

Obiettivo: comprendere il ruolo dei Service Provider in Laravel 12, come crearne uno personalizzato e dove collocare i binding e la logica di bootstrap.

Che cos’è un Service Provider
- È la "fabbrica" di avvio dell’app: registra servizi nel container e inizializza funzionalità.
- Due metodi principali:
  - register(): qui definisci binding, singleton, scoped, merge delle config. NON usare Request o oggetti che richiedono la richiesta HTTP.
  - boot(): qui puoi usare servizi già registrati; logica che necessita dell’app pronta (eventi, Route::pattern, View::composer, ecc.).

Creare un provider personalizzato
```bash
php artisan make:provider SakilaServiceProvider
```

Esempio (Sakila): spostiamo i binding in un provider dedicato
```php
// app/Providers/SakilaServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ActorStatsContract;
use App\Services\ActorStats;

class SakilaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Binding e singletons qui
        $this->app->singleton(ActorStatsContract::class, ActorStats::class);

        // Esempio: merge di config personalizzata
        $this->mergeConfigFrom(config_path('sakila.php'), 'sakila');
    }

    public function boot(): void
    {
        // Logica di bootstrap che può usare i servizi già registrati
        // Esempio: pattern globali per route di Sakila
        \Illuminate\Support\Facades\Route::pattern('actor', '[0-9]+');
    }
}
```

Registrare il provider
- Laravel auto-scansiona i provider in alcuni casi, ma la via canonica è aggiungerlo in config/app.php, sezione 'providers':
```php
'providers' => [
    // ...
    App\Providers\SakilaServiceProvider::class,
],
```

Bindings, singletons, scoped
```php
public function register(): void
{
    // Transient
    $this->app->bind(\App\Contracts\TradingFinanceInfoContract::class, \Service\TradingFinance\TradingFinanceInfo::class);

    // Singleton
    $this->app->singleton(\App\Contracts\ActorStatsContract::class, \App\Services\ActorStats::class);

    // Scoped
    $this->app->scoped(\App\Services\RequestContext::class, fn() => new \App\Services\RequestContext());
}
```

Context binding e tag (accenno)
```php
$this->app->when(\App\Http\Controllers\ReportController::class)
    ->needs(\App\Contracts\ActorStatsContract::class)
    ->give(\App\Services\CachedActorStats::class);

$this->app->tag([\App\Services\A::class, \App\Services\B::class], 'reporters');
$all = $this->app->tagged('reporters');
```

Deferrable provider (avanzato)
- Implementa Illuminate\Contracts\Support\DeferrableProvider per caricare on-demand.
```php
class SakilaServiceProvider extends ServiceProvider implements \Illuminate\Contracts\Support\DeferrableProvider
{
    public function provides(): array
    {
        return [\App\Contracts\ActorStatsContract::class];
    }
}
```

Suggerimento organizzativo: Services
- Crea una cartella app/Services per i servizi applicativi (es. ActorStats, FilmFilter, TradingFinanceInfo).
- Tieni i controller snelli; delega la logica di business ai servizi; registra i binding nel tuo provider.

Esercizi
1) Crea SakilaServiceProvider e sposta lì tutti i binding relativi a Sakila, registralo in config/app.php.
2) Nel metodo boot aggiungi un Route::pattern globale per 'film' numerico e verifica con due rotte.
3) Implementa un provider deferrable che fornisca ActorStatsContract e verifica che venga caricato solo quando richiesto.
