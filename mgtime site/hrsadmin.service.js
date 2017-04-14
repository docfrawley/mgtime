(function () {
"use strict";

angular.module('common')
.service('HrsadminService', HrsadminService)
.constant('ApiPath', 'http://mgofmc.org/hours/public/ajax/');


HrsadminService.$inject = ['$http', 'ApiPath'];
function HrsadminService($http, ApiPath) {
  var service = this;

  service.getStatus = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task: 'get_status'
      }
    });
    return response;
  };

  service.getList = function(filter, filterwhich, page){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'hrsadlist',
        filter:       filter,
        filterwhich:  filterwhich,
        page:         page
      }
    });
    return response;
  };

  service.getRegList = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'hrsReglist'
      }
    });
    return response;
  };

  service.getNonList= function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'hrsNonlist'
      }
    });
    return response;
  };

}



})();
