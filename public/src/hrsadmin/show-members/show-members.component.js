(function () {
"use strict";

angular.module('HadminApp')
.component('showMembers', {
  templateUrl: 'src/hrsadmin/show-members/show-members.html',
  controller: showMComponentController,
  bindings: {
    list:           '<',
    gotMemberid:    '&',
    year:           '<'
  }
});


showMComponentController.$inject = ['$scope', '$element']
function showMComponentController($scope, $element) {
  var $ctrl = this;

    $ctrl.gotId = function (idindex) {
    $ctrl.gotMemberid({ index: $ctrl.list[idindex].id});
  };


}

})();
