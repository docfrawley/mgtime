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
   hctrl.addhrs = true;


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

  hctrl.gomodul = function (index)  {
    hctrl.addhrs = false;
    hctrl.edItems = hctrl.items[index];
  };

  hctrl.backtoadd = function () {
    hctrl.addhrs = true;
  };

  hctrl.hedit = function () {
      HoursService.updateHours(hctrl.edItems)
          .then(function (response) {
            hctrl.addhrs = true;
            console.log("rrindex: ", hctrl.edItems);
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

    hctrl.hdelete = function () {
        HoursService.deleteHrs(hctrl.edItems.numid)
            .then(function (response) {
              hctrl.addhrs = true;
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
