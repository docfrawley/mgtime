(function () {
"use strict";

angular.module('HadminApp')
.component('showTotals', {
  templateUrl: 'src/hrsadmin/show-totals/show-totals.html',
  bindings: {
    list:  '<',
  }
});

})();
