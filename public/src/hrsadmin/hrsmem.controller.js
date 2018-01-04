(function () {
'use strict';

angular.module('HadminApp')
.controller('HrsmemController', HrsmemController);

HrsmemController.$inject=['HrsadminService', 'list', 'info'];
function HrsmemController(HrsadminService, list, info) {
  var hmctrl=this;

  hmctrl.page = 1;
  hmctrl.list = list.data;
  hmctrl.last = info.data.last;
  hmctrl.filter = "full";
  hmctrl.filterwhich ="full";
  hmctrl.lookAtMember=false;
  hmctrl.start_year = 2017;
  var d = new Date();
  hmctrl.this_year = d.getFullYear();
  hmctrl.which_year = hmctrl.this_year;
  hmctrl.years = [];
  for (var i = hmctrl.start_year; i <= hmctrl.this_year; i++) {
    hmctrl.years.push(i);
  }

  hmctrl.returnToThisYear = function(){
    hmctrl.which_year = hmctrl.this_year;
    hmctrl.get_which_year();
  }

  hmctrl.get_which_year = function(){
    if (hmctrl.lookAtMember){
      hmctrl.whenGotId(hmctrl.memberID);
    } else {
      HrsadminService.getmList(hmctrl.filter, hmctrl.filterwhich, hmctrl.page, hmctrl.which_year)
        .then(function (response){
          hmctrl.list = response.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    }

  }

  hmctrl.memberLists = function (){
    hmctrl.lookAtMember = false;
  };


  hmctrl.whenGotId = function(index){
    hmctrl.memberID = index;
    HrsadminService.getMemInfo(hmctrl.memberID, hmctrl.which_year)
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
  hmctrl.goEditModul = false;
  hmctrl.madeUpdates = false;
  hmctrl.goUndoModul = false;
  hmctrl.goDeleteModul = false;

  hmctrl.backToAdd = function () {
    hmctrl.entered = false;
  };

  hmctrl.cancel = function (hrsForm) {
    hmctrl.hdate = null;
    hmctrl.hrstype = '';
    hmctrl.numhrs = null;
    hmctrl.description = '';
    hmctrl.addDescription = '';
    hrsForm.$setUntouched();
  };

  hmctrl.submit = function (hrsForm) {
    HrsadminService.addHrs(hmctrl.memberID, hmctrl.hdate,
                    hmctrl.hrstype, hmctrl.numhrs, hmctrl.description,
                    hmctrl.addDescription)
      .then(function (response){
        hmctrl.entered = true;
        hmctrl.hdate = null;
        hmctrl.hrstype = '';
        hmctrl.numhrs = null;
        hmctrl.description = '';
        hmctrl.addDescription = '';
        hrsForm.$setUntouched();
      })
      .then(function (response) {
        HrsadminService.getMemInfo(hmctrl.memberID)
        .then(function (response) {
        hmctrl.meminfo = response.data;
      });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  hmctrl.doEdit = function(index){
    hmctrl.madeUpdates = false;
    hmctrl.goUndoModul = false;
    hmctrl.goDeleteModul = false;
    hmctrl.edItems = hmctrl.meminfo.annual[index];
    hmctrl.items = [];
    hmctrl.items.numid = hmctrl.edItems.numid;
    hmctrl.items.hdate = hmctrl.edItems.hdate;
    hmctrl.items.hrstype = hmctrl.edItems.hrstype;
    if (hmctrl.items.description==null){
      hmctrl.items.description = hmctrl.edItems.description;
    }
    if (hmctrl.items.numhrs==null){
      hmctrl.items.numhrs = hmctrl.edItems.numhrs;
    }
    hmctrl.goEditModul = true;
  };


  hmctrl.makeUpdate = function(items){
    HrsadminService.makeUpdates(items)
      .then(function (response){
        hmctrl.madeUpdates = true;
        console.log("end: ", response.data);
      })
      .then(function (response) {
        HrsadminService.getMemInfo(hmctrl.memberID)
        .then(function (response) {
        hmctrl.meminfo = response.data;
      });
      })
      .catch(function (error) {
        console.log(error);
      });

  };

  hmctrl.doDelete = function(index){
    hmctrl.goEditModul = false;
    hmctrl.goUndoModul = false;
    hmctrl.goDeleteModul = true;
    hmctrl.madeDelete = false;
    hmctrl.whatDelete = hmctrl.meminfo.annual[index].numid;
    console.log("dodelete: ", hmctrl.meminfo.annual[index].numid);
  };

  hmctrl.makeDelete = function(description){
    HrsadminService.DeleteEntry(hmctrl.whatDelete, description)
      .then(function (response){
        hmctrl.madeDelete = true;
        hmctrl.whatDelete = null;
      })
      .then(function (response) {
        HrsadminService.getMemInfo(hmctrl.memberID)
        .then(function (response) {
        hmctrl.meminfo = response.data;
      });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  hmctrl.doUndo = function(index){
    hmctrl.goEditModul = false;
    hmctrl.goDeleteModul = false;
    hmctrl.madeUndo = false;
    hmctrl.whatUndo = hmctrl.meminfo.annual[index].numid;
    HrsadminService.UndoInfo(hmctrl.whatUndo)
      .then(function (response){
        hmctrl.undoItem = response.data.now;
        hmctrl.changes = response.data.changes;
        console.log("changes: ", hmctrl.changes);
        console.log("now: ", hmctrl.undoItem);
        hmctrl.goUndoModul = true;
      })
      .catch(function (error) {
        console.log(error);
      });

  };

  hmctrl.makeUndo = function(){
    HrsadminService.UndoEntry(hmctrl.whatUndo)
      .then(function (response){
        hmctrl.madeUndo = true;
        hmctrl.whatUndo= null;
      })
      .then(function (response) {
        HrsadminService.getMemInfo(hmctrl.memberID)
        .then(function (response) {
        hmctrl.meminfo = response.data;
      });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  hmctrl.optionHPage = function (index){
    hmctrl.page = parseInt(index);
    hmctrl.getNewHPage(hmctrl.page);
  };

  hmctrl.getNewPage = function(index){
    HrsadminService.getmList(hmctrl.filter, hmctrl.filterwhich, index, hmctrl.which_year)
      .then(function (response){
        hmctrl.page = index;
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
    HrsadminService.getHList(hmctrl.memberID, pageIndex, hmctrl.which_year)
      .then(function (response){
        hmctrl.meminfo.annual = response.data;
      })
      .catch(function (error) {
        console.log(error);
      });

  };




}

})();
