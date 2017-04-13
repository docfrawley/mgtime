(function () {
'use strict';

angular.module('HadminApp')
.controller('HrsmemController', HrsmemController);

HrsmemController.$inject=['HrsadminService', 'list', 'info', 'nonlist'];
function HrsmemController(HrsadminService, list, info, nonlist) {
  var hmctrl=this;

  hmctrl.page = 1;
  hmctrl.list = list.data;
  hmctrl.last = info.data.last;
  hmctrl.filter = "full";
  hmctrl.filterwhich ="full";
  hmctrl.lookAtMember=false;

  hmctrl.memberLists = function (){
    hmctrl.lookAtMember = false;
  };


  hmctrl.whenGotId = function(index){
    hmctrl.memberID = index;
    HrsadminService.getMemInfo(hmctrl.memberID)
      .then(function (response){
        hmctrl.meminfo = response.data;
        hmctrl.trange = [];
        for(var i=1;i<=hmctrl.meminfo.numpages.last;i++) {
          hmctrl.trange.push(i);
        }
        hmctrl.lookAtMember = true;
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  hmctrl.range = [];
  for(var i=1;i<=hmctrl.last;i++) {
    hmctrl.range.push(i);
  }

  hmctrl.doEdit = function(index){
    console.log("doedit: ", index);
  };

  hmctrl.doDelete = function(index){
    console.log("dodelete: ", index);
  };

  hmctrl.optionHPage = function (index){
    hmctrl.page = parseInt(index);
    hmctrl.getNewHPage(hmctrl.page);
  };

  hmctrl.getNewPage = function(index){
    HrsadminService.getmList(hmctrl.filter, hmctrl.filterwhich, index)
      .then(function (response){
        hmctrl.list = response.data;
      })
      .catch(function (error) {
        console.log(error);
      });

  };

  hmctrl.optionPage = function (index){
    hmctrl.page = parseInt(index);
    hmctrl.getNewPage(index);
  };

  hmctrl.getNewHPage = function(pageIndex){
    HrsadminService.getHList(hmctrl.memberID, pageIndex)
      .then(function (response){
        hmctrl.meminfo.annual = response.data;
      })
      .catch(function (error) {
        console.log(error);
      });

  };




}

})();
