<?php

namespace App\Livewire\users;

use Livewire\Component;

use App\Models\User;

class IndexUsers extends Component
{
    public $users;

    public $page = 1;
    public $perPage = 10;
    public $searchText = null;
    public $moreRecords = true;

    protected $listeners = [
        'addedUser' => 'getUsers',
        'editedUser' => 'getUsers'
    ];

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

    public function mount()
    {
        $this->getUsers();
    }

    public function updatedSearchText()
    {
        $this->getUsers();
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        $this->getUsers();
    }

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

    public function render()
    {
        return view('livewire.users.index-users');
    }
}
