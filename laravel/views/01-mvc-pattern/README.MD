# 01 — Pattern MVC in Laravel 12

Obiettivo: comprendere come Laravel implementa Model–View–Controller e come le View si inseriscono nel flusso.

Concetti chiave
- Model: rappresenta i dati e la logica di accesso (Eloquent). Es.: App\Models\Actor per la tabella sakila.actor.
- View: responsabile della presentazione (HTML). In Laravel si usano file Blade in resources/views.
- Controller: coordina la richiesta, invoca i Model/Servizi, passa dati alla View e ritorna una Response.

Flusso tipico (Sakila)
1) Route riceve la richiesta HTTP.
2) Controller legge i dati dal Model/Repository.
3) Controller restituisce una View con i dati.

Esempio
```php
// routes/web.php
use App\Http\Controllers\ActorController;
Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');
```

```php
// app/Http/Controllers/ActorController.php
namespace App\Http\Controllers;
use App\Models\Actor;

class ActorController extends Controller
{
    public function index()
    {
        $actors = Actor::select('actor_id','first_name','last_name')->limit(20)->get();
        return view('actors.index', compact('actors'));
    }
}
```

```blade
{{-- resources/views/actors/index.blade.php --}}
@extends('layouts.app')
@section('title','Attori')
@section('content')
  <h1>Attori</h1>
  <ul>
    @foreach($actors as $actor)
      <li>{{ $actor->first_name }} {{ $actor->last_name }}</li>
    @endforeach
  </ul>
@endsection
```

Dove stanno le View
- resources/views: root delle view.
- Convenzione nomi: view('actors.index') -> resources/views/actors/index.blade.php

Esercizi
1) Crea un controller FilmController@index che legge titolo/anno da sakila.film e mostra una view films/index.blade.php.
2) Aggiungi un layout base e usa @extends in entrambe le viste actors/ e films/.
3) Aggiungi un breadcrumb in layout usando una section opzionale (@yield('breadcrumb')).
