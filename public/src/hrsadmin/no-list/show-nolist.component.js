(function () {
"use strict";

angular.module('HadminApp')
.component('showNolist', {
  templateUrl: 'src/hrsadmin/no-list/show-nolist.html',
  bindings: {
    list: '<',
    title: '@'
  }
});


})();
