var london = new google.maps.LatLng(51.523657, -0.124183);

  var neighborhoods = [
    new google.maps.LatLng(51.521134, -0.15132),
    new google.maps.LatLng(51.535979, -0.11673),
    new google.maps.LatLng(51.520106, -0.12055),
    new google.maps.LatLng(51.527683, -0.16055),
    new google.maps.LatLng(51.521467, -0.12055),
  ];

  var placeNames = [
    "<a href=\"#\"><b>Animal</b></a><br /> <em>We are the world's leading charity dedicated to saving lives through research.</em>",
    "<a href=\"#\"><b>Disablility</b></a><br /> <em>We are the world's leading charity dedicated to saving lives through research.</em>",
    "<a href=\"#\"><b>Health</b></a><br /> <em>We are the world's leading charity dedicated to saving lives through research.</em>",
    "<a href=\"#\"><b>Cancer</b></a><br /> <em>We are the world's leading charity dedicated to saving lives through research.</em>",
    "<a href=\"#\"><b>Christian</b></a><br /> <em>We are the world's leading charity dedicated to saving lives through research.</em>",
  ];

  var markers = [];
  var iterator = 0;

  var map;

  function initialize() {
    var mapOptions = {
      zoom: 12,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: london
    };

    map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
    setTimeout(function () {
        drop();
    }, 1000);
  }

  function drop() {
    for (var i = 0; i < neighborhoods.length; i++) {
      setTimeout(function() {
        addMarker();
      }, i * 200);
    }
}
var infowindow = new google.maps.InfoWindow();

  function addMarker() {
     var marker = new google.maps.Marker({
          position: neighborhoods[iterator],
          map: map,
          draggable: false,
          animation: google.maps.Animation.DROP
      })
      markers.push(marker);
      marker.iterator = iterator
      google.maps.event.addListener(marker, 'click', function () {
          infowindow.setContent(placeNames[marker.iterator]);
          infowindow.open(map, this);
      });
    iterator++;
}

google.maps.event.addDomListener(window, 'load', initialize);
