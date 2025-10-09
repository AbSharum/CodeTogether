<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>3D World – NPCs + Sign + Vertical Buttons</title>
<style>
body { margin:0; overflow:hidden; background:#000; }
canvas { display:block; position:absolute; top:0; left:0; }
#crosshair {
  position: fixed; top:50%; left:50%;
  width: 20px; height: 20px;
  pointer-events: none;
  transform: translate(-50%, -50%);
  z-index: 10;
}
#crosshair::before, #crosshair::after {
  content: ''; position: absolute; background:white;
}
#crosshair::before { left:50%; top:0; width:2px; height:100%; transform: translateX(-50%); }
#crosshair::after { top:50%; left:0; width:100%; height:2px; transform: translateY(-50%); }
.button3d {
  background: rgba(255,255,255,0.8);
  padding: 6px 12px;
  border-radius: 4px;
  font-family: sans-serif;
  cursor: pointer;
  text-align: center;
  user-select: none;
}
.button3d:hover { background: rgba(255,255,0,0.9); }
</style>
</head>
<body>
<div id="crosshair"></div>

<script type="module">
import * as THREE from './js/three.module.js';
import { PointerLockControls } from './js/PointerLockControls.js';
import { FontLoader } from './js/FontLoader.js';
import { TextGeometry } from './js/TextGeometry.js';
import { CSS2DRenderer, CSS2DObject } from './js/CSS2DRenderer.js';

// --- InWorldGUI ---
class InWorldGUI {
  constructor(scene, controls, camera) {
    this.scene = scene;
    this.controls = controls;
    this.camera = camera;
    this.raycaster = new THREE.Raycaster();
    this.hoveredObject = null;
    this.interactiveObjects = [];
    document.addEventListener('mousedown', ()=>this.onClick());
  }
  createButton(text, position, action, parent=this.scene) {
    const div = document.createElement('div');
    div.className = 'button3d';
    div.textContent = text;
    const label = new CSS2DObject(div);
    label.position.copy(position);
    parent.add(label);

    const mesh = new THREE.Mesh(
      new THREE.BoxGeometry(2,0.5,0.1),
      new THREE.MeshBasicMaterial({color:0x00ff00, transparent:true, opacity:0})
    );
    mesh.position.copy(position);
    mesh.userData.action = action;
    mesh.element = div;
    mesh.visible = false;
    div.style.display = 'none';
    parent.add(mesh);

    this.interactiveObjects.push(mesh);
    return mesh;
  }
  onClick() {
    if(!this.controls.isLocked) return;
    this.raycaster.setFromCamera({x:0,y:0}, this.camera);
    const intersects = this.raycaster.intersectObjects(this.interactiveObjects);
    if(intersects.length>0){
      const obj = intersects[0].object;
      if(obj.userData.action) obj.userData.action();
    }
  }
  updateHover() {
    if(!this.controls.isLocked) return;
    this.raycaster.setFromCamera({x:0,y:0}, this.camera);
    const intersects = this.raycaster.intersectObjects(this.interactiveObjects);
    if(intersects.length>0){
      const obj = intersects[0].object;
      if(this.hoveredObject!==obj){
        if(this.hoveredObject) this.resetHover(this.hoveredObject);
        this.setHover(obj);
      }
    } else if(this.hoveredObject){
      this.resetHover(this.hoveredObject);
      this.hoveredObject=null;
    }
  }
  setHover(obj){ this.hoveredObject=obj; obj.targetScale=1.2; obj.element.style.background='rgba(255,255,0,0.9)'; }
  resetHover(obj){ obj.targetScale=1.0; obj.element.style.background='rgba(255,255,255,0.8)'; }
  animateHover(delta){
    this.interactiveObjects.forEach(obj=>{
      if(!obj.targetScale) return;
      obj.scale.lerp(new THREE.Vector3(obj.targetScale,obj.targetScale,obj.targetScale), delta*5);
    });
  }
  update(delta){ this.updateHover(); this.animateHover(delta); }
}

