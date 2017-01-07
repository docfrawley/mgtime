(function() {
'use strict'

angular.module('LoginApp')
.controller('RegisterController',RegisterController);

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

  regctrl.username = "";
  regctrl.password = "";
  regctrl.email = "";

  regctrl.failedLogin=false;

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
                console.log('success');
                window.location.href = 'member.php';
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
                console.log(items.id);
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
}

})();
