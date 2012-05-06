TYPO3Actions =  {
	editRecord: function(table,id,onlycolumns) {
		var link = 'alt_doc.php?returnUrl='+escape(this._getCurrentUrl());
		link = link + '&edit['+table+']['+id+']=edit';
		if (typeof onlycolumns != 'undefined') {
			link = link + '&columnsOnly='+onlycolumns;
		}
		this._redirectToUrl(link);
	},
	
	createRecordOnPage: function(table,onPageId) {		
		if (typeof onPageId == 'undefined') {
			if (typeof pageId == 'undefined') {
				alert('Need to know where to create.. no pageId given!');	
				return;
			}
			//use defaul global variable if not passed
			onPageId = pageId;
		}
		return this._createRecord(table, onPageId);
	},
	
	createRecordAfterRecord: function(table,afterId) {		
		if (typeof afterId == 'undefined') {
			alert('Need to know where to create');			
		}
		return this._createRecord(table, '-'+afterId);
	},
	
	hideRecord: function(table,id ) {
		this._doTCEAction('&data['+table+']['+id+'][hidden]=1');
	},
	
	showRecord: function(table,id ) {
		this._doTCEAction('&data['+table+']['+id+'][hidden]=0');
	},
	
	deleteRecord: function(table,id ) {	
		WindowsUI.showConfirmation('Really want to delete?','Delete','Delete',
				function() {
					TYPO3Actions._doTCEAction('&cmd['+table+']['+id+'][delete]=1');
				}
		);
		
	},
	
	/******
	 * Private Helper
	 */
	
	_createRecord: function(table, actionId) {	
		var link = 'alt_doc.php?returnUrl='+escape(this._getCurrentUrl());
		link = link + '&edit['+table+']['+actionId+']=new';		
		this._redirectToUrl(link);
	},
	
	
	_checkTceToken: function() {
		if (typeof userSessionToken == 'undefined') {
			alert('userSessionToken not set');
			return false;
		}
		
		if (typeof tceDbFormTockenParameter == 'undefined') {
			alert('tceDbFormTockenParameter not set');
			return false;
		}
		return true;
	},
	
	_getCurrentUrl: function() {
		return location.href;
	},
	
	_doTCEAction: function(additionalParameters) {
		if (this._checkTceToken() == false) {
			return;
		}
		var link = 'tce_db.php?redirect='+escape(this._getCurrentUrl());
		link = link + additionalParameters;
		link = link + '&vC='+userSessionToken+tceDbFormTockenParameter+'&prErr=1&uPT=1';
		this._redirectToUrl(link);		
	},
	
	_redirectToUrl: function(link) {
		jQuery('#body-overlay').addClass('ui-widget-overlay');
		jQuery('.please-wait-container').dialog();
		window.location.href=link;
	},
		
	
}
//array = $('form input:checkbox').serializeArray();


