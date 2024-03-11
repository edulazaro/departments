<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Illuminate\Support\Str;

use App\Models\User;

class AddUser extends Component
{
    public string $name;
    public string $email;

    /**
     * Define the validation rules for the Livewire component.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
        ];
    }

    /**
     * Process form submission to create a new user.
     *
     * @return void
     */
    public function submit()
    {
        $this->validate();

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Str::password();
        $user->role = 'user';
        $user->save();

        $this->name = '';
        $this->email = '';

        $this->dispatch('close-modal');
        $this->dispatch('addedUser');
    }

    /**
     * Render the Livewire component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.users.add-user');
    }
}
