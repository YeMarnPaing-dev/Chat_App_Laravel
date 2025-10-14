<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
      public $users;
      public $selectedUser;

        public function mount(){
            $this->users= User::whereNot('id',Auth::id())->get();
            $this->selectedUser=$this->users->first();
        }

         public function select($id)
    {
         $this->selectedUser= User::find($id);
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
