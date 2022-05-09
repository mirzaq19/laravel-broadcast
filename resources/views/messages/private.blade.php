<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Chatting App</title>
</head>
<body>
<section class='bg-gray-900'>
    <div class='flex flex-col items-center min-h-screen py-16 space-y-8 text-white layout'>
        <h1 class="font-semibold text-3xl">Laravel Broadcasting with Private Channel </h1>
        <div class='w-full max-w-lg space-y-2'>
            <label for="message">Message:</label>
            <input
                type='text'
                id='message'
                placeholder='Write your message, then press enter.'
                class='w-full border border-gray-600 rounded-lg focus:ring-primary-400 p-4 text-gray-700'
            />
        </div>
        <div id="message-container" class='flex flex-col items-start w-full max-w-lg max-h-[36rem] overflow-y-auto'>
            {{-- Messages will be rendered here || Template--}}
        </div>
    </div>
</section>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    let username = prompt('Enter your name:');
    const channel = 'private';

    // Listen for new messages

    Echo.private('messages')
        .listen('MessageSent', (e) => {
            console.log(e);
            const message = e.message;
            const name = e.name;
            const html = `
                    <div class='flex py-2'>
                        <p class='flex items-center mr-2 font-semibold'>
                            <span class='inline-block'>${name}</span>:
                        </p>
                        <p>${message}</p>
                    </div>
                `;
            document.querySelector('#message-container').innerHTML += html;
        });

    const INPUT_MESSAGE = document.querySelector('#message');
    INPUT_MESSAGE.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            const MESSAGE = e.target.value;
            console.log(MESSAGE);
            e.target.value = '';
            // Broadcast message
            window.axios.post('/api/chat/send', {
                message: MESSAGE,
                name: username,
                channel: channel
            });
        }
    });
</script>
</body>
</html>
