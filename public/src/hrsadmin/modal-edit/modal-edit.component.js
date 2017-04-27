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
  $ctrl.items.chdescription= "";
  $ctrl.doUpdate = function() {
    $ctrl.makeUpdate({ index: $ctrl.items });
    // $ctrl.list.hdate = $ctrl.items.hdate;
    // $ctrl.list.numid = $ctrl.items.numid;
  };

}

})();
