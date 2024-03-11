<?php

namespace App\Livewire\users;

use Livewire\Component;

use App\Models\User;

class IndexUsers extends Component
{
    public $users;

    public int $page = 1;
    public int $perPage = 10;
    public string|null $searchText = null;
    public bool $moreRecords = true;

    protected $listeners = [
        'addedUser' => 'getUsers',
        'editedUser' => 'getUsers'
    ];

    /**
     * Retrieve users based on search criteria.
     *
     * Retrieves users from the database based on the current search text
     * and sets the users collection accordingly.
     *
     * @return void
     */
    public function getUsers()
    {
        $this->moreRecords = true;

        $usersQuery = User::query();

        if ($this->searchText) {
            $usersQuery->searchText($this->searchText);
        }

        $totalCount = $usersQuery->count();
        $this->users = $usersQuery->latest()->limit($this->perPage)->get();

        if ($this->users->count() >= $totalCount) {
            $this->moreRecords = false;
        }
    }

    /**
     * Perform initial setup when the Livewire component is mounted.
     *
     * Retrieves the initial list of users from the database.
     *
     * @return void
     */
    public function mount()
    {
        $this->getUsers();
    }

    /**
     * Handle updates to the search text.
     *
     * Updates the users list when the search text is updated.
     *
     * @return void
     */
    public function updatedSearchText()
    {
        $this->getUsers();
    }

    /**
     * Delete a user.
     *
     * Deletes the specified user from the database and refreshes the users list.
     *
     * @param  \App\Models\User  $user The user to delete
     * @return void
     */
    public function deleteUser(User $user)
    {
        $user->delete();
        $this->getUsers();
    }

    /**
     * Load more users and append them to the existing collection.
     *
     * This method increases the page number, retrieves additional users based on the current page
     * and search criteria, and appends them to the existing users collection.
     *
     * @return void
     */
    public function loadMore()
    {
        $this->page += 1;

        $offset = ($this->page - 1) * $this->perPage;

        $usersQuery = User::query();

        if ($this->searchText) {
            $usersQuery->searchTextOn($this->searchText);
        }

        $totalCount = $usersQuery->count();
        $nextusers = $usersQuery->latest()->offset($offset)->limit($this->perPage)->get();

        $this->users = $this->users->concat($nextusers);

        if ($this->users->count() >= $totalCount) {
            $this->moreRecords = false;
        }
    }

    /**
     * Render the Livewire component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.users.index-users');
    }
}
