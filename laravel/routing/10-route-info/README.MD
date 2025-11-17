# 10 — Info sulla route (Facade Route e Request)

Obiettivo: ottenere informazioni sulla route corrente e generare URL.

Metodi utili (Route)
```php
use Illuminate\Support\Facades\Route;

$currentName   = Route::currentRouteName();
$currentAction = Route::currentRouteAction();
$current       = Route::current(); // ->uri(), ->methods(), ->parameters()

if (Route::has('actors.index')) {
    // esiste una route registrata con questo nome
}
```

Da Request/URL helpers
```php
$request = request();
$request->route();                // oggetto Route
$request->routeIs('actors.*');    // match sul nome
$request->is('admin/*');          // match sul path
$request->route('actor');         // parametro

$url        = route('actors.show', ['actor' => 123]);
$currentUrl = url()->current();   // senza query
$fullUrl    = url()->full();      // con query
$previous   = url()->previous();
```

Esempio (Sakila)
```php
// Evidenzia voce di menu se siamo nella sezione attori
<li class="nav-item">
  <a class="nav-link {{ request()->routeIs('actors.*') ? 'active' : '' }}" href="{{ route('actors.index') }}">Attori</a>
</li>
```

Esercizi
1) In un layout Blade, evidenzia la voce di menu attiva usando routeIs().
2) In un middleware, logga currentRouteName() e currentRouteAction() per ogni richiesta.
3) Usa Route::has() per mostrare un link opzionale solo se la route esiste.
