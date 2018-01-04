(function () {
'use strict';

angular.module('HoursApp')
.config(RoutesConfig);

RoutesConfig.$inject = ['$stateProvider', '$urlRouterProvider'];
function RoutesConfig($stateProvider, $urlRouterProvider) {

  // Redirect to home page if no other URL matches
  $urlRouterProvider.otherwise('/');

  // *** Set up UI states ***
  $stateProvider

  // Home page
  .state('home', {
    url: '/',
    controller: 'HoursController',
    controllerAs: 'hctrl',
    templateUrl: 'src/hours/hours.html',
    resolve: {
      pages: ['HoursService',function (HoursService) {
        return HoursService.getHoursPages();
      }],
      items: ['HoursService',function (HoursService) {
        return HoursService.getHoursInfo(1);
      }],
      totals: ['HoursService',function (HoursService) {
        return HoursService.getHourTotals();
      }],
      mgstatus: ['HoursService',function (HoursService) {
        return HoursService.getStatus();
      }],
      ototals: ['HoursService',function (HoursService) {
        return HoursService.getOveralTotals();
      }]
    }

  });

}

})();
