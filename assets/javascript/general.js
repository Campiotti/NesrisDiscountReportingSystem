/**
 * This is here to provide a few general functions which may or may not be used by other js files.
 * They're simply here to provide a simpler usage of JS (sort of like a library)
 * @author Campiotti
 */

function setVisible(elemOrId){
    try{document.getElementById(elemOrId).style.visibility="visible";}
    catch (e){elemOrId.style.visibility="visible";}
}

function setHidden(id){
    try{document.getElementById(id).style.visibility="hidden";}
    catch (e){id.style.visibility="hidden";}
}

function setDisplay(elemOrId,type){
    try{document.getElementById(elemOrId).style.display=type;}
    catch(e){elemOrId.style.display=type;}
}

function getValue(elemOrId){
    var res=null;
    try{res=document.getElementById(elemOrId).value;}
    catch(e){res=elemOrId.value;}
    return res;
}

function prevDef(event){
    event.preventDefault();
}

function getChildCount(elemOrId){
    var res=null;
    try{res=document.getElementById(elemOrId).childNodes.length;}
    catch (e){res=elemOrId.childNodes.length;}
    return res;
}

function addClass(elemOrId, className){
    try{document.getElementById(elemOrId).classList.add(className);}
    catch(e){elemOrId.classList.add(className);}
}

function removeClass(elemOrId, className){
    try{document.getElementById(elemOrId).classList.remove(className);}
    catch (e){elemOrId.classList.remove(className);}
}
//experimental
function clearClassList(elemOrId){
    try{document.getElementById(elemOrId).classList.remove();}
    catch (e){elemOrId.classList.remove()}
}

/**
 * Holds up the whole page and every other line of code or loading thing in existence.
 * Waits a certain amount of time (given in milliseconds) until continuing execution of the js code.
 * @param ms milliseconds of time to wait before continuing.
 */
function waitFull(ms){
    var start = new Date().getTime();
    var end = start;
    while(end < start + ms) {
        end = new Date().getTime();
    }
}

/**
 * Runs code (without holding up page or other loading elements) after a set amount of time)
 * @param time how many seconds it'll wait until it runs.
 * @param func function to run (name of the function)
 * @param args argument(s?) to give said function
 */
function wait(time, func, args) {
    var a=func.toString();
    var b=args;
    setTimeout(function () {
        window[a](b);
    }, time*1000);
}