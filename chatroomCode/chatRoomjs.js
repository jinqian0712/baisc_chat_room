var genericGetRequest = function(URL,callback){
    var xhr = new XMLHttpRequest();
    xhr.onload = function(){
        if(this.status == 200){
            callback(JSON.parse(this.response));
        }else{
            console.log("GET data failed!");
        }
    };

    xhr.open("GET",URL);
    xhr.send();
};

var showMsg = function(msgArray){
    var $showMessage = document.querySelector("#msgList");
    document.querySelector("#msgList").innerHTML="";
    for(var i=0;i<msgArray.length;i++){
        var thisMsg = msgArray[i];
        var $el = document.createElement("li");
        $el.innerHTML = `${thisMsg.username}: ${thisMsg.msg}`;
        $showMessage.appendChild($el);
    }
};

setInterval(function(){
    genericGetRequest("/chatroomCode/chatRoom.php",showMsg);
},1000);

document.querySelector("#msgSend").addEventListener("click",function(){
    //document.querySelector("#msgInput").value = "";
    var userName = document.querySelector("#usernameInput").value;
    var userMsg = document.querySelector("#msgInput").value;
    //document.querySelector("#msgInput").value = "";
    //console.log({username:userName,msg:userMsg});
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST",'chatroomCode/chatRoom.php',true);
    xhr.setRequestHeader('Content-type','application/json');
    xhr.onload = function(){
       console.log(this.responseText);
    };
    xhr.send(JSON.stringify({username:userName,msg:userMsg}));
    document.querySelector("#msgInput").value = "";
});