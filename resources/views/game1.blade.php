<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Game 1') }}
        </h2>
    </x-slot>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial_scale=1.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
	<title>Game 1</title>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Montserrat');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  font-family: 'Montserrat', sans-serif;
  background-color: #eee;
  color: #111;
}

.draggable-elements {
  display: flex;
  justify-content: center;
  margin: 2rem;
}
.draggable {
  height: 5rem;
  width: 5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 4rem;
  margin: 0rem 0.5rem;
  cursor: move;
  transition: opacity 0.2s;
}
.draggable:hover {
  opacity: 0.5;
}
.droppable {
  height: 6.5rem;
  width: 6.5rem;
  display: flex;
  margin: 1rem auto;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  text-align: center;
  font-size: 4rem;
  font-weight: bold;
  background-color: #fff;
  border: 3px dashed #111;
  transition: border-width 0.2s, transform 0.2s, background-color 0.4s;
}
.droppable span {
  font-size: 1.25rem;
  pointer-events: none;
  flex-direction: row; 
  /* The element is never the target of pointer events */
}

/* Drag and Drop Related Styling */

.droppable.droppable-hover {
  /* background-color: #bee3f0; */
  border-width: 5px;
  transform: scale(1.1);
}
.droppable.dropped {
  border-style: solid;
  color: #fff;
}
.droppable.dropped span {
  font-size: 0.75rem;
  margin-top: 0.5rem;
}
.droppable.dropped i {
  pointer-events: none;
}
.draggable.dragged {
  user-select: none;
  opacity: 0.1;
  cursor: default;
}
.draggable.dragged:hover {
  opacity: 0.1;
}
#btn{
	position: absolute;
	margin-left: 45.5%;
}
#next-game-btn {
  font-size: 1rem;
  font-weight: bold;
  color: #fff;
  background-color: #111;
	border: 5px double #fff; 
	border-radius: 14px;
	padding: 8px 10px;  
  outline: none;
  letter-spacing: .05em;
  cursor: pointer;
}

@media (max-width: 600px) {
  html { font-size: 14px; }
  .draggable-elements { margin: 1.0rem; }
}
</style>
</head>
<body>
	
    <section class="draggable-elements">
    <i class="fas fa-cat draggable" draggable="true" style="color: #ff6384;" id="cat"></i>
    <i class="fas fa-dog draggable" draggable="true" style="color: #36a2eb;" id="dog"></i>
    <i class="fas fa-dove draggable" draggable="true" style="color: #ffce56;" id="dove"></i>
    <i class="fas fa-fish draggable" draggable="true" style="color: #9966ff;" id="fish"></i>
    <i class="fas fa-frog draggable" draggable="true" style="color: #4bc0c0;" id="frog"></i>
    <!-- <i class="fas fa-horse draggable" draggable="true" style="color: #333333;" id="horse"></i>
    <i class="fas fa-hippo draggable" draggable="true" style="color: #ff9f40;" id="hippo"></i>
    <i class="fas fa-spider draggable" draggable="true" style="color: #ff99cc;" id="spider"></i> -->
  </section>
  <section class="droppable-elements">
    <div class="droppable" data-draggable-id="frog"><span>Frog</span></div>
    <div class="droppable" data-draggable-id="dove"><span>Bird</span></div>
    <div class="droppable" data-draggable-id="cat"><span>Cat</span></div>
    <div class="droppable" data-draggable-id="fish"><span>Fish</span></div>
    <div class="droppable" data-draggable-id="dog"><span>Dog</span></div>
    <!-- <div class="droppable" data-draggable-id="spider"><span>Spider</span></div>
    <div class="droppable" data-draggable-id="horse"><span>Horse</span></div>
    <div class="droppable" data-draggable-id="hippo"><span>Hippo</span></div> -->
  </section>
  <section id="btn">
  	<form action="{{route('game1store')}}" method="post">
  		@csrf
  		@method('post')
  		<input type="number" name="score1" value="5" hidden>
  	<button id="next-game-btn" type="submit">Next game</button>
  	</form>
  </section>
  <script>
  	const draggableElements = document.querySelectorAll(".draggable");
const droppableElements = document.querySelectorAll(".droppable");

draggableElements.forEach(elem => {
  elem.addEventListener("dragstart", dragStart); // Fires as soon as the user starts dragging an item - This is where we can define the drag data
  // elem.addEventListener("drag", drag); // Fires when a dragged item (element or text selection) is dragged
  // elem.addEventListener("dragend", dragEnd); // Fires when a drag operation ends (such as releasing a mouse button or hitting the Esc key) - After the dragend event, the drag and drop operation is complete
});

droppableElements.forEach(elem => {
  elem.addEventListener("dragenter", dragEnter); // Fires when a dragged item enters a valid drop target
  elem.addEventListener("dragover", dragOver); // Fires when a dragged item is being dragged over a valid drop target, repeatedly while the draggable item is within the drop zone
  elem.addEventListener("dragleave", dragLeave); // Fires when a dragged item leaves a valid drop target
  elem.addEventListener("drop", drop); // Fires when an item is dropped on a valid drop target
});

// Drag and Drop Functions

//Events fired on the drag target

function dragStart(event) {
  event.dataTransfer.setData("text", event.target.id); // or "text/plain" but just "text" would also be fine since we are not setting any other type/format for data value
}

//Events fired on the drop target

function dragEnter(event) {
  if(!event.target.classList.contains("dropped")) {
    event.target.classList.add("droppable-hover");
  }
}

function dragOver(event) {
  if(!event.target.classList.contains("dropped")) {
    event.preventDefault(); // Prevent default to allow drop
  }
}

function dragLeave(event) {
  if(!event.target.classList.contains("dropped")) {
    event.target.classList.remove("droppable-hover");
  }
}

function drop(event) {
  event.preventDefault(); // This is in order to prevent the browser default handling of the data
  event.target.classList.remove("droppable-hover");
  const draggableElementData = event.dataTransfer.getData("text"); // Get the dragged data. This method will return any data that was set to the same type in the setData() method
  const droppableElementData = event.target.getAttribute("data-draggable-id");
  const isCorrectMatching = draggableElementData === droppableElementData;
  if(isCorrectMatching) {
    const draggableElement = document.getElementById(draggableElementData);
    event.target.classList.add("dropped");
    // event.target.style.backgroundColor = draggableElement.style.color; // This approach works only for inline styles. A more general approach would be the following: 
    event.target.style.backgroundColor = window.getComputedStyle(draggableElement).color;
    draggableElement.classList.add("dragged");
    draggableElement.setAttribute("draggable", "false");
    event.target.insertAdjacentHTML("afterbegin", `<i class="fas fa-${draggableElementData}"></i>`);
  }
}
</script>
</body>
</html>
</x-app-layout>