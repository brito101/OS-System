$(document).ready((function(){const e=document.getElementById("player"),t=document.getElementById("canvas"),n=t.getContext("2d"),a=document.getElementById("capture"),c=document.getElementById("cover_base64");a.addEventListener("click",(a=>{a.preventDefault(),n.drawImage(e,0,0,t.width,t.height),c.value=t.toDataURL("image/jpeg",.5)})),navigator.mediaDevices.getUserMedia({video:{facingMode:"environment"}}).then((t=>{e.srcObject=t})).catch((function(e){$(".capture_container").hide(),console.log(`Cam error: ${e.name}`)}))}));
