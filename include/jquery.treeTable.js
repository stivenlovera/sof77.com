/*
 * jQuery treeTable Plugin VERSION
 * http://ludo.cubicphuse.nl/jquery-plugins/treeTable/doc/
 *
 * Copyright 2011, Ludo van den Boom
 * Dual licensed under the MIT or GPL Version 2 licenses.
 */
(function($) {
  // Helps to make options available to all functions
  // TODO: This gives problems when there are both expandable and non-expandable
  // trees on a page. The options shouldn't be global to all these instances!
  var options;
  var defaultPaddingLeft;
  var persistStore;

  $.fn.treeTable = function(opts) {
    options = $.extend({}, $.fn.treeTable.defaults, opts);

    if(options.persist) {
      persistStore = new Persist.Store(options.persistStoreName);
    }

    return this.each(function() {
      $(this).addClass("treeTable").find("tbody tr").each(function() {
        // Skip initialized nodes.
        if (!$(this).hasClass('initialized')) {
          var isRootNode = ($(this)[0].className.search(options.childPrefix) == -1);

          // To optimize performance of indentation, I retrieve the padding-left
          // value of the first root node. This way I only have to call +css+
          // once.
          if (isRootNode && isNaN(defaultPaddingLeft)) {
            defaultPaddingLeft = parseInt($($(this).children("td")[options.treeColumn]).css('padding-left'), 10);
          }

          // Set child nodes to initial state if we're in expandable mode.
          if(!isRootNode && options.expandable && options.initialState == "collapsed") {
            $(this).addClass('ui-helper-hidden');
          }

          // If we're not in expandable mode, initialize all nodes.
          // If we're in expandable mode, only initialize root nodes.
          if(!options.expandable || isRootNode) {
            initialize($(this));
          }
        }
      });
    });
  };