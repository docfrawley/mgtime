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
    hmctrl.lookAtMember = true;
    hmctrl.memberID = index;
    HrsadminService.getMemInfo(hmctrl.memberID)
      .then(function (response){
        hmctrl.minfo = response.data;
        console.log("got data: ", hmctrl.minfo);
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  hmctrl.range = [];
  for(var i=1;i<=hmctrl.last;i++) {
    hmctrl.range.push(i);
  }

  hmctrl.firstPage = function ()  {
    hmctrl.page = 1;
  };

  hmctrl.decreasePage = function ()  {
    if (hmctrl.page>1){
      hmctrl.page = parseInt(hmctrl.page) - 1;
    } else {
      hmctrl.page = 1;
    }
  };

  hmctrl.increasePage = function ()  {
    if (hmctrl.page < hmctrl.last){
      hmctrl.page = parseInt(hmctrl.page) + 1;
    }
  };

  hmctrl.lastPage = function ()  {
    hmctrl.page = parseInt(hmctrl.last);
  };

  hmctrl.optionPage = function (index){
    hmctrl.page = parseInt(index);
    hmctrl.getNewPage();
  }

  hmctrl.getNewPage = function(){
    HrsadminService.getmList(hmctrl.filter, hmctrl.filterwhich, hmctrl.page)
      .then(function (response){
        hmctrl.list = response.data;
      })
      .catch(function (error) {
        console.log(error);
      });

  };




}

})();
