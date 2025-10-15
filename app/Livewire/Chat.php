<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Events\MessageSent;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $users;
    public $selectedUser;
    public $newMessage;
    public $messages;
    public $authId;
    public $loginId;

    public function mount()
    {
        $this->authId = Auth::id();
        $this->loginId = $this->authId;

        $this->users = User::where('id', '!=', $this->authId)
            ->latest()
            ->get();

        $this->selectedUser = $this->users->first();
        if ($this->selectedUser) {
            $this->loadMessages();
        }
    }

    public function select($id)
    {
        $this->selectedUser = User::find($id);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->selectedUser) return;

        $this->messages = ChatMessage::query()
            ->where(function ($q) {
                $q->where('sender_id', $this->authId)
                  ->where('receiver_id', $this->selectedUser->id);
            })
            ->orWhere(function ($q) {
                $q->where('sender_id', $this->selectedUser->id)
                  ->where('receiver_id', $this->authId);
            })
            ->get();
    }

    public function submit()
    {
        if (!$this->newMessage || !$this->selectedUser) return;

        $message = ChatMessage::create([
            'sender_id' => $this->authId,
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->newMessage,
        ]);

        $this->messages->push($message);
        $this->newMessage = '';

        broadcast(new MessageSent($message));
    }

    // ✅ FIXED: Use string concatenation instead of placeholders
    public function getListeners()
    {
        return [
            "echo-private:chat.{$this->loginId},MessageSent" => 'newChatMessageNotification',
        ];
    }

    public function newChatMessageNotification($message)
    {
        if ($message['sender_id'] == $this->selectedUser->id) {
            $messageObj = ChatMessage::find($message['id']);
            if ($messageObj) {
                $this->messages->push($messageObj);
            }
        }
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
