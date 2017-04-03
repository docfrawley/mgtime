(function () {
"use strict";

angular.module('HadminApp')
.component('regTotals', {
  templateUrl: 'src/hrsadmin/reg-total/reg-totals.html',
  bindings: {
    categories: '<',
    title: '@'
  }
});


})();
