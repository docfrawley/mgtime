(function() {
'use strict'

angular.module('LoginApp')
.controller('RegisterController',RegisterController)
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

RegisterController.$inject=['LoginService', '$window'];
function RegisterController(LoginService, $window) {
  var regctrl=this;

  regctrl.memberId = 0;
  regctrl.fname = "";
  regctrl.lname = "";
  regctrl.class = "";
  regctrl.nonMember = true;
  regctrl.triedRegister = false;
  regctrl.alreadyRegistered = false;
  regctrl.notUnique = false;

  regctrl.username = "";
  regctrl.password = "";
  regctrl.email = "";

  regctrl.failedLogin=false;
  regctrl.forgot = false;
  regctrl.aboutToEmail = false;
  regctrl.wasSent = false;
  regctrl.triedEmail = false;

  regctrl.submit = function () {
      LoginService.startRegistration(regctrl.fname, regctrl.lname, regctrl.class)
          .then(function (response) {
            var items = response.data;
            regctrl.memberId = items.id;
            if (regctrl.memberId>0){
              regctrl.nonMember = false;
            } else if (regctrl.memberId<0) {
              regctrl.alreadyRegistered = true;
            }
            regctrl.triedRegister = true;
          })
          .catch(function (error) {
            console.log(error);
          });
    };

    regctrl.rsubmit = function () {
        LoginService.processRegistration(regctrl.username, regctrl.password, regctrl.email)
            .then(function (response) {
              if (response.data['success']){
                window.location.href = 'member.php';
              } else {
                regctrl.notUnique = true;
              }
            })
            .catch(function (error) {
              console.log(error);
            });
      };

      regctrl.goLogin = function () {
        window.location.href = 'index.php';
      };

      regctrl.lsubmit = function () {
          LoginService.loginUser(regctrl.username, regctrl.password)
              .then(function (response) {
                var items = response.data;
                regctrl.memberId = items.id;
                if (regctrl.memberId>0){
                  window.location.href = 'hours.php';
                } else {
                  regctrl.failedLogin = true;
                }
              })
              .catch(function (error) {
                console.log(error);
              });
        };

        regctrl.forgotup = function (){
          regctrl.forgot=!regctrl.forgot;
          regctrl.aboutToEmail = !regctrl.aboutToEmail;
        };


        regctrl.esubmit = function (){
          LoginService.sendEmail(regctrl.remail)
              .then(function (response) {
                regctrl.wasSent = response.data.success;
                regctrl.triedEmail = true;
                if (regctrl.wasSent){
                  regctrl.forgot=!regctrl.forgot;
                  regctrl.aboutToEmail = !regctrl.aboutToEmail;
                }
              })
              .catch(function (error) {
                console.log(error);
              });
        };
}

})();
