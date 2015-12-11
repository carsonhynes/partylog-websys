
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
        outputFraternity += "<option value=";
        outputFraternity += item.value;
        outputFraternity += ">";
        outputFraternity += item.fraternity;
        outputFraternity += "</option>";
      });         