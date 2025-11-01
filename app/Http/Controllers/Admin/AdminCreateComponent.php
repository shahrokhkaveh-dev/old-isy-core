<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Livewire\Component;

class AdminCreateComponent extends Component
{
    public function __construct()
    {

    }

    public function render(){
        return view('admin.panel.admins.create')->layout('admin.panel.layout.master');
    }
}
