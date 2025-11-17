# 09 — Escape e collisioni con framework JS

Obiettivo: capire come Blade effettua l'escape dell'output e come evitare collisioni di sintassi con framework JS (Vue, Alpine, Angular, ecc.).

Escape in Blade
- `{{ $var }}`: escape HTML automatico (sicuro contro XSS).
- `{!! $html !!}`: output raw, NON fa escape — usare solo con contenuti fidati/sanitizzati.
- `@verbatim ... @endverbatim`: blocca il parsing Blade all'interno del blocco.
- `@{{ ... }}`: stampa letteralmente `{{ ... }}` per evitare che Blade lo interpreti (utile con Vue 2).

Esempi
```blade
{{-- Escape automatico --}}
<p>{{ $actor->first_name }}</p>

{{-- Output HTML raw (attenzione!) --}}
<div>{!! $film->description_html !!}</div>

{{-- Verbatim per blocchi JS template-based --}}
@verbatim
<div id="vue-app">
  <p>{{ message }}</p>
</div>
@endverbatim

{{-- Stampare doppie graffe letterali --}}
<p>@{{ username }}</p>
```

Collisioni comuni con JS
- Vue 2 usa `{{ }}` per le interpolation: usa `@{{ }}` o `v-once`/`v-pre`.
- Vue 3/Alpine: stessa sintassi; considera `x-text`, `x-html` per iniettare.
- Angular usa `{{ }}`: usare `@verbatim` per blocchi di template.

Suggerimenti di sicurezza
- Escapa sempre l'output utente con `{{ }}`.
- Usa `{!! !!}` solo per contenuti sanitizzati (es. da un CMS con whitelist) o provenienti da sorgenti fidate.
- Per URL, usa helper `e()` o `route()`/`url()` invece di concatenare stringhe.

Esempio (Sakila)
```blade
{{-- resources/views/films/description.blade.php --}}
@extends('layouts.app')
@section('content')
  <h1>{{ $film->title }}</h1>
  <div class="desc">{!! $film->description_html !!}</div> {{-- sanitizzato lato server --}}
  @verbatim
  <div id="app">
    <p>@{{ dynamicText }}</p>
  </div>
  @endverbatim
@endsection
```

Esercizi
1) Inserisci un widget Vue in una vista Blade e usa `@verbatim` per il suo template.
2) Mostra sia `{{ }}` (escape) sia `{!! !!}` (raw) con dati dimostrativi e spiega le differenze.
3) In un partial condiviso, stampa `@{{ item }}` per evitare il parsing Blade e verifica il comportamento con Alpine.js.
