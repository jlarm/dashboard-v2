## Get Current Store
```php
public Store $store;

public function mount(): void
{
    $this->store = Store::find(app('currentStore'));
}
```
