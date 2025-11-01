<?php

namespace App\Livewire\Forms\Auth;

use Livewire\Attributes\Validate;
use Livewire\Form;

class RegisterForm extends Form
{
    #[Validate('required|min:5|max:50')]
    public $first_name = '';

    #[Validate('required|min:5|max:50')]
    public $last_name = '';

    public $identificationCode = '';
}
