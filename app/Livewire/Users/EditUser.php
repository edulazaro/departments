<?php

namespace App\Livewire\Users;

use Livewire\Component;

use App\Models\User;

class EditUser extends Component
{
    public $name;
    public $email;

    public $user;

    protected $listeners = [
        'editUser' => 'editUser',
    ];

    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ];
    }

    public function mount($user = null)
    {
        $this->user = $user;
    }

    public function editUser(User $user)
    {
        $this->user = $user;

        $this->name = $this->user->name;
        $this->email = $this->user->email;

        $this->dispatch('open-modal');
    }

    public function submit()
    {
        $this->validate();

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->save();

        $this->dispatch('close-modal');
        $this->dispatch('editedUser');
    }

    public function render()
    {
        if (!$this->user) {
            $this->skipRender();
        }

        return view('livewire.users.edit-user');
    }
}
