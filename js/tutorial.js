var slideNumber = 0;
var slideCount = 6;

function nextSlide() {
  slideNumber++;

  if (slideNumber == 6) {
    document.location = "/";
    return;
  }

  //Remove old slide
  var oldSlide = $(".slide-" + slideNumber)[0];
  oldSlide.classList.add("anim-slideRightOut");
  oldSlide.classList.remove("anim-slideRightIn");

  //Show new slide
  $(".slide-" + (slideNumber + 1))[0].classList.add("anim-slideRightIn");

  addCircle();

  updateSlides();
}

function backSlide() {

  if (slideNumber == 0) {
    return;
  }

  //Show old slide
  var oldSlide = $(".slide-" + slideNumber)[0];
  oldSlide.classList.remove("anim-slideRightOut");
  oldSlide.classList.add("anim-slideRightIn");

  //Hide slide
  var oldSlide = $(".slide-" + (slideNumber + 1))[0];
  oldSlide.classList.add("anim-slideRightOut");
  oldSlide.classList.remove("anim-slideRightIn");


  slideNumber--;
  removeCircle();

  updateSlides();
}

function updateSlides() {
  if (slideNumber == 0) {
    $(".back")[0].classList.add("grey");
  } else {
    $(".back")[0].classList.remove("grey");
  }

  if (slideNumber == 5) {
    $("#skip")[0].style.display = "none";
    $(".next")[0].textContent = "FINISH";
  } else {
    $("#skip")[0].style.display = "block";
    $(".next")[0].textContent = "NEXT >";
  }
}

function addCircle() {
  $(".circles").find("." + (slideNumber + 1))[0].classList.add("active");
}

function removeCircle() {
  $(".circles").find("." + (slideNumber + 2))[0].classList.remove("active");
}

$(document).ready(function() {
  //Set random face delays
  $(".anim-hover").each(function( index ) {
    this.style.animationDelay = (Math.random() * 2) + "s";
  });
});
