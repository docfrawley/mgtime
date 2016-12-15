(function () {
"use strict";

angular.module('common')
.service('MemberService', MemberService)
.constant('ApiPath', 'http://localhost:8888/mgtime/public/');


MemberService.$inject = ['$http', 'ApiPath'];
function MemberService($http, ApiPath) {
  var service = this;


  service.updateLogin = function(uname, pword, email) {
    var response = $http({
      method: "POST",
      url: (ApiPath +"registerajaxfiles.php"),
      data: {
        uname:  uname,
        pword:  pword,
        email:  email
      }
    });
    return response;
  };

  service.getInfo = function() {
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task: 'getinfo'
      }
    });
    return response;
  };


}



})();
