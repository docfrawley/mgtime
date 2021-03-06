(function () {
"use strict";

angular.module('common')
.service('LoginService', LoginService)
.constant('ApiPath', 'http://localhost:8888/mgtime/public/ajax/');


LoginService.$inject = ['$http', 'ApiPath'];
function LoginService($http, ApiPath) {
  var service = this;

  service.startRegistration = function(fname, lname, year) {
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'check',
        fname:  fname,
        lname:  lname,
        year:   year
      }
    });
    return response;
  };

  service.loginUser = function(uname, pword) {
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:  'login',
        uname: uname,
        pword: pword
      }
    });
    return response;
  };

  service.processRegistration = function(uname, pword, email) {
    var response = $http({
      method: "POST",
      url: (ApiPath +"createlogin.php"),
      data: {
        uname: uname,
        pword: pword,
        email: email
      }
    });
    return response;
  };

  service.getMemberId = function(uname, pword) {
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task: 'login',
        uname: uname,
        pword: pword
      }
    });
    return response;
  };

  service.sendUserInfo = function(email) {
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task: 'mail',
        email: email
      }
    });
    return response;
  };

  service.sendEmail = function(remail){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task: 'check_email',
        email: remail
      }
    });
    return response;
  };

}



})();
