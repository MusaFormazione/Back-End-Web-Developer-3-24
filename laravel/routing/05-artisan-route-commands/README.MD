# 05 — Comandi Artisan per le route

Obiettivo: usare i comandi Artisan per ispezionare, ottimizzare e debug del routing.

Comandi principali
- php artisan route:list
  - Filtri: --name=actors, --path=actors, --columns=Method,URI,Name,Action,Middleware
- php artisan route:cache    // crea cache delle route (prod)
- php artisan route:clear    // rimuove cache

Esempi
```bash
php artisan route:list --columns=Method,URI,Name,Action,Middleware
php artisan route:list --name=actors
php artisan route:list --path=films
```

Note
- La cache fallisce se ci sono closure nelle route. Usa controller methods.
- Dopo una modifica alle route in prod: route:cache.

Esercizi
1) Esegui route:list e individua le rotte con prefix /api.
2) Abilita la cache delle route, verifica i tempi di bootstrap con e senza cache.
3) Usa --columns per visualizzare solo Method,URI,Name e incolla lo screenshot nel report del corso.
