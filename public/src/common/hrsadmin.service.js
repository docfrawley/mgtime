(function () {
"use strict";

angular.module('common')
.service('HrsadminService', HrsadminService)
.constant('ApiPath', 'http://localhost:8888/mgtime/public/ajax/');


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

  service.getmList = function(filter, filterwhich, page, year){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:         'hrsmlist',
        filter:       filter,
        filterwhich:  filterwhich,
        page:         page,
        year:         year
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

  service.getMemInfo=function(memberID, year){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:     'getMemInfo',
        memberID: memberID,
        year:     year
      }
    });
    return response;
  };

  service.getHList=function(memberID, pageIndex, year){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:     'getHlist',
        memberID: memberID,
        page:     pageIndex,
        year:     year
      }
    });
    return response;
  };

  service.makeUpdates=function(items){
    var response = $http({
      method: "POST",
      url: (ApiPath +"changeHrsAdmin.php"),
      data: {
        numhrs:  items.numhrs,
        hrstype:  items.hrstype,
        description: items.description,
        hrsid:  items.numid,
        chdescription: items.chdescription
      }
    });
    return response;
  };

  service.addHrs=function(memberID, hdate, hrstype, numhrs, description, addDescription){
    var response = $http({
      method: "POST",
      url: (ApiPath +"addHrsAdmin.php"),
      data: {
        id:           memberID,
        hdate:         hdate,
        hrstype:      hrstype,
        numhrs:       numhrs,
        description:  description,
        chdescription: addDescription
      }
    });
    return response;
  };

  service.DeleteEntry=function(whatDelete, chdescription){
    var response = $http({
      method: "POST",
      url: (ApiPath +"deleteHrsAdmin.php"),
      data: {
        hrsid:  whatDelete,
        chdescription: chdescription
      }
    });
    return response;
  };


  // service.UndoInfo=function(memberID, year){
  //   var response = $http({
  //     method: "GET",
  //     url: (ApiPath +"loginajaxfiles.php"),
  //     params: {
  //       task:     'UndoInfo',
  //       memberID: memberID,
  //       year:     year
  //     }
  //   });
  //   return response;
  // };

  service.UndoInfo=function(whatUndo){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:     'getWhatUndo',
        numid:    whatUndo
      }
    });
    return response;
  };

  service.UndoEntry=function(whatUndo){
    var response = $http({
      method: "POST",
      url: (ApiPath +"undoHrsAdmin.php"),
      data: {
        hrsid:  whatUndo
      }
    });
    return response;
  }

  service.rList=function(whichlist, page, year){
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task:     'rlist',
        report:   whichlist,
        page:     page,
        year:     year
      }
    });
    return response;
  };

}



})();
