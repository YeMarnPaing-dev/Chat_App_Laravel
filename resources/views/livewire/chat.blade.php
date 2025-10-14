<div>
     <flux:heading size="xl" level="1">{{ __('Chat') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your profile and account settings') }}</flux:subheading>
    <flux:separator variant="subtle" />



<div class="flex h-[90vh] bg-gray-50 rounded-lg shadow-md overflow-hidden">

    <!-- Sidebar -->
    <div class="w-1/4 border-r bg-white flex flex-col">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-700">Users</h2>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="p-4 hover:bg-gray-100 cursor-pointer border-b">
                <p class="font-medium text-gray-800">Test User</p>
                <p class="text-sm text-gray-500">test@gmail.com</p>
            </div>
        </div>
    </div>

    <!-- Chat Window -->
    <div class="flex-1 flex flex-col bg-gray-50">
        <!-- Chat Header -->
        <div class="p-4 border-b bg-white flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Test User</h3>
                <p class="text-sm text-gray-500">test@gmail.com</p>
            </div>
        </div>

        <!-- Messages -->
        <div id="chat-box" class="flex-1 overflow-y-auto p-6 space-y-3 bg-white">
            <div class="flex justify-end">
                <div class="bg-blue-500 text-white px-4 py-2 rounded-lg max-w-xs">
                    Hi, This is test
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="p-4 bg-white border-t">
            <form id="chat-form" class="flex items-center space-x-2">
                <input
                    type="text"
                    id="message-input"
                    placeholder="Type your message..."
                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200"
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
