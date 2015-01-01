$(function() {

	
	$('#addPlayer').submit(function() {
		var form = $(this);
		var pName = form.find('#playerName').val();

		submitPlayerName(pName);

		// Do not reload the page
		return false;
	});

	
	function submitPlayerName(pName) {
		$.ajax({
			url: "player_choice.php",
			dataType: "json",
			data: {
			// game_id : 0,
			// create_player: {
			//   "class" : "Aria",
			//   "name" : "aName"
			player_name : pName
			},
			success: function(data) {
				console.log("Success: ", data);
			},
			error: function(data) {
				console.log("startNewGame error: ", data.responseText);
			}
		});
	}



});