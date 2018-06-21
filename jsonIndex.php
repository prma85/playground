<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CS 215 Examples</title>
        <style>* { font-size: 20px;}</style>
    </head>
    <body>
      <div id="result">
      </div>
      <a href="javascript:loadDoc()">Load Database</a>
      <a href="javascript:loadDoc()">Load Notification</a>
      <script>
      function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      var result = JSON.parse(this.responseText);
      if (typeof result == 'String'){
        alert (result);
      }
      var len = result.length;

      var html = '';
      for (var i = 0; i < len; i++){
        html += '<div><b>Name:</b>'+result[i].name+'</div>';
      }
      console.log(result);
     document.getElementById("result").innerHTML = html;
    }
  };
  xhttp.open("GET", "json.php", true);
  xhttp.send();
}
      </script>


      <script>
      function notifyMe() {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
      alert("This browser does not support desktop notification");
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
      // If it's okay let's create a notification
      var notification = new Notification("Hi there!");
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== "denied") {
      Notification.requestPermission(function (permission) {
        // If the user accepts, let's create a notification
        if (permission === "granted") {
          var notification = new Notification("Hi there!");
        }
      });
    }
  }

      </script>
    </body>
    </html>
