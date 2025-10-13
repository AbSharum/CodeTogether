// js/NPC.js
import * as THREE from './three.module.js';
import { CSS2DObject } from './CSS2DRenderer.js';
import { InWorldGUI } from './InWorldGUI.js';

export class NPC {
  /**
   * @param {THREE.Scene} scene - Three.js scene
   * @param {THREE.Vector3} position - Position of NPC
   * @param {Object} options - Optional config:
   *        - name: string
   *        - dialogue: array of strings
   *        - buttons: array of { text, callback, offset }
   *        - proximity: distance to trigger UI
   * @param {THREE.Camera} camera - player camera
   * @param {PointerLockControls} controls - pointer lock controls
   */
  constructor(scene, position, options, camera, controls) {
    this.scene = scene;
    this.camera = camera;
    this.controls = controls;
    this.position = position.clone();
    this.name = options.name || "NPC";
    this.dialogue = options.dialogue || ["Hello, traveler!"];
    this.dialogueIndex = 0;
    this.buttons = options.buttons || [];
    this.proximity = options.proximity || 15;

    // NPC mesh
    this.mesh = new THREE.Mesh(
      new THREE.BoxGeometry(1,2,1),
      new THREE.MeshLambertMaterial({ color: 0x3366ff })
    );
    this.mesh.position.copy(this.position);
    scene.add(this.mesh);

    // Name label
    const nameDiv = document.createElement('div');
    nameDiv.textContent = this.name;
    nameDiv.style.color = "white";
    nameDiv.style.fontWeight = "bold";
    const nameLabel = new CSS2DObject(nameDiv);
    nameLabel.position.set(0,2.5,0);
    this.mesh.add(nameLabel);

    // Speech bubble
    const speechDiv = document.createElement('div');
    speechDiv.style.color = "yellow";
    speechDiv.style.background = "rgba(0,0,0,0.6)";
    speechDiv.style.padding = "4px 8px";
    speechDiv.style.borderRadius = "4px";
    speechDiv.style.display = "none"; // hidden initially
    this.speechLabel = new CSS2DObject(speechDiv);
    this.speechLabel.position.set(0,3,0);
    this.mesh.add(this.speechLabel);

    // In-world GUI buttons
    this.gui = new InWorldGUI(scene, controls, camera);
    this.buttonMeshes = [];
    this.buttons.forEach(btn=>{
      const offset = btn.offset || new THREE.Vector3(1.5,1.5,0);
      const mesh = this.gui.createButton(btn.text, offset, btn.callback, this.mesh);
      mesh.visible = false; // start hidden
      if(mesh.element) mesh.element.style.display = 'none';
      this.buttonMeshes.push(mesh);
    });
  }

  // Update every frame
  update(playerPosition) {
    const distance = playerPosition.distanceTo(this.mesh.position);
    if(distance < this.proximity){
      this.showUI();
    } else {
      this.hideUI();
    }
    this.gui.update(0.016);
  }

    showUI() {
        // Show speech
        if(this.dialogue.length > 0) {
            this.speechLabel.element.style.display = 'block';
            this.speechLabel.element.textContent = this.dialogue[this.dialogueIndex];
        }

        // Show buttons
        this.buttonMeshes.forEach(b => {
            b.visible = true;                   // make raycastable
            if(b.element) b.element.style.display = 'block'; // make visible
        });
    }

    hideUI() {
        // Hide speech
        this.speechLabel.element.style.display = 'none';

        // Hide buttons
        this.buttonMeshes.forEach(b => {
            b.visible = false;                  // disable raycast
            if(b.element) b.element.style.display = 'none';  // hide visually
        });
    }


  // Cycle to next dialogue line
  nextDialogue() {
    if(this.dialogue.length > 1){
      this.dialogueIndex = (this.dialogueIndex + 1) % this.dialogue.length;
      this.speechLabel.element.textContent = this.dialogue[this.dialogueIndex];
    }
  }
}
