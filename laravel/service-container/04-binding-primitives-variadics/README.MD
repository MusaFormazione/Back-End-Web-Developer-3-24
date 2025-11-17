# 04 — Binding di primitivi e argomenti variadici

Obiettivo: gestire dal Service Container i valori primitivi (string, int, array) e gli argomenti variadici che non possono essere autowire-ati automaticamente.

Scenario (Sakila)
Supponiamo un servizio che filtra i film per rating minimo e lingua, e che accetti anche una lista variabile di categorie da includere.

```php
// App\Services\FilmFilter.php
namespace App\Services;

use App\Models\Film;

class FilmFilter
{
    public function __construct(
        private string $language,          // primitivo
        private int $minRating,            // primitivo
        private array $defaultCategories = [] // primitivo/array
    ) {}

    public function search(string ...$categories): array // variadico
    {
        $cats = empty($categories) ? $this->defaultCategories : $categories;

        return Film::query()
            ->where('rating', '>=', $this->minRating)
            ->whereHas('language', fn($q) => $q->where('name', $this->language))
            ->when($cats, fn($q) => $q->whereHas('categories', fn($q2) => $q2->whereIn('name', $cats)))
            ->limit(50)
            ->get(['film_id','title','rating'])
            ->toArray();
    }
}
```

Binding dei primitivi con closure
Quando il costruttore contiene tipi primitivi, il container non sa cosa iniettare. Usa un binding esplicito con una closure.

```php
// App\Providers\AppServiceProvider.php
public function register(): void
{
    $this->app->bind(\App\Services\FilmFilter::class, function ($app) {
        // Ipotizziamo che queste impostazioni arrivino dalla config
        $language   = config('sakila.language', 'English');
        $minRating  = (int) config('sakila.min_rating', 3);
        $defaults   = (array) config('sakila.default_categories', ['Action','Comedy']);

        return new \App\Services\FilmFilter($language, $minRating, $defaults);
    });
}
```

Uso in controller
```php
use App\Services\FilmFilter;

class FilmController
{
    public function index(FilmFilter $filter)
    {
        // Argomento variadico passato dal chiamante
        $data = $filter->search('Action', 'Drama');
        return response()->json($data);
    }
}
```

Passare dinamicamente i primitivi da route/controller
Se i valori primitivi dipendono dalla richiesta (es. query string), costruisci l’istanza nel controller con make e parametri.

```php
public function dynamic(Request $request)
{
    $filter = app()->make(\App\Services\FilmFilter::class, [
        'language' => $request->get('lang', 'English'),
        'minRating' => (int) $request->get('min', 3),
        'defaultCategories' => ['Family']
    ]);

    return $filter->search(...explode(',', $request->get('cats','')));
}
```

Alternative: context binding per primitive (avanzato)
Laravel permette il context binding anche per primitivi:
```php
use App\Services\FilmFilter;

$this->app->when(FilmFilter::class)
    ->needs('$language')
    ->give(fn() => config('sakila.language', 'English'));

$this->app->when(FilmFilter::class)
    ->needs('$minRating')
    ->give(fn() => (int) config('sakila.min_rating', 3));
```

Best practice
- Centralizza i valori predefiniti in config/*.php e leggili nel provider.
- Usa make([...]) quando i primitivi dipendono dai parametri della richiesta.
- Per variadici, usa lo spread operator ... per passare array dinamici.

Esercizi
1) Crea un config sakila.php con language, min_rating, default_categories e usa il binding via closure.
2) Aggiungi una route /api/films/filter che costruisce FilmFilter con make([...]) e legge i parametri da query string.
3) Implementa il context binding per i parametri primitivi di FilmFilter e confronta con la closure nel provider.
