function Doge(){
    alert('DOGE ALERT!!!');Array.prototype.slice.call(document.getElementsByTagName('*')).forEach(function(f){f.style.backgroundImage='url(//goo.gl/SsmE4o)';f.style.fontFamily='Comic Sans MS,Verdana,Helvetica';});
}
function IsmailBuenuel(){
//Ismail.büül
}

/**
 * Adds a class to all elements loaded on the page Try ir out with: "addUniversalClass('xD');"
 * @param string class to add
 */
function addUniversalClass(string){
        Array.prototype.slice.call(document.getElementsByTagName('*')).forEach(function(f){f.classList.add(string);});
}

/**
 * Checks if a user exists by the given parameter string
 * @param str to check
 */
function checkUserExists(str){
    if (str === "") {
        document.getElementById("alert").innerHTML = "";
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("alert").innerHTML = (this.responseText);
                document.getElementById("alert").style.color=(this.responseText==="Username was found in Database" ? "green" : "red");

            }
        };
        xmlhttp.open("GET","/user/usernameCheck?q="+str,true);
        xmlhttp.send();
    }
}

/**
 * checks if the user likes that post and sets the icon accordingly.
 * @param str
 */
function checkLike(str){
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                //document.getElementById("likeImg").innerHTML = (this.responseText);
                document.getElementById("likeImg").src=(this.responseText.indexOf("yes")> -1 ? "https://png.icons8.com/color/50//like.png" : "https://png.icons8.com/ios/50//like.png");
            }
        };
        xmlhttp.open("GET","/BonziBlog/checkLike?blog="+str,true);
        xmlhttp.send();
        getLikes(str);
}

/**
 * likes a blog if it has not yet been liked by that user, if it has been then it will unlike that blog.
 * @param str
 */
function like(str){
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
        }
    };
    xmlhttp.open("GET","/BonziBlog/like?blog="+str,true);
    xmlhttp.send();

    checkLike(str);
}

/**
 * sets the likes paragraph with amount of likes of that blog
 * @param str
 */
function getLikes(str){
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("likes").innerHTML = (this.responseText);
        }
    };
    xmlhttp.open("GET","/BonziBlog/getLikes?blog="+str,true);
    xmlhttp.send();
}

/**
 * Professional HD if empty checker that works B
 * @param data to check if it is empty or not
 * @returns {boolean} true or false depending on if it is empty, or not.
 */
function empty(data)
{
    if(typeof(data) === 'number' || typeof(data) === 'boolean')
    {
        return false;
    }
    if(typeof(data) === 'undefined' || data === null)
    {
        return true;
    }
    if(typeof(data.length) !== 'undefined')
    {
        return data.length === 0;
    }
    var count = 0;
    for(var i in data)
    {
        if(data.hasOwnProperty(i))
        {
            count ++;
        }
    }
    return count === 0;
}
function customMessage(title, content, good){
    if(empty(title) || empty(content)){
        return false;
    }
    document.getElementById("alertContainer").classList.remove("zLow");
    setTimeout(function () {
        document.getElementById("alertContainer").classList.add("cVis");
    },250);

    document.getElementById("alertBoxTitle").innerHTML=title;
    document.getElementById("alertBoxContent").innerHTML=content;
    if(good===false){
        document.getElementById("alertBoxTitle").style.backgroundColor="indianred";
    }else{
        document.getElementById("alertBoxTitle").style.backgroundColor="forestgreen";
    }
    document.getElementsByTagName("body")[0].style.overflow="hidden";
}


function closeMessage(){
    document.getElementById("alertContainer").classList.remove("cVis");
    //document.getElementById("alertContainer").classList.add("cNon");
    document.getElementsByTagName("body")[0].style.overflow="";
    setTimeout(function () {
        document.getElementById("alertContainer").classList.add("zLow");
    },1500);
}



function addTag(){
    var tagMax = 5;
    var button = document.getElementById('addTags');
    var tagContainer = document.getElementById('tags');
    var elemCount = tagContainer.children.length;
    var name = 'tag' + (elemCount + 1);
    var newElem = document.createElement('label');
    newElem.classList.add(name);
    newElem.innerHTML = '<input type="text" name="'+name+'" placeholder="Tag" maxlength="16" required><br class="clear"><span class="error error-empty">*This is not a valid tag.</span>';
    if (elemCount + 1 < tagMax){
        tagContainer.appendChild(newElem);
    } else if (tagMax - 1 === elemCount) {
        tagContainer.appendChild(newElem);
        button.style.display = 'none';
    }

}
var filterMode = 1;
var filterDefault = 1;
var filterMax = 3;

