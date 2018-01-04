(function () {
'use strict';

angular.module('HadminApp')
.config(RoutesConfig);

RoutesConfig.$inject = ['$stateProvider', '$urlRouterProvider'];
function RoutesConfig($stateProvider, $urlRouterProvider) {

  // Redirect to home page if no other URL matches
  $urlRouterProvider.otherwise('/');

  // *** Set up UI states ***
  $stateProvider
  .state('home', {
    url: '/',
    controller: 'HrsadminController',
    controllerAs: 'hactrl',
    templateUrl: 'src/hrsadmin/hoursadmin.php',
    resolve: {
      list: ['HrsadminService',function (HrsadminService) {
        return HrsadminService.getList('full', 'full', 1);
      }],
      rlist: ['HrsadminService',function (HrsadminService) {
        return HrsadminService.getRegList();
      }],
      nonlist: ['HrsadminService',function (HrsadminService) {
        return HrsadminService.getNonList();
      }]
    }
  })
  .state('reports', {
    url: '/reports',
    controller: 'HrsreportController',
    controllerAs: 'hrctrl',
    templateUrl: 'src/hrsadmin/hoursreport.html',
    resolve: {
      list: ['HrsadminService',function (HrsadminService) {
        return HrsadminService.rList('nclist', 1, 2000);
      }]
    }
  })
  .state('memhours', {
    url: '/memhours',
    controller: 'HrsmemController',
    controllerAs: 'hmctrl',
    templateUrl: 'src/hrsadmin/memhours.html',
    resolve: {
      list: ['HrsadminService',function (HrsadminService) {
        return HrsadminService.getmList('full', 'full', 1, 2000);
      }],
      info: ['MemadminService',function (MemadminService) {
        return MemadminService.getInitialInfo();
      }]
    }
  });


}

})();
