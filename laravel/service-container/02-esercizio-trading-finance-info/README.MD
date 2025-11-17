# Laravel Architecture Concepts: service container, service provider, dependency injection

L'esercizio qui proposto serve come esercitazione pratica per la comprensione dei concetti architetturali di Laravel:
- Service (E' semplicemente una classe che viene definita servizio specializzato per risolvere un problema, riferita dagli altri componenti)
- Service Container (Contenitore dei ``binding`` dei servizi registrati nell'app).
- Service Provider (Pattern/Componente che restituisce istanze dei servizi registrati su richiesta)
- Dependency Injection (Il meccanismo attraverso il quale si "forniscono/iniettano" le dipendenze ai componenti che ne hanno bisogno.

## Esercizio:

- Creare un Servizio (interfaccia più concretizzazione).
- Registrare il binding in ``AppServiceProvider``.
- Usare il servizio in una Route via DI.
- Test
- Aggiungere una nuova implementazione dell'interfaccia del servizio
- Cambiare il binding in ``AppServiceProvider``.
- Test

### Steps:

Procederemo alla creazione di un servizio che consente di ottenere le azioni che stanno "guadagnando di più" / "perdendo di più" o che in generale sono più ``attive``.

#### 1. Definizione di un nuovo "name space" in ``compose.json``
All'interno del file composer.json, ed in particolare in corrispondenza della proprietà ``autoload``, aggiungere il mapping ``"Service\\": "services/"`` come segue:

```json
"autoload": {
        "psr-4": {
            "App\\": "app/",
            
            "Service\\": "services/",
            
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
```

#### 2. Creiamo l'interaccia per il servizio (definiamo il comportamento del servizio)

Creare la cartella ``services`` nella root del progetto, e al suo interno creare la folder ``TradingFinance``.
Lavoreremo all'interno di questa folder.

```php
<?php

namespace Service\TradingFinance;

interface TradingFinanceInfoContract {

    public function getDailyGainers( Market $market ) : array;
    public function getDailyLosers( Market $market ) : array;
    public function getDailyMostActive( Market $market ) : array;
    public function getQuotes( Market $market, string ...$symbols ) : array;

}

```

L'interfaccia utilizza un ``enum`` che serve a guidare il client a fornire solo una voce "censita" come mercato.
Definiamolo:

```php
<?php

namespace Service\TradingFinance;

enum Market : string {

    case US = "US";
    case IT = "IT";

}

```

#### 3. Forniamo ora un'implementazione per l'interfaccia.

Creare il file ``TradingFinanceInfo.php`` che avrà il seguente contenuto:

```php
<?php

namespace Service\TradingFinance;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class TradingFinanceInfo implements TradingFinanceInfoContract {

    private string $host = "apidojo-yahoo-finance-v1.p.rapidapi.com";
    // get your own api key from RAPID API: https://rapidapi.com/apidojo/api/yahoo-finance1
    private string $rapidApiKey = "____LA_TUA_APPLICATION_KEY____";
    private string $baseUrl = 'https://apidojo-yahoo-finance-v1.p.rapidapi.com';

    public function getDailyGainers( Market $market = Market::US ) : array {

        return $this->getMovers( $market, Movers::Gainers );

    }

    public function getDailyLosers( Market $market = Market::US  ) : array {

        return $this->getMovers( $market, Movers::Losers );

    }

    public function getDailyMostActive( Market $market = Market::US  ) : array {

        return $this->getMovers( $market, Movers::MostActives );

    }

    public function getQuotes( Market $market, string ...$titles ) : array {

        $url = URL::format($this->baseUrl, 'market/v2/get-quotes');

        $headers = $this->getHeaders();

        $region = $market->name;

        $result = Http::withHeaders($headers)
                      ->withoutVerifying()
                      ->get($url,[
                          "region" => $region,
                          "symbols" => implode(",", $titles)
                      ]);

        if ($result->successful()){

            $rawQuotes = $result->object()->quoteResponse->result;

            return array_map(fn ($q) => $this->toTradingTitle($q), $rawQuotes);
        }

        return [];
    }

    private function getMovers( Market $market, Movers $movers ): array {

        $url = URL::format($this->baseUrl, 'market/v2/get-movers');
        $region = $market->name;
        $headers = $this->getHeaders();

        $result = Http::withHeaders($headers)
                      ->withoutVerifying()
                      ->get($url,[ "region" => $region ]);

        if ($result->successful()) {

            $records = $result->object()->finance->result;

            return $this->toResult($records, $market, $movers->value);

        }

        return  [];
    }

    private function toResult(array $rawRecords, Market $market, int $index) : array {

        if (array_key_exists( $index, $rawRecords )) {

            $meaningfulResults = $rawRecords[ $index ]->quotes;

            $symbols = array_map(fn ( $quote ) => $quote->symbol, $meaningfulResults);

            return $this->getQuotes($market, ...$symbols);
        }

        return [];
    }

    private function toTradingTitle( mixed $rawQuote ) : TradingQuote {

        $quote = new TradingQuote();

        $quote->symbol = $rawQuote->symbol;
        $quote->name = $rawQuote->longName;
        $quote->currency = $rawQuote->currency;
        $quote->fiftyTwoWeekRange = $rawQuote->fiftyTwoWeekRange;
        $quote->regularMarketDayHigh = $rawQuote->regularMarketDayHigh;
        $quote->regularMarketDayRange = $rawQuote->regularMarketDayRange;
        $quote->regularMarketPrice = $rawQuote->regularMarketPrice;
        $quote->regularMarketVolume = $rawQuote->regularMarketVolume;

        return $quote;
    }

    private function getHeaders(): array{
        return [
            "X-RapidAPI-Host" => $this->host,
            "X-RapidAPI-Key" => $this->rapidApiKey
        ];
    }
}


```

La ``TradingInfoFinance`` fa uso di un Enum chiamato ``Movers`` che come sopra è pensato per agevolare il chiamante di un metodo privato a fornire valori "censiti" dal metodo, e fa uso di un modello per rappresentare i dati in uscita ``TradingQuote``.
Andiamo a definirli (sempre nella stessa folder dove si trova la classe).

```php 
<?php

namespace Service\TradingFinance;

enum Movers: int {

    case Gainers = 0;
    case Losers = 1;
    case MostActives = 2;

}

```

E poi la TradingQuote.php (valido esempio di DTO - Data Transfer Object)

```php
<?php

namespace Service\TradingFinance;

class TradingQuote {

    public string $symbol;
    public string $name;
    public string $currency;
    public float $regularMarketPrice;
    public float $regularMarketDayHigh;
    public string $regularMarketDayRange;
    public float $regularMarketVolume;
    public string $fiftyTwoWeekRange;

}

```

#### 4. Registriamo ora un Binding nel AppServiceProvider.

In questo passo "insegnamo" a Laravel che tutte le volte che un client vuole un ``TradingFinanceInfoContract`` deve essere fornita una ``TradingFinanceInfo``.

Inserire le seguenti righe all'interno del file ``AppServiceProvider.php`` che potete trovare all'interno di ``app/Providers``.

```php

$this->app->bind(TradingFinanceInfoContract::class, function (){
    return new TradingFinanceInfo();
});

```

#### 5. Definiamo ora delle route via API restituiranno i dati forniti dal servizio.

Portarsi ora nel file ``api.php`` presente nella folder ``routes/`` ed aggiungere le seguenti linee.

```php

Route::get('trading/gainers/{market}',
    fn ( Market $market, TradingFinanceInfoContract $service ) => $service->getDailyGainers( $market )
);
Route::get('trading/losers/{market}',
    fn ( Market $market, TradingFinanceInfoContract $service ) => $service->getDailyLosers( $market )
);
Route::get('trading/actives/{market}',
    fn ( Market $market, TradingFinanceInfoContract $service ) => $service->getDailyMostActive( $market )
);
Route::get('trading/quotes/{market}/{quote}',
    fn ( Market $market, string $quote, TradingFinanceInfoContract $service ) => $service->getQuotes( $market, $quote )
);

```

#### 6. Testiamo il servizio via Postman.

Testiamo ora le route create attraverso [Postman](https://www.postman.com/) o un altro HTTP client.

Se tutti i passaggi sono andati bene le nostre api ritorneranno i dati provenienti dal servizio yahoo mediamente tra 1 e 3 secondi... Decisamente troppo tempo!! Dobbiamo quindi fornire un layer di cache per accelerare le risposte (e preservare il numero di richieste che vengono fatte al servizio Yahoo).

Nei passaggi successivi creiamo un'altra implementazione di TradingFinanceInfoContract, ma questa volta questa farà uso della cache.

#### 7. Creiamo una nuova implementazione, basata sulla precedente, ma in grado di "cachare" i risultati.

Creiamo un file come ``TradingFinanceInfoWithCache.php`` con il seguente codice:

```php 

<?php

namespace Service\TradingFinance;

use DateInterval;
use Illuminate\Support\Facades\Cache;

class TradingFinanceInfoWithCache extends TradingFinanceInfo implements TradingFinanceInfoContract{

    private string $interval = '30 seconds';

    public function getDailyGainers( Market $market = Market::US ): array {

        $cacheKey = "getDailyGainers_result_" . $market->name;

        return $this->fromCache( $cacheKey, fn() => parent::getDailyGainers( $market ) );
    }

    public function getDailyLosers( Market $market = Market::US ): array {

        $cacheKey = "getDailyLosers_result". $market->name;

        return $this->fromCache( $cacheKey, fn() => parent::getDailyLosers( $market ) );
    }

    public function getDailyMostActive( Market $market = Market::US ): array {

        $cacheKey = "getMostActives_result". $market->name;

        return $this->fromCache( $cacheKey, fn() => parent::getDailyMostActive( $market ) );
    }

    public function getQuotes( Market $market, string ...$titles ): array {

        $cacheKey = "getQuotes_result". $market->name . "_" . implode(",", $titles);

        return $this->fromCache( $cacheKey, fn() => parent::getQuotes( $market, ...$titles ) );
    }

    private function fromCache(string $key, callable $callable){

        if ( ! Cache::has( $key ) ) {

            $result = $callable();

            $interval = DateInterval::createFromDateString( $this->interval );

            Cache::set( $key, $result, $interval);

        }

        return Cache::get( $key );
    }
}


```

#### 8. Modifichiamo ora il binding per fare in modo che laddove si utilizza il servizio, venga utilizzata questa nuova versione.

```php

$this->app->bind(TradingFinanceInfoContract::class, function (){
    return new TradingFinanceInfoWithCache();
});

```


### Nota bene:
In questo esercizio faremo uso di una API fornita dal servizio [RapidApi](https://rapidapi.com/hub).
Si consiglia di registrarsi al servizio (è gratuito) e di utilizzare l'API [Yahoo Finance](https://rapidapi.com/apidojo/api/yahoo-finance1)
E' necessario possedere una chiave ``Application Key`` per il servizio Yahoo Finance.