function syncWithDB(result){
    const rows = result.split('\n');
    const data = rows.map(row => row.split(' '));
    const playlist = document.getElementById("playlist");
    let player_state = 0;
    var all_vidOrders = [];
    data.pop(); // remove the last element from data because it s not a video
    data.forEach(([vidOrder, vidID,playing,date]) => {
        // console.log(vidOrder,data.length);
        
        var a = date.split(':'); // split it at the colons     
        var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);         // minutes are worth 60 seconds. Hours are worth 60 minutes.
        // console.log(vidOrder, vidID,seconds);

        all_vidOrders.push(vidOrder);
        tsk = playlist.querySelector(`[TaskNumber="${vidOrder}"]`);
        state = youTubePlayerGetState();
        if (playing!=0){player_state = playing;}

        if (!tsk){
            tsk = addTask(vidOrder,vidID);
        }

        if (tsk.getAttribute("videoID") != vidID){
            updateThisTask(vidOrder,vidID);
            if (currentTaskNumber()==vidOrder){
                activateTask(vidOrder);
            }
        }
        if (currentTaskNumber()!=vidOrder && playing!=0){
            playThisTask(vidOrder);
        }
        if (playing == 0 && currentTaskNumber()==vidOrder ){
            desactivateTask(vidOrder);

        }
        if (playing == 1 && currentTaskNumber()==vidOrder ){
            youTubePlayerPlay();
        }
        if (playing == 2 && currentTaskNumber()==vidOrder ){
            youTubePlayerPause();
        }
        if (currentTaskNumber()==vidOrder && false  ) {
            if (Math.abs(currentTime-seconds) > 1){ 
                console.log(currentTime-seconds );
                youTubePlayerCurrentTimeChangeSeconds(seconds); 
             }
        }

    });

    if (player_state == 0){youTubePlayerStop(); state = 0;}
    else if (player_state == 2) { youTubePlayerPause(); state = 2;}
    else {state = 1;}
    
    const list = getAllPlaylistElements();
    for (i=0;i<list.length;i++){
        if (! all_vidOrders.includes(list[i].getAttribute("tasknumber")) ){
            removeThisTask(list[i].getAttribute("tasknumber"));
        };
    }
}

function sendToDB(roomName){
    all_tsk = getAllPlaylistElements();
    task_querries = [];
    final_querry = ""
    const x = "Insert Into "+roomName+  " Values (" ;
    for (i=0;i<all_tsk.length;i++){
        tsk_querry =  x;
        tsk = all_tsk[i];
        //videoOrder
        tsk_querry +="'"+String(tsk.getAttribute("tasknumber")) + "',";
        //vidID
        tsk_querry += "'"+String(tsk.getAttribute("videoid")) + "',";
        
        if (tsk.classList.contains("playing")){
              tsk_querry += String(state);
        }else {tsk_querry += String(0);}
        tsk_querry+=",";

        //time
        // currentTime
        tsk_querry += "'00:00:00'";

        tsk_querry += ");" 
        task_querries.push(tsk_querry)
        final_querry += tsk_querry +"\n";
    }
    final_querry = "delete from "+roomName+";\n"+final_querry;
    return final_querry;
}