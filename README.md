# Mini Customer Management App

Week 1 PHP Lab project (PHP arrays, functions, conditionals, filtering, statistics).

## Environment Check
```bash
php --version
composer --version
git --version
```

## Run
```bash
php -S localhost:8000 -t public
```
Open: http://localhost:8000

## Extra Features
- Filter by status: `VIP`, `Active`, `New`
- Search by customer name or email
- Sort by spent amount or customer name
- Implemented with GET query + `array_filter()` + `usort()`
