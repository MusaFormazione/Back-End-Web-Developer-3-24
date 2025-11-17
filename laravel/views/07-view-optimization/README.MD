# 07 — Ottimizzazione delle view

Obiettivo: migliorare performance di rendering e deploy con gli strumenti di cache/compilazione di Laravel.

Concetti chiave
- Blade viene compilato in PHP e poi eseguito. La compilation è automatica al primo accesso.
- Comandi Artisan per ottimizzare in produzione:
  - `php artisan view:cache` compila e mette in cache tutte le view.
  - `php artisan view:clear` svuota la cache delle view.
- Riduci il lavoro nelle view: nessuna logica di business, evita query nel Blade, usa eager loading nel controller.

Comandi utili
```bash
php artisan view:cache   # precompila tutte le view (prod)
php artisan view:clear   # pulisce la cache
```

Best practice (Sakila)
- Nel controller, prepara i dati già filtrati/paginati:
```php
$films = \App\Models\Film::with('category')
    ->select('film_id','title','release_year','rating')
    ->orderBy('release_year','desc')
    ->paginate(20);
return view('films.index', compact('films'));
```
- Nel Blade, evita chiamate a metodi costosi in loops; pre-calcola nel controller se necessario.
- Usa partials/componenti per riuso ma senza frammentare eccessivamente (trade-off IO).
- Minimizza asset: delega a Vite/Laravel Mix per bundling e minificazione.

Misurare
- Usa Laravel Debugbar o clock() per misurare il tempo di rendering.
- Profilare query con `DB::enableQueryLog()` in ambienti di sviluppo.

Esercizi
1) Attiva `view:cache` nel progetto, poi apri /actors e misura il tempo di prima risposta vs replica senza cache (svuota con `view:clear`).
2) Sposta una logica condizionale costosa dal Blade al controller e confronta.
3) Precarica relazioni per `films.index` con `with('actors')` e mostra count attori per film, evitando N+1.
