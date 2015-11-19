<html>
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<style>
		.date {
			margin: 25px 0;
			font: 30px verdana, arial, sans-serif;
			text-align: center;
			width: 367px;
		}

		.submit {
			width: 367px;
			text-align: center;
		}

		input[type=checkbox] {
			visibility: hidden;
		}

		/* ROUNDED ONE */
		.roundedOne {
			width: 28px;
			height: 28px;
			background: #fcfff4;

			background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
			background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
			background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
			background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
			background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );

			margin: 10px 100px;
			-webkit-border-radius: 50px;
			-moz-border-radius: 50px;
			border-radius: 50px;

			-webkit-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
			-moz-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
			box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
			position: relative;
		}

		.roundedOne label {
			cursor: pointer;
			position: absolute;
			width: 20px;
			height: 20px;

			-webkit-border-radius: 50px;
			-moz-border-radius: 50px;
			border-radius: 50px;
			left: 4px;
			top: 4px;

			-webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
			-moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
			box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);

			background: -webkit-linear-gradient(top, #222 0%, #45484d 100%);
			background: -moz-linear-gradient(top, #222 0%, #45484d 100%);
			background: -o-linear-gradient(top, #222 0%, #45484d 100%);
			background: -ms-linear-gradient(top, #222 0%, #45484d 100%);
			background: linear-gradient(top, #222 0%, #45484d 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#222', endColorstr='#45484d',GradientType=0 );
		}

		.roundedOne label:before {
			position: absolute;
			left: -100px;
			content: "Over 21?";
			font: 20px verdana, arial, sans-serif;
		}

		.roundedOne label:after {
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
			filter: alpha(opacity=0);
			opacity: 0;
			content: '';
			position: absolute;
			width: 16px;
			height: 16px;
			background: #00bf00;

			background: -webkit-linear-gradient(top, #00bf00 0%, #009400 100%);
			background: -moz-linear-gradient(top, #00bf00 0%, #009400 100%);
			background: -o-linear-gradient(top, #00bf00 0%, #009400 100%);
			background: -ms-linear-gradient(top, #00bf00 0%, #009400 100%);
			background: linear-gradient(top, #00bf00 0%, #009400 100%);

			-webkit-border-radius: 50px;
			-moz-border-radius: 50px;
			border-radius: 50px;
			top: 2px;
			left: 2px;

			-webkit-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
			-moz-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
			box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
		}

		.roundedOne label:hover::after {
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
			filter: alpha(opacity=30);
			opacity: 0.3;
		}

		.roundedOne input[type=checkbox]:checked + label:after {
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
			filter: alpha(opacity=100);
			opacity: 1;
		}
	</style>
</head>

<body>

<form action="submit-party.php" method="post" onsubmit="return validate(this);">

	<div class='date'>
		<?php
			echo date("F jS, Y");
		?>
	</div>

    <div class="ui-widget" style="margin-top: 10px;">
        <label for="name">Name: </label>
        <input name="name" id="name" class="skipEnter" style="width: 300px;">
    </div>

	<div class="ui-widget" style="margin-top: 10px;">
		<label for="school">School:</label>
		<select name="school" class="school" style="width: 294px;">
			<option vslue="-">-</option>
			<option value="RPI">RPI</option>
			<option value="Sage">Sage</option>
			<option value="UAlbany">UAlbany</option>
			<option value="Siena">Siena</option>
			<option value="Hudson Valley">Hudson Valley</option>
			<option value="Other">Other</option>
		</select>
	</div>

	<div class="ui-widget" style="margin-top: 10px;">
		<label for="fraternity">Fraternity: </label>
		<select name="fraternity" style="width: 266px;">
			<option value="None">Non-Greek</option>
			<option value="Acacia">Acacia</option>
			<option value="Alpha Chi Rho">Alpha Chi Rho</option>
			<option value="Alpha Epsilon Pi">Alpha Epsilon Pi</option>
			<option value="Alpha Phi Alpha">Alpha Phi Alpha</option>
			<option value="Alpha Sigma Phi">Alpha Sigma Phi</option>
			<option value="Chi Phi">Chi Phi</option>
			<option value="Delta Kappa Epsilon">Delta Kappa Epsilon</option>
			<option value="Delta Phi">Delta Phi</option>
			<option value="Delta Tau Delta">Delta Tau Delta</option>
			<option value="Lambda Chi Alpha">Lambda Chi Alpha</option>
			<option value="Lambda Upsilon Lambda">Lambda Upsilon Lambda</option>
			<option value="Phi Gamma Delta">Phi Gamma Delta</option>
			<option value="Phi Iota Alpha">Phi Iota Alpha</option>
			<option value="Phi Kappa Tau">Phi Kappa Tau</option>
			<option value="Phi Kappa Theta">Phi Kappa Theta</option>
			<option value="Phi Mu Delta">Phi Mu Delta</option>
			<option value="Phi Sigma Kappa">Phi Sigma Kappa</option>
			<option value="Pi Delta Psi">Pi Delta Psi</option>
			<option value="Pi Kappa Alpha">Pi Kappa Alpha</option>
			<option value="Pi Kappa Phi">Pi Kappa Phi</option>
			<option value="Pi Lambda Phi">Pi Lambda Phi</option>
			<option value="Psi Upsilon">Psi Upsilon</option>
			<option value="RSE">RSE</option>
			<option value="Sigma Alpha Epsilon">Sigma Alpha Epsilon</option>
			<option value="Sigma Chi">Sigma Chi</option>
			<option value="Sigma Phi Epsilon">Sigma Phi Epsilon</option>
			<option value="Tau Epsilon Phi">Tau Epsilon Phi</option>
			<option value="Theta Chi">Theta Chi</option>
			<option value="Theta Xi">Theta Xi</option>
			<option value="Zeta Psi">Zeta Psi</option>
		</select>
	</div>

	<div class="roundedOne">
		<input type="checkbox" value="Over" id="roundedOne" name="over" />
		<label for="roundedOne"></label>
	</div>

	<div class="submit">
        <button style="margin-top: 10px" type="submit">Submit</button>
	</div>
</form>

</body>

<script src="../js/jquery-1.11.2.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="list.js"></script>
<script>
    $(function() {
        $( "#name" ).autocomplete({
            source: names
        });
    });
</script>

<script>
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
</script>

</html>