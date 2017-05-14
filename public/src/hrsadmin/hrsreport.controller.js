(function () {
'use strict';

angular.module('HadminApp')
.controller('HrsreportController', HrsreportController);

HrsreportController.$inject=['HrsadminService', 'list'];
function HrsreportController(HrsadminService, list) {
  var hrctrl=this;

  hrctrl.active = "nclist";  //mlist, slist, rdlist
  hrctrl.list = list.data.reportArray;
  hrctrl.page = 1;
  hrctrl.show = true;
  hrctrl.last = list.data.last;

  // hrctrl.optionPage=function(index){
  //   hrctrl.page = index;
  //   hrctrl.changeB(hrctrl.active);
  // }

  hrctrl.changeB = function(towhat){
    hrctrl.show = false;
    if (hrctrl.active != towhat){
      hrctrl.page = 1;
      hrctrl.active = towhat;
    }
    console.log("stuff: ", hrctrl.active, hrctrl.page);
    HrsadminService.rList(hrctrl.active, hrctrl.page)
      .then(function (response){
        hrctrl.list = response.data.reportArray;
        hrctrl.last = response.data.last;
        hrctrl.show= true;
      })
      .catch(function (error) {
        console.log(error);
      });
  }

}

})();
