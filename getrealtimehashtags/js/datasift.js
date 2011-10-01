// var url = 'http://api.datasift.net/compile?csdl=interaction.content%20contains%20"apple"&username=nickhalstead&api_key=347c2581beae30a14ff6c1717b591534';
// $.get(url, function(data) {
    // // can use 'data' in here...
// });

// $.ajax({
  // url: 'http://api.datasift.net/compile?csdl=interaction.content%20contains%20"apple"&username=nickhalstead&api_key=347c2581beae30a14ff6c1717b591534',
  // context: document.body,
  // dataType: 'json',
  // success: function(data){
    // if (console && console.log){
      // console.log( 'Sample of data:', data.slice(0,100) );
     // }
  // }
// });

$(document).ready(function() {
hash = $('#hash').val();

alert(hash);

var ws = new WebSocket('ws://websocket.datasift.net/'+hash+'?username=nickhalstead&api_key=347c2581beae30a14ff6c1717b591534');

ws.onopen = function(evt) {
    // connection event
}

ws.onmessage = function(evt) {
    // parse received message
    //console.log(evt.data);
    var data = eval('(' + evt.data + ')');
    $('#twitter').append(
    	'<p>' + 
    	data.interaction.content
    	+ '</p>'
   	);
}

ws.onclose = function(evt) {
    // parse event
}

// No event object is passed to the event callback, so no useful debugging can be done
ws.onerror = function() {
    // Some error occured
}
});




