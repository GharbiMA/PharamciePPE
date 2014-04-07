<html>
    <head>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    </head>
    <body>
        <script type="text/css">
                 #map {
                    width: 100px;
                    height: 100px;
                    border: 1px #000 solid;
                        }   
        </script>
        
        <script type="text/javascript">
                 var mapInstance;
                    var marker;

            function placeMarker(location) {
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: mapInstance
                    });
                }
            }
            function submitAction() {
                alert("Value of firstname is " + $("#firstnamefield").val());
                alert("Value of lastname is " + $("#lastnamefield").val());
                alert("Value of latlng is " + $("#latlngfield").val());
            }

            $(document).ready(function() {
                var latlng = new google.maps.LatLng(36.74328605437939, 10.7391357421875);
                var mapOptions = {
                    zoom: 9,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DEFAULT
                    }
                };
                mapInstance = new google.maps.Map(document.getElementById("map"), mapOptions);
                google.maps.event.addListener(mapInstance, 'click', function(event) {
                    placeMarker(event.latLng);
                });

                $("#submitbutton").on("click", function(e) {
                    // Prevent normal submit action
                    e.preventDefault();
                    // Collect current latlng of marker and put in hidden form field
                    if (marker) {
                        $("#latlngfield").val(marker.getPosition().toString());
                    } else {
                        $("#latlngfield").val("not entered");
                    }
                    // Show results for debugging
                    submitAction();
                    // Uncomment this for production and remove submitAction() call
                    // $("#dataform").submit();
                });
            });
        </script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        
        <form id="dataform">
           <div id="map" ></div>       
        <fieldset>
            <legend>Form Information</legend>                
            <input type="submit" name="submit" id="submitbutton" value="Submit Data">
            <input type="hidden" name="latlng" id="latlngfield">
        </fieldset>
           <?php echo 'herehere'; ?>
</form>        
        
        
    </body>    
</html>
<?php