// --- NPC ---
class NPC {
  constructor(scene, position, options, gui) {
    this.scene = scene;
    this.position = position.clone();
    this.name = options.name || "NPC";
    this.dialogue = options.dialogue || ["Hello!"];
    this.dialogueIndex = 0;
    this.buttons = options.buttons || [];
    this.proximity = options.proximity || 5;
    this.gui = gui;

    this.mesh = new THREE.Mesh(new THREE.BoxGeometry(1,2,1), new THREE.MeshLambertMaterial({color:0x3366ff}));
    this.mesh.position.copy(this.position);
    scene.add(this.mesh);

    const nameDiv = document.createElement('div');
    nameDiv.textContent=this.name;
    nameDiv.style.color='white'; nameDiv.style.fontWeight='bold';
    const nameLabel = new CSS2DObject(nameDiv);
    nameLabel.position.set(0,2.5,0);
    this.mesh.add(nameLabel);

    const speechDiv=document.createElement('div');
    speechDiv.style.color='yellow';
    speechDiv.style.background='rgba(0,0,0,0.6)';
    speechDiv.style.padding='4px 8px';
    speechDiv.style.borderRadius='4px';
    speechDiv.style.display='none';
    this.speechLabel = new CSS2DObject(speechDiv);
    this.speechLabel.position.set(0,3,0);
    this.mesh.add(this.speechLabel);

    this.buttonMeshes=[];
    this.buttons.forEach((btn,index)=>{
      const baseOffset = btn.offset || new THREE.Vector3(1.5,1.5,0);
      const offset = baseOffset.clone();
      offset.y += index*0.6; // vertical stack
      const mesh = this.gui.createButton(btn.text, offset, btn.callback, this.mesh);
      mesh.visible=false;
      mesh.element.style.display='none';
      this.buttonMeshes.push(mesh);
    });

    // Optional idle movement
    this.timeOffset = Math.random()*1000;
  }

  update(playerPosition, time){
    const distance = playerPosition.distanceTo(this.mesh.position);
    if(distance<this.proximity){
      this.showUI();
    } else {
      this.hideUI();
    }

    // Idle movement
    this.mesh.position.x = this.position.x + Math.sin((time+this.timeOffset)/1000)*0.5;

    this.gui.update(0.016);
  }

  showUI(){
    if(this.dialogue.length>0){
      this.speechLabel.element.style.display='block';
      this.speechLabel.element.textContent=this.dialogue[this.dialogueIndex];
    }
    this.buttonMeshes.forEach(b=>{
      b.visible=true;
      if(b.element) b.element.style.display='block';
    });
  }

  hideUI(){
    this.speechLabel.element.style.display='none';
    this.buttonMeshes.forEach(b=>{
      b.visible=false;
      if(b.element) b.element.style.display='none';
    });
  }

  nextDialogue(){
    if(this.dialogue.length>1){
      this.dialogueIndex=(this.dialogueIndex+1)%this.dialogue.length;
      this.speechLabel.element.textContent=this.dialogue[this.dialogueIndex];
    }
  }
}

// --- Scene setup ---
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75,innerWidth/innerHeight,0.1,1000);
camera.position.y=2;
const renderer = new THREE.WebGLRenderer({antialias:true});
renderer.setSize(innerWidth,innerHeight);
document.body.appendChild(renderer.domElement);

const labelRenderer = new CSS2DRenderer();
labelRenderer.setSize(innerWidth,innerHeight);
labelRenderer.domElement.style.position='absolute';
labelRenderer.domElement.style.top='0';
labelRenderer.domElement.style.pointerEvents='none';
document.body.appendChild(labelRenderer.domElement);

const light = new THREE.DirectionalLight(0xffffff,1);
light.position.set(5,10,7.5); scene.add(light);
scene.add(new THREE.AmbientLight(0x404040));

const ground = new THREE.Mesh(new THREE.PlaneGeometry(500,500), new THREE.MeshLambertMaterial({color:0x228B22}));
ground.rotation.x=-Math.PI/2; scene.add(ground);

const controls = new PointerLockControls(camera,renderer.domElement);
scene.add(controls.getObject());
document.body.addEventListener('click',()=>{ if(!controls.isLocked) controls.lock(); });

