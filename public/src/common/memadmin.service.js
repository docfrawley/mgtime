(function () {
"use strict";

angular.module('common')
.service('MembadminService', MembadminService)
.constant('ApiPath', 'http://localhost:8888/mgtime/public/ajax/');


MembadminService.$inject = ['$http', 'ApiPath'];
function MembadminService($http, ApiPath) {
  var service = this;

  service.getList = function(page){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'memlist',
        page:   page
      }
    });
    return response;
  };

  service.getInitialInfo = function(page){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'initial_info'
      }
    });
    return response;
  };


}



})();
