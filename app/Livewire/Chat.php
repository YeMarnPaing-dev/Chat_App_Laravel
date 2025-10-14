<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
      public $users;
      public $selectedUser;
      public $newMessage;

        public function mount(){
            $this->users= User::whereNot('id',Auth::id())->get();
            $this->selectedUser=$this->users->first();
        }

         public function select($id)
    {
         $this->selectedUser= User::find($id);
    }

    public function submit(){
           if (!$this->newMessage) return;
        ChatMessage::create([
            'sender_id'=>Auth::id(),
            'receiver_id'=>$this->selectedUser->id,
            'message'=>$this->newMessage
        ]);

        $this->newMessage='';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
