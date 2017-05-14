<div class="row">
  <div class="col-sm-12 text-center">
    <h1>Hours Administration: Reports</h1>
  </div>
  <div class="col-sm-12 text-center">
    <button ui-sref="memhours" class='btn btn-sm btn-info'>MEMBER HRS</button>
    <button ui-sref="home" class='btn btn-sm btn-info'>ONLINE REG</button>
  </div>
</div><br>
<div class="row">
  <div class="col-lg-3 text center">
    <button ng-if="hrctrl.active=='nclist'" class='btn btn-md btn-success buttonr'>New Class Report</button>
    <button
      ng-if="hrctrl.active!='nclist'"
      ng-click = "hrctrl.changeB('nclist')"
      class='btn btn-md btn-primary buttonr'>New Class Report</button>
  </div>
  <div class="col-lg-3 text center">
    <button ng-if="hrctrl.active=='mlist'" class='btn btn-md btn-success buttonr'>Milestones</button>
    <button
      ng-if="hrctrl.active!='mlist'"
      ng-click = "hrctrl.changeB('mlist')"
      class='btn btn-md btn-primary buttonr'>Milestones</button>
  </div>
  <div class="col-lg-3 text center">
    <button ng-if="hrctrl.active=='slist'" class='btn btn-md btn-success buttonr'>Summary Report</button>
    <button
      ng-if="hrctrl.active!='slist'"
      ng-click = "hrctrl.changeB('slist')"
      class='btn btn-md btn-primary buttonr'>Summary Report</button>
  </div>
  <div class="col-lg-3 text center">
    <button ng-if="hrctrl.active=='rdlist'" class='btn btn-md btn-success buttonr'>Requirement Deficiencies</button>
    <button
      ng-if="hrctrl.active!='rdlist'"
      ng-click = "hrctrl.changeB('rdlist')"
      class='btn btn-md btn-primary buttonr'>Requirement Deficiencies</button>
  </div>

  <div class='row'>
    <div class="col-sm-12">
      <show-report ng-if="hrctrl.show"
        list        = 'hrctrl.list'
        whichreport = 'hrctrl.active'
        last        = 'hrctrl.last'></show-report>
    </div>
  </div>
</div>
