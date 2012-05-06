ListInitialization =  {
	init: function() {
		//initialize a WidgetListController for each widget on the page
	 	jQuery('.listwidget').each(
	 		function(index, value) {
	 			new WidgetListController(value);
	 		}	 	
	 	);
		
	}

}

WidgetListController = function(widgetElement) {
	this.widgetContainer = jQuery(widgetElement);
	
	/**
	 * Controller Initialisation
	 */
	this.init = function() {
		this._initTableSortings();
		this._registerActions();		
		this.widgetContainer.find( ".listwidget-table" ).simpleResizableTable();		 
		//init jquery-ui button
		this.widgetContainer.find('.button').button();		 
		// init jquery toggle box
		this.widgetContainer.find( ".toggle .ui-widget-header" ).click(function(e) {
			jQuery(this).parent().find('.togglecontent').toggle( 'blind');
		});
	};
	
	/**
	 * Registered possible WidgetControllerActions
	 */
	this._registerActions = function() {
		//register click all action button
		this.widgetContainer.find('.action-select-all').click( 
				function(event) {
					jQuery(this).data('WidgetListController').toggleSelectRow()
				}				
		).data('WidgetListController', this);		
	};
	
	
	/*************************
	 * MASS SELECT methods
	 */
	
	/**
	 * Init selectable rows
	 */
	this._initSelectableRows = function() {
		this.widgetContainer.find( ".listwidget-table tbody" ).selectable({ filter: "tr", cancel: "a",
			selected: function(event, ui) {
				jQuery(ui.selected).find('.massaction-select').attr('checked', true);
			},
			unselected: function(event, ui) {
				jQuery(ui.unselected).find('.massaction-select').attr('checked', false);
			}
		});		
	},
	
	/**
	 * checks if rows are selected and unselect or deselcet all
	 */
	this.toggleSelectRow = function() {
		if ( this.widgetContainer.find( ".listwidget-table tbody tr.ui-selected" ).size() > 0 ) {
			this.unSelectAllRows();
		}
		else {
			this.selectAllRows();
		}
	};
	/**
	 * select all rows
	 */
	this.selectAllRows = function() {
		this.widgetContainer.find( ".listwidget-table tbody tr" ).addClass('ui-selected');
		this.widgetContainer.find( '.massaction-select').attr('checked', true);
	};
	/**
	 * unselect all rows
	 */
	this.unSelectAllRows = function() {
		this.widgetContainer.find( ".listwidget-table tbody tr" ).removeClass('ui-selected');
		this.widgetContainer.find( '.massaction-select').attr('checked', false);
	};
	
	/**
	 * jquery table sorting:
	 * @todo: no callback implemented yet
	 */
	this._initTableSortings =  function() {
		// Return a helper with preserved width of cells
		var fixHelper = function(e, ui) {
		    ui.children().each(function() {
		    	jQuery(this).width(jQuery(this).width());
		    });
		    return ui;
		};		 
		this.widgetContainer.find(".listwidget-table .sorthandle").button({
	            icons: {
	            primary: "ui-icon-arrow-4"
	        },
	        text: false
	    });
		//make table rows sortable via drag and drop
		this.widgetContainer.find(".listwidget-table tbody").sortable({helper: fixHelper, cursor: 'crosshair', handle: '.sorthandle'}).disableSelection();		
	};
	
	this.init();	
}


$(function() {
	ListInitialization.init();
})