const sidebar = document.getElementById("sidebar");
const sidebarButton = document.getElementById("sidebar-close");
let savedTitles = [];
function sidebarToggle() {
    let textItems = Array.from(sidebar.querySelectorAll(".sidebar-text, .sidebar-hide"));
    let titleItems = Array.from(sidebar.querySelectorAll(".sidebar-body h4"));
    if(!sidebar.classList.contains("sidebar-closed")) {
        textItems.forEach(function(item) {
            item.style.display = 'none';
        });
        titleItems.forEach(function(item) {
            savedTitles.push(item.textContent);
            item.textContent = '--';
            item.style.visibility = 'hidden';
        });
        document.documentElement.style.setProperty('--content', 'none');
        sidebar.classList.remove("col-3");
        sidebar.classList.add("sidebar-closed");
        sidebar.classList.add("w-auto");
        sidebarButton.classList.add("me-auto");
    }
    else {
        textItems.forEach(function(item) {
            item.style.display = 'inline';
        });
        for(let i = 0; i < titleItems.length; i++) {
            let item = titleItems[i];
            // console.log(item);
            item.textContent = savedTitles[i];
            item.style.visibility = 'visible';
        }
        document.documentElement.style.setProperty('--content', '""');
        sidebar.classList.remove("w-auto");
        sidebar.classList.add("col-3");
        sidebar.classList.remove("sidebar-closed");
        sidebarButton.classList.remove("me-auto");
    }
}