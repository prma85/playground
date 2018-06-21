if (login = document.getElementById('login')) {
    login.addEventListener('submit', validateLogin);
}
if (message = document.getElementById('message')) {
    message.addEventListener('keyup', countMessage);
}
if (sign_email = document.getElementById('email')) {
    sign_email.addEventListener('blur', checkEmail);
}
if (sign_password2 = document.getElementById('password2')) {
    sign_password2.addEventListener('change', checkPassword);
}
if (newpost = document.getElementById('newpost')) {
    newpost.addEventListener('submit', savePost);
}
var enableAutoUpdate = setInterval(function () {
    executeAutoUpdate();
}, 10000);

if (!localStorage.isOnAutoUpdate) {
    localStorage.setItem("isOnAutoUpdate", "true");
} else {
    if (localStorage.isOnAutoUpdate == "false") {
        clearInterval(enableAutoUpdate);
        document.getElementById('btn_update').value = 'Auto-update: OFF';
    }
}
Notification.requestPermission().then(function (result) {
    console.log(result);
});
updateLastPost();


function validateLogin(ev) {
    ev.preventDefault();
    var el = ev.target;
    if (el.password.value.length < 5) {
        alert('this password is not valid');
        return false;
    }

    executeLogin(el.email.value, el.password.value);
}

function countMessage(ev) {
    var count = document.getElementById('count');
    var msg = ev.target.value;
    var remain = 140 - msg.length;
    count.innerHTML = 'Remain characters: ' + remain;
}

function savePost(ev) {
    ev.preventDefault();
    var form = ev.target;
    var image = form.image;
    var btn = form.btnsubmit;
    var file = null;
    var formData = new FormData();
    formData.append('message', form.message.value);
    formData.append('ajax', 'true');
    formData.append('task', form.task.value);

    if (image.files.length > 0) {
        if (!window.XMLHttpRequest) {
            alert('Your browser don\'t suport ajax file upload. Changing for the normal method.');
            form.unbind('submit').submit();
            return true;
        } else {
            file = image.files[0];
            btn.value = 'Uploading...';
            formData.append('image', file, file.name);
        }
    }
    //console.log(formData);
    executeSavePost(form, formData);

}

function checkPassword() {
    var p1 = document.getElementById('password').value;
    var p2 = document.getElementById('password2').value;
    var hit = document.getElementById('hit_password');
    var classes = 'help is-danger';
    if (p1 == p2) {
        hit.className = classes + ' dpn';
    } else {
        hit.className = classes;
    }
}

function autoUpdate() {
    if (localStorage.isOnAutoUpdate == "true") {
        clearInterval(enableAutoUpdate);
        document.getElementById('btn_update').value = 'Auto-update: OFF';
        localStorage.isOnAutoUpdate = "false";
    } else {
        executeAutoUpdate();
        document.getElementById('btn_update').value = 'Auto-update: ON';
        localStorage.isOnAutoUpdate = "true";
        enableAutoUpdate = setInterval(function () {
            executeAutoUpdate();
        }, 10000);
    }
}

function markFavorite(id) {
    executeFavorite(id);
}

function deletePost(id) {
    executeDeletePost(id);
}

function replyPost(id) {

}

function allComments(id) {
    alert('not implemented');
}

function notifyMe(msg) {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support system notifications");
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification(msg);
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var notification = new Notification(msg);
            }
        });
    }

    // Finally, if the user has denied notifications and you 
    // want to be respectful there is no need to bother them any more.
    
    setTimeout(notification.close.bind(notification), 5000); 
}