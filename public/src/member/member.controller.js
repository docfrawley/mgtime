(function () {
'use strict';

angular.module('MemberApp')
.controller('MemberController',MemberController);

MemberController.$inject=['MemberService', 'info'];
function MemberController(MemberService, info) {
  var mctrl=this;
  mctrl.items = info.data;
  console.log("hello", info.data);
   mctrl.username = mctrl.items.username;
   mctrl.password = mctrl.items.password;
   mctrl.cpassword = "";
   mctrl.email = mctrl.items.email;
   mctrl.updated = false;


  mctrl.submit = function () {
      MemberService.updateLogin(mctrl.username, mctrl.password, mctrl.email)
          .then(function (response) {
            mctrl.updated = true;
          })
          .catch(function (error) {
            console.log(error);
          });
    };
}

})();
