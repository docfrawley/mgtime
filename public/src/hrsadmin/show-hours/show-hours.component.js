(function () {
"use strict";

angular.module('HadminApp')
.component('showHours', {
  templateUrl: 'src/hrsadmin/show-hours/show-hours.html',
  bindings: {
    list:          '<'
  }
});

})();