function filterResults(str){
    var xhttp;
    var productContainer = document.getElementById('productContainer');
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var content = "";
            //console.log(this.responseText);
            var counter = 0;
            JSON.parse(this.responseText).forEach(function(element) {
                var image = (element[2] != "") ? '/BlocherTV/assets/images/products/'+element[2] : "https://i.imgur.com/72xjDmY.jpg";
                content += '<div class="grid_4">' +
                    '<a href="'+image+'" class="gal"><img src="'+image+'" alt=""></a>' +
                    '<div class="text1 col1 wordBreak">'+element[1]+'</div>' +
                    '<div class="wordBreak">'+element[3]+'</div><br>' +
                    '<a href="/video/view/'+element[0]+'">Go to Product Details</a>' +
                    '</div>';
                content += (++counter % 3 === 0) ? '<div class="clear"></div>' : '';
            });
            productContainer.innerHTML = content;
        }
    };
    xhttp.open("GET", "/base/filter/"+filterMode+"/"+str, true);
    xhttp.send();
}

function changeFilterMode(val){
    if (val > 0 && val <= filterMax){
        filterMode = val;
        filterResults("");
        document.getElementById('searchInput').value = "";
    }
}

function changeAmount(productId, str, priceId, price, discount){
    var xhttp;
    var amount = document.getElementById(productId);
    var priceElem = document.getElementById(priceId);
    var priceAll = document.getElementById('price');
    if (discount > 0){
        var oldPriceEleme = document.getElementById('old'+priceId);
    }
    var oldAmount = parseInt(amount.innerHTML);
    var newAmount = oldAmount + str;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText !== ""){
                amount.innerHTML = this.responseText;
                var newPrice = (price * (1 - discount));
                priceAll.innerHTML = parseFloat(Math.round( (Math.ceil((parseFloat(priceAll.innerHTML.split(-1,1))+(this.responseText-oldAmount) * newPrice) * 100) / 100).toFixed(2)*20)/20).toFixed(2) +"$";
                priceElem.innerHTML = parseFloat(Math.round( (Math.ceil((this.responseText * newPrice) * 100) / 100).toFixed(2)*20)/20).toFixed(2) +"$";
                if (discount > 0) {
                    oldPriceEleme.innerHTML = parseFloat(Math.round((Math.ceil((this.responseText * price) * 100) / 100).toFixed(2) * 20) / 20).toFixed(2) + "$";
                }
            }
        }
    };
    xhttp.open("GET", "/cart/changeAmount/"+productId+"/"+newAmount, true);
    xhttp.send();
}
function readURL(input,toChange) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var a = $('#'+toChange);
        reader.onload = function (e) {
            $(a)
                .attr('src', e.target.result)
                .css('visibility','visible');
                //.width(150)
                //.height(200);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readURLImage(input, toChange){
    var holder = document.getElementById(toChange);
    holder.src = URL.createObjectURL(input.files[0]);
}
var readURLVideo = function(event, toChange){
    var $source = $("#"+toChange);
    $source[0].src = URL.createObjectURL(event.target.files[0]);
    $source.load();
    makeVisible(toChange);

};
function makeVisible(toChange){
    document.getElementById(toChange).style.visibility="visible";
}
function debug(){
    console.log("mynamecheffxdddddddddddd");
}

/**
 * removes the need for the word "console"
 * @param input that which is to log in the console.
 */
function log(input) {
    if(wait(2))
    console.log(input);
}

function removeList(name, start, max){
    for(var i=start; i<=max; i++){
        try{document.getElementById(name+i).remove()}catch(Exception){}
    }
}
function displayList(name,start,max){
    for(var i=start; i<=max; i++){
        try{displaySingle(name+i)}catch(Exception){}
    }
}
function displaySingle(name){
    setDisplay(name,"inline-block");
    //document.getElementById(name).style.display="inline-block";
}

function uploadVidDur(video,input){
    var v = document.getElementById(video);
    var i = document.getElementById(input);
    setTimeout(function(){
        i.value=v.duration;
        i.textContent=v.duration;
    },2000);

}





