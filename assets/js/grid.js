var Grid = "";

$(document).ready(function(){	
    Grid = {
        debug : appOptions.debug,                   //debug status of grid
		parent : undefined,                         //element the grid is build in
		data : undefined,                           //complete json data
        dataSelection : undefined,                  //json data selection (e.g. after searching)
		tableHeadConversionArray : undefined,       //array with column name conversion
        tableHeadData : new Array(),                //array of available columns with status data of column
        sortColumn : 0,                             //column to sort
        sortDirection : 'asc',                      //sort direction of column
        isInitialized : true,                       //internal status for some sorting stuff after initialization

        /*
        *   initialize grid
        *       requesting json data from provided url
        *       render table
        *       init events
        */
        Initialize : function(parentElement, tableHeadConversionArray) {
			Grid.parent = parentElement;
			Grid.tableHeadConversionArray = tableHeadConversionArray;
            Grid.sortDirection = 'asc';

            if(Grid.parent == undefined){
                Grid._throwErrorMessage('001');
                return true;
            }
			
			$.ajax({
				url:			Grid.parent.attr('data-requestURL'),
				type:			'GET',
				cache:			false,
				beforeSend:		function(){
									Application.Loader.Show();
								},
				success:		function(data){
									Grid.data = jQuery.parseJSON(data);
                                    Grid.dataSelection = Grid.data;
                                    Grid._createHeaderData();
                                    Grid._sortData();
									Grid._renderData();
                                    Grid._initializeEvents();
                                    Application.Loader.Hide();
								},
				error:			function(data){
									if(Grid.debug){
										console.log(dataSelection);
									}
									Application.Loader.Hide();
								}
			});
        },

        _createHeaderData : function(){
            if(Grid.data.length > 0){
                Grid.tableHeadData = new Array();

                jQuery.each(Grid.data[1], function(key, value){
                    if(Grid.tableHeadConversionArray != undefined && Grid.tableHeadConversionArray[key] != undefined){
                        keyConversion = Grid.tableHeadConversionArray[key];
                    } else {
                        if(Grid.debug){
                            console.log('GRID: There is no name conversion available for the database field "' + key + '". Standard column name is used.')
                        }
                        keyConversion = key;
                    }

                    var headObj = new Object();
                    headObj.columnName = key;
                    headObj.displayName = keyConversion;
                    if(Grid.isInitialized){
                        headObj.sortType = 'asc';
                        Grid.isInitialized = false;
                    } else {
                        headObj.sortType = 'none';
                    }

                    Grid.tableHeadData.push(headObj);
                });
            }
        },

        /*
        *   render complete grid object
        *
        */
		_renderData : function(){
            var htmlTableOptions = '';
            htmlTableOptions = htmlTableOptions + '<div class="dropdown pull-right">';
            htmlTableOptions = htmlTableOptions + '<button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"><i class="fa fa-fw fa-cog"></i> <span class="caret"></span></button>';
            htmlTableOptions = htmlTableOptions + '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">';
            htmlTableOptions = htmlTableOptions + '<li role="presentation"><a role="menuitem" href="#" class="grip-option-hideShowColumn"><i class="fa fa-fw fa-check-square-o"></i> show/hide columns</a></li>';
            htmlTableOptions = htmlTableOptions + '<li role="presentation" class="divider"></li>';
            htmlTableOptions = htmlTableOptions + '<li role="presentation"><a role="menuitem" href="#" class="grid-option-refresh"><i class="fa fa-fw fa-refresh"></i> refresh table</a></li>';
            htmlTableOptions = htmlTableOptions + '</ul>';
            htmlTableOptions = htmlTableOptions + '</div>';

            var htmlTable = '<div class="panel panel-default"><div class="panel-heading"><strong>' + Grid.parent.attr('data-tableTitle') + '</strong>' + htmlTableOptions + '</div><div class="panel-body"><div class="table-responsive"><table class="table table-condensed table-striped table-hover" class="grid" ><thead class="grid-head"></thead><tbody class="grid-body"></tbody></table></div></div></div>';

            Grid.parent.html(htmlTable);
			Grid.parent.find('.grid-head').html(Grid._renderTableHeadData());
			Grid.parent.find('.grid-body').html(Grid._renderTableBodyData());
		},

        /*
        *   render table header
        *
        */
        _renderTableHeadData : function(){
            var htmlHead = "";
            if(Grid.dataSelection.length > 0){
                jQuery.each(Grid.dataSelection[1], function(key, value){
                    for(var i = 0; i < Grid.tableHeadData.length; i++){
                        if(Grid.tableHeadData[i].columnName == key){
                            var sortType = new Object();
                            switch(Grid.tableHeadData[i].sortType){
                                case 'asc':
                                    sortType.symbol = ' <i class="fa fa-fw fa-sort-alpha-asc grid-column-sort" data-sortDirection="asc"></i>';
                                    break;

                                case 'desc':
                                    sortType.symbol = ' <i class="fa fa-fw fa-sort-alpha-desc grid-column-sort" data-sortDirection="desc"></i>';
                                    break;

                                default:
                                    sortType.symbol = ' <i class="fa fa-fw fa-sort grid-column-sort" data-sortDirection="none"></i>';
                                    break;
                            }
                            htmlHead = htmlHead + '<th><span class="grid-column-header" data-columnName="' + Grid.tableHeadData[i].columnName + '">' + Grid.tableHeadData[i].displayName + '</span>' + sortType.symbol + '</th>';
                        }
                    }
                });
            }

            return htmlHead;
        },

        /*
        *   render table body
        *
        */
        _renderTableBodyData : function(){
            var htmlBody = "";
            for(var i = 0; i < Grid.dataSelection.length; i++){
                htmlBody = htmlBody + '<tr>';
                jQuery.each(Grid.dataSelection[i], function(key, value){
                    if(value instanceof Object){
                        value = value.date;
                    }
                    htmlBody = htmlBody + '<td>' + value + '</td>';
                });
                htmlBody = htmlBody + '</tr>';
            }

            return htmlBody;
        },

        /*
        *
        *
        */
        //sort json-array by field-identifier
        _sortBy : function(field, direction, primer){
            var reverse = false;
            if(direction == "asc"){
                reverse = true;
            }

            var key = function (x) {return primer ? primer(x[field]) : x[field]};

            return function (a,b) {
                var A = key(a), B = key(b);
                if(A instanceof Object && B instanceof Object){
                    return ( (A.date < B.date) ? -1 : ((A.date > B.date) ? 1 : 0) ) * [-1,1][+!!reverse];
                } else {
                    return ( (A < B) ? -1 : ((A > B) ? 1 : 0) ) * [-1,1][+!!reverse];
                }
            }
        },

        _sortData : function(){
            if(Grid.sortDirection != 'none'){
                Grid.dataSelection.sort(Grid._sortBy(Grid.tableHeadData[Grid.sortColumn].columnName, Grid.sortDirection, undefined));
            } else {
                Grid.dataSelection.sort(Grid._sortBy(Grid.tableHeadData[0].columnName, Grid.sortDirection, undefined));
            }
        },

        _clearBrowserSelection : function(){
            if(document.selection && document.selection.empty) {
                document.selection.empty();
            } else if(window.getSelection) {
                var sel = window.getSelection();
                sel.removeAllRanges();
            }
        },

        /*
        *   throw error messages
        *   001 - neccessary initialization data not given (element for building table in not given)
        *
        *   999 - error message for testing
        */
        _throwErrorMessage : function(errorCode){
            var alertMessage = false;
            switch(errorCode){
                case '001':
                    alertMessage = true;
                    errorCode = 'No parent element given. I don\'t know where to build my table :-(';

                case '999':
                    errorCode = 'Just a test message for an error.';
                default:
                    errorCode = errorCode;
                    break;
            }

            if(alertMessage){
                alert(errorCode);
            } else {
                var html = '<div class="panel panel-danger"><div class="panel-heading"><strong>Error</strong></div><div class="panel-body">' + errorCode + '</div></div>';
                Grid.parent.html(html);
            }
        },

        /*
        *   initialize events used in the grid
        *
        */
        _initializeEvents : function(){
            //table head column click (change sort direction - tri state)
            Grid.parent.off('click', '.grid-column-sort').on('click', '.grid-column-sort', function(){
                var sortDirection = $(this).attr('data-sortDirection');
                var newSortDirection = 'none'
                var columnName = $(this).parent('th').find('.grid-column-header').attr('data-columnName');
                switch(sortDirection){
                    case 'asc':
                        newSortDirection = 'desc';
                        break;
                    case 'desc':
                        newSortDirection = 'asc';
                        break;
                    default:
                        newSortDirection = 'asc';
                        break;
                }

                for(var i = 0; i < Grid.tableHeadData.length; i++){
                    if(Grid.tableHeadData[i].columnName == columnName){
                        Grid.tableHeadData[i].sortType = newSortDirection;
                        Grid.sortColumn = i;
                        Grid.sortDirection = newSortDirection;
                    } else {
                        Grid.tableHeadData[i].sortType = 'none';
                    }
                }

                Grid._sortData();
                Grid._renderData();
            });
            //table head column double click
            Grid.parent.off('dblclick', '.grid-column-header').on('dblclick', '.grid-column-header', function(){
                Grid._clearBrowserSelection();

                var columnName = $(this).attr('data-columnName');

                alert(columnName);
            });
            //refresh complete grid by new initialization
            Grid.parent.off('click', '.grid-option-refresh').on('click', '.grid-option-refresh', function(){
                Grid.Initialize(Grid.parent, Grid.tableHeadConversionArray);
            });
            //open dialog to hide or show columns
            Grid.parent.off('click', '.grip-option-hideShowColumn').on('click', '.grip-option-hideShowColumn', function(){
                alert('available soon');
            });
        }
    }
});