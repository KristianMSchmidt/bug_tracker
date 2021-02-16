function toggle_user(user_id) {
    if (!document.getElementById(user_id).classList.contains("active")) {
        document.getElementById(user_id).classList.add("active");
        selected_users.push(user_id);
        document.getElementById('row_' + user_id).style.display = "table-row";
        document.getElementById("no_selected_users_info").style.display = "none";
    } else {
        document.getElementById(user_id).classList.remove("active");
        selected_users = selected_users.filter(function(value, index, arr) {
            return value != user_id;
        })
        document.getElementById('row_' + user_id).style.display = "none";
        if (selected_users.length == 0) {
            document.getElementById("no_selected_users_info").style.display = "block";
        }

    }
}

function submit_form() {
    var errors = false;
    if (selected_users.length == 0) {
        document.getElementById("no_selected_users").innerHTML = "Select one or more Users";
        errors = true;
    } else {
        document.getElementById("no_selected_users").innerHTML = "";
    }
    if (document.getElementById("selected_role").value == "") {
        document.getElementById("no_selected_role").innerHTML = "Select new Role";
        errors = true;
    } else {
        document.getElementById("no_selected_role").innerHTML = "";
    };
    if (!errors) {
        document.getElementById("input_user_ids").value = JSON.stringify(selected_users);
        document.getElementById("assign_role_submit").value = "submited";
        document.getElementById("assign_role_form").submit();
    }
}

var search_items = document.getElementsByClassName("searchable");
document.getElementById("search_field").addEventListener("input", function() {
    search_input = document.getElementById("search_field").value;
    for (let item of search_items) {
        var name = item.innerHTML;
        if (!name.toLowerCase().includes(search_input.toLowerCase())) {
            document.getElementById(item.id).style.display = "none";
        } else {
            document.getElementById(item.id).style.display = "block";
        }
    }
});

selected_users = [];
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const user_id = urlParams.get('user_id');
if (user_id) {
    toggle_user(user_id);
}