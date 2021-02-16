var selected_users_to_enroll = [];
var selected_users_to_disenroll = [];

function choose_project(project_id) {
    search_input = document.getElementById("search_field_project").value;
    url = 'manage_project_users.php?project_id=' + project_id + '&search=' + search_input;
    window.location = url;
}


function toggle_users_to_enroll(user_id) {
    if (!document.getElementById('available_user_' + user_id).classList.contains("active")) {
        document.getElementById('available_user_' + user_id).classList.add("active");
        selected_users_to_enroll.push(user_id);
    } else {
        document.getElementById('available_user_' + user_id).classList.remove("active");
        selected_users_to_enroll = selected_users_to_enroll.filter(function(value, index, arr) {
            return value != user_id;
        })
    }
}

function toggle_users_to_disenroll(user_id) {
    if (!document.getElementById('enrolled_user_' + user_id).classList.contains("active")) {
        document.getElementById('enrolled_user_' + user_id).classList.add("active");
        selected_users_to_disenroll.push(user_id);
    } else {
        document.getElementById('enrolled_user_' + user_id).classList.remove("active");
        selected_users_to_disenroll = selected_users_to_disenroll.filter(function(value, index, arr) {
            return value != user_id;
        })
    }
}

function submit_enroll_form() {
    var errors = false;
    if (typeof(project_id) == 'undefined') {
        document.getElementById("enroll_error").innerHTML = "No selected project";
    } else if (selected_users_to_enroll.length == 0) {
        document.getElementById("enroll_error").innerHTML = "No selected users";
        errors = true;
    } else {
        document.getElementById("enroll_error").innerHTML = "";
    }
    if (!errors) {
        document.getElementById("users_to_enroll").value = JSON.stringify(selected_users_to_enroll);
        document.getElementById("enroll_form").submit();
    }
}

function submit_disenroll_form() {
    var errors = false;
    if (typeof(project_id) == 'undefined') {
        document.getElementById("disenroll_error").innerHTML = "No selected project";
    } else if (selected_users_to_disenroll.length == 0) {
        document.getElementById("disenroll_error").innerHTML = "No selected users";
        errors = true;
    } else {
        document.getElementById("disenroll_error").innerHTML = "";
    }
    if (!errors) {
        document.getElementById("users_to_disenroll").value = JSON.stringify(selected_users_to_disenroll);
        document.getElementById("disenroll_form").submit();
    }
}

var search_items_enroll = document.getElementsByClassName("searchable_enroll");
document.getElementById("search_field_enroll").addEventListener("input", function() {
    search_input_enroll = document.getElementById("search_field_enroll").value;
    for (let item of search_items_enroll) {
        if (!item.innerHTML.toLowerCase().includes(search_input_enroll.toLowerCase())) {
            document.getElementById(item.id).style.display = "none";
        } else {
            document.getElementById(item.id).style.display = "block";
        }
    }
});

var search_items_disenroll = document.getElementsByClassName("searchable_disenroll");
document.getElementById("search_field_disenroll").addEventListener("input", function() {
    search_input_disenroll = document.getElementById("search_field_disenroll").value;
    for (let item of search_items_disenroll) {
        if (!item.innerHTML.toLowerCase().includes(search_input_disenroll.toLowerCase())) {
            document.getElementById(item.id).style.display = "none";
        } else {
            document.getElementById(item.id).style.display = "block";
        }
    }
});

function thin_out_projects(search_input_project) {
    for (let item of search_items_project) {
        if (!item.innerHTML.toLowerCase().includes(search_input_project.toLowerCase())) {
            document.getElementById(item.id).style.display = "none";
        } else {
            document.getElementById(item.id).style.display = "block";
        }
    }
}

var search_items_project = document.getElementsByClassName("searchable_project");
document.getElementById("search_field_project").addEventListener("input", function() {
    search_input_project = document.getElementById("search_field_project").value;
    thin_out_projects(search_input_project);

});

const urlParams = new URLSearchParams(window.location.search);
search = urlParams.get('search');
project_id = urlParams.get('project_id')
console.log("project_id :" + project_id)

if (search !== null) {
    thin_out_projects(search);
}

if (project_id !== "none") {
    document.getElementById('project_' + project_id).classList.add("active");
}