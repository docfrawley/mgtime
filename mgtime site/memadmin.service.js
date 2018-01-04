(function () {
"use strict";

angular.module('common')
.service('MemadminService', MemadminService)
.constant('ApiPath', 'http://mgofmc.org/hours/public/ajax/');


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

  service.deleteMember = function(memberid){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'deleteMem',
        memberid:  memberid
      }
    });
    return response;
  };

  service.getList = function(filter, filterwhich, page){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'memlist',
        filter:       filter,
        filterwhich:  filterwhich,
        page:         page
      }
    });
    return response;
  };

  service.getLast = function(filter, filterwhich){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:   'getLast',
        filter:       filter,
        filterwhich:  filterwhich
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

  service.addMember = function(fname, lname, aclass, mgstatus, adstatus,
                              street, town, state, zip, hphone, cphone, preferred) {
    var response = $http({
      method: "POST",
      url: (ApiPath +"addmember.php"),
      data: {
        fname:    fname,
        lname:    lname,
        aclass:   aclass,
        mgstatus: mgstatus,
        adstatus: adstatus,
        street:   street,
        town:     town,
        state:    state,
        zip:      zip,
        hphone:   hphone,
        cphone:   cphone,
        preferred:  preferred
      }
    });
    return response;
  };

  service.changeToActive =  function(checkedArray){
    var response = $http({
      method: "POST",
      url: (ApiPath +"makeActive.php"),
      data: {
        group:  checkedArray
      }
    });
    return response;
  };

  service.editMember = function(values) {
    var response = $http({
      method: "POST",
      url: (ApiPath +"editmember.php"),
      data: {
        values: values
      }
    });
    return response;
  };

}



})();
