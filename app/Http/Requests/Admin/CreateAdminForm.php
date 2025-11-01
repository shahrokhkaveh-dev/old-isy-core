<?php

namespace App\Http\Requests\Admin;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateAdminForm extends Form
{
    #[Validate('required|min:5|max:50|persian_alpha')]
    public $fname = '';

    #[Validate('required|min:5|max:50|persian_alpha')]
    public $lname = '';

    #[Validate('required|min:5|max:50|persian_alpha')]
    // public $lname = '';

    #[Validate('required|min:5|max:50|persian_alpha')]
    // public $lname = '';

    #[Validate('required|min:5|max:50|persian_alpha')]
    // public $lname = '';
}
