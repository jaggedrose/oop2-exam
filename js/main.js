$(function() {

	
	function choosePlayerClass() {
		// Empty DOM "html" areas
		$(".gameText").html('');
		$(".gameOptions").html('');

		$(".gameText").append("<h2>Create your player!</h2>");
		// Player name input
		$(".gameOptions").append("<h3>Player Name:</h3>");
		$(".gameOptions").append('<input id="myPlayerName" name="myPlayerName" type="text" placeholder="Enter your name">');

		
		$(".gameOptions").append("<h3>Choose a class for your player:</h3>");
		// Player classes as radio buttons
		$(".gameOptions").append('<input type="radio" name="playerClass" id="dressmakerClass" value="Dressmaker"><label for="Dressmaker">Dressmaker</label><br>');
		$(".gameOptions").append('<input type="radio" name="playerClass" id="tailorClass" value="Tailor"><label for="Tailor">Tailor</label><br>');
		$(".gameOptions").append('<input type="radio" name="playerClass" id="patternmakerClass" value="Patternmaker"><label for="Patternmaker">Pattern Maker</label><br>');

		//Append start new game button
		$(".gameOptions").append('<button class="startGame">Start new game!</button>');

		// clickhandler for start new game button
		$(".startGame").click(function() {
			var pName = $("#myPlayerName").val();
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
			submitHumanPlayer(pName, pClass);
			// Do not reload the page
			return false;
		});
	}
	
	function submitHumanPlayer(chosenName, chosenClass) {
		$.ajax({
			url: "create_player.php",
			dataType: "json",
			data: {
				myplayer_name : chosenName,
				player_class : chosenClass
			},
			success: function(data) {
				playGame(false);
				console.log("Success: ", data);
			},
			error: function(data) {
				console.log("Error: ", data);
			}
		});
	}

	function playGame(challengeChange) {
		$.ajax({
			url: "start_game.php",
			dataType: "json",
			data: {
				challenge_change : challengeChange
			},
			success: function(data) {
				// Above (data) is the associative array $return_data echoed from PHP
				var successPoints = data["myPlayerSuccess"];
				if (successPoints === 0) {
					lostStartGameAgain();
				}
				else {
					printChallengeData(data);
					console.log("Success: ", data);
				}
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
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["myPlayerName"] + " </li><li><strong>Success points:</strong> " + gameData["myPlayerSuccess"] + " </li><li><strong>Class:</strong> " + gameData["myPlayerClass"] + "</li></ul>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["contestant1Name"] + " </li><li><strong>Success points:</strong> " + gameData["contestant1Success"] + " </li><li><strong>Class:</strong> " + gameData["contestant1Class"] + "</li></ul>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["contestant2Name"] + " </li><li><strong>Success points:</strong> " + gameData["contestant2Success"] + " </li><li><strong>Class:</strong> " + gameData["contestant2Class"] + "</li></ul>");
		

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
			playGame(true);
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
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["myPlayerName"] + " </li><li><strong>Success points:</strong> " + gameData["myPlayerSuccess"] + " </li><li><strong>Class:</strong> " + gameData["myPlayerClass"] + "</li></ul>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["contestant1Name"] + " </li><li><strong>Success points:</strong> " + gameData["contestant1Success"] + " </li><li><strong>Class:</strong> " + gameData["contestant1Class"] + "</li></ul>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["contestant2Name"] + " </li><li><strong>Success points:</strong> " + gameData["contestant2Success"] + " </li><li><strong>Class:</strong> " + gameData["contestant2Class"] + "</li></ul>");
		

		$(".gameText").append("<h4>" + gameData["acceptedString"] + "</h4>");
		$(".gameText").append("<p>Carrying out the challenge with a contestant will cost you 5 success points, but may increase your chances of winning the game!</p>");

		$(".gameOptions").append('<button class="doChallengeBtn">Carry out challenge!</button>');
		$(".gameOptions").append('<button class="companionChallengeBtn">Carry out challenge with contestant!</button>');

		$(".doChallengeBtn").click(function() {
			playChallenge(false);
			// Do not reload the page
			return false;
		});

		$(".companionChallengeBtn").click(function() {
			playChallenge(true);
			// Do not reload the page
			return false;
		});
	}

	function playChallenge(challengeCompanion) {
		$.ajax({
			url: "play_challenge.php",
			dataType: "json",
			data: {
				challenge_companion : challengeCompanion
			},
			success: function(data) {
				var successPoints = data["myPlayerSuccess"];
				if (successPoints === 100) {
					winStartGameAgain();
				}
				else if (successPoints === 0) {
					lostStartGameAgain();
				}
				else {
					printActiveChallenge(data);
					console.log("Success: ", data);
				}
			},
			error: function(data) {
				console.log("Error: ", data);
			}
		});
	}

	function printActiveChallenge(gameData) {
		$(".gameText").html('');
		$(".gameOptions").html('');

		// ToDo - Add challenge Id number to headline???
		$(".gameText").append("<h4>The results of the challenge</h4>");


		
		$(".gameText").append("<p>After " + gameData["doingChallenge"][gameData["myPlayerName"]] + " attempts " + gameData["myPlayerName"] + " has completed the challenge!</p>");
		$(".gameText").append("<p>Success: " + gameData["myPlayerSuccess"] + "</p>");
		$(".gameText").append("<p>After " + gameData["doingChallenge"][gameData["contestant1Name"]] + " attempts " + gameData["contestant1Name"] + " has completed the challenge!</p>");
		$(".gameText").append("<p>Success: " + gameData["contestant1Success"] + "</p>");
		$(".gameText").append("<p>After " + gameData["doingChallenge"][gameData["contestant2Name"]] + " attempts " + gameData["contestant2Name"] + " has completed the challenge!</p>");
		$(".gameText").append("<p>Success: " + gameData["contestant2Success"] + "</p>");
		

		$(".gameOptions").append('<button class="nextChallengeBtn">Play next challenge!</button>');
		
		$(".nextChallengeBtn").click(function() {
			playGame(false);
			// Do not reload the page
			return false;
		});
	}

	function winStartGameAgain() {
		$(".gameText").html("<h2>You have won the game!</h2>");
		$(".gameOptions").html('<button class="startAgain">Start over!</button>');

		//start over clickhandler
		$(".startAgain").click(function() {
			$.ajax({
				url: "reset.php",
				dataType: "json",
				success: function(data) {
				choosePlayerClass();
				},
				error: function(data) {
				console.log("startOver error: ", data.responseText);
				}
			});
		});
	}

	function lostStartGameAgain() {
		$(".gameText").html("<h2>You have lost the game!</h2>");
		$(".gameOptions").html('<button class="startAgain">Start over!</button>');

		//start over clickhandler
		$(".startAgain").click(function() {
			$.ajax({
				url: "reset.php",
				dataType: "json",
				success: function(data) {
				choosePlayerClass();
				},
				error: function(data) {
				console.log("startOver error: ", data.responseText);
				}
			});
		});
	}



	// Call first function needed in chain here
	choosePlayerClass();
});