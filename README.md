# Zadanie rekrutacyjne dla firmy FORMAT
### by Paweł "Grzyb9k" Grzyb

## SETUP

Uruchamiamy w konsoli/terminalu następujące polecenia:
```
git clone https://github.com/Grzyb9k/RT-Format
```
```
cd RT-Format
```
```
composer install
```
```
npm install
```

```
cp .env.example .env
```
Po tym kroku należy zaktualizować ustawienia bazy danych w pliku .env

``` 
php artisan key:generate
```

Uruchamiamy migrację razem z demonstracyjnymi danymi:
``` 
php artisan migrate:fresh --seed
```
I uruchamiamy aplikację:
``` 
php artisan serve
```

