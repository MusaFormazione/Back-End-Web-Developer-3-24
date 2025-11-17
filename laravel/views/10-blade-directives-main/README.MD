# 10 — Direttive Blade principali

Obiettivo: usare le direttive Blade più comuni per controllare il flusso, includere partials, gestire sicurezza dei form e autorizzazioni.

Controllo di flusso
```blade
{{-- Condizionali --}}
@if($film->rating === 'PG')
  <span class="badge">Per tutti</span>
@elseif($film->rating === 'R')
  <span class="badge badge-danger">Per adulti</span>
@else
  <span class="badge badge-secondary">N/D</span>
@endif

@unless($actors->isEmpty())
  <p>Totale attori: {{ $actors->count() }}</p>
@endunless

{{-- isset/empty --}}
@isset($pageTitle)
  <h1>{{ $pageTitle }}</h1>
@endisset

@empty($subtitle)
  <p class="muted">Nessun sottotitolo</p>
@endempty

{{-- switch --}}
@switch($film->language)
  @case('English')
    <span>🇬🇧</span>
    @break
  @case('Italian')
    <span>🇮🇹</span>
    @break
  @default
    <span>🌍</span>
@endswitch

{{-- loop --}}
@foreach($actors as $actor)
  {{ $loop->iteration }}. {{ $actor->first_name }} {{ $actor->last_name }}
@endforeach

{{-- forelse: gestisce collezioni vuote --}}
@forelse($films as $film)
  <li>{{ $film->title }}</li>
@empty
  <li>Nessun film disponibile</li>
@endforelse

@for($i = 0; $i < 3; $i++)
  <span>{{ $i }}</span>
@endfor

@while($condition)
  {{-- ... --}}
  @break
@endwhile
```

Direttive per include e componenti
```blade
@include('partials.nav')
@includeIf('partials.banner')                {{-- include solo se esiste --}}
@includeWhen($isAdmin, 'partials.admin')     {{-- include condizionale --}}
@includeFirst(['themes.admin.header','partials.header'])  {{-- primo disponibile --}}

{{-- Componenti --}}
<x-badge type="success">Nuovo</x-badge>
```

Form e sicurezza
```blade
<form method="POST" action="{{ route('actors.store') }}">
  @csrf                 {{-- token CSRF --}}
  @method('PUT')        {{-- spoof HTTP verb --}}
  <input name="first_name">
  <button type="submit">Salva</button>
</form>

{{-- errori di validazione --}}
@error('first_name')
  <div class="error">{{ $message }}</div>
@enderror
```

Autenticazione e autorizzazioni
```blade
@auth
  <a href="{{ route('logout') }}">Logout</a>
@endauth

@guest
  <a href="{{ route('login') }}">Login</a>
@endguest

@can('update', $film)
  <a href="{{ route('films.edit', $film) }}">Modifica</a>
@endcan

@cannot('delete', $film)
  <span class="muted">Non puoi cancellare questo film</span>
@endcannot
```

Utility
```blade
@php($year = now()->year)
<p>&copy; {{ $year }}</p>

{{-- debug (solo dev) --}}
@dump($film)
{{-- @dd($film) --}}  {{-- interrompe l'esecuzione --}}

{{-- Eseguire un blocco una sola volta (utile per script) --}}
@once
  @push('scripts')
    <script>console.log('Caricato una sola volta');</script>
  @endpush
@endonce
```

Direttive Blade comuni (promemoria)
- Struttura: @extends, @section, @yield, @include, @component, @slot, @endcomponent
- Controllo: @if/@elseif/@else/@endif, @unless/@endunless, @isset/@endisset, @empty/@endempty, @switch/@case/@break/@default/@endswitch
- Loop: @for/@endfor, @foreach/@endforeach (variabile $loop), @forelse/@empty/@endforelse, @while/@endwhile
- Sicurezza form: @csrf, @method, @error
- Auth: @auth/@endauth, @guest/@endguest, @can/@endcan, @cannot/@endcannot
- Varie: @php, @dump, @dd, @once, @push/@stack, @vite (per asset con Vite)

Esercizi
1) In `actors/index`, usa `@forelse` per mostrare la lista o un messaggio "Nessun attore"; mostra anche l'indice con `$loop->iteration`.
2) In `films/show`, mostra un bottone Modifica solo se `@can('update', $film)`, e un avviso `@cannot('delete', $film)`.
3) Crea un partial `partials/alerts` e includilo con `@includeWhen(session('status'), 'partials.alerts')`; inietta il messaggio via sessione dal controller.
