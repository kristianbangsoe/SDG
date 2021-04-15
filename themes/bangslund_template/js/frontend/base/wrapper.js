// This closure function makes the $-sign an alias for jQuery (noConflict)
(function($) {

// Defining a global object for the javascript functions
// By defining all our functions to this global object, we can access all functions in any function or file.
    window.projectFunctions = window.projectFunctions || {};

<%= contents %>

})(jQuery);