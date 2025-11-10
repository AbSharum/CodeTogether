document.addEventListener('DOMContentLoaded', () => {

    // Countdown timer logic
    const timerElement = document.getElementById('countdown-timer');
    let totalSeconds = 15 * 60; // 15 minutes in seconds
    let countdownInterval = null;
    let isTimerRunning = false;

    function updateCountdown() {
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;

        // Format for display (e.g., "05" instead of "5")
        const formattedMinutes = String(minutes).padStart(2, '0');
        const formattedSeconds = String(seconds).padStart(2, '0');

        timerElement.textContent = `${formattedMinutes}:${formattedSeconds}`;
        
        if (totalSeconds <= 0) {
            clearInterval(countdownInterval);
            timerElement.textContent = "Time's Up!";
            timerElement.classList.add('timer-end');
            showWinnerPopup('Team B'); // placeholder — backend should decide winner
        } else {
            totalSeconds--;
        }
    }

    // backend needed to handle team joining
    function joinTeam(team) {
        alert(`You have attempted to join Team ${team}. This action would typically be handled by a server-side script.`);
        console.log(`Attempting to join Team ${team}`);
    }

    function startTimer() {
        if (isTimerRunning) return;

        isTimerRunning = true;
        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);

        // Make the timer appear inactive once started
        timerElement.style.cursor = 'default';
        timerElement.style.boxShadow = 'none';
    }

    // Show winner popup (frontend placeholder)
    function showWinnerPopup(winnerName) {
        if (typeof bootstrap === 'undefined' || !bootstrap.Modal) {
            console.error("Bootstrap's Modal functionality is not available.");
            return;
        }

        const winnerModalElement = document.getElementById('winnerModal');
        const winningTeamNameElement = document.getElementById('winningTeamName');

        if (winnerModalElement && winningTeamNameElement) {
            winningTeamNameElement.textContent = winnerName + ' Wins!';

            let textColor = '#fff';
            // Set specific colors based on the winning team
            if (winnerName.includes('A')) {
                textColor = '#dc3545'; // Team A (red)
            } else if (winnerName.includes('B')) {
                textColor = '#0d6efd'; // Team B (blue)
            }

            winningTeamNameElement.style.color = textColor;
            winningTeamNameElement.style.textShadow = `0 0 10px ${textColor}`;

            const winnerModal = new bootstrap.Modal(winnerModalElement);
            winnerModal.show();
        }
    }

    // Initialize display immediately
    updateCountdown();
    timerElement.addEventListener('click', startTimer);
});
