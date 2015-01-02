$(function() {

	
	function choosePlayerClass() {
		// Empty DOM "html" areas
		$(".gameText").html('');
		$(".gameOptions").html('');

		$(".gameText").append("<h2>Create your player!</h2>");

		// Player name input
		$(".gameOptions").append("<h3>Player Name:</h3>");
		$(".gameOptions").append('<input id="playerName" name="playerName" type="text" placeholder="Enter your name">');

		// TODO Might need this later.......
		//find out available characters for chosen storyline
		// var availableCharacters = storyData.available_characters;

		$(".gameOptions").append("<h3>Choose a class for your player:</h3>");
		// Player classes as radio buttons
		$(".gameOptions").append('<input type="radio" name="playerClass" id="dressmakerClass" value="Dressmaker">');
		$(".gameOptions").append('<input type="radio" name="playerClass" id="tailorClass" value="Tailor">');
		$(".gameOptions").append('<input type="radio" name="playerClass" id="patternmakerClass" value="Patternmaker">');

		$('#addPlayer').submit(function() {
			var form = $(this);
			var pName = form.find('#playerName').val();

			var pClass;

			if ($("input[name='playerClass']:checked").length > 0){
				pClass = $('input:radio[name=playerClass]:checked').val();
				console.log(pClass);
			}
			else {
				alert("You must select a class!");
				return false;
			}

			submitPlayerName(pName, pClass);

			// Do not reload the page
			return false;
		});
	}

	
	function submitPlayerName(chosenName, chosenClass) {
		$.ajax({
			url: "player_choice.php",
			dataType: "json",
			data: {
			// game_id : 0,
			// create_player: {
			//   "class" : "Aria",
			//   "name" : "aName"
			player_name : chosenName,
			player_class : chosenClass
			},
			success: function(data) {

				console.log("Success: ", data);
			},
			error: function(data) {
				console.log("Error: ", data);
			}
		});
	}

//	function startNewGame()




});