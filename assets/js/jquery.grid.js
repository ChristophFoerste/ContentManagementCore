; (function ($, window, document, undefined) {
    var pluginName = "BootstrapGrid",

    grid = {
        jsonData: null,                                 //received json-data for grid (complete list)
        selectionData: null,                            //temporary filtered list (subset of jsonData)
        totalRows: 0                                    //number of total rows (based on selectionData)  
    };

    defaults = {
        requestURL: null,
        debug: true,                                    //debug status of grid
        parent: undefined,                              //element the grid is build in
        parentRow: undefined,                           //parent row of grid
        data: undefined,                                //complete json data
        dataSelection: undefined,                       //json data selection (e.g. after searching)
        tableHeadConversionArray: undefined,            //array with column name conversion
        tableHeadData: new Array(),                     //array of available columns with status data of column
        sortColumn: 0,                                  //column to sort
        sortDirection: 'asc',                           //sort direction of column
        isInitialized: true,                            //internal status for some sorting stuff after initialization
        totalRows: 0,                                   //number or rows
        totalPages: 1,                                  //number of pages
        currentPage: 1,                                 //current selected page
        rowsPerPage: 15,                                //number of datasets per page
        rowsArray: new Array(15, 25, 50, 100)           //list of available datasets per page
    };

    // The actual plugin constructor
    function Plugin(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._grid = grid;
        this._name = pluginName;
        this.init();
    }

    // Avoid Plugin.prototype conflicts
    $.extend(Plugin.prototype, {
        init: function () {
            this.requestJsonData();

            return this;
        },

        requestJsonData: function () {
            plugin = this;
            $.ajax({
                url:        this.settings.requestURL,
                type:       'GET',
                cache:      false,
                beforeSend: function () {
                                Application.Loader.Show();
                            },
                success:    function (data) {
                                plugin._grid.jsonData = jQuery.parseJSON(data);
                                if (typeof plugin._grid.jsonData == 'object') {
                                    plugin._grid.selectionData = plugin._grid.jsonData;
                                    plugin._grid.totalRows = plugin._grid.selectionData.length;
                                } else {
                                    alert('shit happens');
                                }
                                Application.Loader.Hide();
                            },
                error:      function (data) {
                                if (plugin.settings.debug) {
                                    console.log(data);
                                }
                                Application.Loader.Hide();
                            }
            });

            return this;
        },

        yourOtherFunction: function () {
            // some logic
        }
    });

    // plugin wrapper (prevent multiple instancing)
    $.fn[pluginName] = function (options) {
        this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
        return this;
    };
})(jQuery, window, document);