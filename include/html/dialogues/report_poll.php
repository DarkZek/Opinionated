<script>
if (xsrf == "") {
  //Not logged in
  showDialogue('/api/html/login_page');
}
</script>
    <div class="container report-div animated">
      <a>Please select the reason for reporting this poll.</a>
      <form action="/api/polls/report" method="POST">
        <input type="text" name="id" value="" hidden>
        <div class="form-check">
          <input class="form-check-input" name="reason" checked type="radio" value="1" id="reason1">
          <label class="form-check-label" for="defaultCheck1">
            Its not a poll
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" name="reason" type="radio" value="2" id="reason1">
          <label class="form-check-label" for="defaultCheck2">
            The poll is biased
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" name="reason" type="radio" value="3" id="reason1">
          <label class="form-check-label" for="defaultCheck2">
            The poll is unnecessarily offensive
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" name="reason" type="radio" value="4" id="reason1">
          <label class="form-check-label" for="defaultCheck2">
            Malicious Links
          </label>
        </div>
        <br>
        <div class="form-group">
          <input type="submit" onclick="SubmitReport();return false;" class="btn form-control-lg form-control" value="SUBMIT REPORT">
        </div>
      </form>
    </div>
  <div id="submitted_report" class="afterDiv" style='display: none;'>
    <i class="material-icons">check_circle_outline</i>
    <h1 class="center">Submitted report!</h1>
    <h6 class="center">Our team will review your report shortly</h6>
    <br>
  </div>
