(function () {
"use strict";

angular.module('common')
.service('HoursService', HoursService)
.constant('ApiPath', 'http://localhost:8888/mgtime/public/ajax/');


HoursService.$inject = ['$http', 'ApiPath'];
function HoursService($http, ApiPath) {
  var service = this;



  service.enterHours = function(hdate, hrstype, numhrs, description) {
    var response = $http({
      method: "POST",
      url: (ApiPath +"enterhrs.php"),
      data: {
        hdate:        hdate,
        hrstype:      hrstype,
        numhrs:       numhrs,
        description:  description
      }
    });
    return response;
  };

  service.updateHours = function(info) {
    var response = $http({
      method: "POST",
      url: (ApiPath +"updatehrs.php"),
      data: {
        hdate:        info.hdate,
        hrstype:      info.hrstype,
        numhrs:       info.numhrs,
        description:  info.description,
        numid:        info.numid
      }
    });
    return response;
  };

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

  service.getHoursInfo = function() {
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task: 'hours_info'
      }
    });
    return response;
  };

  service.deleteHrs = function(numid) {
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task: 'deletehrs',
        numid: numid
      }
    });
    return response;
  };

  service.getHourTotals = function() {
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task: 'hours_totals'
      }
    });
    return response;
  };

  service.getHourTotalsYear = function(year) {
    var response = $http({
      method: "GET",
      url: (ApiPath +"loginajaxfiles.php"),
      params: {
        task: 'hours_totals_year',
        year: year
      }
    });
    return response;
  };


}



})();
