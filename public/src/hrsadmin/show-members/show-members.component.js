(function () {
"use strict";

angular.module('HadminApp')
.component('showMembers', {
  templateUrl: 'src/hrsadmin/show-members/show-members.html',
  controller: showMComponentController,
  bindings: {
    list:           '<',
    gotMemberid:    '&'
  }
});


showMComponentController.$inject = ['$scope', '$element']
function showMComponentController($scope, $element) {
  var $ctrl = this;
  var the_date = new Date();
  $ctrl.year = the_date.getYear()+1900;
  $ctrl.gotId = function (idindex) {
    $ctrl.gotMemberid({ index: $ctrl.list[idindex].id});
  };


}

})();
