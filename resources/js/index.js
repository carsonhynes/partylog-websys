 // $(function() {
 //        $( "#name" ).autocomplete({
 //            source: names
 //        });
 //    });

$(document).ready(function(){

    var COOKIE_NAME = 'splash-page-cookie-test2';
    $go = $.cookie(COOKIE_NAME);
    if ($go == null) {
        console.log("null");
        $.cookie(COOKIE_NAME, 'test', { path: '/', expires: 6 });
        $("#splash").toggle();
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
                $("#menu,form,#footer").delay(150).animate({"opacity":"1.0"},8000);
            });
        },40000);
    }
    else {
    }

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

    $("#fraternity").hide();
    $("#school").change(function () {
        var select = $('#school option:selected').text();
        if (select == "RPI") {
            $("#fraternity").show();
        }
        else {
            $("#fraternity").hide();
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
