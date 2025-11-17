# 05 — Passare dati alle view

Obiettivo: conoscere i modi comuni per passare dati alle view Blade.

Modi principali
- Array associativo: `return view('actors.index', ['actors' => $actors]);`
- compact(): `return view('films.show', compact('film'));`
- with(): chaining per singoli valori: `return view('actors.index')->with('actors',$actors)->with('title','Elenco');`
- Share temporaneo in una singola risposta: terzo argomento `$mergeData` dell'helper `view()`.

Esempi (Sakila)
```php
// Controller
public function show(int $id) {
    $film = \App\Models\Film::where('film_id',$id)->firstOrFail(['film_id','title','release_year']);
    // 1) compact
    return view('films.show', compact('film'));
}

public function index() {
    $actors = \App\Models\Actor::select('actor_id','first_name','last_name')->paginate(20);
    // 2) array + mergeData per pageTitle
    return view('actors.index', ['actors' => $actors], ['pageTitle' => 'Attori Sakila']);
}

public function stats() {
    $count = \App\Models\Actor::count();
    // 3) with chain
    return view('actors.stats')->with('count',$count)->with('updated_at', now());
}
```

In Blade
```blade
<h1>{{ $pageTitle ?? 'Catalogo' }}</h1>
<p>Totale attori: {{ $count ?? '-' }}</p>
```

Suggerimenti
- Preferisci `compact()` per variabili locali con lo stesso nome della chiave.
- Usa il terzo parametro `$mergeData` per aggiunte puntuali senza inquinare l'array dati principale.

Esercizi
1) In `films/index`, mostra un `pageTitle` passato via `$mergeData` e un sottotitolo via `with()`.
2) In `actors/show`, passa l'attore sia con `compact()` sia con un array che contiene anche `breadcrumbs`.
3) Crea una vista `categories/stats` che riceve `total` e `last_update` e li formatta in Blade.
