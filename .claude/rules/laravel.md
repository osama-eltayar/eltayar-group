# Laravel Rules

Rules for working with Laravel Framework
- the app based on laravel 11 version 
- use laravel naming convention 

##  Model
- model should has fillable for columns 
- column for status or type should casts to enum 
- relation should has return type 

## Migration
- date column should be in the past prefixed with _at like finsished_at
- always add new column before created_at 
- migrations must only change schema (create/alter/drop tables and columns) — never update or transform existing row data inside a migration
- if existing data needs to be backfilled or transformed, create a dedicated Artisan command for it instead

## Dates
- dates are always displayed as DD/MM/YYYY and times as HH:mm:ss (datetimes as DD/MM/YYYY HH:mm:ss)
- this is enforced globally for Filament tables and infolists via `Table::configureUsing()` / `Schema::configureUsing()` in `app/Providers/AppServiceProvider.php` — do not override the format on individual `->date()`/`->dateTime()`/`->time()` calls unless a field genuinely needs a different format
- only datetime values are converted to the user's timezone (via `FilamentTimezone::set()`, also in `AppServiceProvider`); plain date-only values are not timezone-converted, since a date has no time component to shift

