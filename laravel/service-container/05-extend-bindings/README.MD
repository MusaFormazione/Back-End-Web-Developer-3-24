# 05 — Estendere i binding con Container::extend

Obiettivo: usare `extend` per decorare/arricchire un servizio già registrato senza cambiare l’implementazione originale.

Quando serve
- Aggiungere cross-cutting concerns: logging, caching, metriche, circuit breaker.
- Sovrapporre comportamento in test o in ambienti specifici.

Esempio (Sakila) — aggiungiamo logging a ActorStatsContract
```php
// Contratto e implementazione base (vedi modulo 03)
use App\Contracts\ActorStatsContract;
use App\Services\ActorStats;

// App\Providers\AppServiceProvider.php
public function register(): void
{
    // Binding base (transient o singleton a tua scelta)
    $this->app->singleton(ActorStatsContract::class, ActorStats::class);

    // Decorazione con extend
    $this->app->extend(ActorStatsContract::class, function (ActorStatsContract $service, $app) {
        // ritorna un wrapper che aggiunge logging senza toccare la classe originale
        return new class($service) implements ActorStatsContract {
            public function __construct(private ActorStatsContract $inner) {}
            public function topActors(int $limit = 10): array
            {
                \Log::info('[ActorStats] topActors start', compact('limit'));
                $t0 = microtime(true);
                $res = $this->inner->topActors($limit);
                \Log::info('[ActorStats] topActors end', ['ms' => (int)((microtime(true)-$t0)*1000)]);
                return $res;
            }
        };
    });
}
```

Più decorazioni in cascata
`extend` può essere chiamato più volte: ogni volta ricevi l’istanza precedente e la restituisci decorata ulteriormente.

```php
$this->app->extend(ActorStatsContract::class, function (ActorStatsContract $service) {
    // seconda decorazione, ad esempio metriche
    return new MetricsActorStats($service);
});
```

Esempio — caching con extend
```php
$this->app->extend(ActorStatsContract::class, function (ActorStatsContract $service) {
    return new class($service) implements ActorStatsContract {
        public function __construct(private ActorStatsContract $inner) {}
        public function topActors(int $limit = 10): array
        {
            $key = "actorstats.top.$limit";
            return \Cache::remember($key, 60, fn() => $this->inner->topActors($limit));
        }
    };
});
```

Best practice
- Mantieni i decorator semplici e focalizzati; valuta classi dedicate al posto di classi anonime se crescono.
- `extend` agisce sul binding già risolto: assicurati di chiamarlo dopo il binding base nello stesso `register()`.
- Evita side-effect nel costruttore del decorator; sposta il lavoro nei metodi.

Esercizi
1) Aggiungi un decorator che normalizza i dati (es. aggiunge full_name a ogni attore).
2) Implementa un decorator che mette in cache topActors per 30s con chiave dipendente da `$limit`.
3) Scrivi un test che verifichi che, con due `extend` in cascata, i metodi vengano invocati nell’ordine corretto.
