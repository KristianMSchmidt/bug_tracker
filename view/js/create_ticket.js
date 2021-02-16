var search_items_project = document.getElementsByClassName("searchable_project");
const urlParams = new URLSearchParams(window.location.search);
project_options = urlParams.get('project_options');
search = urlParams.get('search');
project_id = urlParams.get('project_id');

function choose_project(project_id) {
    search_input = document.getElementById("search_field_project").value;
    document.getElementById('project_id_input').value = project_id;
    document.getElementById('search_input_to_post').value = search_input;
    document.getElementById("create_ticket_form").submit();
}

function thin_out_projects(search_input_project) {
    for (let item of search_items_project) {
        if (!item.innerHTML.toLowerCase().includes(search_input_project.toLowerCase())) {
            document.getElementById(item.id).style.display = "none";
        } else {
            document.getElementById(item.id).style.display = "block";
        }
    }
}

document.getElementById("search_field_project").addEventListener("input", function() {
    thin_out_projects(document.getElementById("search_field_project").value);
    document.getElementById('search_input_to_post').value = document.getElementById("search_field_project");
});

if (search !== '') {
    thin_out_projects(search);
}
if (project_id !== "none") {
    document.getElementById('project_' + project_id).classList.add("active");
}