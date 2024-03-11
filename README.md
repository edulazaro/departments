
This small Laravel/Livewire App allows to manage users and departments.

## How to install

1. Clone the repository.
2. Execute `composer install` to install the PHP dependencies.
3. Execute `npm install` to install JavaScript dependencies.
4. Copy the `.env.example` file, rename it as `.env` and add the database configuration values.
5. Run the migrations with the command `php artisan migrate`.
6. To start with some data, execute the command `php artisan db:seed`

You can now access the app with the email `test@test.com` and the password `testpass`.

## Testing

To run the tests against a memory database, execute the command `php artisan test`;

## Running

To run the App on development, execute the command `php artisan serve` to start the development server and `npm run dev` to start Vite. The app will start on the port **8000** by default.

## App structure

The app has two sections, departments and users.

### Departments

This view shows a table with all the departments. The `name` field is used as a search field.

* **Creating department**: Click the `Add New` button to open the new user modal. Enter a demartment name and optionally select the parent department.
* **Deleting a department**: Click the dropdown on the right of any department and then click the `Delete` button. If the department has child departments, they will be detached when deleted via the `deleting` event.
* **Editing a department**: Click the dropdown on the right of any department and then click the `Edit` button. You can update the name and the parent department here, and also remove child departments, if any.

### Users

This view shows a table with all the users. The `search_text` field is used as a search field.

* **Creating user**: Click the `Add New` button to open the new user modal. Enter a name and the email of the user.
* **Deleting a user**: Click the dropdown on the right of any user and then click the `Delete` button. If the user was assigned to any department, the relation will be removed.
* **Editing a user**: Click the dropdown on the right of any user and then click the `Edit` button. You can update the name and the email of the user here.
* **Adding a user to a department**: Click the dropdown on the right of any user and then click the `Departments` button. You can select and add a department to the user here.
* **Removing a user from a department**: Click the dropdown on the right of any user and then click the `Departments` button. You will see the list of departments here. Click the `Remove` button to remove the user from the desired department.

## Possible improvements

The number of users and departments might grow. Here are some improvements:

* When selecting a user or a department, a dynamic select with a search field can be added. Here is a personal project where I do this when selecting developers or editors when [adding games](https://duracionde.com/juegos/create).

* If the number of users goes beyond 100k, a full text index will be better suited so MySQL does not decide to skip indexes on paginated results. On the same project there's [another example](https://duracionde.com/juegos) where I do it. Another [example here](https://horseandcountry.tv/search) when searching on millions of records.

## License

Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
