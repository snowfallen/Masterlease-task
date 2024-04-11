To build:

```
bash scripts/build.sh
```
*Press "yes" to create sqlite db*

To run: 
```
php artisan serve
```

**1. `MultiplicationTableController`:**

* The `__invoke` method is the request handler method.
    * It retrieves validated data from the request using `MultiplicationTableRequest`.
    * It calls the `getTable` method of the `MultiplicationTableService` to generate or retrieve the multiplication table.
    * It returns a JSON response with the obtained table.

**2. `MultiplicationTableRequest`:**

* The `authorize` method always allows the request.
* The `rules` method defines validation rules for the `size` parameter in the request.
    * The `size` parameter must be required (`required`), an integer (`integer`), and within the range of 1 to 100 (`between:1,100`).

**3. `MultiplicationTableService`:**

* It uses the singleton pattern to ensure that only one instance of the class exists.
    * `getInstance` returns the service instance.
    * `__construct` is a private constructor to prevent direct instantiation.
* `getTable` is the main method that generates or retrieves a multiplication table for a given size.
    * It delegates the work to `getCachedOrGenerateTable`.
* `getCachedOrGenerateTable` checks the cache for the existence of a table for the given size.
    * If the table is found, it returns it.
    * If the table is not found, it generates it using `generateTable` and stores it in the cache.
* `generateTable` performs the logic of generating a multiplication table for a given size.
    * It creates an array where each key is a row of the table, and the value is another array containing the values for each column.
