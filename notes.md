## New Worktree
```./bin/worktree my-new-feature```
"my-new-feature" is the branch name

## Get Current Store
```php
public Store $store;

public function mount(): void
{
    $this->store = Store::find(app('currentStore'));
}
```
# Production with default location
```php artisan import:sds --dry-run```

# Development with custom file
```php artisan import:sds --file=storage/app/test-data.json --dry-run```

# Import with options
```php artisan import:sds --file=database/seeders/data/sds-data.json --chunkSize=1000 --skip-duplicates```

# Full import
```php artisan import:sds --update-duplicates```

## Tests 
- [ ] Logs page and livewire component
