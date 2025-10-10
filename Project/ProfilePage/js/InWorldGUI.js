// js/InWorldGUI.js
import * as THREE from './three.module.js';
import { CSS2DObject } from './CSS2DRenderer.js';

export class InWorldGUI {
  constructor(scene, controls, camera) {
    this.scene = scene;
    this.controls = controls;
    this.camera = camera;
    this.raycaster = new THREE.Raycaster();
    this.hoveredObject = null;
    this.interactiveObjects = [];

    // Bind mouse click
    document.addEventListener('mousedown', () => this.onClick());
  }

  createButton(text, position, action, parent = this.scene) {
    // CSS2D for visuals
    const div = document.createElement('div');
    div.className = 'button3d';
    div.textContent = text;
    const label = new CSS2DObject(div);
    label.position.copy(position);
    parent.add(label);

    // Invisible mesh for raycasting
    const mesh = new THREE.Mesh(
      new THREE.BoxGeometry(2, 0.5, 0.1),
      new THREE.MeshBasicMaterial({ color: 0x00ff00, transparent: true, opacity: 0 })
    );
    mesh.position.copy(position);
    mesh.userData.action = action;
    mesh.element = div; // link to CSS2D element
    parent.add(mesh);

    this.interactiveObjects.push(mesh);
    return mesh;
  }

  onClick() {
    if (!this.controls.isLocked) return;
    this.raycaster.setFromCamera({ x: 0, y: 0 }, this.camera);
    const intersects = this.raycaster.intersectObjects(this.interactiveObjects);
    if (intersects.length > 0) {
      const obj = intersects[0].object;
      if (obj.userData.action) obj.userData.action();
    }
  }

  updateHover() {
    if (!this.controls.isLocked) return;
    this.raycaster.setFromCamera({ x: 0, y: 0 }, this.camera);
    const intersects = this.raycaster.intersectObjects(this.interactiveObjects);

    if (intersects.length > 0) {
      const obj = intersects[0].object;
      if (this.hoveredObject !== obj) {
        if (this.hoveredObject) this.resetHover(this.hoveredObject);
        this.setHover(obj);
      }
    } else if (this.hoveredObject) {
      this.resetHover(this.hoveredObject);
      this.hoveredObject = null;
    }
  }

  setHover(obj) {
    this.hoveredObject = obj;
    obj.targetScale = 1.2;
    obj.element.style.background = 'rgba(255,255,0,0.9)';
  }

  resetHover(obj) {
    obj.targetScale = 1.0;
    obj.element.style.background = 'rgba(255,255,255,0.8)';
  }

  animateHover(delta) {
    // Smooth scaling
    this.interactiveObjects.forEach(obj => {
      if (!obj.targetScale) return;
      obj.scale.lerp(new THREE.Vector3(obj.targetScale, obj.targetScale, obj.targetScale), delta * 5);
    });
  }

  update(delta) {
    this.updateHover();
    this.animateHover(delta);
  }
}
