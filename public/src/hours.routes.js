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
    templateUrl: 'src/hours/hours.php',
    resolve: {
      items: ['HoursService',function (HoursService) {
        return HoursService.getHoursInfo();
      }],
      totals: ['HoursService',function (HoursService) {
        return HoursService.getHourTotals();
      }]
    }

  });

}

})();
