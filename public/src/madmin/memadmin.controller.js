(function () {
'use strict';

angular.module('MadminApp')
.controller('MemadminController',MemadminController);

MemadminController.$inject=['MemadminService'];
function MemadminController(MemadminService) {
  var mactrl=this;
  // mctrl.items = info.data;
  // console.log("hello", info.data);



  // mctrl.submit = function () {
  //     MemberService.updateLogin(mctrl.username, mctrl.password, mctrl.email)
  //         .then(function (response) {
  //           mctrl.updated = true;
  //         })
  //         .catch(function (error) {
  //           console.log(error);
  //         });
  //   };
}

})();
