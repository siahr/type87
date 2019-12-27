# 八十七式躯体 (Type87 framework)
Packaged framework based on Slim3.

## Included package
 * slim/slim 
 * illuminate/database
    * If you need to use DB facade, `use Illuminate\Database\Capsule\Manager as DB;` or `db()::select("...")`. 
 * rubellum/slim-blade-view
 * andrewdyer/slim3-session-middleware
 * laravel/helpers
 * maximebf/debugbar
 * dopesong/slim-whoops
 * vlucas/phpdotenv
 ### Other implements
 * flash session handling (like the `laravel`)

## Usage
 1. Clone this repository.
 2. Execute `composer update`
 3. Deploy on your Web server (already fixed slim3 sub-directory issue).
 4. Enjoy!