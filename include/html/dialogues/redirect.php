<<<<<<< HEAD
  <h4>This link goes to <a id="link-loc" style="color: blue;"></a></h4>

  <script> $("#link-loc")[0].textContent = main_link.toUpperCase(); </script>
  <br>
  <div class="row">
    <div class="col-6">
      <a onclick="hideDialogue($('.grey-out')[0]);" class="btn btn-primay">BACK</a>
    </div>
    <div class="col-6">
      <a class="btn continue right" onclick="document.location = main_link;">CONTINUE</a>
=======
  <h1>You're leaving Opinionated</h1>
  <h4>This link goes to </h4>
  <a id="link-loc" style="color: blue;"></a>
  <br>
  <br>
  <div class="row">
    <div class="col-6">
      <a onclick="
      $('.leaving-grey')[0].style.display = 'none';
      $('.leaving')[0].style.display = 'none';" class="btn btn-primay">BACK</a>
    </div>
    <div class="col-6">
      <a class="btn continue">CONTINUE</a>
>>>>>>> master
    </div>
  </div>
