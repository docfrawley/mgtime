(function () {
"use strict";

angular.module('HadminApp')
.component('pageTurn', {
  templateUrl: 'src/hrsadmin/page-turn/page-turn.html',
  controller: pageturnComponentController,
  bindings: {
    range:      '<',
    firstPage:     '&',
    newPage:       '&',
    decreasePage:  '&',
    increasePage:  '&',
    lastPage:      '&',
    optionPage:    '&'
  }
});


pageturnComponentController.$inject = ['$scope', '$element']
function pageturnComponentController($scope, $element) {
  var $ctrl = this;
  $ctrl.page = 1;

  $ctrl.opPage = function () {
    $ctrl.optionPage({ index: $ctrl.page });
  };


}

})();
