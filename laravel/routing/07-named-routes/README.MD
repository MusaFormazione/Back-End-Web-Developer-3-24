# 07 — Named routes

Obiettivo: assegnare nomi alle route per generare URL e redirect stabili.

Perché usarle
- Eviti URL hard-coded nel codice di business (servizi, controller).
- Facile refactor: cambi l'URI ma non rompi i link.
- Comodo con i gruppi: prefissi di nome.

Esempi (Sakila)
```php
use App\Http\Controllers\ActorController;

Route::name('actors.')->group(function () {
    Route::get('/actors', [ActorController::class, 'index'])->name('index');
    Route::get('/actors/{actor}', [ActorController::class, 'show'])->name('show');
    Route::post('/actors', [ActorController::class, 'store'])->name('store');
});

// Generazione URL
$url = route('actors.show', ['actor' => 123]);

// Redirect per nome
return redirect()->route('actors.index');

// Verifica route corrente
if (request()->routeIs('actors.*')) {
    // evidenzia menu
}
```

Best practice
- Usa prefissi coerenti (actors., films., categories.).
- Nelle viste usa sempre route('name') al posto di URL fissi.

Esercizi
1) Dai un nome a tutte le rotte del CRUD categories con prefisso categories.*.
2) Sostituisci nei Blade tutti i link hard-coded con route('...').
3) Aggiungi un test feature che verifichi che GET route('actors.index') ritorni 200.
