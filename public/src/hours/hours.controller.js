(function () {
'use strict';

angular.module('HoursApp')
.controller('HoursController',HoursController);

HoursController.$inject=['HoursService', 'items', 'totals'];
function HoursController(HoursService, items, totals) {
  var hctrl=this;
   hctrl.items = items.data;
   hctrl.totals = totals.data;
   hctrl.hdate = "";
   hctrl.hrstype = "";
   hctrl.numhrs = 0;
   hctrl.description = "";
   hctrl.entered = false;


  hctrl.submit = function () {
      HoursService.enterHours(hctrl.hdate, hctrl.hrstype, hctrl.numhrs, hctrl.description)
          .then(function (response) {
            hctrl.entered = response.data.success;
            if (hctrl.entered){
              hctrl.hdate = "";
              hctrl.hrstype = "";
              hctrl.numhrs = 0;
              hctrl.description = "";
            }
          }).then(function (response) {
            HoursService.getHoursInfo()
            .then(function (response) {
            hctrl.items = response.data;
          });
          })
          .then(function (response) {
            HoursService.getHourTotals()
            .then(function (response) {
            hctrl.totals = response.data;
          });
          })
          .catch(function (error) {
            console.log(error);
          });
    };
}

})();
