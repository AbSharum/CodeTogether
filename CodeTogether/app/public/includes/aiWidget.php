<link rel="stylesheet" href="/public/css/ai.css">
<div id="aiContainer">
  <img src="/public/images/maid.webp" id="aiCharacter" alt="AI assistant">
  <div id="speech"></div>

  <!-- unified control bar -->
  <div id="aiControls">
    <form id="aiForm">
      <input type="text" id="aiInput" placeholder="Ask your Question...">
      <button type="submit" id="sendBtn">Send</button>
    </form>

    <button id="openMenuBtn">Switch</button>
  </div>

  <div id="aiPersonalityMenu">
    <h3>Select AI Personality</h3>
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
