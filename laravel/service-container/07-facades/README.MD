# 07 — Facade in Laravel: cosa sono e come crearne una custom

Obiettivo: capire il pattern Facade di Laravel 12, come usarlo e come definire una facade personalizzata collegata a un servizio del container.

Cos’è una Facade
- È una classe statica che fornisce un’interfaccia semplice verso un servizio reale risolto dal Service Container.
- Non è veramente “statica”: le chiamate vengono inoltrate a un’istanza concreta (lazy) tramite il container.
- Esempi core: Cache, DB, Log, Http, Storage.

Uso quotidiano
```php
use Illuminate\Support\Facades\Cache;

Cache::put('key', 'value', 60);
$value = Cache::get('key');
```

Creare una Facade personalizzata (Sakila)
Supponiamo un servizio `TitleFormatter` che formatta i titoli dei film.

1) Servizio e binding
```php
// app/Services/TitleFormatter.php
namespace App\Services;

class TitleFormatter
{
    public function format(string $title): string
    {
        return trim(mb_strtoupper($title));
    }
}

// App\Providers\SakilaServiceProvider.php (register)
$this->app->singleton('title.formatter', function () {
    return new \App\Services\TitleFormatter();
});
```

2) Facade class
```php
// app/Facades/Title.php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Title extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        // chiave/alias registrata nel container
        return 'title.formatter';
    }
}
```

3) Alias (se necessario)
- In Laravel 12, l’autoload delle Facade custom funziona tramite namespace; puoi importare App\Facades\Title e usarla.
- In alternativa, aggiungi un alias in config/app.php se desideri un alias globale:
```php
'aliases' => [
    // ...
    'Title' => App\Facades\Title::class,
],
```

4) Utilizzo
```php
use App\Facades\Title;

Title::format('  The Godfather  '); // "THE GODFATHER"
```

Mocking e test delle Facade
- Le Facade supportano il finto/mocking senza cambiare codice.
```php
use App\Facades\Title;

Title::shouldReceive('format')
    ->once()
    ->with('Shrek')
    ->andReturn('SHREK');

$this->get('/films/format/preview');
```

Sotto il cofano
- `getFacadeAccessor()` restituisce la chiave o la classe che il container deve risolvere.
- La prima chiamata risolve e memorizza l’istanza; le successive riusano la stessa (comportamento simile a singleton del servizio risolto).

Best practice
- Registra il servizio nel container (singleton) e mantieni la Facade sottile.
- Evita di abusare delle Facade in dominio complesso: preferisci DI nei servizi e usa Facade in contesti di infrastruttura o per comodità.
- Per librerie/SDK esterni, incapsula l’SDK in un servizio e fornisci una Facade, così puoi fare mocking nei test.

Esercizi
1) Crea TitleFormatter, registra la chiave 'title.formatter' nel SakilaServiceProvider e crea la Facade Title.
2) Usa la Facade in una rotta /titles/format?title=... che restituisce il titolo formattato.
3) Scrivi un test che faccia shouldReceive('format')->andReturn(...) e verifichi la risposta dell’endpoint.
