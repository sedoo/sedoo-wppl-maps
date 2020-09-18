// when the 'adress' field is updated, I need to geocode the user value and set the latitude and longitude in the fields 
var latitude;
jQuery('#acf-field_5f1973e456ef0').change(function() {
    var recherche = jQuery('#acf-field_5f1973e456ef0').val();
    jQuery.ajax({
        dataType: "json",
        url: 'https://api.mapbox.com/geocoding/v5/mapbox.places/'+recherche+'.json?access_token=pk.eyJ1IjoiZ25pY29sYXMzMSIsImEiOiJja2RpbTBteDkwNmRqMnJvaGM3Z2tncXRnIn0.yVz4MD1Jt_gJmHGNfM-Wbw',
        success: function(data) {
            // latitude
                latitude = data.features[0].center[0];
                jQuery('input#acf-field_5f19740e00ef1').val(latitude);

            //longitude
                longitude = data.features[0].center[1];
                jQuery('input#acf-field_5f1973e600ef0').val(longitude);

            // set the correct place name in the search field
                correct_name = data.features[0].place_name;
                jQuery('#acf-field_5f1973e456ef0').val(correct_name)
          }
      });
});
