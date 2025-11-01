<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Livewire\Component;

class AdminComponent extends Component
{
    public function __construct()
    {

    }

    public function render(){
        return view('admin.panel.admins.index')->layout('admin.panel.layout.master');
    }
}
