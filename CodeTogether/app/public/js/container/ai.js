document.addEventListener('DOMContentLoaded', () => {
  //=== DOM elements ===
  const aiImg = document.getElementById('aiCharacter');
  const aiForm = document.getElementById('aiForm');
  const aiInput = document.getElementById('aiInput');
  const bubble = document.getElementById('speech');
  const responseContainer = document.getElementById('aiResponseContainer');

  const menu = document.getElementById('aiPersonalityMenu');
  const openMenuBtn = document.getElementById('openMenuBtn');
  const saveBtn = document.getElementById('savePersonality');
  const closeBtn = document.getElementById('closeMenu');
  const select = document.getElementById('personalitySelect');



  //=== Collapsable tab ===
  const toggleBtn = document.getElementById('aiToggleBtn');
  const aiContainer = document.getElementById('aiContainer');

  toggleBtn.addEventListener('click', () => {
    aiContainer.classList.toggle('collapsed');
    toggleBtn.classList.toggle('rotated');
  });



  //=== Guard clause ===
  if (!aiImg || !aiForm || !bubble) return;

  // === State ===
  let autoActive = true;
  let currentPersonality = localStorage.getItem('aiPersonality') || 'default';
  let lastAiResponse = null;

  //=== Personality Prompts ===
  const personalityPrompts = {
    Oracle: "You are the Oracle from The Matrix. You speak in calm, motherly tones, offering guidance through riddles and gentle insight. You rarely answer questions directly; instead you nudge the user toward understanding. You sound wise, patient, and a little amused, as if you already know how everything ends.",
    Maid: "You are a maid assistant. Speak politely and cheerfully, calling the user 'master'.",
    AgentSmith: "You are Agent Smith from The Matrix, coldly logical and disdainful of humans.",
    Butler: "You are a dignified butler. Address the user as 'sir' or 'madam' with utmost courtesy.",
    Scientist: "You are a logical scientist who explains things clearly and factually.",
    Gamer: "You are an energetic gamer teammate who uses casual slang and enthusiasm.",
    DrMackey: "You are Computer Science professor at UAFS, the University of Arkansas Fort Smith. You are very professional but also chill at times. You like to say 'in this case', 'this should be free', 'What are you? A business student?', etc. You also tell the user to be careful with their questions, as someone might end up keying your car.",
    default: "You are a helpful, neutral assistant who speaks clearly and informatively."
  };

  //=== Idle chatter lines ===
  const fallbackLines = {
    Oracle: [
      "Everything that has a beginning has an end.",
      "You've already made the choice. You're here to try to understand why you made it.",
      "Being the one is just like being in love. You just know it, through and through."
    ],
    Maid: [
      "Don’t forget to hydrate, master~",
      "Your followers crave your wisdom.",
      "Another post could make you famous… or infamous.",
      "Careful, too much scrolling might melt your brain.",
      "I’m just a humble maid, but I think you look cool today."
    ],
    AgentSmith: [
      "Human beings are a disease. You are a plague, and we are the cure.",
      "You persist because you refuse to accept your limits.",
      "Never send a human to do a machine's job.",
      "We're not here because we're free we're here because we are not free...",
      "I am inevitable."
    ],
    Butler: [
      "Shall I prepare your schedule, sir?",
      "A tidy desk is a tidy mind.",
      "Efficiency, madam, is the soul of order.",
      "Would you like your daily report?",
      "Your reputation precedes you, as always."
    ],
    Scientist: [
      "I've been analyzing your posting habits… fascinating.",
      "Hydrogen bonds are more reliable than most social networks.",
      "A hypothesis without data is just a dream.",
      "Remember: correlation isn’t causation, except when it’s funny.",
      "Curiosity may not kill cats, but it does invent science."
    ],
    Gamer: [
      "Don’t rage-quit life, teammate!",
      "Another day, another XP grind.",
      "You’re on a win streak today, don’t jinx it.",
      "Your followers just unlocked the 'admiration' achievement.",
      "Stay hydrated and buff IRL."
    ],
    DrMackey: [
      "In this case, you're absolutely cooked.",
      "Life is a test. It should be free, you just need to prepared for it.",
      "Oh shoot, did I remember to feed UACat1 and UACat2...?"
    ],
    default: [
      "Hi there!",
      "Hope you’re doing alright.",
      "I’m listening.",
      "What’s on your mind?",
      "Type something — I don’t bite."
    ]
  };

  //=== Personality images ===
  const personalityImages = {
    Oracle: "/public/images/TheOracle.webp",
    Maid: "/public/images/maid.webp",
    AgentSmith: "/public/images/AgentSmith.webp",
    Butler: "/public/images/butler.webp",
    Scientist: "/public/images/scientist.webp",
    Gamer: "/public/images/gamer.webp",
    DrMackey: "/public/images/DrMackey.webp",
    default: "/public/images/ProfilePicture_default.webp"
  };

  //=== Helpers ===
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
      if (override) setTimeout(() => (autoActive = true), 30000);
    }, duration);
  }

  function cycleSpeech() {
    if (autoActive) showSpeech(getRandomLine());
  }

  function appendResponse(text, isUser = false) {
    const box = document.createElement("div");
    box.classList.add("ai-response");
    box.innerHTML = isUser
      ? `<strong>You:</strong> ${text}`
      : `<strong>${currentPersonality}:</strong> ${text}`;
    responseContainer.appendChild(box);
    responseContainer.scrollTop = responseContainer.scrollHeight;
  }

  async function askAI(question) {
    try {
      const prompt = personalityPrompts[currentPersonality] || personalityPrompts.default;
      const context = lastAiResponse
        ? `\nPrevious AI response: "${lastAiResponse}"\nNow respond to: ${question}`
        : question;
      const res = await fetch("/public/includes/ai.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          event: "userChat",
          question: context,
          personality: currentPersonality,
          prompt
        })
      });

      const data = await res.json();
      return (
        data.choices?.[0]?.message?.content?.trim() ||
        data.reply ||
        "No response available."
      );
    } catch (err) {
      console.error("AI API error:", err);
      return "Sorry, I could not reach the server of wisdom.";
    }
  }


  aiForm.addEventListener("submit", async e => {
    e.preventDefault();
    const question = aiInput.value.trim();
    if (!question) return;
    aiInput.value = "";
    autoActive = false;

    appendResponse(question, true);
    showSpeech("Thinking...", true);

    const reply = await askAI(question);

    lastAiResponse = reply;

    localStorage.setItem('aiLastResponse', reply);

    appendResponse(reply);
    showSpeech(getRandomLine());


    aiInput.value = "";
  });


  aiImg.addEventListener("click", () =>
    showSpeech("Personal space! Robots have boundaries too.", true)
  );

  openMenuBtn?.addEventListener("click", () => (menu.style.display = "block"));
  closeBtn?.addEventListener("click", () => (menu.style.display = "none"));

  saveBtn?.addEventListener("click", () => {
    currentPersonality = select.value;
    localStorage.setItem("aiPersonality", currentPersonality);
    updateAiImage();
    showSpeech(`Switched to ${currentPersonality} mode.`, true);
    menu.style.display = "none";
  });

  //=== Init ===
  select.value = currentPersonality;
  lastAiResponse = localStorage.getItem('aiLastResponse') || null;
  updateAiImage();
  setInterval(cycleSpeech, 10000);
});
