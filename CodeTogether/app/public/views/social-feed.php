<!DOCTYPE html>
<html lang="en">

<!-- 
Most of this was made using ai, need to add more documentation along probably 
gutting out the style sheet and java script into separate folders for global project use.
Will make the site's style more consistent :)
But otherwise it works and looks cool, need to also hook it up to the server and database asap.
Seth W-->

<!--THINGS TO DO
-Connect posts to the database, and allow the server to retrieve the posts for the user.
-Need to add username as well as pfp to posts.
-Need to add ability to attach images to posts and save them to the database.
-Need to probably make some sort of integration for the main page, not sure how we want it
    but it is probably good that we keep it separate maybe? We'll see.
-Add ability to delete or edit posts.
-Add buttons/functions for ease of styling the text in posts for more creative users.
-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Together Feed</title>
    <style>
        /* --- Basic & Matrix Background Styling --- */
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #000;
            color: #0f0;
            /* Green text */
            margin: 0;
            padding: 40px 20px;
            overflow-x: hidden;
            /* Prevent horizontal scroll */
        }

        #matrix-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            /* Puts canvas in the background */
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            /* Ensure it's on top of the canvas */
            z-index: 1;
        }

        .fading-heading {
            text-shadow:
                0 0 5px #000,
                /* A small, sharp shadow */
                0 0 10px #000,
                /* A slightly larger, softer shadow */
                0 0 15px #000;
            /* An even larger, very soft shadow */
        }

        h1 {
            text-align: center;
            text-shadow: 0 0 5px #0f0;
        }

        /* --- "Create Post" Button --- */
        #show-modal-btn {
            display: block;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            color: #0f0;
            border: 1px solid rgba(0, 255, 0, 0.5);
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            border-radius: 4px;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 30px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        #show-modal-btn:hover {
            background-color: rgba(0, 255, 0, 0.2);
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.75);
        }

        /* --- Modal (Pop-up) Styling --- */
        .modal-overlay {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: rgba(0, 0, 0, 0.8);
            padding: 25px;
            border: 1px solid rgba(0, 255, 0, 0.5);
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            border-radius: 5px;
            position: relative;
            width: 90%;
            max-width: 500px;
        }

        .modal-content h2 {
            text-align: center;
            text-shadow: 0 0 5px #0f0;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: #0f0;
            text-shadow: 0 0 5px #0f0;
        }

        /* --- Post Creation Form (inside the modal) --- */
        #post-input {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid rgba(0, 255, 0, 0.5);
            background-color: rgba(0, 0, 0, 0.5);
            color: #0f0;
            font-family: 'Courier New', Courier, monospace;
            resize: vertical;
            box-sizing: border-box;
        }

        #post-input:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 255, 0, 0.75);
        }

        #submit-btn {
            display: block;
            width: 100%;
            background-color: #0c0;
            color: #000;
            border: 1px solid #0c0;
            border-radius: 4px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        #submit-btn:hover {
            background-color: #0a0;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.75);
        }

        /* --- Post Feed Styling --- */
        .post-feed {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .post {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid rgba(0, 255, 0, 0.5);
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            backdrop-filter: blur(5px);
            border-radius: 5px;
            padding: 20px;
        }

        .post-content {
            font-size: 1.1em;
            line-height: 1.5;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .post-timestamp {
            font-size: 0.8em;
            color: #0a0;
            margin-top: 15px;
            text-align: right;
        }
    </style>
</head>

<body>

    <canvas id="matrix-canvas"></canvas>

    <div class="container">
        <h1 class="fading-heading">Code Together<br>-Posts-</h1>
        <button id="show-modal-btn">>> Create Transmission</button>

        <div class="post-feed" id="post-feed-container">
        </div>
    </div>

    <div id="post-modal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>New Transmission</h2>
            <form id="post-form">
                <textarea id="post-input" placeholder="Enter your message..." required></textarea>
                <button type="submit" id="submit-btn">Transmit</button>
            </form>
        </div>
    </div>

    <script>
        // --- Matrix Background Animation ---
        const canvas = document.getElementById('matrix-canvas');
        const context = canvas.getContext('2d');

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const katakana = ''; //'アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
        const latin = ''; //'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numbers = '01'; //'0123456789';
        const alphabet = katakana + latin + numbers;
        const characters = alphabet.split('');

        const fontSize = 32;
        const columns = Math.floor(canvas.width / fontSize);
        const drops = Array(columns).fill(1);

        const drawMatrix = () => {
            context.fillStyle = 'rgba(0, 0, 0, 0.05)';
            context.fillRect(0, 0, canvas.width, canvas.height);
            context.fillStyle = '#0F0';
            context.font = `${fontSize}px monospace`;

            for (let i = 0; i < drops.length; i++) {
                const text = characters[Math.floor(Math.random() * characters.length)];
                context.fillText(text, i * fontSize, drops[i] * fontSize);

                if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                    drops[i] = 0;
                }
                drops[i]++;
            }
        };

        let matrixInterval = setInterval(drawMatrix, 70);//The speed of the matrix background animation stuff! Lower is faster

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            const newColumns = Math.floor(canvas.width / fontSize);
            drops.length = newColumns;
            for (let i = 0; i < newColumns; i++) {
                if (drops[i] === undefined) {
                    drops[i] = 1;
                }
            }
            // No need to restart the interval, it will adapt
        });


        // --- Social Feed & Modal Logic ---
        const postForm = document.getElementById('post-form');
        const postInput = document.getElementById('post-input');
        const postFeedContainer = document.getElementById('post-feed-container');
        const showModalBtn = document.getElementById('show-modal-btn');
        const postModal = document.getElementById('post-modal');
        const closeModalBtn = document.querySelector('.close-btn');

        showModalBtn.addEventListener('click', () => {
            postModal.style.display = 'flex';
            postInput.focus();
        });

        closeModalBtn.addEventListener('click', () => {
            postModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === postModal) {
                postModal.style.display = 'none';
            }
        });

        postForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const postText = postInput.value.trim();

            if (postText !== "") {
                createPost(postText);
                postInput.value = '';
                postModal.style.display = 'none';
            }
        });

        function createPost(text) {
            const postElement = document.createElement('div');
            postElement.classList.add('post');

            const contentElement = document.createElement('p');
            contentElement.classList.add('post-content');
            contentElement.textContent = text;

            const timestampElement = document.createElement('div');
            timestampElement.classList.add('post-timestamp');
            const now = new Date();
            timestampElement.textContent = `Transmitted: ${now.toLocaleString()}`;

            postElement.appendChild(contentElement);
            postElement.appendChild(timestampElement);

            postFeedContainer.prepend(postElement);
        }
    </script>

</body>

</html>