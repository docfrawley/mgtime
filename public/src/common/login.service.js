(function () {
"use strict";

angular.module('common')
.service('LoginService', LoginService);


LoginService.$inject = ['$http', 'ApiPath'];
function LoginService($http, ApiPath) {
  var service = this;

  service.getCategories = function () {
    return $http.get(ApiPath + '/categories.json').then(function (response) {
      return response.data;
    });
  };

  service.setInfo = function (info){
    service.member = {
      fname: info.fname,
      lname: info.lname,
      email: info.email,
      phone: info.phone,
      item_name: info.item_name,
      item_desc: info.item_desc,
      item_img:  ApiPath+"/images/"+info.item_img+".jpeg",
      item_short: info.item_img
    }
  };

  service.showInfo = function (){
    return service.member;
  };

  service.getMenuItems = function (category) {
    var config = {};
    if (category) {
      config.params = {'category': category};
    }

    return $http.get(ApiPath + '/menu_items.json', config).then(function (response) {
      return response.data;
    });
  };

  service.getFavItem = function (ShortName) {
    var response = $http({
      method: "GET",
      url: (ApiPath+"/menu_items/"+ShortName+".json")
    });
    return response;
  };

}



})();
