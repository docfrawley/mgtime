(function () {
"use strict";

angular.module('common')
.service('MemberService', MemberService)
.constant('ApiPath', 'http://mgofmc.org/hours/public/ajax/');


MemberService.$inject = ['$http', 'ApiPath'];
function MemberService($http, ApiPath) {
  var service = this;


  service.updateLogin = function(uname, pword, email, street, town, state, zip,
                                  hphone, cphone, preferred) {
    var response = $http({
      method: "POST",
      url: (ApiPath +"registerajaxfiles.php"),
      data: {
        uname:  uname,
        pword:  pword,
        email:  email,
        street: street,
        town:   town,
        state:  state,
        zip:    zip,
        hphone: hphone,
        cphone: cphone,
        preferred:  preferred
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
