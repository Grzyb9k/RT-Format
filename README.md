# Zadanie rekrutacyjne dla firmy FORMAT
### by Paweł "Grzyb9k" Grzyb

## SETUP

Uruchamiamy w konsoli/terminalu następujące polecenia:
```bash
git clone https://github.com/Grzyb9k/RT-Format
```
```bash
cd RT-Format
```
```bash
composer install
```
```bash
npm install
```

```bash 
cp .env.example .env
```
Po tym kroku należy zaktualizować ustawienia bazy danych w pliku .env

```bash 
php artisan key:generate
```

Uruchamiamy migrację razem z demonstracyjnymi danymi:
```bash 
php artisan migrate:fresh --seed
```



