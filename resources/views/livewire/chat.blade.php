<div>
     <flux:heading size="xl" level="1">{{ __('Chat') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your profile and account settings') }}</flux:subheading>
    <flux:separator variant="subtle" />



<div class="flex h-[90vh] bg-gray-50 rounded-lg shadow-md overflow-hidden">

    <!-- Sidebar -->
    <div class="w-1/4 border-r bg-white flex flex-col">
        <!-- Sidebar Header -->
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-700">Users</h2>
        </div>

        <!-- User List -->
        <div class="flex-1 overflow-y-auto">
            @foreach ($users as $user)
                <div wire:click="select({{$user->id}})"
                    class="flex items-center gap-3 p-4 hover:bg-blue-50 cursor-pointer border-b transition duration-200"
                >
                    <!-- User Avatar -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-semibold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <!-- User Info -->
                    <div class="flex flex-col">
                        <p class="font-medium text-gray-800 leading-tight">
                            {{ $user->name }}
                        </p>
                        <p class="text-sm text-gray-500 truncate max-w-[180px]">
                            {{ $user->email }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Chat Window -->
    <div class="flex-1 flex flex-col bg-gray-50">
        <div class="p-4 border-b bg-white flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">{{$selectedUser->name}}</h3>
                <p class="text-sm text-gray-500">{{$selectedUser->email}}</p>
            </div>
        </div>

    <div id="chat-box" class="flex-1 overflow-y-auto p-6 space-y-3 bg-white">
    @foreach ($messages as $message)
        <div class="flex {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
            <div class="px-4 py-2 rounded-2xl max-w-xs break-words
                        {{  $message->sender_id == Auth::id()
                            ? 'bg-blue-500 text-white rounded-br-none'
                            : 'bg-gray-200 text-gray-800 rounded-bl-none' }}">
                {{ $message->message }}
            </div>
        </div>
    @endforeach
</div>

<div id="typing-indicator" class="px-4 pb-1 text-xs text-gray-400 italic"></div>


        <div class="p-4 bg-white border-t">
            <form wire:submit="submit" id="chat-form" class="flex items-center space-x-2">
                <input
                    wire:model.live="newMessage"
                    type="text"
                    id="message-input"
                    placeholder="Type your message..."
                    class="flex-1 border text-black border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                >
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full"
                >
                    Send
                </button>
            </form>
        </div>
    </div>
</div>



<!-- Optional JS -->
{{-- <script>
    const form = document.getElementById('chat-form');
    const input = document.getElementById('message-input');
    const chatBox = document.getElementById('chat-box');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;

        const msgDiv = document.createElement('div');
        msgDiv.className = 'flex justify-end';
        msgDiv.innerHTML = `<div class="bg-blue-500 text-white px-4 py-2 rounded-lg max-w-xs">${message}</div>`;

        chatBox.appendChild(msgDiv);
        chatBox.scrollTop = chatBox.scrollHeight;
        input.value = '';
    });
</script> --}}



</div>