const velocity=new THREE.Vector3();
const direction=new THREE.Vector3();
const move={forward:false,backward:false,left:false,right:false};
const speed=400.0,gravity=9.8*50,jumpHeight=350;
let canJump=true;
document.addEventListener('keydown',e=>{
  switch(e.code){
    case 'KeyW': move.forward=true; break;
    case 'KeyS': move.backward=true; break;
    case 'KeyA': move.left=true; break;
    case 'KeyD': move.right=true; break;
    case 'Space': if(canJump){ velocity.y+=jumpHeight; canJump=false; } break;
  }
});
document.addEventListener('keyup',e=>{
  switch(e.code){
    case 'KeyW': move.forward=false; break;
    case 'KeyS': move.backward=false; break;
    case 'KeyA': move.left=false; break;
    case 'KeyD': move.right=false; break;
  }
});

// --- Global GUI ---
const gui = new InWorldGUI(scene, controls, camera);

// --- Sign buttons ---
const signGroup = new THREE.Group(); scene.add(signGroup);
const signBoard = new THREE.Mesh(new THREE.BoxGeometry(5,3,0.2), new THREE.MeshLambertMaterial({color:0x884400}));
signGroup.add(signBoard);
const pole = new THREE.Mesh(new THREE.CylinderGeometry(0.2,0.2,4,12), new THREE.MeshLambertMaterial({color:0x553300}));
pole.position.y=-3.5/2; signGroup.add(pole);
signGroup.position.set(10,3,-10);

// (Font/text omitted for brevity; can add as in previous example)
const jumpMesh = gui.createButton('Jump',new THREE.Vector3(0,4,0),()=>{ if(canJump){ velocity.y+=jumpHeight; canJump=false; } },signGroup);
const tpMesh = gui.createButton('Teleport Here',new THREE.Vector3(0,3.2,0),()=>{ controls.getObject().position.set(10,3,-10); },signGroup);
let lightToggle=false;
const lightMesh = gui.createButton('Toggle Light',new THREE.Vector3(0,2.4,0),()=>{ light.color.set(lightToggle?0xffffff:0xff00ff); lightToggle=!lightToggle; },signGroup);

// --- NPCs ---
const npc1 = new NPC(scene,new THREE.Vector3(5,0,-5),{
  name:'Bob',
  dialogue:['Hello!','Nice to see you again!'],
  buttons:[
    {text:'Give Item', callback:()=>{ console.log('Item given!'); }},
    {text:'Talk', callback:()=>{ npc1.nextDialogue(); }}
  ]
},gui);

const npc2 = new NPC(scene,new THREE.Vector3(-5,0,-8),{
  name:'Alice',
  dialogue:['Hi there!','Come back soon!'],
  buttons:[
    {text:'Trade', callback:()=>{ console.log('Trading...'); }},
    {text:'Talk', callback:()=>{ npc2.nextDialogue(); }}
  ]
},gui);

// --- Animate ---
let prevTime=performance.now();
function animate(){
  requestAnimationFrame(animate);
  const time = performance.now();
  const delta=(time-prevTime)/1000;

  if(controls.isLocked){
    velocity.x-=velocity.x*10*delta;
    velocity.z-=velocity.z*10*delta;
    velocity.y-=gravity*delta;

    direction.z=Number(move.backward)-Number(move.forward);
    direction.x=Number(move.left)-Number(move.right);
    direction.normalize();

    if(move.forward||move.backward) velocity.z -= direction.z*speed*delta;
    if(move.left||move.right) velocity.x -= direction.x*speed*delta;

    controls.moveRight(velocity.x*delta);
    controls.moveForward(velocity.z*delta);
    controls.getObject().position.y += velocity.y*delta;

    if(controls.getObject().position.y<2){
      velocity.y=0;
      controls.getObject().position.y=2;
      canJump=true;
    }
  }

  npc1.update(controls.getObject().position, time);
  npc2.update(controls.getObject().position, time);

  gui.update(delta);

  prevTime=time;
  renderer.render(scene,camera);
  labelRenderer.render(scene,camera);
}
animate();

window.addEventListener('resize',()=>{
  camera.aspect=innerWidth/innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(innerWidth,innerHeight);
  labelRenderer.setSize(innerWidth,innerHeight);
});
</script>
</body>
</html>
