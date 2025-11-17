# 11 — Esercizio: View “Trading Finance Info” con Facade

Obiettivo: creare una semplice pagina Blade che presenti i dati finanziari (gainers/losers/most active e alcune quotes) utilizzando la Facade creata nell’esercizio sulle Facade.

Requisiti:
- Laravel 12
- Usare la Facade definita nell’esercizio `laravel/service-container/08-esercizio-facades` (TradingFinanceInfoFacade) che espone i metodi del contratto TradingFinanceInfoContract.
- View semplice, auto-consistente: inline CSS minimale nella pagina Blade.
- Nessuna dipendenza esterna (niente framework CSS).

Nota: L’esercizio si appoggia al lavoro svolto in “02-esercizio-trading-finance-info” e “08-esercizio-facades”. Assicurati di avere il binding del servizio e la Facade funzionanti.

---

## Traccia dell’esercizio (da svolgere)

1) Route web
- Aggiungi una route GET che mostri un’overview di mercato opzionalmente filtrabile per `market`:
  - URL: `/trading/overview/{market?}`
  - Parametro: `{market?}` con default `US` (usa l’enum Market del servizio se disponibile)

2) Recupero dati via Facade
- Nella closure della route usa la Facade per richiamare:
  - `TradingFinanceInfoFacade::getDailyGainers($market)`
  - `TradingFinanceInfoFacade::getDailyLosers($market)`
  - `TradingFinanceInfoFacade::getMostActives($market)`
  - Opzionale: `TradingFinanceInfoFacade::getQuotes($market, ...$symbols)` su una lista di simboli.

3) View Blade con CSS minimale inline
- Crea una view `resources/views/trading/overview.blade.php` con:
  - Un piccolo header e un selettore mercato (US / EU / ANY altri previsti dall’enum).
  - Tre colonne con tabelle: Gainers, Losers, Most Active.
  - Sezione “Quotes” con form GET per cercare uno o più simboli (separati da virgola).
  - Tutto lo stile in un tag `<style>` nella view.

4) Consegna
- Dimostra il funzionamento aprendo `/trading/overview` (default US) e cambiando mercato o cercando quote.

---

## Soluzione proposta (esempio completo)

Di seguito un esempio funzionante che puoi copiare nel tuo progetto.

### 1) Rotta (routes/web.php)

```php
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Service\TradingFinance\Market; // enum dall'esercizio precedente
use App\Facades\TradingFinanceInfoFacade; // la tua Facade custom (08-esercizio-facades)

Route::get('/trading/overview/{market?}', function (Request $request, ?Market $market = null) {
    // Default market
    $market = $market ?? Market::US;

    // Dati principali
    $gainers = TradingFinanceInfoFacade::getDailyGainers($market);
    $losers  = TradingFinanceInfoFacade::getDailyLosers($market);
    $actives = TradingFinanceInfoFacade::getMostActives($market);

    // Gestione quotes opzionali da query string (?q=AAPL,MSFT)
    $q = trim((string) $request->query('q', ''));
    $quotes = [];
    if ($q !== '') {
        $symbols = array_values(array_filter(array_map('trim', explode(',', $q))));
        if (!empty($symbols)) {
            $quotes = TradingFinanceInfoFacade::getQuotes($market, ...$symbols);
        }
    }

    return view('trading.overview', [
        'market' => $market,
        'gainers' => $gainers,
        'losers' => $losers,
        'actives' => $actives,
        'q' => $q,
        'quotes' => $quotes,
        'markets' => Market::cases(), // per il selettore
    ]);
})->name('trading.overview');
```

Note:
- Il type-hint `?Market $market` sfrutta il Route Model Binding per enum (Laravel 12 supporta casting verso enum backed). Se non funziona automaticamente, mappa manualmente: `$market = $market ?? Market::from(strtoupper($request->route('market', 'US')));`.

### 2) View Blade (resources/views/trading/overview.blade.php)

