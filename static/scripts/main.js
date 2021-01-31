function set_active_link(new_active_item) {
  // Function used to higlight sidebar menu links

    sidebar_items = sidebar_items = [
      "dashboard", 
      "manage_user_roles", 
      "my_projects", 
      "my_tickets"];                       

    sidebar_items.forEach(item => {
        document.getElementById(item + "_link").classList.remove("active");
    });

    document.getElementById(new_active_item + "_link").classList.add("active");
}


window.onclick = function (event) {
  // Eventlistener used to close down dropdown menus if they are uopn. 
  var e = event.target;
  if (!event.target.classList.contains("notifications")){
    document.getElementById("notifications").classList.remove("show");
  } else{
    document.getElementById("notifications").classList.toggle("show");
  }
  if (!event.target.classList.contains("user_actions")){
    document.getElementById("user_actions").classList.remove("show");
  }
    else{
      document.getElementById("user_actions").classList.toggle("show");
    }
}

// Force display notifications
url = window.location.href
if (url.split("?")[1] == "seen=") {
    document.getElementById("notifications").classList.toggle("show");

}

