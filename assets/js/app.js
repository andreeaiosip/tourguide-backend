let mainNav = document.getElementById("js-menu");
let navBarToggle = document.getElementById("js-navbar-toggle");

navBarToggle.addEventListener("click", function() {
    mainNav.classList.toggle("active");
});

function myFunction(x) {
    x.classList.toggle("change");
  }
// Canvas 

// Helpful code found at this video https://www.youtube.com/watch?v=FWB7SF9TM-A
var c = document.getElementById("myCanvas2");

var ctx = c.getContext("2d");



// Create gradient

var grd = ctx.createLinearGradient(0, 100, 200, 0);

grd.addColorStop(0, "rgba(97,172,152,1)");

grd.addColorStop(1, "rgba(12,194,109,1)");



// Fill with gradient

ctx.fillStyle = grd;

ctx.fillRect(0, 10, 500, 100);



/* Text in canvas */

var canvas = document.getElementById("myCanvas2");

var ctx = canvas.getContext("2d");

ctx.font = "18px Arial";

ctx.fillStyle = "white";

ctx.textAlign = "center";

ctx.fillText("Make your stay a wonderful stay at Brasov!", canvas.width / 2, canvas.height / 2);






// First name field must be filled validation
// Helpful code found here: https://www.w3schools.com/js/tryit.asp?filename=tryjs_validation_js 

function validateForm() {
    var x = document.forms["myForm"]["fname"].value;
    if (x == "") {
        alert("Name must be filled out");
        return false;
    }
}