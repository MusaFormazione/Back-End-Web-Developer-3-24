# 02 — Creare le view: helper view() e Facade View

Obiettivo: capire come restituire una view dal controller/route usando l'helper `view()` e la Facade `View`.

Concetti chiave
- Helper `view($name, $data = [], $mergeData = [])`: crea una risposta con la view Blade.
- Facade `View`: per operazioni avanzate (es. `View::exists()`, `View::share()`), oppure per ottenere factory/template.
- Convenzioni di naming: `view('actors.index')` -> `resources/views/actors/index.blade.php`.

Esempi (Sakila)
```php
// Route/Controller -> helper view()
return view('actors.index', ['actors' => $actors]);

// Merge data
return view('films.show', compact('film'), ['pageTitle' => $film->title]);

// Usare la Facade View per creare una view
use Illuminate\Support\Facades\View;
if (View::exists('actors.index')) {
    return View::make('actors.index', compact('actors'));
}
abort(404);
```

Passi tipici
1) Prepari i dati nel controller.
2) Restituisci `view('cartella.nome-file', $dati)`.
3) Blade renderizza HTML.

Esercizi
1) Modifica ActorController@index per usare `View::make()` invece di `view()` e verifica l’output.
2) Crea la view `categories/index.blade.php` e restituiscila da route con `view()` passando un array associativo.
3) In un controller show, passa sia `compact()` sia `$mergeData` per aggiungere un `pageTitle`.
