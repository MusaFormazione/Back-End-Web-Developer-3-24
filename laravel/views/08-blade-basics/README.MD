# 08 — Blade: basi

Obiettivo: prendere confidenza con Blade, il motore di template di Laravel.

Concetti chiave
- Estensione file: `.blade.php` in `resources/views`.
- Ereditarietà: `@extends` per layout, `@section`/`@yield` per aree di contenuto.
- Inclusioni: `@include` per partials.
- Componenti: `<x-component />` con slot e attributi.
- Stack: `@push`/`@stack` per iniettare script o stili da viste figlie.

Layout ed eredità
```blade
{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <title>@yield('title','Sakila')</title>
  @stack('styles')
</head>
<body>
  @include('partials.nav')
  <main class="container">
    @yield('content')
  </main>
  @stack('scripts')
</body>
</html>
```

```blade
{{-- resources/views/films/index.blade.php --}}
@extends('layouts.app')
@section('title','Film')
@push('styles')
  <link rel="stylesheet" href="/css/films.css">
@endpush
@section('content')
  <h1>Film</h1>
  @include('films._table',['films'=>$films])
@endsection
@push('scripts')
  <script src="/js/films.js"></script>
@endpush
```

Componenti base
```bash
php artisan make:component Badge   # crea app/View/Components/Badge.php e resources/views/components/badge.blade.php
```

```php
// app/View/Components/Badge.php
namespace App\View\Components;
use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(public string $type = 'secondary') {}
    public function render() { return view('components.badge'); }
}
```

```blade
{{-- resources/views/components/badge.blade.php --}}
<span class="badge badge-{{ $type }}">{{ $slot }}</span>
```

Uso componente
```blade
<x-badge type="success">Nuovo</x-badge>
```

Esercizi
1) Aggiungi uno stack `@stack('head')` nel layout e in `actors/index` fai `@push('head')` per inserire un meta tag specifico.
2) Crea un componente `<x-card>` con slot titolo e contenuto per visualizzare i dettagli di un film.
3) Estrai la tabella film in un `@include('films._table')` riutilizzabile in index e search.
