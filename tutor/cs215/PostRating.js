if (window.XMLHttpRequest) {
    var ajax = new XMLHttpRequest();
} else {
    var ajax = new ActiveXObject("Microsoft.XMLHTTP");
}


function likePost(rating, post_id) {
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //create an object from the PHP ARRAY (JSON FORMAT)
            var result = JSON.parse(this.responseText);

            if (result.status == "ok") {
                var likes = document.getElementById('likes_' + post_id);
                likes.innerHTML = result.likes + " likes";
            } else {
                alert(result.error);

            }
        }
    }

    var data = "rating=" + rating + "&post_id=" + post_id;
    ajax.open("post", "getlike.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
}

setInterval(function(){ 
    updateLikes();
    upadatePosts();
}, 3000);

function updateLikes(){
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //create an object from the PHP ARRAY (JSON FORMAT)
            var result = JSON.parse(this.responseText);
            var len = result.length;
            
            for (var i = 0; i<len; i++){
                var likes = document.getElementById('likes_' + result[i].post_id);
                if (likes.innerHTML != result[i].likes + " likes") {
                    likes.innerHTML = result[i].likes + " likes";
                }
            }   
        }
    }

    ajax.open("post", "updatelikes.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send();
}

function upadatePosts(){
    
}