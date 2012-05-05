ListInitialization =  {
	init: function() {
		this._initTableSortings();
		// make table rows selectable
		$( ".listwidget-table tbody" ).selectable();
		
		$( ".listwidget-table" ).simpleResizableTable();
		 
		//init jquery-ui button
		$('.listwidget .button').button();
		 
		// init jquery toggle box
		$( ".listwidget .toggle .ui-widget-header" ).click(function(e) {
			$(this).parent().find('.togglecontent').toggle( 'blind');
		});	
	},
	
	/**
	 * jquery table sorting:
	 * @todo: no callback implemented yet
	 */
	_initTableSortings: function() {
		// Return a helper with preserved width of cells
		var fixHelper = function(e, ui) {
		    ui.children().each(function() {
		        $(this).width($(this).width());
		    });
		    return ui;
		};		 
		//make table rows sortable via drag and drop
		$(".listwidget-table tbody").sortable({helper: fixHelper, cursor: 'crosshair', handle: '.sorthandle'}).disableSelection();		
	}

}


$(function() {
	ListInitialization.init();
})