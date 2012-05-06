WidgetListController = function(widgetElement) {
	this.widgetContainer = jQuery(widgetElement);
	
	/**
	 * Controller Initialisation
	 */
	this.init = function() {
		this.widgetContainer.data('WidgetListController', this);
		
		this._initTableSortings();
		this._initSelectableRows();
		this._registerActions();
		this._initUI();		
	};
	
	this._initUI = function() {
		this.widgetContainer.find( ".listwidget-table" ).simpleResizableTable();		 
		//init jquery-ui button
		this.widgetContainer.find('.button').button();		 
		// init jquery toggle box
		this.widgetContainer.find( ".toggle .ui-widget-header" ).click(function(e) {
			jQuery(this).parent().find('.togglecontent').toggle( 'blind');
		});		
	},
	
	/**
	 * Registered possible WidgetControllerActions
	 */
	this._registerActions = function() {
		//register click all action button
		this.widgetContainer.find('.action-select-all').click( 
				function(event) {
					jQuery(this).parent('.listwidget').data('WidgetListController').toggleSelectRowAction();
				}				
		);	
		
		//
		this.widgetContainer.find('.action-massaction-execute').change( 
				function(event) {
					jQuery(this).parent('.listwidget').data('WidgetListController').executeMassAction()
				}				
		);
	};
	
	this.executeMassAction = function() {
		var actionName = this.widgetContainer.find('.massactionname').val();
		var massActionIds = this.getSelectedMassactionIds();
		WindowsUI.showConfirmation('Really want to '+actionName+' # '+this.getSelectedCount()+' records?',actionName+' confirmation..',actionName,
				function() {
					alert('Todo - dispatch massActionIds to typo3action JS Controller');
				}
		);
		this.widgetContainer.find('.massactionname').val('empty');
		
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
	
	this.getSelectedCount = function() {
		return this.widgetContainer.find('input:checkbox[name=tx_list_web_listlist[massactionids]]:checked').size();		
	},
	/**
	 * @return Array of all selected item ids
	 */
	this.getSelectedMassactionIds = function() {
		var selected = new Array();
		this.widgetContainer.find('input:checkbox[name=tx_list_web_listlist[massactionids]]:checked').each(
			function() {
				selected.push(jQuery(this).val());				
			}
		);
		return selected;		
	},
	
	/**
	 * checks if rows are selected and unselect or deselcet all
	 */
	this.toggleSelectRowAction = function() {
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