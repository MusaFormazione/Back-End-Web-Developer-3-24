# 06 — View share e View Composers

Obiettivo: condividere dati globali tra più viste e preparare dati automaticamente prima del rendering.

Strumenti
- View::share($key, $value): condivide una variabile con TUTTE le view per l’intero ciclo della richiesta.
- View Composers: callback/classi che iniettano dati in specifiche viste quando vengono renderizzate.
- View Creators: simili ai composers ma eseguiti prima della composizione.

Esempi (Sakila)

Condivisione globale (es. titolo applicazione, menu)
```php
// App\Providers\AppServiceProvider.php
use Illuminate\Support\Facades\View;

public function boot(): void
{
    View::share('appName', 'Sakila CMS');
    View::share('mainMenu', [
        ['label' => 'Attori', 'route' => 'actors.index'],
        ['label' => 'Film', 'route' => 'films.index'],
        ['label' => 'Categorie', 'route' => 'categories.index'],
    ]);
}
```

Blade
```blade
<h1>{{ $appName }}</h1>
<nav>
  @foreach($mainMenu as $item)
    <a href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
  @endforeach
</nav>
```

View Composers
```php
// App\Providers\ViewServiceProvider.php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // inietta le categorie in sidebar SOLO per alcune viste
        View::composer([
            'layouts.app',
            'partials.sidebar',
        ], function ($view) {
            $view->with('sidebarCategories', Category::orderBy('name')->limit(10)->get());
        });
    }
}
```

Registrazione del provider
```php
// config/app.php => 'providers' => [
//    ...
//    App\Providers\ViewServiceProvider::class,
// ],
```

Note
- Preferisci `View::composer` per dati costosi, limitandolo alle viste che ne hanno bisogno.
- Evita `View::share` per dati variabili per utente (usa composers o middleware che passa dati alla view).

Esercizi
1) Crea un `ViewServiceProvider` e inietta `popularFilms` nella vista `layouts.app` con i 5 film più noleggiati.
2) Usa `View::composer('*', ...)` per condividere `currentYear` in tutte le viste; poi sostituiscilo con `share` e misura differenze.
3) Crea un composer di classe (non closure) per popolare `categoriesCount` nelle viste `categories/*`.
