/* Scripts used by all or several pages after login*/

function reorder(page, order_by, order_direction) {
    // function used to reorder tables upon click on header 
    var url = page + ".php?order=" + order_by + "&dir=";
    if (order_direction == "asc") {
        url += "desc";
    } else {
        url += "asc";
    }
    window.location.href = url;
}

function double_reorder(table_num, order_by, current_direction) {
    // Function used to reorder tables on pages two tables
    document.getElementById('order' + table_num).value = order_by;
    if (current_direction == "asc") {
        document.getElementById('dir' + table_num).value = "desc";
    } else {
        document.getElementById('dir' + table_num).value = "asc";
    }
    document.getElementById('reorder_form').submit();
}

function set_active_link(new_active_item) {
    // Function used to higlight active sidebar menu links

    sidebar_items = sidebar_items = [
        "dashboard",
        "manage_project_users",
        "manage_user_roles",
        "my_projects",
        "my_tickets",
        "users_overview"
    ];

    sidebar_items.forEach(item => {
        if (document.body.contains(document.getElementById(item + "_link"))) {
            document.getElementById(item + "_link").classList.remove("active");
        }
    });
    document.getElementById(new_active_item + "_link").classList.add("active");
}

window.onclick = function(event) {

    //Eventlistener used to close down dropdown menus

    var e = event.target;
    if (!event.target.classList.contains("notifications")) {
        document.getElementById("notifications").classList.remove("show");
    } else {
        document.getElementById("notifications").classList.toggle("show");
    }
    if (!event.target.classList.contains("user_actions")) {
        document.getElementById("user_actions").classList.remove("show");
    } else {
        document.getElementById("user_actions").classList.toggle("show");
    }
}

//When the user clicks on new notifications, set 'seen' to true and reload page
function seen_redirect() {
    var url = new URL(window.location.href);
    url.searchParams.set('seen', 'true');
    window.location.href = url;
}

// Display notifications after page reload, when user has clicked on a new notification 
url = window.location.href
const currentUrlParams = new URLSearchParams(window.location.search);
if (currentUrlParams.get('seen') == "true") {
    document.getElementById("notifications").classList.toggle("show");
}