(function () {
"use strict";

angular.module('HoursApp')
.component('modalExplain', {
  templateUrl: 'src/hours/modal-explain/modal-explain.html',
  bindings: {
    now:        '<',
    changes:    '<'
  }
});

})();
