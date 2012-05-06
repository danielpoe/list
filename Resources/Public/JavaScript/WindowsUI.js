WindowsUI =  {	
	showConfirmation: function(text,title,confirmActionName, callBack) {	
		jQuery('#body-overlay').show();
		jQuery('#body-overlay').addClass('ui-widget-overlay');
		jQuery( "#dialog-confirm" ).find('.message').text(text);
		jQuery( "#dialog-confirm" ).dialog({
			title: title,
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				Yes: function() {					
					$( this ).dialog( "close" );
					jQuery('#body-overlay').hide();
					callBack();
				},
				Cancel: function() {
					$( this ).dialog( "close" );
					jQuery('#body-overlay').hide();
					return false;
				}
			}
		});		
	},
	
	showWaitMessage: function(message) {
		jQuery('#body-overlay').addClass('ui-widget-overlay');
		jQuery('.please-wait-container').dialog();
	},
		
	
}
//array = $('form input:checkbox').serializeArray();


