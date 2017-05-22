(function () {
'use strict';

angular.module('HadminApp')
.controller('HrsreportController', HrsreportController);

HrsreportController.$inject=['HrsadminService', 'list'];
function HrsreportController(HrsadminService, list) {
  var hrctrl=this;

  hrctrl.active = "nclist";  //mlist, slist, rdlist
  hrctrl.milestone = 'l100';
  hrctrl.list = list.data.reportArray;
  hrctrl.page = 1;
  hrctrl.show = true;
  hrctrl.last = list.data.last;

  hrctrl.changeRange = function(index){
    hrctrl.milestone = index;
    console.log("range: ", hrctrl.milestone);
    hrctrl.changeB('mlist');
  }

  hrctrl.changeB = function(towhat){
    hrctrl.show = false;
    if (hrctrl.active != towhat){
      hrctrl.page = 1;
      hrctrl.active = towhat;
    }
    if (hrctrl.active == 'mlist'){
      hrctrl.page = hrctrl.milestone;
    }
    HrsadminService.rList(hrctrl.active, hrctrl.page)
      .then(function (response){
        if (hrctrl.active != 'mlist') {
          hrctrl.list = response.data.reportArray;
          hrctrl.last = response.data.last;
        } else {
          hrctrl.list = response.data;
          hrctrl.last = hrctrl.page;
        }
        console.log("report:", hrctrl.list);
        hrctrl.show= true;
      })
      .catch(function (error) {
        console.log(error);
      });
  }

}

})();
