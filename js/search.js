
var search = {
		
  init: function () {
	var that = this;
	console.log ("aa");
	$('ul#feature-list').find('input').each (function (i, e) {
	  $(e).change (function () {
        that.updateResults ();
	  })
		
	});
  },

  updateResults: function () {
	var that = this;
	
	// Get query
	var q = $('#search-q').val();
	
	// Get selected features
	var serFeatures = "";
    $('input.feature-filter').each (function (i, e) {
      if ($(e).is(':checked')) serFeatures += $(e).val() + ",";
    });
    serFeatures = serFeatures.substring (0, serFeatures.length - 1);
	
	$.ajax ({
	  url: "api/spaces/search.php",
	  type: "post",
	  data: "q=" + q + "&features=" + serFeatures + "&auth_type=SESSION",
	  success: function (xml) {
        $('#results').empty();
	    $(xml).find('space').each (function (i, e) {
	      var id = $(e).attr("id");
	      var name = $(e).find("name").text();
	      var description = $(e).find("description").text();
	      var minPrice = $(e).find("minPrice").text();
	      var newItem = "<tr><td><ul class=\"media-list\"><li class=\"media\"><a class=\"pull-left thumbnail\" href=\"index.php?s=view-space&id="+ id + "\"><img class=\"media-object\" src=\"img/spaces/"+ id + ".jpg\" alt=\"\" style=\"width: 170px; height: 130px;\"></a><div class=\"media-body\"><span class=\"badge price\">"+ minPrice +" &euro; / hr</span><h4 class=\"media-heading\">" + name + "</h4></div><p>" + description + "</p><br><br><a class=\"btn btn-info btn-xs\" role=\"button\" href=\"index.php?s=view-space&id="+ id + "\">Visit profile</a></li></ul></td></tr>";
	      console.log ("aaaaa");
	      $('#results').append (newItem);
	    });
	  }
		
	})
  }
		
		
}

$(document).ready (function () {
	
search.init ();
	
});