# 04 — View first() ed exists()

Obiettivo: gestire fallback di template e verificare l’esistenza di una view prima del rendering.

Concetti chiave
- View::exists('path'): ritorna true/false se la view esiste.
- view()->first(['a','b'], $data): restituisce la prima view esistente nella lista.
- Utile per branding/tenant, temi, override specifici per sezione o lingua.

Esempi (Sakila)
```php
use Illuminate\Support\Facades\View;

// 1) Verifica esistenza
if (View::exists('actors.index_custom')) {
    return view('actors.index_custom', compact('actors'));
}
return view('actors.index', compact('actors'));

// 2) Fallback multipli con first()
return view()->first([
    "themes.$tenant.actors.index",   // per-tenant
    'actors.index_custom',            // override progetto
    'actors.index',                   // default
], compact('actors'));
```

Note
- I nomi delle view usano il dot-notation (cartella.file).
- Usare first() semplifica if/else annidati.

Esercizi
1) Implementa un fallback per le viste dei film con `view()->first(['films.index_custom','films.index'])`.
2) Crea una cartella `themes/admin/actors/index.blade.php` e usa `first()` per preferirla quando l’utente è admin.
3) Aggiungi un controllo con `View::exists()` per mostrare un banner opzionale `partials/banner.blade.php` se presente.
