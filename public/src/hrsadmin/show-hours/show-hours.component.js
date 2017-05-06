(function () {
"use strict";

angular.module('HadminApp')
.component('showHours', {
  templateUrl: 'src/hrsadmin/show-hours/show-hours.html',
  controller: showhoursComponentController,
  bindings: {
    list:     '<',
    doEdit:   '&',
    doDelete: '&',
    doUndo:   '&'
  }
});

showhoursComponentController.$inject = ['$scope', '$element']
function showhoursComponentController($scope, $element) {
  var $ctrl = this;

  $ctrl.toEd = function(theindex) {
    $ctrl.doEdit({ index: theindex });
  };

  $ctrl.toDelete = function(theindex) {
    $ctrl.doDelete({ index: theindex });
  };

  $ctrl.toUndo = function(theindex) {
    $ctrl.doUndo({ index: theindex });
  };
}

})();
