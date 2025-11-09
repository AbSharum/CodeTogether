// --- Core Application Data ---
const vocabulary = [
    { id: 1, term: "Boolean", definition: "A data type having only two possible values, typically true or false (0 or 1)." },
    { id: 2, term: "Algorithm", definition: "A finite sequence of well-defined, computer-implementable instructions to solve a class of problems." },
    { id: 3, term: "Recursion", definition: "A process in which a function or procedure calls itself, either directly or indirectly." },
    { id: 4, term: "Syntax", definition: "The set of rules that defines how a program or script is written and structured in a programming language." },
    { id: 5, term: "Compile", definition: "To translate source code written in a high-level language into machine code or bytecode." },
    { id: 6, term: "API", definition: "A set of functions and procedures that allow the creation of applications accessing features or data of an operating system, application, or other service." },
    { id: 7, term: "Framework", definition: "A platform for developing software applications that provides a foundation on which software developers can build programs for a specific platform." },
    { id: 8, term: "Object-Oriented Programming", definition: "A programming paradigm based on the concept of 'objects', which can contain data and code to manipulate that data." },
    { id: 9, term: "Database", definition: "An organized collection of data, generally stored and accessed electronically from a computer system." },
    { id: 10, term: "Version Control", definition: "A system that records changes to a file or set of files over time so that specific versions can be recalled later." },
    { id: 11, term: "Encapsulation", definition: "The bundling of data with the methods that operate on that data, restricting direct access to some of the object's components." },
    { id: 12, term: "Inheritance", definition: "A mechanism in object-oriented programming that allows a new class to inherit properties and behavior (methods) from an existing class." },
    { id: 13, term: "Polymorphism", definition: "The ability of different classes to be treated as instances of the same class through a common interface, typically by overriding methods." },
    { id: 14, term: "Asynchronous Programming", definition: "A programming paradigm that allows for non-blocking operations, enabling tasks to run concurrently without waiting for each other to complete." },
    { id: 15, term: "Lambda Function", definition: "A small anonymous function defined with the lambda keyword, often used for short, throwaway functions." }
];

// --- Global State ---
let currentCards = [];
let score = 0;

// --- DOM Elements ---
const termsContainer = document.getElementById('terms-container');
const definitionsContainer = document.getElementById('definitions-container');
const scoreElement = document.getElementById('score');
const totalMatchesElement = document.getElementById('total-matches');
const gameOverModal = document.getElementById('game-over-modal');
const progressBar = document.getElementById('progress-bar'); // NEW
const progressText = document.getElementById('progress-text'); // NEW

// --- AutoScroll during the drag operation ---
let autoScrollInterval = null;
const SCROLL_SPEED = 10;
const SCROLL_ZONE_HEIGHT = 50;

// Function to start the scrolling loop
function startAutoScrolling(scrollAmount) {
    // Only start if not already scrolling in the requested direction
    if (autoScrollInterval) {
        // Determine direction based on sign
        const currentDirection = autoScrollInterval.scrollAmount > 0 ? 'down' : 'up';
        const newDirection = scrollAmount > 0 ? 'down' : 'up';

        // If the direction hasn't changed, do nothing
        if (currentDirection === newDirection) return;

        // If the direction changed, clear the old one
        clearInterval(autoScrollInterval.id);
    }

    autoScrollInterval = {
        id: setInterval(() => {
            window.scrollBy(0, scrollAmount);
        }, 50),
        scrollAmount: scrollAmount // Store for direction check
    };
}

// Function to stop the scrolling loop
function stopAutoScrolling() {
    if (autoScrollInterval) {
        clearInterval(autoScrollInterval.id);
        autoScrollInterval = null;
    }
}

// Listen to the drag event globally when a drag operation is active
window.addEventListener('dragover', (e) => {
    // Prevent default to allow drop *and* ensure the drag event keeps firing regularly
    e.preventDefault();

    const viewportHeight = window.innerHeight;
    const mouseY = e.clientY; // Mouse position relative to the viewport

    // Check if dragging near the top edge
    if (mouseY < SCROLL_ZONE_HEIGHT) {
        // Scroll Up
        startAutoScrolling(-SCROLL_SPEED);
    }
    // Check if dragging near the bottom edge
    else if (mouseY > viewportHeight - SCROLL_ZONE_HEIGHT) {
        // Scroll Down
        startAutoScrolling(SCROLL_SPEED);
    }
    // Mouse is in the middle, stop scrolling
    else {
        stopAutoScrolling();
    }
});

// Ensure scrolling stops when drag operation ends or is cancelled
window.addEventListener('dragend', stopAutoScrolling);



// Utility to shuffle an array (Fisher-Yates)
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

// --- Drag and Drop Handlers ---

