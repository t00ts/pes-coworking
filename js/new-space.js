

var NewSpace = {
		
  addFeature: function (name) {
	$.ajax ({
	  url: "api/features/new.php",
	  type: "post",
	  data: "name=" + name + "&auth_type=SESSION",
	  success: function (xml) {
	    if ($(xml).find("error").size() == 0) {
	      // No errors
	      $('#newFeature').val("");
	      
	      var newFeatureListEl = "<li><div class=\"input-group\"><span class=\"input-group-addon\"><input class=\"chkFeature\" value=\"" +  $(xml).find("feature").attr("id") + "\" type=\"checkbox\" checked=\"checked\"></span><input type=\"text\" class=\"form-control\" disabled=\"disabled\" value=\""+ $(xml).find("name").text() +"\" /></div></li>";
	      $(newFeatureListEl).insertAfter ($("#featureList li").eq(-2));
	      
	    }
	  }
		
	})
  },
  
  serializeFeatures: function () {
	var serFeatures = "";
    $('input.chkFeature').each (function (i, e) {
      if ($(e).is(':checked')) serFeatures += $(e).val() + ",";
    });
    serFeatures = serFeatures.substring (0, serFeatures.length - 1);
    $('input#features').val (serFeatures);
  }
		
};

$('#btnAddFeature').click (function () {
  NewSpace.addFeature(document.getElementById('newFeature').value);
});