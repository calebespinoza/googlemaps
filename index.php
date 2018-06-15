<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Rio Rocha | Puntos de Monitoreo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

  <body>
    <div id="map"></div>

    <script>

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-17.393339, -66.180482),
          zoom: 13
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('http://localhost/googlemaps/phptoxml.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var name = markerElem.getAttribute('name');
              //var address = markerElem.getAttribute('address');
              //var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var mainTitle = document.createElement('h4');
              mainTitle.textContent = "Punto " + name
              infowincontent.appendChild(mainTitle);
              //infowincontent.appendChild(document.createElement('br'));

              var secondTitle = document.createElement('h5');
              secondTitle.textContent = "Historial de Muestras"
              infowincontent.appendChild(secondTitle);
              var table = document.createElement('div');
              table.className = "table-responsive";
              //table.innerHTML = "<table><tr><th>Fecha</th><th>Total</th></tr><td>05/05/2018</td><tr></tr></table>";
              table.innerHTML = markerElem.getAttribute('samples');
              //table.textContent = "<tr><th>Tabla</th></tr>"
              infowincontent.appendChild(table);
              //var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                //label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGFnz8Rdnr43gMZtVGrO7h4eqIKrj-v2s&callback=initMap">
    </script>
  </body>
</html>