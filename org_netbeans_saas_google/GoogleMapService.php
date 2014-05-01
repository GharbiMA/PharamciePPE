<?php

require_once "org_netbeans_saas/RestConnection.php";
require_once "GoogleMapServiceProfile.php";

define("GEOCODE_URL", "http://maps.google.com/maps/geo");

class GoogleMapService {

    public static function getApiKey() {
        $apiKey = GoogleMapServiceProfile::getApiKey();
        if ($apiKey == null || $apiKey == "") {
            throw new Exception("Please specify your api key in the apikey.php file.");
        }
        return $apiKey;
    }

    /**
     * Returns HTML text to access GoogleMap.
     * @param address - address string to generate map for.
     * @param zoom.
     */
    public static function getGoogleMap($address, $zoom, $iframe) {
        $key = self::getApiKey();
        $encoded = urlencode($address);
        $coder = new GeoCoder($encoded, $key);
        $code = $coder->invoke();

        $mapRep = "";
        if ($iframe != null && $iframe == "true") {
            $mapRep .=
                    "    <div id='map' style='width: 500px; height: 300px'></div>\n" .
                    self::getMapScript($address, $zoom, $code->getLatitude(), $code->getLongitude(), $key) .
                    "    <script type='text/javascript'>\n" .
                    "       loadScript();\n" .
                    "    </script>\n";
        } else {
            $mapRep .=
                    "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'\n" .
                    "  'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>\n" .
                    "<html xmlns='http://www.w3.org/1999/xhtml'>\n" .
                    "  <head>\n" .
                    "    <meta http-equiv='content-type' content='text/html; charset=utf-8'/>\n" .
                    "    <title>Google Maps JavaScript API Example</title>\n" .
                    self::getMapScript($address, $zoom, $code->getLatitude(), $code->getLongitude(), $key) .
                    "  </head>\n" .
                    "  <body onload='loadScript()' onunload='GUnload()'>\n" .
                    "    <div id='map' style='width: 500px; height: 300px'></div>\n" .
                    "  </body>\n" .
                    "</html>";
        }
        $result = new RestResponse();
        $result->setResponseBody($mapRep);
        return $result;
    }

    public static function getMapScript($address, $zoom, $latitude, $longitude, $key) {
        $mapRep = "    <script type='text/javascript'>\n" .
                "    //<![CDATA[\n" .
                "    function loadMap() {\n" .
                "      if (GBrowserIsCompatible()) {\n" .
                "        var map = new GMap2(document.getElementById('map'));\n" .
                "        var point = new GLatLng(" . $latitude . ", " . $longitude . ");\n" .
                "        map.addControl(new GSmallMapControl());\n" .
                "        map.addControl(new GMapTypeControl());\n" .
                "        map.setCenter(point, " . $zoom . ");\n" .
                "        var marker = createMarker(point);\n" .
                "        map.addOverlay(marker);\n" .
                "        marker.openInfoWindowHtml(\"" . $address . "\");\n" .
                "      }\n" .
                "    }\n" .
                "    function createMarker(point) {\n" .
                "      var marker = new GMarker(point);\n" .
                "      GEvent.addListener(marker, \"click\", function() {\n" .
                "         marker.openInfoWindowHtml(\"" . $address . "\");\n" .
                "      });\n" .
                "      return marker;\n" .
                "    }\n" .
                "    function loadScript() {\n" .
                "      var script = document.createElement(\"script\");\n" .
                "      script.setAttribute(\"src\", \"http://maps.google.com/maps?file=api&v=2.x&key=" . $key . "&async=2&callback=loadMap\");\n" .
                "      script.setAttribute(\"type\", \"text/javascript\");\n" .
                "      document.documentElement.firstChild.appendChild(script);\n" .
                "    }\n" .
                "    //]]>\n" .
                "    </script>\n";
        return $mapRep;
    }

}

class GeoCoder {

    private $location;
    private $key;

    /** Creates a new instance of GeoCoder */
    public function GeoCoder($location, $key) {
        $this->location = $location;
        $this->key = $key;
    }

    /**
     *
     * @return geocode
     */
    public function invoke() {
        $queryParams = array();
        $queryParams["q"] = $this->location;
        $queryParams["output"] = "xml";
        $queryParams["key"] = $this->key;

        $cl = new RestConnection(GEOCODE_URL, $queryParams);
        $response = $cl->get();
        $codeStr = $response->getResponseBody();
        return new GeoCode($codeStr);
    }

}

class GeoCode {

    private $longitude;
    private $latitude;

    /** Creates a new instance of GeoCode */
    public function GeoCode($xmlStr) {
        $xmlStr = str_replace("<", "&lt;", $xmlStr);
        $xmlStr = str_replace(">", "&gt;", $xmlStr);
        $ts = strpos($xmlStr, "&lt;coordinates&gt;");
        $te = strpos($xmlStr, "&lt;/coordinates&gt;");
        $codeStr = "";
        if ($ts != -1 && $te != -1)
            $codeStr = substr($xmlStr, $ts + 19, $te);
        $codes = split(",", $codeStr);
        if ($codes != null && count($codes) > 1) {
            $this->longitude = $codes[0];
            $this->latitude = $codes[1];
        }
    }

    /**
     *
     * @return longitude
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     *
     * @return latitude
     */
    public function getLatitude() {
        return $this->latitude;
    }

}

?>
