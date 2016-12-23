(function () {
"use strict";

angular.module('common')
.service('MemadminService', MemadminService)
.constant('ApiPath', 'http://localhost:8888/mgtime/public/ajax/');


MemadminService.$inject = ['$http', 'ApiPath'];
function MemadminService($http, ApiPath) {
  var service = this;

  service.lookMember = function(lname){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'lookupMem',
        lname:   lname
      }
    });
    return response;
  };

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

  service.getFList = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'flist'
      }
    });
    return response;
  };

  service.getHList = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'hlist'
      }
    });
    return response;
  };

  service.getInitialInfo = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'initial_info'
      }
    });
    return response;
  };

  service.addMember = function(fname, lname, aclass, mgstatus, adstatus) {
    var response = $http({
      method: "POST",
      url: (ApiPath +"addmember.php"),
      data: {
        fname:    fname,
        lname:    lname,
        aclass:   aclass,
        mgstatus: mgstatus,
        adstatus: adstatus
      }
    });
    return response;
  };

  service.editMember = function(id, aclass, mgstatus, adstatus) {
    var response = $http({
      method: "POST",
      url: (ApiPath +"editmember.php"),
      data: {
        id:       id,
        aclass:   aclass,
        mgstatus: mgstatus,
        adstatus: adstatus
      }
    });
    return response;
  };

}



})();
