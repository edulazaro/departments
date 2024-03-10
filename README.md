
This small Laravel/Livewire App allows to manage users and departmetns.

## How to install

1. Clone the repository.
2. Execute `composer install` to install the PHP dependencies.
3. Execute `npm install` to install JavaScript dependencies.
3. Run the migrations with the command `php artisan migrate`.
4. To start with some data, execute the command `php artisan db:seed`
5. You can now access the app with the email `test@test.com` and the password `testpass`.

## Testing

To run the tests against a memory database, execute the command `php artisan test`;

## App structure

The app has two sections, departments and users.

### Departments

This view shows a table with all the departments. The name is used as a search field.

* **Creating user**: Click the `Add New` button to open the new user modal. Enter a name name and the email.
* **Deleting a user**: Click the dropdown on the right of any user and then click the `Delete` button. If the user was assigned to any department, the relation will be removed.
* **Editing a user**: Click the dropdown on the right of any user and then click the `Edit` button. You can update the name and the email of the user here.
* **Adding a user to a department**: Click the dropdown on the right of any user and then click the `Departments` button. You can select and add a department to the user here.
* **Removing a user from a department**: Click the dropdown on the right of any user and then click the `Departments` button. You will see the list of departments here. Click the `Remove` button to remove the user from the desired department.

## License

This project and Laravel framework are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).