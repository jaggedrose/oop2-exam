$(function() {

	
	$('#addPlayer').submit(function() {
		var form = $(this);
		var pName = form.find('#playerName').val();

		var selectedClass;

		if ($("input[name='playerClass']:checked").length > 0){
			selectedClass = $('input:radio[name=playerClass]:checked').val();
			console.log(selectedClass);
		}
		else {
			alert("You must select a class!");
			return false;
		}

		submitPlayerName(pName, selectedClass);

		// Do not reload the page
		return false;
	});

	
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
				console.log("startNewGame error: ", data);
			}
		});
	}




});