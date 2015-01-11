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
			// ToDo - Add css msg that name must be entered!
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
		$(".gameText").html('');
		$(".gameOptions").html('');

		$(".gameText").append("<h3>Player Info!</h3>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["myPlayerName"] + " </li><li><strong>Class:</strong> " + gameData["myPlayerClass"] + "</li><li><strong>Success points:</strong> " + gameData["myPlayerSuccess"] + " </li></ul>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["contestant1Name"] + " </li><li><strong>Class:</strong> " + gameData["contestant1Class"] + "</li><li><strong>Success points:</strong> " + gameData["contestant1Success"] + " </li></ul>");
		if (gameData["contestant2Name"] !== null) {
			$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["contestant2Name"] + " </li><li><strong>Class:</strong> " + gameData["contestant2Class"] + "</li><li><strong>Success points:</strong> " + gameData["contestant2Success"] + " </li></ul>");
		}

		$(".gameText").append("<h2>Your Challenge!</h2>");
		$(".gameText").append("<h3>" + gameData["challenge"]["title"] + "</h3>");
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
		// gameData is the same data as playGame success, just with a new name (it is the $return_data info)
		$(".gameText").html('');
		$(".gameOptions").html('');

		$(".gameText").append("<h3>Player Info!</h3>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["myPlayerName"] + " </li><li><strong>Class:</strong> " + gameData["myPlayerClass"] + "</li><li><strong>Success points:</strong> " + gameData["myPlayerSuccess"] + " </li></ul>");
		$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["contestant1Name"] + " </li><li><strong>Class:</strong> " + gameData["contestant1Class"] + "</li><li><strong>Success points:</strong> " + gameData["contestant1Success"] + " </li></ul>");

		if (gameData["contestant2Name"] !== null) {
			$(".gameText").append("<ul><li><strong>Name:</strong> " + gameData["contestant2Name"] + " </li><li><strong>Class:</strong> " + gameData["contestant2Class"] + "</li><li><strong>Success points:</strong> " + gameData["contestant2Success"] + " </li></ul>");
		}

		$(".gameText").append("<h4>" + gameData["acceptedString"] + "</h4>");
		$(".gameText").append("<p>Carrying out the challenge with a contestant will cost you 5 success points, but may increase your chances of winning the game!<br> If you win as a team, you will get 9 success points each.</p>");
		$(".gameText").append("<p>If you win a challenge alone, you get 15 success points.<br>If you lose the challenge it will cost you 5 success points & if you come in second or third you lose a tool!</p>");

		$(".gameOptions").append('<button class="doChallengeBtn">Carry out challenge!</button>');
		if (gameData["contestant2Name"] !== null) {
			$(".gameOptions").append('<button class="companionChallengeBtn">Carry out challenge with contestant!</button>');
		}

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

		$(".gameText").append("<h3>The results of the challenge...</h3>");

		if (gameData["gameOver"] === true) {
			$(".gameText").append("<p>" + gameData["returnString"] + "</p>");

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
		else {
			$(".gameText").append("<p>" + gameData["returnString"] + "</p>");

			$(".gameText").append("<p><strong>First Place:</strong> " + gameData["firstPlace"] + "</p>");
			$(".gameText").append("<p><strong>Second Place:</strong> " + gameData["secondPlace"] + "</p>");
			if (gameData["thirdPlace"] !== null) {
				$(".gameText").append("<strong><p>Third Place:</strong> " + gameData["thirdPlace"] + "</p>");
			}
			
			$(".gameOptions").append('<button class="nextChallengeBtn">Play next challenge!</button>');
			$(".nextChallengeBtn").click(function() {
				playGame(false);
				// Do not reload the page
				return false;
			});
		}
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