```blade
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trading Overview — {{ $market->name }}</title>
  <style>
    :root { --bg:#0f172a; --panel:#111827; --muted:#9ca3af; --ok:#16a34a; --bad:#dc2626; --acc:#38bdf8; }
    * { box-sizing: border-box; }
    body { margin:0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell; background: var(--bg); color: #e5e7eb; }
    header { padding:16px; border-bottom:1px solid #1f2937; }
    h1 { margin:0 0 4px; font-size:20px; }
    .muted { color: var(--muted); font-size: 12px; }
    .wrap { padding:16px; }
    .toolbar { display:flex; gap:12px; align-items:center; margin-bottom:16px; flex-wrap:wrap; }
    select, input[type=text], button { background:#0b1220; color:#e5e7eb; border:1px solid #1f2937; border-radius:6px; padding:8px 10px; }
    button { cursor:pointer; }
    .grid { display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap:12px; }
    .card { background: var(--panel); border:1px solid #1f2937; border-radius:10px; overflow:hidden; }
    .card h2 { margin:0; font-size:14px; letter-spacing:.3px; padding:10px 12px; border-bottom:1px solid #1f2937; }
    table { width:100%; border-collapse: collapse; font-size:13px; }
    th, td { padding:8px 10px; border-bottom:1px solid #1f2937; }
    th { text-align:left; color: var(--muted); font-weight:600; }
    .pos { color: var(--ok); }
    .neg { color: var(--bad); }
    .quotes { margin-top:16px; }
    .badge { font-size:11px; padding:2px 6px; border-radius:999px; border:1px solid #1f2937; color:#cbd5e1; }
    @media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body>
<header>
  <h1>Trading Overview — Mercato: {{ $market->name }}</h1>
  <div class="muted">Dati: gainers, losers, most active. Facade: TradingFinanceInfoFacade</div>
</header>
<div class="wrap">
  <form method="get" action="{{ route('trading.overview', ['market' => $market->name]) }}" class="toolbar">
    <label>
      Mercato
      <select name="market" onchange="location.href='{{ url('/trading/overview') }}/'+this.value">
        @foreach($markets as $m)
          <option value="{{ $m->name }}" @selected($m === $market)>{{ $m->name }}</option>
        @endforeach
      </select>
    </label>
    <label>
      Quotes (es: AAPL,MSFT,TSLA)
      <input type="text" name="q" value="{{ $q }}" placeholder="Simboli separati da virgola" />
    </label>
    <button type="submit">Cerca quotes</button>
    <span class="badge">{{ now()->format('H:i:s') }}</span>
  </form>

  <div class="grid">
    <section class="card">
      <h2>Top Gainers</h2>
      <table>
        <thead><tr><th>Symbol</th><th>Name</th><th class="pos">Change%</th></tr></thead>
        <tbody>
        @forelse($gainers as $row)
          <tr>
            <td>{{ $row['symbol'] ?? $row['ticker'] ?? '-' }}</td>
            <td>{{ $row['longName'] ?? $row['shortName'] ?? '-' }}</td>
            <td class="pos">{{ $row['regularMarketChangePercent'] ?? $row['changePercent'] ?? '?' }}%</td>
          </tr>
        @empty
          <tr><td colspan="3" class="muted">Nessun dato</td></tr>
        @endforelse
        </tbody>
      </table>
    </section>

    <section class="card">
      <h2>Top Losers</h2>
      <table>
        <thead><tr><th>Symbol</th><th>Name</th><th class="neg">Change%</th></tr></thead>
        <tbody>
        @forelse($losers as $row)
          <tr>
            <td>{{ $row['symbol'] ?? $row['ticker'] ?? '-' }}</td>
            <td>{{ $row['longName'] ?? $row['shortName'] ?? '-' }}</td>
            <td class="neg">{{ $row['regularMarketChangePercent'] ?? $row['changePercent'] ?? '?' }}%</td>
          </tr>
        @empty
          <tr><td colspan="3" class="muted">Nessun dato</td></tr>
        @endforelse
        </tbody>
      </table>
    </section>

    <section class="card">
      <h2>Most Active</h2>
      <table>
        <thead><tr><th>Symbol</th><th>Price</th><th>Vol</th></tr></thead>
        <tbody>
        @forelse($actives as $row)
          <tr>
            <td>{{ $row['symbol'] ?? $row['ticker'] ?? '-' }}</td>
            <td>{{ $row['regularMarketPrice'] ?? $row['price'] ?? '-' }}</td>
            <td>{{ $row['regularMarketVolume'] ?? $row['volume'] ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="3" class="muted">Nessun dato</td></tr>
        @endforelse
        </tbody>
      </table>
    </section>
  </div>

  <section class="card quotes">
    <h2>Quotes</h2>
    <table>
      <thead><tr><th>Symbol</th><th>Name</th><th>Price</th><th>Change%</th></tr></thead>
      <tbody>
      @forelse($quotes as $row)
        <tr>
          <td>{{ $row['symbol'] ?? '-' }}</td>
          <td>{{ $row['longName'] ?? $row['shortName'] ?? '-' }}</td>
          <td>{{ $row['regularMarketPrice'] ?? '-' }}</td>
          <td>{{ $row['regularMarketChangePercent'] ?? '-' }}%</td>
        </tr>
      @empty
        <tr><td colspan="4" class="muted">Inserisci uno o più simboli e premi "Cerca quotes"</td></tr>
      @endforelse
      </tbody>
    </table>
  </section>
</div>
</body>
</html>
```

Note sul layout dati:
- Le chiavi esatte degli array dipendono dal provider usato nell’esercizio TradingFinanceInfo. Nell’esempio vengono gestite varianti comuni (`symbol`/`ticker`, `longName`/`shortName`, `regularMarketChangePercent`/`changePercent`, ecc.) per rendere la view robusta.

---

## Spunti di verifica
- Cambia mercato dal selettore e verifica che le tre sezioni si aggiornino.
- Cerca più simboli contemporaneamente: `?q=AAPL,MSFT,TSLA`.
- Se hai implementato la versione “with cache” del servizio, verifica che ricaricando entro l’intervallo i dati arrivino dalla cache.

---

## Esercizi per i partecipanti
1) Aggiungi un indicatore visivo di trend: colora in verde/rosso l’intera riga in base al segno di Change%.
2) Aggiungi una colonna “Prev Close” nelle quotes, se disponibile; gestisci fallback “-” se mancante.
3) Crea una seconda view `/trading/compact/{market?}` con una sola tabella che unisca i top 5 gainers e top 5 losers, con colonne minime.
4) Migliora l’accessibilità: aggiungi attributi `aria-label` ai controlli del form e `scope="col"` alle intestazioni.

Suggerimento: mantieni lo stile inline e semplice, senza introdurre framework CSS esterni.

---

## Riferimenti
- Facade esercizio: `laravel/service-container/08-esercizio-facades/README.MD`
- Service Container esercizio (API Yahoo Finance via RapidAPI e caching): `laravel/service-container/02-esercizio-trading-finance-info/README.MD`
- Documentazione Blade (base e direttive): vedi moduli nella cartella `laravel/views`.
