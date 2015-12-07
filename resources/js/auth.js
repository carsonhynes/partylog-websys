$(document).ready(function(){

  $.ajax({
  type: "GET",
  url: "information.js",
  dataType: "json",
  success: function(responseData, status){
  var outputSchool = "";
  var outputFraternity = "";
     $.each(responseData.schools, function(i, item) {
      outputSchool += "<option value=";
      outputSchool += item.value;
      outputSchool += ">";
      outputSchool += item.school;
      outputSchool += "</option>";
    });
    $.each(responseData.fraternities, function(i, item) {
      outputFraternity += "<option value=\"";
      outputFraternity += item.value;
      outputFraternity += "\">";
      outputFraternity += item.fraternity;
      outputFraternity += "</option>";
    });
    $("#school").html(outputSchool);
    $("#fraternity").html(outputFraternity);
  },
  error: function(xhr, ajaxOptions, thrownError) {
      alert("There was a problem: "+xhr.status+" "+thrownError);
      }
  });

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

function validate_login(formObj){
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
}
