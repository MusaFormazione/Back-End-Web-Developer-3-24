# 04 — Redirect

Obiettivo: reindirizzare l’utente da una route a un’altra in modo semplice e semantico.

Metodi rapidi
```php
// Redirect 302 temporaneo
Route::redirect('/home', '/actors');

// Redirect 301 permanente
Route::permanentRedirect('/old-films', '/films');
```

Da controller/closure
```php
return redirect('/actors');
return redirect()->route('actors.index');
return back();                 // torna alla pagina precedente
return back()->with('status','Fatto');
```

Esempio (Sakila)
```php
// routes/web.php
Route::get('/old-actors', function () {
    return redirect()->route('actors.index');
});
```

Note
- Usa redirect permanenti (301) per URL deprecati e SEO.
- Per route naming, preferisci redirect()->route() per non hardcodare gli URL.

Esercizi
1) Aggiungi un redirect permanente da /catalog a /films.
2) Dopo la creazione di un attore, effettua redirect alla route actors.show con messaggio flash.
3) Implementa un pulsante "indietro" che usa back() dopo un errore di validazione.
