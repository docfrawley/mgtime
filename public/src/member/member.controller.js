(function () {
'use strict';

angular.module('MemberApp')
.controller('MemberController',MemberController)
.directive('pwCheck', [function () {
    return {
      require: 'ngModel',
      link: function (scope, elem, attrs, ctrl) {
        var firstPassword = '#' + attrs.pwCheck;
        elem.add(firstPassword).on('keyup', function () {
          scope.$apply(function () {
            var v = elem.val()===$(firstPassword).val();
            ctrl.$setValidity('pwmatch', v);
          });
        });
      }
    }
  }]);

MemberController.$inject=['MemberService', 'info'];
function MemberController(MemberService, info) {
  var mctrl=this;
  mctrl.items = info.data;
   mctrl.username = mctrl.items.username;
   mctrl.password = mctrl.items.password;
   mctrl.password2 = mctrl.password;
   mctrl.cpassword = "";
   mctrl.email = mctrl.items.email;
   mctrl.updated = false;
   mctrl.triedUpdate = false;


  mctrl.submit = function () {
      MemberService.updateLogin(mctrl.username, mctrl.password, mctrl.email)
          .then(function (response) {
            mctrl.updated = response.data.success;
            mctrl.triedUpdate = true;
          })
          .catch(function (error) {
            console.log(error);
          });
    };
}

})();