function handleDragStart(e) {
    // Set the ID of the term being dragged
    e.dataTransfer.setData('text/plain', e.target.dataset.termId);
    e.target.classList.add('opacity-50');
}

function handleDragEnd(e) {
    e.target.classList.remove('opacity-50');
}

function handleDragOver(e) {
    e.preventDefault(); // Necessary to allow dropping
}

function handleDragEnter(e) {
    e.preventDefault();
    if (e.target.classList.contains('definition-target') && !e.target.classList.contains('matched')) {
        e.target.classList.add('drag-over');
    }
}

function handleDragLeave(e) {
    if (e.target.classList.contains('definition-target')) {
        e.target.classList.remove('drag-over');
    }
}

function handleDrop(e) {
    e.preventDefault();
    const droppedElement = e.target.closest('.definition-target');
    if (!droppedElement || droppedElement.classList.contains('matched')) {
        return;
    }

    droppedElement.classList.remove('drag-over');

    const termId = parseInt(e.dataTransfer.getData('text/plain'));
    const definitionId = parseInt(droppedElement.dataset.definitionId);
    const termCard = document.querySelector(`[data-term-id='${termId}']`);

    if (termId === definitionId) {
        // Correct Match
        score++;
        scoreElement.textContent = score;

        // --- PROGRESS UPDATE ---
        const percentage = Math.round((score / currentCards.length) * 100);
        progressBar.style.width = `${percentage}%`;
        progressText.textContent = `${percentage}%`;
        // If progress is low, switch text color to neon green to ensure visibility
        progressText.style.color = percentage < 10 ? '#000000' : '#000000';
        // -------------------------

        // 1. Style the definition target
        droppedElement.classList.add('matched');
        droppedElement.innerHTML = `<span class="matrix-text" style="font-weight: bold; font-size: 1.125rem;">${termCard.textContent}</span><br>
                                            <span style="color: #6ee7b7;">${droppedElement.dataset.definitionText}</span>`;
        droppedElement.style.cursor = 'default';

        // 2. Remove the term card
        termCard.remove();

        // 3. Check for Game Over
        if (score === currentCards.length) {
            endGame();
        }

    } else {
        // Incorrect Match - Apply shake animation to the definition target
        droppedElement.classList.add('incorrect');
        setTimeout(() => {
            droppedElement.classList.remove('incorrect');
        }, 500);
    }
}

// --- Rendering Functions ---

function renderTerms(terms) {
    termsContainer.innerHTML = '';
    terms.forEach(card => {
        const termDiv = document.createElement('div');
        termDiv.className = 'matrix-card';
        termDiv.textContent = card.term;
        termDiv.setAttribute('draggable', 'true');
        termDiv.dataset.termId = card.id;

        termDiv.addEventListener('dragstart', handleDragStart);
        termDiv.addEventListener('dragend', handleDragEnd);

        termsContainer.appendChild(termDiv);
    });
}

function renderDefinitions(definitions) {
    definitionsContainer.innerHTML = '';
    definitions.forEach(card => {
        const definitionDiv = document.createElement('div');
        definitionDiv.className = 'definition-target';
        definitionDiv.textContent = card.definition;
        definitionDiv.dataset.definitionId = card.id;
        definitionDiv.dataset.definitionText = card.definition; // Store original text for display on match

        definitionDiv.addEventListener('dragover', handleDragOver);
        definitionDiv.addEventListener('dragenter', handleDragEnter);
        definitionDiv.addEventListener('dragleave', handleDragLeave);
        definitionDiv.addEventListener('drop', handleDrop);

        definitionsContainer.appendChild(definitionDiv);
    });
}

// --- Game Flow Functions ---

function startGame() {
    // Reset state
    currentCards = JSON.parse(JSON.stringify(vocabulary)); // Deep copy
    score = 0;
    scoreElement.textContent = 0;
    totalMatchesElement.textContent = currentCards.length;


    // Reset Progress Bar
    progressBar.style.width = '0%';
    progressText.textContent = '0%';
    progressText.style.color = '#030303ff'; // Ensure text is visible when bar is empty


    // Prepare cards
    const shuffledTerms = JSON.parse(JSON.stringify(currentCards)); // Shuffled Terms (left column)
    shuffleArray(shuffledTerms);

    const definitions = currentCards; // Definitions (right column) - we want these fixed
    // Note: We don't shuffle definitions so the matching is clear, only the terms are shuffled.

    // Render
    renderTerms(shuffledTerms);
    renderDefinitions(definitions);
}

function endGame() {
    document.getElementById('final-score').textContent = `${score}/${currentCards.length}`;
    gameOverModal.classList.remove('hidden');
}

// Initialize the game on load
window.onload = () => startGame();