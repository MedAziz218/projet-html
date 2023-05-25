if(document.readyState == "loading"){
    document.addEventListener("DOMContentLoaded", ready);
}
else{
    ready();
}

function makeSureToPlay(){
   if (youTubePlayerActive() ){
        var state = youTubePlayer.getPlayerState();
        if (state != 1){
            
            youTubePlayerPlay();
            setTimeout(makeSureToPlay,500);
            console.log("making sure to play "+state);
        }
   } else {
    
    console.log("making sure to play "+ "no state");
   }
}
function myOnReady(){
    // const urlInput = document.getElementById("URL-input");
    const vidContainer = document.getElementById("video-group");
    vidContainer.style.display = "none";
    // urlInput.value = "https://www.youtube.com/watch?v=WSKi8HfcxEk";
    // addTask();

    
        
}
function myOnStateChange(state){
    // console.log("state: "+state);
    var pauseBtn = document.getElementsByClassName("pause-play")[0];
    if (state == 1) {
        pauseBtn.childNodes[1].classList.value = "fa fa-pause";
    }else if (state == 2){
        pauseBtn.childNodes[1].classList.value = "fa fa-play";

    }
}

function ready(){
    var addTaskBtn = document.getElementById("add-btn");
    var clearTaskBtn = document.getElementById("clear-btn");
    var pauseBtn = document.getElementsByClassName("pause-play")[0];
    var nextBtn = document.getElementsByClassName("next")[0]
    var previousBtn = document.getElementsByClassName("previous")[0]
    const input = document.getElementById("URL-input");
  
    input.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
        addTask();
        }
    });
    addTaskBtn.addEventListener("click", ()=>{addTask();test_up();});
    clearTaskBtn.addEventListener("click",()=>{clearTasks();test_up();} );
    pauseBtn.addEventListener("click",()=>{pauseOrplay();test_up();})
    nextBtn.addEventListener("click",()=>{nextTask();test_up();});
    previousBtn.addEventListener("click",()=>{previousTask();test_up();});
}   
function pauseOrplay(){
    var pauseBtn = document.getElementsByClassName("pause-play")[0];

    if (youTubePlayerActive()){
        if (youTubePlayer.getPlayerState() == 1){
            youTubePlayerPause();
            state = 2;
            // pauseBtn.childNodes[1].classList.value = "fa fa-play";  
        }
        else {
            youTubePlayerPlay();
            state = 1;
            // pauseBtn.childNodes[1].classList.value = "fa fa-pause";
        }
    }
   

}
// Task logic 
// var currentTaskNumber = 0;  //-1 means empty;
var TaskCount = 0;
var state = 0;
function currentTaskNumber(){
    const playlist = document.getElementById("playlist");
    const currentTask = playlist.getElementsByClassName("playing");
    if (currentTask.length >0){
        return parseInt(currentTask[0].getAttribute("TaskNumber"));
    }
    else {
        return -1;
    }
}
function desactivateTask(taskIndex){
    if (taskIndex<0){return;}
    const tsk = getPlaylistElement(taskIndex);
    if (tsk.classList.contains("playing")){
        tsk.classList.remove("playing");
    }
    youTubePlayerStop();
}
function activateTask(taskIndex){
    const tsk = getPlaylistElement(taskIndex);
    const videoID = tsk.getAttribute("videoID");
    tsk.classList.add("playing");
    console.log(videoID);
    youTubePlayerChangeVideoId(videoID);
    makeSureToPlay();
    
    
}
function playThisTask(taskIndex){
    desactivateTask(currentTaskNumber());
    activateTask(taskIndex);
    state = 1;
}
function nextTask(){
    taskNumbers = getAllTaskNumbers();
    nextTaskNumber = taskNumbers[ taskNumbers.indexOf(currentTaskNumber()) +1];
    if (nextTaskNumber>=0){
        playThisTask(nextTaskNumber);
    }
}
function previousTask(){
    taskNumbers = getAllTaskNumbers();
    prevTaskNumber = taskNumbers[ taskNumbers.indexOf(currentTaskNumber()) -1];

    if (prevTaskNumber>=0){
        playThisTask(prevTaskNumber);
    }
} 
function getAllPlaylistElements(){
    return document.getElementById("playlist").querySelectorAll(".task-element");
}
function getPlaylistElement(taskIndex){
    return document.getElementById("playlist").querySelector(`[TaskNumber="${taskIndex}"]`);
} 
function getAllTaskNumbers(){
    var playlist = document.getElementById("playlist");

    // Get all child elements with class "task-element"
    var taskElements = playlist.querySelectorAll(".task-element");

    // Create an array to store the task numbers
    var taskNumbers = [];

    // Loop through the task elements and retrieve the "tasknumber" attribute
    for (var i = 0; i < taskElements.length; i++) {
        var taskElement = taskElements[i];
        var taskNumber = taskElement.getAttribute("TaskNumber");
        taskNumbers.push(parseInt(taskNumber));  
    }

    return taskNumbers.sort();
}
function moveUpThisTask(taskIndex){
    taskIndex = parseInt(taskIndex);
    taskNumbers = getAllTaskNumbers();
    prevTaskNumber = taskNumbers[ taskNumbers.indexOf(taskIndex) -1];
    if (taskIndex >0 && prevTaskNumber>=0){
        const t1 = getPlaylistElement(prevTaskNumber)
        const t2 = getPlaylistElement(taskIndex);
        t1.style.order = taskIndex; 
        t1.setAttribute("TaskNumber",taskIndex);
        t2.style.order = prevTaskNumber; 
        t2.setAttribute("TaskNumber",prevTaskNumber);
    }
}
function updateThisTask(taskIndex,newVidId){
    var tsk = getPlaylistElement(taskIndex);
    tsk.setAttribute("videoID",newVidId);
    img = tsk.getElementsByTagName("img")[0];
    img.setAttribute("src",youtube_thumbnail_url(newVidId));

}
function moveDownThisTask(taskIndex){
    taskIndex = parseInt(taskIndex);
    taskNumbers = getAllTaskNumbers();
    nextTaskNumber = taskNumbers[ taskNumbers.indexOf(taskIndex) +1];
    // if (taskIndex <TaskCount-1 && nextTaskNumber>=0){
    if (nextTaskNumber>=0){

        const t1 = getPlaylistElement(nextTaskNumber)
        const t2 = getPlaylistElement(taskIndex);
        t1.style.order = taskIndex; 
        t1.setAttribute("TaskNumber",taskIndex);
        t2.style.order = nextTaskNumber; 
        t2.setAttribute("TaskNumber",nextTaskNumber);
    }
}
function removeThisTask(taskIndex){
    taskIndex = parseInt(taskIndex);
    var tsk = getPlaylistElement(taskIndex);

    if (0<=taskIndex <=TaskCount-1){ 
        if (tsk.classList.contains("playing")){
            desactivateTask(taskIndex);
        }
        tsk.remove();}
    // if (taskIndex < TaskCount-1){
    //     for (let i=taskIndex;i<TaskCount-1;i++){
    //        tsk = getPlaylistElement(i+1);
    //        tsk.style.order = i;
    //        tsk.setAttribute("TaskNumber",i);
    //     } 
    // }
}   
function myvoidLoop(){
    
    state = youTubePlayer.getPlayerState();
    if (state != -1  ){
        const vgrp = document.getElementById("video-group");
        if (TaskCount>=1 && vgrp.style.display == "none"){
            document.getElementById("no-media-info").style.display="none";
            vgrp.style.display = "block";
            
        }
        else if (TaskCount==0 && vgrp.style.display != "none"){
            document.getElementById("no-media-info").style.display="flex";
            vgrp.style.display = "none";
        }
    }
    test();
    if (!youTubePlayerActive() || TaskCount<=0 || currentTaskNumber()==TaskCount-1 ){
        return ;
    }   
    if (state == 0){
        nextTask();
    } 
    
}
function addTask(customTaskCount = null,customVidId=null){
    var urlInput = document.getElementById("URL-input");
    if (customVidId !=null){
        console.log("|||>>",customVidId);
        // urlInput.value=customVidId;
        // var yt_vid_id = urlInput.value;
        yt_vid_id = customVidId;

    } else {
        if(urlInput.value == ""){
            window.alert("please enter a valid youtube URL");
            return
        }
        else if (yt_vid_id == false){
            window.alert("The URL you entered is not valid\nplease try again.");
            return
        }
        var yt_vid_id = youtube_parser(urlInput.value);
        urlInput.value = ""
    }
    
    var taskList = document.getElementById("playlist");    
    
    var taskElement = document.createElement("div");
    if (customTaskCount==null){
        taskElement.style.order =  Math.max(...getAllTaskNumbers())+1;        ;
    } else {
        taskElement.style.order = customTaskCount;
    }

    taskElement.setAttribute("videoID",yt_vid_id);
    taskElement.setAttribute("TaskNumber",taskElement.style.order);
    TaskCount += 1;
    taskElement.classList.add("task-element");
    taskElement.classList.add("form-group");

    {   /* Thubmnail */
        var thumbnail = document.createElement("figure");
        
        thumbnail.classList.add("thumbnail");
        thumbnail.innerHTML = `
        <img src="${youtube_thumbnail_url(yt_vid_id)}"/> 
        <figcaption class="overlay">
        <i class="fa fa-play" style="font-size: 3rem;"></i>
        </figcaption>`;
        
        thumbnail.addEventListener("click",()=>{playThisTask(taskElement.getAttribute("TaskNumber")); test_up();});
        taskElement.appendChild(thumbnail);
    }
    
    {   /* Label */
        var label = document.createElement("label");
        label.classList.add("yt-title");
        label.setAttribute("for", "task");
        youtube_title(yt_vid_id).then(vidData=>{label.innerText =vidData.title;});
        taskElement.appendChild(label);
    }
    
    {   /* Thubmnail */
        var thumbnail2 = document.createElement("div");

        thumbnail2.classList.add("wrapper");
        thumbnail2.innerHTML = `
        <i class="fa fa-arrow-up"style="font-size: 2rem;"></i>
        <i class="fa fa-trash"style="font-size: 2rem;"></i>
        <i class="fa fa-arrow-down"style="font-size: 2rem;"></i>
        `
        
        thumbnail2.children[0].addEventListener("click",()=>{moveUpThisTask(taskElement.getAttribute("TaskNumber"));test_up();})
        thumbnail2.children[1].addEventListener("click",()=>{removeThisTask(taskElement.getAttribute("TaskNumber"));test_up();})
        thumbnail2.children[2].addEventListener("click",()=>{moveDownThisTask(taskElement.getAttribute("TaskNumber"));test_up();})
        
        taskElement.appendChild(thumbnail2);
    }
    taskList.appendChild(taskElement);
    
    
    if (TaskCount == 1){
        // activateTask(0);
    }
    return taskElement;
    
}

function clearTasks(){
    var allTasks = document.getElementsByClassName("task-element"); 
    TaskCount = 0;
    youTubePlayerChangeVideoId(defaultVideoID);
    youTubePlayerStop();
    while(allTasks.length != 0){
        allTasks[0].remove();
    }
}
