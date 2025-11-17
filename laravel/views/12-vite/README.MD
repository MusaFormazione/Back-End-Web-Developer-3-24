# 12 — Vite in Laravel 12 (informazioni generali)

Obiettivo: capire come Laravel 12 integra Vite per gestire asset frontend (JS, CSS, immagini) con sviluppo veloce (HMR) e build di produzione.

Panoramica
- Vite è un bundler/dev server moderno basato su ES Modules.
- In sviluppo serve i file con HMR (hot module replacement) velocissimo.
- In produzione esegue una build ottimizzata (minificazione, hashing per cache-busting).
- In Laravel si usa la direttiva Blade `@vite` per includere asset gestiti da Vite.

Prerequisiti tipici del progetto
- package.json con script tipo:
```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build"
  }
}
```
- vite.config.js generato (di base con laravel-vite-plugin):
```js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
})
```

Includere asset nelle view
```blade
{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <title>@yield('title','Sakila')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @yield('content')
</body>
</html>
```
- In dev, `@vite` si collega al dev server (es. http://127.0.0.1:5173) con HMR.
- In prod, `@vite` carica i file versionati generati dalla build (manifest.json).

Avvio in sviluppo
- Installa dipendenze: `npm install` o `pnpm install`.
- Avvia Laravel (php artisan serve) e Vite: `npm run dev`.
- Apri il browser sulla tua app; le modifiche a JS/CSS si aggiornano live.

Build di produzione
- Esegui `npm run build`: crea dist/versioned assets.
- Assicurati che `APP_ENV=production` e `APP_DEBUG=false` in .env.
- Facoltativo: pubblica public/build e manifest.json durante il deploy.

Immagini, font e asset statici
- Puoi importare asset in JS/CSS e Vite gestirà i percorsi:
```js
import poster from '@/images/poster.jpg'
const img = new Image()
img.src = poster
```
- In CSS: `background: url('/resources/images/bg.png')` (con path risolti dal plugin).
- Usa alias `@` -> `resources` (spesso configurato dal plugin o manualmente).

Environment e HMR
- Vite usa variabili da `.env` prefissate con `VITE_` es: `VITE_API_BASE_URL=https://...`.
- In JS: `import.meta.env.VITE_API_BASE_URL`.
- HMR: il plugin `laravel-vite-plugin` gestisce refresh su Blade/Php quando `refresh: true`.

Esempio minimale Sakila
- Aggiungi un piccolo JS per interazioni nella lista film (highlight al passaggio):
```js
// resources/js/app.js
import '../css/app.css'

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-hover-row]')?.forEach(tr => {
    tr.addEventListener('mouseenter', () => tr.classList.add('hover'))
    tr.addEventListener('mouseleave', () => tr.classList.remove('hover'))
  })
})
```

```css
/* resources/css/app.css */
.table .hover { background: #fff8e1; }
```

```blade
{{-- resources/views/films/_table.blade.php --}}
<table class="table">
  <tbody>
  @foreach($films as $film)
    <tr data-hover-row>
      <td>{{ $film->title }}</td>
      <td>{{ $film->release_year }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
```

Troubleshooting
- Errore Mixed Content / porte: apri l’app su http://127.0.0.1:8000 e Vite su 5173; evita https misto.
- 404 su asset in prod: assicurati di aver eseguito `npm run build` e che public/build esista sul server.
- Cache browser aggressiva: in prod i file sono versionati, ma invalida la CDN/browser se cambi manifest.

Comandi utili riassunto
- `npm run dev` — avvia dev server con HMR.
- `npm run build` — build di produzione.
- `php artisan view:cache` — compila view (non legato a Vite, ma utile nel deploy assieme a Vite).

Esercizi
1) Integra `@vite(['resources/css/app.css','resources/js/app.js'])` nel tuo layout principale. Crea un CSS minimale che stili i titoli delle pagine di Sakila.
2) Aggiungi un piccolo script in `resources/js/app.js` che mostra un toast (alert) quando si salva un attore con successo (leggi `session('status')` e, se presente, mostra `alert(...)`).
3) Crea un file `resources/js/films.js` e includilo solo nella vista `films/index.blade.php` con `@vite('resources/js/films.js')`, che evidenzi le righe dei film più recenti (es. `data-recent="1"`).
