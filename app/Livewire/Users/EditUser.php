<?php

namespace App\Livewire\Users;

use Livewire\Component;

use App\Models\User;

class EditUser extends Component
{
    public string $name;
    public string $email;

    public User|null $user;

    protected $listeners = [
        'editUser' => 'editUser',
    ];

    /**
     * Define the validation rules for the Livewire component.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ];
    }

    /**
     * Perform initial setup when the Livewire component is mounted.
     *
     * Initializes the Livewire component's state with the provided user, if any.
     *
     * @param  \App\Models\User|null  $user The user to initialize
     * @return void
     */
    public function mount($user = null)
    {
        $this->user = $user;
    }

    /**
     * Edit a user.
     *
     * Sets the current user for editing, initializes form fields with user data,
     * and triggers the opening of the modal for editing.
     *
     * @param  \App\Models\User  $user The user to edit
     * @return void
     */
    public function editUser(User $user)
    {
        $this->user = $user;

        $this->name = $this->user->name;
        $this->email = $this->user->email;

        $this->dispatch('open-modal');
    }

    /**
     * Process form submission to edit a user.
     *
     * @return void
     */
    public function submit()
    {
        $this->validate();

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->save();

        $this->dispatch('close-modal');
        $this->dispatch('editedUser');
    }

    /**
     * Render the Livewire component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.users.edit-user');
    }
}
