let lastActivity = Date.now();
const INACTIVITY_THRESHOLD = 5 * 60 * 1000; // 5 minutes for inactivity
const CHECK_INTERVAL = 15 * 1000; // Check every 15 seconds

function updateStatus(status) {
    fetch('index.php?action=status', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status })
    }).catch(() => {});
}

// Detect user activity
['mousemove', 'keydown', 'scroll', 'click'].forEach(evt => {
    window.addEventListener(evt, () => {
        lastActivity = Date.now();
        updateStatus('online');
    });
});

setInterval(() => {
    const now = Date.now();
    const inactiveFor = now - lastActivity;
    echo 

    if (inactiveFor > INACTIVITY_THRESHOLD) {
        updateStatus('away');
    } else {
        updateStatus('online');
    }
}, CHECK_INTERVAL);

