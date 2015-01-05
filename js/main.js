$(function() {

	
	function choosePlayerClass() {
		// Empty DOM "html" areas
		$(".gameText").html('');
		$(".gameOptions").html('');

		$(".gameText").append("<h2>Create your player!</h2>");
		// Player name input
		$(".gameOptions").append("<h3>Player Name:</h3>");
		$(".gameOptions").append('<input id="playerName" name="playerName" type="text" placeholder="Enter your name">');

		// ToDo - Might need this later.......
		//find out available characters for chosen storyline
		// var availableCharacters = storyData.available_characters;

		$(".gameOptions").append("<h3>Choose a class for your player:</h3>");
		// Player classes as radio buttons
		$(".gameOptions").append('<input type="radio" name="playerClass" id="dressmakerClass" value="Dressmaker"><label for="Dressmaker">Dressmaker</label><br>');
		$(".gameOptions").append('<input type="radio" name="playerClass" id="tailorClass" value="Tailor"><label for="Tailor">Tailor</label><br>');
		$(".gameOptions").append('<input type="radio" name="playerClass" id="patternmakerClass" value="Patternmaker"><label for="Patternmaker">Pattern Maker</label><br>');

		//Append start new game button
		$(".gameOptions").append('<button class="startGame">Start new game!</button>');

		// clickhandler for start new game button
		$(".startGame").click(function() {
			var pName = $("#playerName").val();
			// ToDo - Add alert msg that name must be entered!
			var pClass;
			if ($("input[name='playerClass']:checked").length > 0 && pName.length > 0){
				pClass = $('input:radio[name=playerClass]:checked').val();
				console.log(pClass);
			}
			else {
				alert("You must enter a name & select a class!");
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
				playGame();
				console.log("Success: ", data);
			},
			error: function(data) {
				console.log("Error: ", data);
			}
		});
	}

	function playGame() {
		$.ajax({
			url: "start_game.php",
			dataType: "json",
			success: function(data) {
				// Above (data) is the associative array $return_data echoed from PHP
				printChallengeData(data);
				console.log("Success: ", data);
			},
			error: function(data) {
				console.log("Error: ", data);
			}
		});
	}

	function printChallengeData(gameData) {
		// gameData is the same data from playGame success, just with a new name
		// ToDo - Add if else for game data, if false start new game, elseif empty array game completed, restart.
		$(".gameText").html('');
		$(".gameOptions").html('');

		$(".gameText").append("<h3>Player Info!</h3>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["playerName"] + " </li><li><strong>Class:</strong> " + gameData["playerClass"] + "</li></ul>");
		$(".gameText").append("<p>ToDo - Same as above but for the 2 computer players.</p>");

		$(".gameText").append("<h2>Your Challenge!</h2>");
		$(".gameText").append("<h2>" + gameData["challenge"]["title"] + "</h2>");
		$(".gameText").append("<p>"+gameData["challenge"]["description"] +"</p>");

		$(".gameText").append("<h4>Skill levels for challenge:</h4>");
		$(".gameText").append("<li>Needlework: "+ gameData["challenge"]["skills"]["needlework"] +"</li>");
		$(".gameText").append("<li>Sewing: "+ gameData["challenge"]["skills"]["sewing"] +"</li>");
		$(".gameText").append("<li>Cutting: "+ gameData["challenge"]["skills"]["cutting"] +"</li>");
		$(".gameText").append("<li>Patterns: "+ gameData["challenge"]["skills"]["patterns"] +"</li>");

		$(".gameOptions").append("<h2>Do you want to accept this challenge?</h2>");
		$(".gameOptions").append('<button class="acceptChallengeBtn">Accept challenge!</button>');
		$(".gameOptions").append('<button class="changeChallengeBtn">Change challenge!</button>');

		$(".acceptChallengeBtn").click(function() {
			doChoice();
			// Do not reload the page
			return false;
		});
		
		$(".changeChallengeBtn").click(function() {
			playGame();
			// Do not reload the page
			return false;
		});
	}

	function doChoice() {
		$.ajax({
			url: "do_choice.php",
			dataType: "json",
			success: function(data) {
				challengeAccepted(data);
				console.log("Success: ", data);
			},
			error: function(data) {
				console.log("Error: ", data);
			}
		});
	}

	function challengeAccepted(gameData) {
		// gameData is the same data from playGame success, just with a new name (it is the $return_data info)
		$(".gameText").html('');
		$(".gameOptions").html('');

		$(".gameText").append("<h3>Player Info!</h3>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["playerName"] + " </li><li><strong>Class:</strong> " + gameData["playerClass"] + "</li></ul>");
		$(".gameText").append("<p>ToDo - Same as above but for the 2 computer players.</p>");

		$(".gameText").append("<h4>" + gameData["acceptedString"] + "</h4>");

		$(".gameOptions").append('<button class="doChallengeBtn">Carry out challenge!</button>');
		$(".gameOptions").append('<button class="companionChallengeBtn">Carry out challenge with companion!</button>');

		$(".doChallengeBtn").click(function() {
			playChallenge();
			// Do not reload the page
			return false;
		});

		$(".companionChallengeBtn").click(function() {
			playChallenge();
			// Do not reload the page
			return false;
		});
	}

	function playChallenge() {
		$.ajax({
			url: "play_challenge.php",
			dataType: "json",
			success: function(data) {
				printActiveChallenge(data);
				console.log("Success: ", data);
			},
			error: function(data) {
				console.log("Error: ", data);
			}
		});
	}

	function printActiveChallenge(gameData) {
		$(".gameText").html('');
		$(".gameOptions").html('');

		$(".gameText").append("<h4>" + gameData["challengeCounter"] + "</h4>");
	}



	// Call first function needed in chain here
	choosePlayerClass();
});