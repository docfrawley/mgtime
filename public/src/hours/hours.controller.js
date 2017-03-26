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
   console.log("here", hctrl.ototals);
   hctrl.months = ['January', 'February', 'March', 'April', 'May', 'June',
                  'July', 'August', 'September', 'October', 'November',
                  'December'];
   hctrl.mgstatus = mgstatus.data.mgstatus;
   hctrl.initstatus = mgstatus.data.mgstatus;
   hctrl.aitems = [];
   hctrl.aitems.hdate = "";
   hctrl.aitems.hrstype = "";
   hctrl.aitems.numhrs = null;
   hctrl.aitems.description = "";
   hctrl.entered = false;
   hctrl.addhrs = true;
   hctrl.edited = false;
   hctrl.deleted = false;
  //  hctrl.ishelpline = false;
   hctrl.pastLimit = false;
   hctrl.dateGone = false;
   hctrl.congrats = false;
   hctrl.previousYear = false;
   hctrl.showlast = false;
   hctrl.litems = [];


  hctrl.submit = function (hrsForm) {
      HoursService.enterHours(hctrl.aitems)
          .then(function (response) {
            hctrl.entered = response.data.success;
            console.log('first result: ', hctrl.entered);
            if (hctrl.entered){
              hctrl.litems.hdate = hctrl.aitems.hdate;
              hctrl.litems.hrstype = hctrl.aitems.hrstype;
              hctrl.litems.numhrs = hctrl.aitems.numhrs;
              hctrl.litems.description = hctrl.aitems.description;
              hctrl.aitems.hdate = "";
              hctrl.aitems.hrstype = "";
              hctrl.aitems.numhrs = null;
              hctrl.aitems.description = "";
              hctrl.dateGone = false;
              hrsForm.$setUntouched();
              hctrl.showlast = true;
            } else {
              hctrl.dateGone = true;
              hctrl.previousYear = response.data.previousYear;
              console.log('result: ', hctrl.previousYear);
            }
          }).then(function (response) {
            HoursService.getNumid(hctrl.litems)
            .then(function (response) {
            hctrl.litems.numid = response.data.numid;
            console.log("array: ", response.data);
          });
          })
          .then(function (response) {
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
          });
          })
          .catch(function (error) {
            console.log(error);
          });
    };

  hctrl.gomodul = function (index)  {
    hctrl.pastLimit = false;
    var dLimit = new Date();
    dLimit.setDate(dLimit.getDate() - 91);
    var thisDate = new Date(hctrl.items[index]['hdate']);
    if (thisDate >= dLimit){
      hctrl.addhrs = false;
      hctrl.edItems = hctrl.items[index];
    } else {
      hctrl.pastLimit = true;
    }
  };

  hctrl.gomodulL = function ()  {
    hctrl.pastLimit = false;
    var dLimit = new Date();
    dLimit.setDate(dLimit.getDate() - 91);
    var thisDate = new Date(hctrl.items[index]['hdate']);
    if (thisDate >= dLimit){
      hctrl.addhrs = false;
      hctrl.edItems = hctrl.litems;
    } else {
      hctrl.pastLimit = true;
    }
  };

  hctrl.backToAdd = function () {
    hctrl.addhrs = true;
    hctrl.edited = false;
    hctrl.deleted = false;
    hctrl.entered = false;
    hctrl.previousYear = false;
    hctrl.dateGone = false;
    hctrl.pastLimit = false;
  };


  hctrl.hedit = function () {
      HoursService.updateHours(hctrl.edItems)
          .then(function (response) {
            hctrl.edited = response.data.success;
            if (hctrl.edited){
            hctrl.litems = hctrl.edItems;
            hctrl.addhrs = true;
            hctrl.entered = false;
            hctrl.deleted = false;
            hctrl.dateGone = false;
            hctrl.showlast = true;
            hctrl.litems = hctrl.edItems;
          } else {
            hctrl.dateGone = true;
          }
        }).then(function (response) {
            HoursService.getNumid(hctrl.litems)
            .then(function (response) {
            hctrl.litems.numid = response.data.numid;
            console.log("array: ", response.data);
          });
          })
          .then(function (response) {
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
              hctrl.showlast = false;
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
            });
            })
            .catch(function (error) {
              console.log(error);
            });
      };
}

})();
