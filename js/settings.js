function showSettings(settings, obj) {
  document.location.hash = settings;
  //Disable all
  var container = $(".pages-container")[0];
  for(var i = 0; i < container.children.length; i++) {
    container.children[i].style.display = "none";
  }

  //Enable the one we want
  $(settings)[0].style.display = "block";

  //Remove selected tag
  if ($(".selected").length > 0) {
    $(".selected")[0].classList.remove("selected");
  }
  obj.classList.add("selected");
}

$(document).ready(function() {
  var fragment = window.location.hash.substr(1);
  if (fragment != "") {
    showSettings("#" + fragment, $("." + fragment + "-menu-item")[0]);
  } else {
    showSettings("#user", $(".perspective-menu-item")[0]);
  }
});
