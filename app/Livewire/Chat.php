<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\ChatMessage;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
    public $users;
    public $selectedUser;
    public $newMessage = '';
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

        if ($this->users->isNotEmpty()) {
            $this->selectedUser = $this->users->first();
            $this->loadMessages();
        }
    }

    public function select($id)
    {
        $this->selectedUser = User::findOrFail($id);
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
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function submit()
    {
        if (empty(trim($this->newMessage)) || !$this->selectedUser) return;

        $message = ChatMessage::create([
            'sender_id' => $this->authId,
            'receiver_id' => $this->selectedUser->id,
            'message' => trim($this->newMessage),
        ]);

        $this->messages->push($message);
        $this->newMessage = '';

        // Safely broadcast message
        broadcast(new MessageSent($message))->toOthers();
    }

    public function getListeners()
    {
        return [
            "echo-private:chat.{$this->loginId},MessageSent" => 'newChatMessageNotification',
        ];
    }

    public function newChatMessageNotification($message)
    {
        if ($this->selectedUser && $message['sender_id'] == $this->selectedUser->id) {
            $messageObj = ChatMessage::find($message['id']);
            if ($messageObj) {
                $this->messages->push($messageObj);
            }
        }
    }

    public function updatedNewMessage($value)
    {
        if (!$this->selectedUser) return;

        $this->dispatch('userTyping', [
            'userId' => $this->loginId,
            'userName' => Auth::user()->name ?? "User {$this->loginId}",
            'selectedUserId' => $this->selectedUser->id,
        ]);
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
