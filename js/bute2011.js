function objectToString(o){
    
	var parse = function(_o){		 
			  var a = [], t;
			  
			  for(var p in _o){
			  
					if(_o.hasOwnProperty(p)){
					
						 t = _o[p];
						 
						 if(t && typeof t == "object"){
						 
							  a[a.length]= p + ":{ " + arguments.callee(t).join(", ") + "}";
							  
						 }
						 else {
							  
							  if(typeof t == "string"){
							  
									a[a.length] = [ p+ ": \"" + t.toString() + "\"" ];
							  }
							  else{
									a[a.length] = [ p+ ": " + t.toString()];
							  }
							  
						 }
					}
			  }
			  
			  return a;
			  
		 }
		 
		 return "{" + parse(o).join(", ") + "}";
		 
	}
	$().ready(function() {
	  $('#dialog').jqm();
	  hideAllPaymentConfirmationSteps();
		var pusher = new Pusher('ef8c48dfede24f30d0ad'); // Replace with your app key
		var thingChannel = pusher.subscribe('bute2011');
		thingChannel.bind('donate', function(messageStr) {
		  var message = eval("("+messageStr+")");
		  addDonateMessage(message);
		});
		thingChannel.bind('tweet', function(messageStr) {
		  var message = eval("("+messageStr+")");
		  addTwitterMessage(message);
		});		
		addDonateMessage({'amount':"5",'name':"Anonymous",'message':"Keep up the good work!"});
		addCharityNews('Help fight childhood cancer by donating to Friends of a Feather. Aflac doubles EVERY donation!');
		addCharityNews('Help us get to more people!');
	});

	function processPayment()
	{
		setTimeout("$('#makePaymentStep1').hide();hideAllPaymentConfirmationSteps();$('#paymentConfirmationStep1').show();",0);
		setTimeout("hideAllPaymentConfirmationSteps();$('#paymentConfirmationStep2').show();",2000);
		setTimeout("sendSMS();hideAllPaymentConfirmationSteps();$('#paymentConfirmationStep3').show();",4000);
		setTimeout("sendPusherNotification();hideAllPaymentConfirmationSteps();$('#makePaymentStep1').hide();$('#makePaymentStep2').show();",6000);
	}
	function donationClicked()
	{
		hideAllPaymentConfirmationSteps();
		$('#makePaymentStep1').show();
		$('#makePaymentStep2').hide();
	}
	function hideAllPaymentConfirmationSteps()
	{
		$('#paymentConfirmationStep1').hide();
		$('#paymentConfirmationStep2').hide();
		$('#paymentConfirmationStep3').hide();
	}
	function sendPusherNotification()
	{
		var event ="donate";
		var messageStr = objectToString(getMessage());
		var url ="http://agostonfung.co.uk/apidevday/services/pina.php?event="+event+"&message="+messageStr;
		$.get(url, function(data) {			  
		});
	}
	function promoteCharity(name, message)
	{
		var event ="tweet";
		var messageStr = objectToString({'name':name,'message':message});
		var url ="http://agostonfung.co.uk/apidevday/services/pina.php?event="+event+"&message="+messageStr;
		$.get(url, function(data) {			  
		});
	}
	function getMessage()
	{
		var message = {'amount':$("#amount").val(),'name':$("#name").val(),'message':$("#message").val()};
		return message;
	}
	var numElements = 0;
	function addDonateMessage(message)
	{
		//alert("displaying message");
		numElements++;
		var element = $('#referenceDonationMessage').clone();
		element.attr("id","element_"+numElements);
		var html = element.html().replace("{name}",message.name).replace("{amount}",message.amount).replace("{charityName}","Cancer Research UK").replace("{message}",message.message);
		element.html(html);
		$("#donationMessages").prepend(element);
		$("#element_"+numElements).fadeIn('slow');
	}
	function addCharityNews(message)
	{
		numElements++;
		var element = $('#referenceCharityBuzzTweet').clone();
		element.attr("id","element_"+numElements);
		var html = element.html().replace("{message}",message).replace("{message2}",message);
		element.html(html);
		$("#charityBuzz").prepend(element);
		$("#element_"+numElements).fadeIn('slow');		
	}
	function addTwitterMessage(message)
	{
		//alert("displaying message");
		numElements++;
		var element = $('#referenceCharityBuzzTweet').clone();
		element.attr("id","element_"+numElements);
		var html = element.html().replace("{name}",message.name).replace("{amount}",message.amount).replace("{charityName}","Cancer Research UK").replace("{message}",message.message);
		element.html(html);
		$("#donationMessages").prepend(element);
		$("#element_"+numElements).fadeIn('slow');
	}
	function sendSMS()
	{
		var message = getMessage();
		var phoneNumber = "447513389091";
		var messageStr = message.amount + "£ has been donated by " + message.name + " with the message " + message.message;
		var url ="http://agostonfung.co.uk/apidevday/services/sms.php?msisdn="+phoneNumber+"&message="+encodeURI(messageStr);
			$.get(url, function(data) {			  
		});
	}