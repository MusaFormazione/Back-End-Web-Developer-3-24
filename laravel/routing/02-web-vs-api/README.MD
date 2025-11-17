# 02 — Web vs API routes

Obiettivo: distinguere tra rotte web (HTML, sessione) e rotte API (JSON, stateless).

Differenze chiave
- web.php: middleware group "web" (sessioni, CSRF, cookie). Output tipico: Blade/HTML e redirect.
- api.php: middleware group "api" (stateless). Prefisso automatico "/api". Output tipico: JSON.
- CSRF: attivo su web, non su api.
- Versioning: comune sulle API (es. /api/v1).

Esempi (Sakila)
```php
// routes/web.php
use App\Http\Controllers\ActorController;
Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');

// routes/api.php
use App\Http\Controllers\Api\FilmController;
Route::get('/films', [FilmController::class, 'index'])->name('api.films.index');
```

Esempio controller API minimale
```php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Film;

class FilmController extends Controller
{
    public function index()
    {
        return Film::select('film_id','title','release_year')->paginate(50);
    }
}
```

Esercizi
1) Crea una pagina web GET /categories che mostri l'elenco in Blade.
2) Crea l'endpoint API GET /api/categories che ritorna JSON paginato.
3) Confronta i middleware su route:list per le due rotte.
