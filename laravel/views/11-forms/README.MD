# 11 — Forms in Laravel 12 (Blade) — con esempi Sakila

Obiettivo: imparare a costruire form HTML con Blade, proteggere le richieste, gestire validazione/errore e valorizzare i campi con i dati precedenti o del modello.

Concetti chiave
- Sicurezza: @csrf obbligatorio nei form POST/PUT/PATCH/DELETE.
- Verbi HTTP: i form HTML supportano solo GET/POST; per PUT/PATCH/DELETE usa @method('PUT'|'PATCH'|'DELETE').
- Validazione: Form Request o validate() nel controller; errori disponibili in $errors.
- old(): ripopola i campi dopo una validazione fallita.
- Messaggi flash: redirect()->back()->with('status','...') per mostrare conferme.
- File upload: enctype="multipart/form-data" e validazione dei file.

Esempio 1 — Form di creazione Attore (Sakila)
Route
```php
// routes/web.php
use App\Http\Controllers\ActorController;
Route::get('/actors/create', [ActorController::class, 'create'])->name('actors.create');
Route::post('/actors', [ActorController::class, 'store'])->name('actors.store');
```

Controller (metodi essenziali)
```php
// app/Http/Controllers/ActorController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreActorRequest; // vedi sotto

class ActorController extends Controller
{
    public function create()
    {
        return view('actors.create');
    }

    public function store(StoreActorRequest $request)
    {
        // Dati validati
        $data = $request->validated();

        // Esempio: inserimento semplificato (adatta al tuo modello/PK)
        \App\Models\Actor::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
        ]);

        return redirect()->route('actors.index')->with('status', 'Attore creato con successo');
    }
}
```

Form Request di validazione
```php
// app/Http/Requests/StoreActorRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActorRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'first_name' => ['required','string','max:45'],
            'last_name'  => ['required','string','max:45'],
        ];
    }
}
```

Vista Blade del form
```blade
{{-- resources/views/actors/create.blade.php --}}
@extends('layouts.app')
@section('title','Crea Attore')
@section('content')
  <h1>Nuovo Attore</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('actors.store') }}">
    @csrf
    <div>
      <label>Nome</label>
      <input name="first_name" value="{{ old('first_name') }}" />
      @error('first_name') <div class="error">{{ $message }}</div> @enderror
    </div>
    <div>
      <label>Cognome</label>
      <input name="last_name" value="{{ old('last_name') }}" />
      @error('last_name') <div class="error">{{ $message }}</div> @enderror
    </div>
    <button type="submit">Salva</button>
  </form>
@endsection
```

Esempio 2 — Edit Attore (PATCH) con valori del modello
Route
```php
Route::get('/actors/{actor}/edit', [ActorController::class, 'edit'])->name('actors.edit');
Route::patch('/actors/{actor}', [ActorController::class, 'update'])->name('actors.update');
```

Controller (estratto)
```php
public function edit(\App\Models\Actor $actor)
{
    return view('actors.edit', compact('actor'));
}

public function update(\Illuminate\Http\Request $request, \App\Models\Actor $actor)
{
    $data = $request->validate([
        'first_name' => ['required','string','max:45'],
        'last_name'  => ['required','string','max:45'],
    ]);
    $actor->update($data);
    return redirect()->route('actors.edit', $actor)->with('status','Aggiornato');
}
```

Blade (con spoof del verbo PATCH e fallback old())
```blade
{{-- resources/views/actors/edit.blade.php --}}
@extends('layouts.app')
@section('title','Modifica Attore')
@section('content')
  <h1>Modifica Attore #{{ $actor->actor_id }}</h1>
  @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif
  <form method="POST" action="{{ route('actors.update', $actor) }}">
    @csrf
    @method('PATCH')
    <div>
      <label>Nome</label>
      <input name="first_name" value="{{ old('first_name', $actor->first_name) }}">
      @error('first_name') <div class="error">{{ $message }}</div> @enderror
    </div>
    <div>
      <label>Cognome</label>
      <input name="last_name" value="{{ old('last_name', $actor->last_name) }}">
      @error('last_name') <div class="error">{{ $message }}</div> @enderror
    </div>
    <button type="submit">Aggiorna</button>
  </form>
@endsection
```

Esempio 3 — Form di filtro (GET) Film per categoria/anno
```php
// routes/web.php
Route::get('/films/search', [\App\Http\Controllers\FilmController::class, 'search'])->name('films.search');
```

```php
// app/Http/Controllers/FilmController.php (estratto)
public function search(\Illuminate\Http\Request $request)
{
    $q = \App\Models\Film::query();
    $category = $request->query('category');
    $year     = $request->query('year');

    $q->when($category, fn($qq) => $qq->whereHas('categories', fn($c) => $c->where('name',$category)));
    $q->when($year, fn($qq) => $qq->where('release_year', $year));

    $films = $q->limit(50)->get(['film_id','title','release_year']);
    $categories = \App\Models\Category::orderBy('name')->pluck('name');

    return view('films.search', compact('films','categories','category','year'));
}
```

```blade
{{-- resources/views/films/search.blade.php --}}
@extends('layouts.app')
@section('title','Cerca Film')
@section('content')
  <h1>Ricerca Film</h1>
  <form method="GET" action="{{ route('films.search') }}">
    <label>Categoria</label>
    <select name="category">
      <option value="">-- tutte --</option>
      @foreach($categories as $cat)
        <option value="{{ $cat }}" @selected($cat == ($category ?? ''))>{{ $cat }}</option>
      @endforeach
    </select>
    <label>Anno</label>
    <input type="number" name="year" value="{{ $year }}" placeholder="2006">
    <button type="submit">Filtra</button>
  </form>

  <ul>
    @forelse($films as $film)
      <li>{{ $film->title }} ({{ $film->release_year }})</li>
    @empty
      <li>Nessun film trovato</li>
    @endforelse
  </ul>
@endsection
```

Note e best practice
- Posiziona i messaggi di errore vicino ai campi: @error('campo') ... @enderror.
- Usa value="{{ old('campo', $model->campo ?? '') }}" per pre-compilare sia in create che in edit.
- Per checkbox array (es. categorie[]): usa name="categories[]" e in controller valida con array|exists:categories,id.
- Per upload: aggiungi enctype e usa Storage per salvare i file: $path = $request->file('photo')->store('actors','public').

Esercizi
1) Crea un form di creazione Categoria (name, description opzionale). Valida name richiesto e univoco; mostra errori e messaggio di successo.
2) Implementa un form di modifica Film che consenta di aggiornare rating e language con due select; usa PATCH e @method.
3) Aggiungi un campo facoltativo "foto attore" al form di creazione; valida tipo (image) e dimensione (max: 1MB) e salva il path nel modello.
4) Estrai i campi del form attore in un partial `actors/_form.blade.php` e riusalo in create/edit.
