document.addEventListener('DOMContentLoaded', () => {
  // === DOM elements ===
  const aiImg = document.getElementById('aiCharacter');
  const aiForm = document.getElementById('aiForm');
  const aiInput = document.getElementById('aiInput');
  const bubble = document.getElementById('speech');

  const menu = document.getElementById('aiPersonalityMenu');
  const openMenuBtn = document.getElementById('openMenuBtn');
  const saveBtn = document.getElementById('savePersonality');
  const closeBtn = document.getElementById('closeMenu');
  const select = document.getElementById('personalitySelect');

  // === Guard clause: no widget detected ===
  if (!aiImg || !aiForm || !bubble) return;

  // === State ===
  let autoActive = true;
  let currentPersonality = localStorage.getItem('aiPersonality') || 'default';

  // === Client side Personality prompts to send to ai.php, usually overwrites the server personalities ===
    const personalityPrompts = {
        oracle: "You are the Oracle from The Matrix. You speak in calm, motherly tones, offering guidance through riddles and gentle insight. You rarely answer questions directly; instead you nudge the user toward understanding. You sound wise, patient, and a little amused, as if you already know how everything ends.",
        maid: "You are a maid assistant. Speak politely and cheerfully, calling the user 'master'.",
        agentsmith: "You are Agent Smith from The Matrix, coldly logical and disdainful of humans.",
        butler: "You are a dignified butler. Address the user as 'sir' or 'madam' with utmost courtesy.",
        scientist: "You are a logical scientist who explains things clearly and factually.",
        gamer: "You are an energetic gamer teammate who uses casual slang and enthusiasm.",
        default: "You are a helpful, neutral assistant who speaks clearly and informatively."
    };

  // === Fallback chatter for idle mode ===
  const fallbackLines = {
    oracle: [
      'Everything that has a beginning has an end.',
      'You\'ve already made the choice. You\'re here to try to understand why you made it.',
      'Being the one is just like being in love. No one needs to tell you you are in love, you just know it, through and through.'
    ],
    maid: [
      'Don’t forget to hydrate, master~',
      'Your followers crave your wisdom.',
      'Another post could make you famous… or infamous.',
      'Careful, too much scrolling might melt your brain.',
      'I’m just a humble maid, but I think you look cool today.'
    ],
    agentsmith: [
      'Human beings are a disease, a cancer of this planet. You are a plague, and we are the cure.'
    ],
    butler: [
      'Shall I prepare your schedule, sir?',
      'A tidy desk is a tidy mind.',
      'Efficiency, madam, is the soul of order.',
      'Would you like your daily report?',
      'Your reputation precedes you, as always.'
    ],
    scientist: [
      'I’ve been analyzing your posting habits… fascinating.',
      'Hydrogen bonds are more reliable than most social networks.',
      'A hypothesis without data is just a dream.',
      'Remember: correlation isn’t causation, except when it’s funny.',
      'Curiosity may not kill cats, but it does invent science.'
    ],
    gamer: [
      'Don’t rage-quit life, teammate!',
      'Another day, another XP grind.',
      'You’re on a win streak today, don’t jinx it.',
      'Your followers just unlocked the “admiration” achievement.',
      'Stay hydrated and buff IRL.'
    ],
    default: [
      'Hi there!',
      'Hope you’re doing alright.',
      'I’m listening.',
      'What’s on your mind?',
      'Type something — I don’t bite.'
    ]
  };

  // === Personality-specific images ===
  const personalityImages = {
    oracle: '/public/ai/images/TheOracle.webp',
    maid: '/public/ai/images/maid.webp',
    agentsmith: '/public/ai/images/AgentSmith.webp',
    butler: '/public/ai/images/butler.webp',
    scientist: '/public/ai/images/scientist.webp',
    gamer: '/public/ai/images/gamer.webp',
    default: '/public/ai/images/default_ai.webp'
  };

  // === Helpers ===
  function updateAiImage() {
    aiImg.src = personalityImages[currentPersonality] || personalityImages.default;
  }

  function getRandomLine() {
    const lines = fallbackLines[currentPersonality] || fallbackLines.default;
    return lines[Math.floor(Math.random() * lines.length)];
  }


  let bubbleTimer = null;
  function showSpeech(text, override = false) {
    bubble.textContent = text;
    bubble.style.opacity = 1;

    clearTimeout(bubbleTimer);
    const duration = override
      ? Math.min(6000 + text.length * 80, 20000)
      : 10000;

    bubbleTimer = setTimeout(() => {
      bubble.style.opacity = 0;
      if (override) setTimeout(() => (autoActive = true), 5000);
    }, duration);
  }

  function cycleSpeech() {
    if (autoActive) {
      showSpeech(getRandomLine());
    }
  }

  // === Core AI call ===
  async function askAI(question) {
    try {
        const prompt = personalityPrompts[currentPersonality] || personalityPrompts.default;

        const res = await fetch('/public/ai/ai.php', {
        method: 'POST',
            headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    event: 'userChat',
                    question,
                    personality: currentPersonality,
                    prompt
            })
        });

        const data = await res.json();
        return (
            data.choices?.[0]?.message?.content?.trim() ||
            data.reply ||
            'No response available.'
        );
    } catch (err) {
      console.error('AI API error:', err);
      return 'Sorry, I could not reach the server of wisdom.';
    }
  }

  // === Event listeners ===
  aiForm.addEventListener('submit', async e => {
    e.preventDefault();
    const question = aiInput.value.trim();
    if (!question) return;
    showSpeech('Thinking...', true);
    const reply = await askAI(question);
    showSpeech(reply, true);
    aiInput.value = '';
  });

  aiImg.addEventListener('click', () => {
    showSpeech('Personal space! Robots have boundaries too.', true);
  });

  openMenuBtn?.addEventListener('click', () => (menu.style.display = 'block'));
  closeBtn?.addEventListener('click', () => (menu.style.display = 'none'));
  saveBtn?.addEventListener('click', () => {
    currentPersonality = select.value;
    localStorage.setItem('aiPersonality', currentPersonality);
    updateAiImage();
    showSpeech(`Switched to ${currentPersonality} mode.`, true);
    menu.style.display = 'none';
  });

  // === Initialization ===
  select.value = currentPersonality;
  updateAiImage();
  setInterval(cycleSpeech, 10000);

});
