(function () {
"use strict";

angular.module('HadminApp')
.component('searchMember', {
  templateUrl: 'src/hrsadmin/search-member/search-member.html',
  controller: searchComponentController,
  bindings: {
    gotMemberid:    '&'
  }
});


searchComponentController.$inject = ['MemadminService', '$scope', '$element']
function searchComponentController(MemadminService, $scope, $element) {
  var $ctrl = this;
  $ctrl.id = 0;
  $ctrl.search_lname = "";
  $ctrl.not_multiple = true;
  $ctrl.did_search = false;
  $ctrl.search_items = [];
  $ctrl.found = false;

  $ctrl.goLook = function(){
    MemadminService.lookMember($ctrl.search_lname)
      .then(function (response){
        $ctrl.search_items = response.data;
        $ctrl.did_search = true;
        if ($ctrl.search_items.length == 0){
          $ctrl.found = false;
        } else if ($ctrl.search_items.length>1) {
          $ctrl.found_list = response.data;
          $ctrl.found=true;
          $ctrl.not_multiple = false;
        } else {
          $ctrl.found_list = response.data;
          $ctrl.did_search = false;
          $ctrl.not_multiple = true;
          $ctrl.search_lname = "";
          $ctrl.gotId(0);
          // $ctrl.id = response.data[0].id;
        }

      })
      .catch(function (error) {
        console.log(error);
      });
  };
  $ctrl.gotId = function (idindex) {
    $ctrl.did_search = false;
    $ctrl.not_multiple = true;
    $ctrl.search_lname = "";
    $ctrl.gotMemberid({ index: $ctrl.found_list[idindex].id});
  };


}

})();
