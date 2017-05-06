(function () {
"use strict";

angular.module('HadminApp')
.component('modalUndo', {
  templateUrl: 'src/hrsadmin/modal-undo/modal-undo.html',
  bindings: {
    now:        '<',
    changes:    '<',
    madeUndo:   '<',
    makeUndo:   '&'
  }
});

})();
