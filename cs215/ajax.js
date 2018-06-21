if (window.XMLHttpRequest) {
    var ajax = new XMLHttpRequest();
} else {
    var ajax = new ActiveXObject("Microsoft.XMLHTTP");
}

function executeLogin(email, password) {
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == 'ok') {
                window.location.replace("initial.php");
            } else {
                alert(this.responseText);
            }
        }
    }

    var data = 'task=login&email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password);
    ajax.open("post", 'process/user.php', true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
}

function checkEmail(ev) {
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var hit = document.getElementById('hit_email');
            var classes = 'help is-danger';
            if (this.responseText == 'ok') {
                hit.className = classes + ' dpn';
            } else {
                hit.className = classes;
                hit.innerHTML = this.responseText;
            }
        }
    }

    var data = 'task=email&email=' + encodeURIComponent(ev.target.value);
    ajax.open("post", 'process/user.php', true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
}

function executeAutoUpdate() {
  console.log('cheching update');
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById('tempresult').innerHTML = this.responseText;
            var result = JSON.parse(this.responseText);
            console.log(result);
            if (result && typeof result == 'object') {
                var len = result.length;
                if (document.getElementById('allposts')) {
                    var html = '';
                    for (var i = 0; i < len; i++) {
                        html += result[i].html;
                    }
                    var el = document.getElementById('allposts');
                    var temp = document.createElement('div');
                    temp.innerHTML = html;
                    el.insertBefore(html, el.firstElementChild);
                    updateLastPost();
                } else {
                  //NOTIFICATION API
                  var msg = 'You have ' + len + ' new posts. Check in your homepage';
                  notifyMe(msg);
                }

            } else if (result = 'there is no result for your query') {

            } else {
                alert('Error in your request. Try again later');
                autoUpdate();
                console.log(this.responseText);
            }
        }
    }

    var data = 'task=update&id=' + localStorage.post;
    console.log(data);
    ajax.open("post", 'process/post.php', true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
}

function executeSavePost(form, formData) {
    document.getElementById('tempresult').innerHTML = 'Wait a moment...';
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //console.log('get the result');
            //console.log(this.responseText);
            //document.getElementById('tempresult').innerHTML = this.responseText;

            form.btnsubmit.value = 'Submit'
            if (this.responseText == 'ok') {
                form.reset();
                executeAutoUpdate();
            } else {
                alert(this.responseText);
            }
            document.getElementById('tempresult').innerHTML = '';
        }
    }

    ajax.open("post", 'process/post.php', true);
    ajax.send(formData);
}

function executeDeletePost(id) {
  document.getElementById('tempresult').innerHTML = 'Wait a moment...';
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById('tempresult').innerHTML = this.responseText;
            if (this.responseText == 'ok') {

              var postId = 'post_'+id;
              console.log('deleting post ' + postId);
                var el = document.getElementById(postId);
                el.remove();
            } else {
                alert(this.responseText);
            }
            document.getElementById('tempresult').innerHTML = '';
        }
    }

    var data = 'task=delete&id=' + id;
    ajax.open("post", 'process/post.php', true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
}

function executeFavorite(id) {
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById('tempresult').innerHTML = this.responseText;
            if (this.responseText == 'ok') {
                var btn = document.getElementById('fav_' + id);
                console.log(btn);
                if (btn.innerHTML == 'unfavorite') {
                    btn.innerHTML = 'favorite';
                } else {
                    btn.innerHTML = 'unfavorite';
                }
            } else {
                alert(this.responseText);
            }
        }
    }

    var data = 'task=favorite&id=' + id;
    ajax.open("post", 'process/post.php', true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
}

function updateLastPost() {
    if (all_posts = document.getElementById('allposts')) {
        var id = all_posts.firstElementChild.id.replace('post_', '');
        localStorage.setItem("post", id);
    }

}
