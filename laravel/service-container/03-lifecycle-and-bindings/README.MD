# 03 — Ciclo di vita dei binding: bind (transient), singleton, scoped

Obiettivo: capire le differenze tra i tre tipi di binding del Service Container di Laravel 12 e quando usarli.

Concetti chiave
- bind (transient): ogni risoluzione crea una NUOVA istanza.
- singleton: la prima risoluzione viene memorizzata e riutilizzata in tutte le successive (per l’intero processo).
- scoped: una istanza per richiesta HTTP. In contesto console può comportarsi come singleton per l’esecuzione corrente.

Esempi (Sakila)
Supponiamo di avere un servizio che calcola statistiche sugli attori (numero film, media rating, ecc.).

```php
// App\Contracts\ActorStatsContract.php
namespace App\Contracts;
interface ActorStatsContract { public function topActors(int $limit = 10): array; }

// App\Services\ActorStats.php
namespace App\Services;
use App\Models\Actor;
use App\Contracts\ActorStatsContract;
class ActorStats implements ActorStatsContract {
    public function topActors(int $limit = 10): array {
        return Actor::withCount('films')
            ->orderByDesc('films_count')
            ->limit($limit)
            ->get(['actor_id','first_name','last_name'])
            ->toArray();
    }
}
```

Binding in un Service Provider (es. AppServiceProvider)
```php
public function register(): void
{
    // Transient: nuova istanza a ogni risoluzione
    $this->app->bind(\App\Contracts\ActorStatsContract::class, \App\Services\ActorStats::class);

    // Singleton: un’unica istanza condivisa
    // $this->app->singleton(\App\Contracts\ActorStatsContract::class, \App\Services\ActorStats::class);

    // Scoped: una istanza per richiesta
    // $this->app->scoped(\App\Contracts\ActorStatsContract::class, \App\Services\ActorStats::class);
}
```

Dimostrazione pratica
```php
Route::get('/debug/bindings', function () {
    $a = app(\App\Contracts\ActorStatsContract::class);
    $b = app(\App\Contracts\ActorStatsContract::class);
    return [
        'same_instance' => spl_object_id($a) === spl_object_id($b),
    ];
});
```
- bind: same_instance = false
- singleton: same_instance = true
- scoped: true all’interno della stessa richiesta HTTP; false tra richieste diverse

Quando usare cosa
- bind: oggetti leggeri/stateless, nessun caching interno, o quando vuoi esplicitamente nuove istanze.
- singleton: servizi con cache interna, client esterni costosi (es. HTTP client configurati), repository in-memory, adapter.
- scoped: servizi che mantengono stato della richiesta (es. preferenze utente calcolate, aggregatori che accumulano dati durante la pipeline middleware+controller).

Best practice
- Preferisci singleton per client “costosi” (HTTP, SDK, DB alternativi, storage) o per evitare overhead.
- Evita “singletons” che mantengono stato mutabile tra richieste (memory leak, dati sporchi) se il processo resta vivo (Swoole/RoadRunner).
- scoped è sicuro per stato per-richiesta su app HTTP tradizionali e server permanenti.

Esercizi
1) Prova i tre binding per ActorStatsContract e verifica same_instance nei log su più richieste.
2) Trasforma ActorStats in un singleton che memoizza i risultati per 60s usando Cache; misura differenze.
3) Crea un servizio RequestContext che esponga actorCountVisualizzati durante la richiesta e bindalo come scoped.
