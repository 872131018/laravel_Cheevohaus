$(document).ready()
{
	/*
  * Delegate all clicks to the document
  */
  $(document).on('click', '[data-delegate=gamertag]', function(event)
  {
		/*
		* Check the users login when the button is clicked
		*/
		loadGamertag();
	});
  /*
  * Delegate all clicks to the document
  */
  $(document).on('click', '[data-delegate=recent_activity]', function(event)
  {
		/*
		* Check the users login when the button is clicked
		*/
		retrieveRecentActivity();
	});
}
