(function () {
'use strict';

angular.module('HadminApp')
.controller('HrsreportController', HrsreportController);

HrsreportController.$inject=['HrsadminService', 'list'];
function HrsreportController(HrsadminService, list) {
  var hrctrl=this;

  hrctrl.active = "nclist";  //mlist, slist, rdlist
  hrctrl.milestone = 'l100';
  hrctrl.deficient = 'A - Trainee'
  hrctrl.list = list.data.reportArray;
  hrctrl.page = 1;
  hrctrl.show = true;
  hrctrl.last = list.data.last;

  hrctrl.changeRange = function(index){
    if (hrctrl.active=='mlist'){
      hrctrl.milestone = index;
      hrctrl.changeB('mlist');
    } else {
      hrctrl.deficient = index;
      hrctrl.changeB('rdlist');
    }
  }

  hrctrl.changeB = function(towhat){
    hrctrl.show = false;
    if (hrctrl.active != towhat){
      hrctrl.page = 1;
      hrctrl.active = towhat;
    }
    if (hrctrl.active == 'mlist'){
      hrctrl.page = hrctrl.milestone;
    } else if (hrctrl.active == 'rdlist') {
      hrctrl.page = hrctrl.deficient;
    }
    HrsadminService.rList(hrctrl.active, hrctrl.page)
      .then(function (response){
        if (hrctrl.active != 'mlist' && hrctrl.active != 'rdlist') {
          hrctrl.list = response.data.reportArray;
          hrctrl.last = response.data.last;
        } else {
          hrctrl.list = response.data;
          console.log(hrctrl.list);
          hrctrl.last = hrctrl.page;
        }
        hrctrl.show= true;
      })
      .catch(function (error) {
        console.log(error);
      });
  }

}

})();
