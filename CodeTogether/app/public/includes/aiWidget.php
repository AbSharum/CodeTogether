<link rel="stylesheet" href="/public/css/core/main.css">
<link rel="stylesheet" href="/public/css/container/ai.css">

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
      <strong>Start of your conversation:</strong>
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
      <option value="Oracle">The Oracle</option>
      <option value="AgentSmith">Agent Smith</option>
      <option value="Maid">Maid</option>
      <option value="Butler">Butler</option>
      <option value="Scientist">Scientist</option>
      <option value="Gamer">Gamer</option>
      <option value="DrMackey">Dr. Mackey</option>
    </select><br><br>
    <button id="savePersonality">Confirm</button>
    <button id="closeMenu">Close</button>
  </div>


</div>

<button id="aiToggleBtn" aria-label="Toggle AI">
  <i class="fas fa-chevron-down"></i>
</button>