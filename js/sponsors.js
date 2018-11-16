function dataChanged(sponsorSpot) {
  $("#apply" + sponsorSpot)[0].style.display = "block";
}

function imageChanged(sponsorSpot) {
  dataChanged(sponsorSpot);

  //Update image
  $("#image" + sponsorSpot)[0].src = $("#sponsor" + sponsorSpot + "image")[0].value;
}

function saveChanges(sponsorSpot) {
  //Hide data changed button again
  $("#apply" + sponsorSpot)[0].style.display = "none";

  //Send changes to server
  var sponsorMessage = $("#sponsor" + sponsorSpot + "message")[0].value;
  var sponsorTitle = $("#sponsor" + sponsorSpot + "title")[0].value;
  var sponsorImageURL = $("#sponsor" + sponsorSpot + "image")[0].value;

  console.log(sponsorMessage);

  //MySQL starts at 1
  sponsorSpot++;

  sendRequest("/api/admin/setsponsor", {sponsor: sponsorSpot, image: sponsorImageURL, content: sponsorMessage, title: sponsorTitle}, function(data) {
    if (data == "Success") {
      showNotification("Saved changes");
    } else {
      showNotification(data);
    }
  });
}


function loadImages() {
  for(var i = 0; i < 6; i++) {
    $("#image" + i)[0].src = $("#sponsor" + i + "image")[0].value;
  }
}

$(document).ready(function() {
  loadImages();
});
