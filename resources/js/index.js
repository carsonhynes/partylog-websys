 // $(function() {
 //        $( "#name" ).autocomplete({
 //            source: names
 //        });
 //    });

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

    $("#splash").click(function() {
        var ocean = document.getElementById("splash"),
        waveWidth = 10,
        waveCount = Math.floor(window.innerWidth/waveWidth),
        docFrag = document.createDocumentFragment();

        for(var i = 0; i < waveCount; i++){
          var wave = document.createElement("div");
          wave.className += " wave";
          docFrag.appendChild(wave);
          wave.style.left = i * waveWidth + "px";
          wave.style.webkitAnimationDelay = (i/100) + "s";
        }

        ocean.appendChild(docFrag);

        setTimeout(function() {
            $("#splash").slideUp("800", function() {
                $("#menu,form,#footer").delay(100).animate({"opacity":"1.0"},8000);
            });
        },4000);
    });

    $("#fraternity").hide();
    $(".school").change(function () {
        var select = $('.school option:selected').text();
        if (select == "RPI") {
            $("#fraternity").toggle();
        }
        else {
            $("#fraternity").toggle();
        }
    });

});

function validate(formObj) {
    if (formObj.name.value == "") {
        alert("You must enter a name");
        formObj.name.focus();
        return false;
    }

    if (formObj.school.value == "-") {
        alert("You must select a school");
        formObj.school.focus();
        return false;
    }

    return true;
}
