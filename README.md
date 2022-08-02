## Installation
To begin, run the following command to download the project using Git:
```
git clone https://github.com/Msalah11/laravel-repository-pattern.git
```
Next, move into the new project’s folder and install all its dependencies:
```
// move into the new folder
cd news

//install dependencies
composer install
```
Next, create a `.env` file at the root of the project and populate it with the content found in the .env.example file. You can do this manually or by running the command below:
```
cp .env.example .env
```
Create a `database.sqlite` file in the `database` folder, replace the database environment variables
```
DB_CONNECTION=sqlite
```
Now generate the Laravel application key for this project with:
```
php artisan key:generate
```
Then run 
```
// Migrate database table
php artisan migrate

// Seed database table
php artisan db:seed
```
Lastly, use the following command to run PHPUnit
```
composer test
```
