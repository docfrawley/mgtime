(function () {
"use strict";

angular.module('HadminApp')
.component('modalDelete', {
  templateUrl: 'src/hrsadmin/modal-delete/modal-delete.html',
  controller: dComponentController,
  bindings: {
    makeDelete: '&',
    madeDelete: '<'
  }
});

dComponentController.$inject = ['$scope', '$element']
function dComponentController($scope, $element) {
  var $ctrl = this;
  $ctrl.chdescription = "";
  $ctrl.doDelete = function() {
    $ctrl.makeDelete({ index: $ctrl.chdescription });
  };
}

})();
