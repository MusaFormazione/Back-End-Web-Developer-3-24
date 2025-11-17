# Laravel Architecture Concepts: facade

L'esercizio proposto serve come esercitazione pratica per la comprensione dei concetti architetturali di Laravel:
- Facade

## Esercizio:

- Creare un Servizio per interagire con un servizio di cui si è definito il binding nel Service Contaainer

### Pre-requisiti

Per procedere alla creazione di una Facade si deve aver registrato un servizio nel ``Service Container`` di Laravel.
Questo esercizio è basato sull'esercitazione [Laravel Architecture Concepts: service container, service provider, dependency injection](https://gist.github.com/antonio8101/8d4d5b5117169cfdd1428f90337aa83f).

### Steps:

#### 1. Creare un classe che estenda ```Illuminate\Support\Facades\Facade```

```php

class TradingFinanceInfoFacade extends Facade {

//

}

```

#### 2. Fare l'override del metodo ```protected static function getFacadeAccessor()```

#### 3. Restituire (con il return) il riferimento al ```Contratto``` definito nel ```binding```

```php

class TradingFinanceInfoFacade extends Facade {

    protected static function getFacadeAccessor() {
        
        return TradingFinanceInfoContract::class;
        
    }

}

```

#### 4. A questo punto si potrà utilizzare dove si vuole la nostra nuova Facade. I metodi esposti dal contratto saranno disponibili come metodi ```statici```

```php

Route::get('/trading/gainers/{market}', fn( Market $market ) => TradingFinanceInfoFacade::getDailyGainers( $market ) );

Route::get('/trading/losers/{market}', fn( Market $market ) => TradingFinanceInfoFacade::getDailyLosers( $market ) );

Route::get('/trading/actives/{market}', fn( Market $market ) => TradingFinanceInfoFacade::getMostActives( $market ) );

Route::get('/trading/quotes/{market}/{quote}', fn( Market $market, string $quote ) => TradingFinanceInfoFacade::getQuotes( $market, $quote ) );

```

#### 5. Per agevolare l'utilizzo della nostra Facade, possiamo poi una fornire descrizione per ogni metodo nel ```phpdoc``` della classe

```php

/**
 * @method static getDailyGainers( Market $market )
 * @method static getDailyLosers( Market $market )
 * @method static getMostActives( Market $market )
 * @method static getQuotes( Market $market, string $quote )
 */
class TradingFinanceInfoFacade extends Facade {

    protected static function getFacadeAccessor() {
        
        return TradingFinanceInfoContract::class;
        
    }

}

```