<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reaction</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <main>
        <div class="flex justify-center items-center h-screen">
            <button id="heart" class="reaction-button">
                ❤️
            </button>
            <button id="fire" class="reaction-button">
                🔥
            </button>
            <button id="rocket" class="reaction-button">
                🚀
            </button>
        </div>
    </main>

    <script type="module">
        function flyEmoji(emoji, button) {
            const rect = button.getBoundingClientRect();
            const flyEmoji = document.createElement('div');
            flyEmoji.innerText = emoji;
            flyEmoji.style.position = 'fixed';
            flyEmoji.style.left = `${rect.left + rect.width / 2}px`;
            flyEmoji.style.top = `${rect.top + rect.height / 2}px`;
            flyEmoji.style.transition = 'all 1s ease-out';
            flyEmoji.style.fontSize = '3rem';
            flyEmoji.style.pointerEvents = 'none';

            document.body.appendChild(flyEmoji);

            setTimeout(() => {
                flyEmoji.style.top = `${rect.top - rect.height}px`;
                flyEmoji.style.opacity = 0;
                flyEmoji.style.transform = 'translate(-50%, -50%) scale(2)';
            }, 10);

            setTimeout(() => {
                flyEmoji.remove();
            }, 1000);
        }

        window.Echo.channel('reaction').listen('ReactedEvent', (e) => {
            flyEmoji(e.reaction, document.getElementById(e.buttonId));
        })
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                flyEmoji(button.innerText, button);
                console.log(`Reaction ${button.getAttribute('id')} ${button.innerText}`);
                window.axios.post('/reaction', {
                    buttonId: button.getAttribute('id'),
                    reaction: button.innerText,
                })
            });
        });
    </script>
</body>

</html>
