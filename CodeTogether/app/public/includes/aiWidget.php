<link rel="stylesheet" href="/public/css/ai.css">

<div id="aiContainer">
  <!-- Character and speech area -->
  <div id="aiTopSection">
    <img src="/public/images/maid.webp" id="aiCharacter" alt="AI assistant">
    <div id="speech"></div>
  </div>

  <!-- Scrollable response area for AI replies -->
  <div id="aiResponseContainer">
    <!-- AI responses will be appended here -->
    <div>
      <strong>You:</strong>
    </div>
  </div>

  <!-- Unified control bar -->
  <div id="aiControls">
    <form id="aiForm">
      <input type="text" id="aiInput" placeholder="Ask your Question...">
      <button type="submit" id="sendBtn">Send</button>
    </form>
    <button id="openMenuBtn">Switch</button>
  </div>

  <!-- Personality menu -->
  <div id="aiPersonalityMenu">
    <h3 class="menu-heading">Select AI Personality</h3>
    <select id="personalitySelect">
      <option value="oracle">The Oracle</option>
      <option value="maid">Maid</option>
      <option value="agentsmith">Agent Smith</option>
      <option value="butler">Butler</option>
      <option value="scientist">Scientist</option>
      <option value="gamer">Gamer</option>
    </select><br><br>
    <button id="savePersonality">Confirm</button>
    <button id="closeMenu">Close</button>
  </div>
</div>

