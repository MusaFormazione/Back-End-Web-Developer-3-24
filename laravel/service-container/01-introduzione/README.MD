# 01 — Introduzione al Service Container e alla Dependency Injection (Laravel 12)

In questo modulo scopriamo cos'è il Service Container di Laravel, perché esiste e come abilita la Dependency Injection (DI) e l'Inversion of Control (IoC) nell'applicazione.

Obiettivi di apprendimento:
- Capire cosa è il Service Container e a cosa serve.
- Comprendere il legame tra IoC e DI in Laravel 12.
- Vedere esempi concreti (leggeri) usando il contesto del database Sakila.
- Eseguire piccoli esercizi per consolidare i concetti.

## Cos'è il Service Container?
Il Service Container è un registro centralizzato e intelligente che gestisce le dipendenze della tua applicazione. In termini pratici:
- È in grado di "risolvere" (instanziare) classi e oggetti su richiesta, analizzando i type-hint del costruttore o dei metodi e creando ciò che serve.
- Può fornire implementazioni per interfacce (binding interfaccia → classe concreta).
- Gestisce lifecycle e condivisione di istanze (ad es. singleton).
- Consente di decouplare componenti, favorendo testabilità e manutenibilità.

In Laravel, ogni volta che il framework deve creare un controller, un listener, un job, una regola di validazione, ecc., il Service Container legge i type-hint e risolve automaticamente le dipendenze.

## Perché serve? (IoC e DI)
- Inversion of Control (IoC): sposti la responsabilità di creare oggetti fuori dal codice applicativo, delegandola al container.
- Dependency Injection (DI): le dipendenze vengono passate dall'esterno (dal container), invece di essere costruite internamente alle classi.

Benefici:
- Basso accoppiamento: sostituire implementazioni è semplice (es. usare uno stub/fake per i test).
- Single Responsibility: le classi non creano ciò di cui hanno bisogno; si occupano solo della propria logica.
- Test più facili: puoi fare mocking delle dipendenze.

## Esempio base con Sakila: Repository e Controller
Immagina di voler leggere attori dal database Sakila. Definiamo un'interfaccia e una implementazione semplice.

1) Definisci un'interfaccia per il repository degli attori:
```php
// app/Contracts/ActorRepository.php
namespace App\Contracts;

interface ActorRepository
{
    /** @return array<int, array{name:string, surname:string}> */
    public function all(): array;
}
```

2) Implementazione concreta (esempio semplificato):
```php
// app/Repositories/DbActorRepository.php
namespace App\Repositories;

use App\Contracts\ActorRepository;
use Illuminate\Support\Facades\DB;

class DbActorRepository implements ActorRepository
{
    public function all(): array
    {
        // Esempio minimale: ipotizziamo tabella sakila.actor con colonne first_name, last_name
        return DB::connection('sakila')
            ->table('actor')
            ->limit(10)
            ->get()
            ->map(fn($row) => [
                'name' => $row->first_name,
                'surname' => $row->last_name,
            ])
            ->all();
    }
}
```

3) Binding nel Service Container (es. in AppServiceProvider):
```php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ActorRepository;
use App\Repositories\DbActorRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Quando qualcuno richiede ActorRepository, fornisci DbActorRepository
        $this->app->bind(ActorRepository::class, DbActorRepository::class);

        // In alternativa, per un'istanza condivisa (singleton):
        // $this->app->singleton(ActorRepository::class, DbActorRepository::class);
    }

    public function boot(): void
    {
        // ...
    }
}
```

4) Usare la DI in un Controller:
```php
// app/Http/Controllers/ActorController.php
namespace App\Http\Controllers;

use App\Contracts\ActorRepository;

class ActorController extends Controller
{
    public function index(ActorRepository $actors)
    {
        // Il container risolve automaticamente l'implementazione bound
        return response()->json($actors->all());
    }
}
```

5) Route:
```php
// routes/web.php
use App\Http\Controllers\ActorController;
use Illuminate\Support\Facades\Route;

Route::get('/actors', [ActorController::class, 'index']);
```

Cosa è successo? Grazie al binding, quando il framework crea ActorController, vede che il metodo `index` richiede un `ActorRepository`. Il container fornisce l'implementazione registrata (`DbActorRepository`).

## Come funziona la risoluzione
- Type-hint di classi concrete: il container costruisce la classe, risolvendo a sua volta le dipendenze del costruttore.
- Type-hint di interfacce: serve un binding esplicito (`bind`, `singleton`, `scoped`).
- Closure binding: puoi fornire una factory function per costruire l'istanza con logica personalizzata.

Esempio closure binding:
```php
$this->app->bind(ActorRepository::class, function($app) {
    // puoi accedere ad altre dipendenze tramite $app
    return new \App\Repositories\DbActorRepository();
});
```

## Best practice essenziali
- Registrare i binding in Service Provider (metodo `register`).
- Dipendere da astrazioni (interfacce), non da implementazioni.
- Usare `singleton` per servizi stateless o costosi da creare.
- Evitare di “neware” classi all'interno dei controller: sfrutta il container.
- Per test: override dei binding con `App::bind` o usando `mock()` nei test.

## Esercizi
1) Crea un'interfaccia `FilmRepository` e una implementazione `DbFilmRepository` che legge i primi 10 film (titolo, anno) da `sakila.film`. Registra il binding e crea un endpoint `/films` che restituisce JSON.
2) Trasforma il binding di `ActorRepository` in `singleton`. Aggiungi un log nel costruttore per verificare che venga istanziato una sola volta durante la richiesta.
3) Crea un binding basato su configurazione: se `config('sakila.repo') === 'db'` usa `DbActorRepository`, altrimenti una `InMemoryActorRepository` con dati finti. Prova a cambiare la config e verifica il risultato.

Suggerimenti:
- Ricorda di configurare la connessione `sakila` in `config/database.php` o usare quella di default se già punta a Sakila.
- Provare ad utilizzare il servizio con un semplice test per provare la risoluzione: `app(\App\Contracts\ActorRepository::class)->all();`.
