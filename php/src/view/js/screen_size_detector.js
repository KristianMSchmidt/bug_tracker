/* This script is used by all pages, including pre-login pages */

//If screen is to small, hide content and inform user: 
function screen_size_check() {
    let width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if (width < min_width) {
        document.getElementsByTagName("body")[0].innerHTML = "<p style='text-align: center'><br>Your screen is to small for this application.<br>Sorry.<p>"
    } else if (width < 560) {
        window.location.href = window.location.href;
    }
}
const min_width = 460;
let width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
if (width < min_width) {
    screen_size_check();
}
window.addEventListener('resize', screen_size_check);