(function () {
"use strict";

angular.module('HadminApp')
.component('modalEdit', {
  templateUrl: 'src/hrsadmin/modal-edit/modal-edit.html',
  controller: modaleditComponentController,
  bindings: {
    list:       '<',
    madeUpdates:'<',
    makeUpdate: '&'
  }
});

modaleditComponentController.$inject = ['$scope', '$element']
function modaleditComponentController($scope, $element) {
  var $ctrl = this;
  $ctrl.items = $ctrl.list;
  console.log("starting: ", $ctrl.items);
  $ctrl.doUpdate = function() {
    console.log("now: ", $ctrl.items);
    $ctrl.makeUpdate({ index: $ctrl.items });
    $ctrl.list.hdate = $ctrl.items.hdate;
  };

}

})();
