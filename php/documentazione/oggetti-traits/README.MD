# Traits

PHP offre una metodologia speciale per facilitare il riuso del codice tra le classi: i traits:

- **Traits**: forniscono implementazioni concrete di metodi che possono essere riutilizzate in diverse classi.

Ecco un esempio di trait:

```php
trait MyTrait {
    public function sum($num1, $num2): string {
        return $num1 + $num2;
    }
}

class Math implements ICalculateAbs {
    use MyTrait; // Utilizzo del trait
    
    public function abs(float|int $number): int|float {
        return abs($number);
    }
}
```

In questo esempio, la classe `Math` implementa l'interfaccia `ICalculateAbs` e utilizza il trait `MyTrait`. L'interfaccia definisce cosa la classe deve fare, mentre il trait fornisce funzionalità aggiuntive.