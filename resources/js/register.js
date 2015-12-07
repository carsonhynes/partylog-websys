$(document).ready(function(){
  $(".skipEnter").keypress(function(event) {
      if(event.keyCode == 13) {
          var textboxes = $("input.skipEnter");
          var currentBoxNumber = textboxes.index(this);

          if (textboxes[currentBoxNumber + 1] != null) {
              var nextBox = textboxes[currentBoxNumber + 1];
              nextBox.focus();
              nextBox.select();
              event.preventDefault();
              return false;
          }
      }
  });

  $("#school").change(function () {
      var select = $('#school option:selected').text();
      if (select == "RPI") {
          $("#fraternityWidget").show();
      }
      else {
          $("#fraternityWidget").hide();
      }
  });

});

function validate_register(formObj) {
  if (formObj.name.value == "") {
      alert("You must enter a name");
      formObj.name.focus();
      return false;
  }

  if (formObj.password.value == "") {
      alert("You must enter a password");
      formObj.password.focus();
      return false;
  }

  if (formObj.school.value == "") {
      alert("You must select a school");
      formObj.school.focus();
      return false;
  }

  return true;
}
