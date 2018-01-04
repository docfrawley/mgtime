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
   mctrl.street = mctrl.items.street;
   mctrl.town = info.data.town;
   mctrl.state = info.data.state;
   mctrl.zip = info.data.zip;
   mctrl.hphone = info.data.hphone;
   mctrl.cphone = info.data.cphone;
   mctrl.preferred = info.data.preferred;


  mctrl.submit = function () {
      MemberService.updateLogin(mctrl.username, mctrl.password, mctrl.email,
                                mctrl.street, mctrl.town, mctrl.state,
                                mctrl.zip, mctrl.hphone, mctrl.cphone,
                                mctrl.preferred)
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
