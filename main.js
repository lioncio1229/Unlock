let toggleVisibility = true;

function toggleMenu(){
    let getGetMenu = document.querySelector(".menu");

    if(toggleVisibility){
        getGetMenu.style.visibility = "unset";
    }
    else{
        getGetMenu.style.visibility = "hidden";
    }
    toggleVisibility = !toggleVisibility;
}

function toggleMenuOff() {
    if(!toggleVisibility){
        toggleMenu();
    }
}

function generatePDF()
{
    toggleMenuOff();
    window.location.href = "index.php?printWindowOpen=1";
}

function closePrintWindow()
{
    toggleMenuOff();
    window.location.href = "index.php?printWindowOpen=0";
}

function deleteAll(){
    toggleMenuOff();
    let isYes = confirm("Do you want to delete all records?");

    if(isYes){
       $.ajax({
            url: 'Javascript_Data_Processor.php',
            type: 'post',
            data: { functionName: "deleteAll"},
            success: function(response) { 
                $('body').html(response);
            }
        })
    }
}

function showUploadWindow()
{
    var window = document.getElementById("upload-image-window");
    window.style.display = "block";
}

function closeWindow()
{
    var window = document.getElementById("upload-image-window");
    window.style.display = "none";
}

function registerCard(cardNumber, tagID){

    var userName = document.getElementById(tagID).value;
    
    let errorMessage = "";

    if(userName == "") errorMessage = "Username required";
    else if(userName.length > 20) errorMessage = "Username should be less then 20 characters";

    if(errorMessage != "")
    {
        alert(errorMessage);
        return;
    }

    let isYes = confirm("Do you want to register \n Username : "+userName+"\n Cardnumber : "+cardNumber);

    if(isYes){
        $.ajax({
            url: 'Javascript_Data_Processor.php',
            type: 'post',
            data: { functionName:"register",arguments:[userName, cardNumber]}
            ,
            success: function(response) { 
                $('body').html(response);
            }
        })
    }
}

addEventListener('mousemove', setPos, false)

let posX;
let posY;

function setPos(position)
{
    posX = position.pageX;
    posY = position.pageY;
}

function showImage(fileName)
{
    let style = document.getElementById('img-icon').style;
    style.display = "block";
    style.backgroundImage = "url('uploads/"+fileName+"')";
    style.top = posY - 100+"px";
}

function closeImage()
{
    let style = document.getElementById('img-icon').style;
    style.display = "none";
}

