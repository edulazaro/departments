<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Illuminate\Support\Str;

use App\Models\User;

class AddUser extends Component
{
    public $name;
    public $email;

    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
        ];
    }

    public function submit()
    {
        $this->validate();

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Str::password();
        $user->role = 'user';
        $user->save();

        $this->dispatch('close-modal');
        $this->dispatch('addedUser');
    }

    public function render()
    {
        return view('livewire.users.add-user');
    }
}
