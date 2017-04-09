(function () {
'use strict';

angular.module('HadminApp')
.controller('HrsmemController', HrsmemController);

HrsmemController.$inject=['HrsadminService', 'list', 'info', 'nonlist'];
function HrsmemController(HrsadminService, list, info, nonlist) {
  var hmctrl=this;

  hmctrl.page = 1;
  hmctrl.list = list.data;
  console.log("the list: ", hmctrl.list);
  hmctrl.last = info.data.last;
  console.log("the last: ", hmctrl.last);
  hmctrl.filter = "full";
  hmctrl.filterwhich ="full";
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
    // HrsadminService.getList(hmctrl.filter, hmctrl.filterwhich, hmctrl.page)
    //   .then(function (response){
    //     hmctrl.list = response.data;
    //   })
    //   .catch(function (error) {
    //     console.log(error);
    //   });

    console.log("here page: ", hmctrl.page);
  };



hmctrl.changeLook = function(){
  hmctrl.doWhat= (hmctrl.doWhat=='regNoHrs')? 'notReg':'regNoHrs';
}

}

})();
