# 03 — Viste annidate: layout, partials, componenti

Obiettivo: organizzare il markup in layout riutilizzabili, partials e componenti.

Concetti chiave
- Layout: un template principale che definisce struttura e sezioni (@yield). Le viste figlie lo estendono con @extends e riempiono le @section.
- Partials: porzioni di HTML incluse con @include (header, footer, form, ecc.).
- Componenti: unità riutilizzabili con parametri (<x-component />). Utili per card, badge, tabelle.

Esempi (Sakila)

Layout
```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>@yield('title','Sakila')</title>
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
  @include('partials.nav')
  <main class="container">
    @yield('breadcrumb')
    @yield('content')
  </main>
  @include('partials.footer')
</body>
</html>
```

Partial
```blade
{{-- resources/views/partials/nav.blade.php --}}
<nav>
  <a href="{{ route('actors.index') }}">Attori</a>
  <a href="{{ route('films.index') }}">Film</a>
</nav>
```

Vista che estende il layout
```blade
{{-- resources/views/actors/index.blade.php --}}
@extends('layouts.app')
@section('title','Elenco Attori')
@section('content')
  <h1>Attori</h1>
  @include('actors._table', ['actors' => $actors])
@endsection
```

Partial di tabella
```blade
{{-- resources/views/actors/_table.blade.php --}}
<table class="table">
  <thead><tr><th>#</th><th>Nome</th><th>Cognome</th></tr></thead>
  <tbody>
  @foreach($actors as $actor)
    <tr>
      <td>{{ $actor->actor_id }}</td>
      <td>{{ $actor->first_name }}</td>
      <td>{{ $actor->last_name }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
```

Esercizi
1) Crea un layout `layouts/admin.blade.php` con una sidebar e usalo in una vista `films/index.blade.php`.
2) Estrai la riga di tabella in un partial `_row.blade.php` e includilo nel loop degli attori.
3) Crea un componente semplice `<x-badge type="success">` per mostrare categorie dei film.
