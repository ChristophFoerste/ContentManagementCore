; (function ($, window, document, undefined) {
    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.
    // window and document are passed through as local variable rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).
    // Create the defaults once
    var pluginName = "BootstrapGrid",

    grid = {
        jsonData: null,
        selectionData: null,
        totalRows: 0
    },

    defaults = {
        requestURL: null,
        debug: true,                   //debug status of grid
        parent: undefined,                          //element the grid is build in
        parentRow: undefined,                          //parent row of grid
        data: undefined,                          //complete json data
        dataSelection: undefined,                          //json data selection (e.g. after searching)
        tableHeadConversionArray: undefined,                          //array with column name conversion
        tableHeadData: new Array(),                        //array of available columns with status data of column
        sortColumn: 0,                                  //column to sort
        sortDirection: 'asc',                              //sort direction of column
        isInitialized: true,                               //internal status for some sorting stuff after initialization
        totalRows: 0,                                  //number or rows
        totalPages: 1,                                  //number of pages
        currentPage: 1,                                  //current selected page
        rowsPerPage: 15,                                 //number of datasets per page
        rowsArray: new Array(15, 25, 50, 100)          //list of available datasets per page
    };

    // The actual plugin constructor
    function Plugin(element, options) {
        this.element = element;
        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
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
            alert(this.settings.requestURL);
            $.ajax({
                url:        this.settings.requestURL,
                type:       'GET',
                cache:      false,
                beforeSend: function () {
                                Application.Loader.Show();
                            },
                success:    function (data) {
                                this._grid.jsonData = jQuery.parseJSON(data);
                                if (typeof this._grid.jsonData == 'object') {
                                    this._grid.selectionData = this._grid.jsonData;
                                    this._grid.totalRows = this._grid.selectionData.length;                        
                                } else {
                                    alert('shit happens');
                                }
                                Application.Loader.Hide();
                            },
                error:      function (data) {
                                if (this.settings.debug) {
                                    console.log(data);
                                }
                                Application.Loader.Hide();
                            }
            });
        },

        yourOtherFunction: function () {
            // some logic
        }
    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function (options) {
        this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
        // chain jQuery functions
        return this;
    };
})(jQuery, window, document);