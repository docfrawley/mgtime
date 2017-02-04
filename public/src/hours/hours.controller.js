(function () {
'use strict';

angular.module('HoursApp')
.controller('HoursController',HoursController);

HoursController.$inject=['HoursService', 'items', 'totals', 'mgstatus', 'ototals'];
function HoursController(HoursService, items, totals, mgstatus, ototals) {
  var hctrl=this;
   hctrl.items = items.data;
   hctrl.totals = totals.data;
   hctrl.ototals = ototals.data;

   hctrl.mgstatus = mgstatus.data.mgstatus;
   console.log("status: ", hctrl.mgstatus);
   hctrl.initstatus = mgstatus.data.mgstatus;
   hctrl.hdate = "";
   hctrl.hrstype = "";
   hctrl.numhrs = null;
   hctrl.description = "";
   hctrl.entered = false;
   hctrl.addhrs = true;
   hctrl.edited = false;
   hctrl.deleted = false;
  //  hctrl.ishelpline = false;
   hctrl.dateGone = false;
   hctrl.congrats = false;

  //  hctrl.checkHelpline = function (){
  //    hctrl.ishelpline = (hctrl.hrstype=="Helpline");
  //  };
   //
  //  hctrl.checkHelplineE = function (){
  //    hctrl.ishelpline = (hctrl.edItems.hrstype=="Helpline");
  //  };


  hctrl.submit = function (hrsForm) {
      HoursService.enterHours(hctrl.hdate, hctrl.hrstype, hctrl.numhrs, hctrl.description)
          .then(function (response) {
            hctrl.entered = response.data.success;
            if (hctrl.entered){
              hctrl.hdate = "";
              hctrl.hrstype = "";
              hctrl.numhrs = null;
              hctrl.description = "";
              hctrl.dateGone = false;
              hrsForm.$setUntouched();
            } else {
              hctrl.dateGone = true;
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
          .then(function (response) {
            HoursService.getOveralTotals()
            .then(function (response) {
            hctrl.ototals = response.data;
          });
          })
          .then(function (response) {
            HoursService.getStatus()
            .then(function (response) {
            hctrl.mgstatus = response.data.mgstatus;
            hctrl.congrats=(hctrl.mgstatus == "Active 1000hrs" &&
                hctrl.initstatus=="A");
            console.log("status: ", hctrl.mgstatus);
          });
          })
          .catch(function (error) {
            console.log(error);
          });
    };

  hctrl.gomodul = function (index)  {
    hctrl.addhrs = false;
    hctrl.edItems = hctrl.items[index];
    hctrl.ishelpline = hctrl.edItems.hrstype == "Helpline";
    // hctrl.edItems = [];
    // hctrl.edItems.hdate = hctrl.items[index].hdate;
    // hctrl.edItems.hrstype = hctrl.items[index].hrstype;
    // hctrl.edItems.numhrs = hctrl.items[index].numhrs;
    // hctrl.edItems.description = hctrl.items[index].description;
  };

  hctrl.backToAdd = function () {
    hctrl.addhrs = true;
    hctrl.edited = false;
    hctrl.deleted = false;
    hctrl.entered = false;
    // hctrl.ishelpline = (hctrl.hrstype=="Helpline");
  };


  hctrl.hedit = function () {
      HoursService.updateHours(hctrl.edItems)
          .then(function (response) {
            hctrl.edited = response.data.success;
            if (hctrl.edited){
            hctrl.addhrs = true;
            hctrl.entered = false;
            hctrl.deleted = false;
            hctrl.dateGone = false;
          } else {
            hctrl.dateGone = true;
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
          .then(function (response) {
            HoursService.getOveralTotals()
            .then(function (response) {
            hctrl.ototals = response.data;
          });
          })
          .then(function (response) {
            HoursService.getStatus()
            .then(function (response) {
            hctrl.mgstatus = response.data.mgstatus;
            hctrl.congrats=(hctrl.mgstatus == "Active 1000hrs" &&
                hctrl.initstatus=="A");
            console.log("status: ", hctrl.mgstatus);
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
              hctrl.deleted = true;
              hctrl.edited = false;
              hctrl.entered = false;
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
            .then(function (response) {
              HoursService.getOveralTotals()
              .then(function (response) {
              hctrl.ototals = response.data;
            });
            })
            .then(function (response) {
              HoursService.getStatus()
              .then(function (response) {
              hctrl.mgstatus = response.data.mgstatus;
              console.log("status: ", hctrl.mgstatus);
            });
            })
            .catch(function (error) {
              console.log(error);
            });
      };
}

})();
