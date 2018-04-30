/**
 * Universal [PC](Chrome,Firefox,Edge) Full screen function for html5 videos
 * @author Campiotti
 * @param video video element to make or exit full screen.
 */
function fullScreenVideo(video){
    var isFullScreen = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
    if(!isFullScreen){
        try{video.webkitRequestFullScreen();}catch(Exception){}
        try{video.mozRequestFullScreen();}catch(Exception){}
        try{video.requestFullScreen();}catch(Exception){}
    }else{
        try{video.webkitExitFullScreen();}catch(Exception){}
        try{video.mozCancelFullScreen();}catch(Exception){}
        try{video.exitFullScreen();}catch(Exception){}
    }
}

function remVideoInfo(video, info, alt){
    video = document.getElementById(video);
    info = document.getElementById(info);
    alt = document.getElementById(alt);
    var overlay = document.getElementById("darkOverlay");
    overlay.style.display="block";
    info.style.visibility="hidden";
    alt.style.display="inline-block";
    video.classList.remove("grid_8");
    video.classList.add('videoBackground');
}
function addVideoInfo(video, info, alt){
    video = document.getElementById(video);
    info = document.getElementById(info);
    alt = document.getElementById(alt);
    var overlay = document.getElementById("darkOverlay");
    overlay.style.display="none";
    info.style.visibility="visible";
    alt.style.display="none";
    video.classList.remove('videoBackground');
    video.classList.add("grid_8");
}

function videoMagic(video){
    if(video.paused===true)
        video.play();
    else
        video.pause();
}

/**
 * favourites a video (uses currently logged in user)
 * @param id int this is the id of the video being favoured
 * @param btn button which was clicked to favourite, text-changes made to visually confirm to user.
 * @param waitTimer experimental used to set delay how long colorChanger will stay on btn
 */
function favourite(id, btn, waitTimer){
    var xhttp;
    var c="colorChanger";
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            addClass(btn,c);
            if(waitTimer!==null && waitTimer!==0){
                setTimeout(function () {
                    removeClass(btn,c);
                    getFavourites(id,"favCount");
                },waitTimer);
            }
            if(xhttp.responseText==="saved"){
                btn.innerHTML="unfavourite";
                //change icon to added or change from + to -
            }else{
                btn.innerHTML="favourite";
                //change icon to not yet faved or from - to +
            }
        }

    };

        xhttp.open("GET", "/video/favourite/"+id, true);
        xhttp.send();


}

function favouriteList(id){
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            if(xhttp.responseText==="saved"){
                //should not happen because it should not be on the page at all if it's not a fave already...
                location.reload();
                //change icon to added or change from + to -
            }else{
                //change icon to not yet faved or from - to +
                spcialize("fave"+id);
                setTimeout(function () {
                    document.getElementById("fave"+id).remove();
                    document.getElementById("dontLook").innerHTML=""+(parseInt(document.getElementById("dontLook").innerHTML)-1);
                    checkFaves();
                },500);

            }
        }

    };
    xhttp.open("GET", "/video/favourite/"+id, true);
    xhttp.send();
}
function checkFaves(){
    var tmp =parseInt(document.getElementById("dontLook").innerHTML);
    //for some reason says 2 even if it's a completely empty div... [only with get child count]
    if(tmp===0){
        removeList("remove",1,10);
        displayList("show",1,10);
    }
}
function addView(id,userId,key){
    var xhttp;
    xhttp = new XMLHttpRequest();
    var views = document.getElementById("views");
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            views.innerHTML=xhttp.responseText;
        }

    };
    xhttp.open("GET", "/video/addView/"+id+"/"+userId+"/"+key, true);
    xhttp.send();
}
function view(args){
    var video = document.getElementById("video");
    alert("view trigggereeered");
    video.onclick="videoMagic(this);";
    wait(video.duration/2,"addView",args);
}

function videoNotAvailable(video,image){
    video = document.getElementById(video);
    video.poster=image;
}

function delHover(event){
    var id=event.dataTransfer.getData("id");
//    document.getElementById("img_"+id).classList.add('img_special');
    favouriteList(id)
}
function startHover(event, elem,id){
    event.dataTransfer.setData('id',id);

}

function videoList(id){
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            if(xhttp.responseText==="error"){
                location.reload();
                //change icon to added or change from + to -
            }else{
                if(xhttp.responseText==="deleted"){
                    //change icon to not yet faved or from - to +
                    document.getElementById("vid"+id).remove();
                    document.getElementById("dontLook").innerHTML=""+(parseInt(document.getElementById("dontLook").innerHTML)-1);
                    checkVids();
                }
            }
        }

    };
    xhttp.open("GET", "/video/delete/"+id, true);
    xhttp.send();
}

function checkVids(){
    if(parseInt(document.getElementById("dontLook"))===0){
        removeList("remove",1,10);
        displayList("show",1,10);
    }
}
function spcialize(id){
    document.getElementById(id).classList.add('special')
}

/**
 * Gets the amount of favourites from a video by its id
 * @param id int id of the video
 */
function getFavourites(id, elem){
    var xhttp;
    var e = elem;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById(e).innerHTML="Favourites: "+xhttp.responseText;
            //alert(xhttp.responseText);
        }

    };
    xhttp.open("GET", "/video/getFavourites/"+id, true);
    xhttp.send();
}