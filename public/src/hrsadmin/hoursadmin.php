
<div class="row">
  <div class="col-md-6">

    <reg-totals title="Master Gardeners Overall Totals" categories="hactrl.rlist"></reg-totals>
  </div>
  <div class="col-md-6">
    <div class="row text-center">
      <div class="col-sm-3" ng-if="hactrl.doWhat=='regNoHrs'">
        <button class='btn btn-sm btn-success' ng-click="hactrl.changeLook('notReg')">NOT REGISTERED</button>
      </div>
      <div class="col-sm-3" ng-if="hactrl.doWhat=='notReg'">
        <button class='btn btn-sm btn-success' ng-click="hactrl.changeLook('regNoHrs')">REGISTERED, NO HRS</button>
      </div>

    </div>

    <div class="row text-center">
      <div class="col-sm-12">
        <div ng-if="hactrl.doWhat=='notReg'">
          <show-nolist
            title="Members Not Registered"
            list="hactrl.nonlist.nonReg">
          </show-nolist>
        </div>
        <div ng-if="hactrl.doWhat=='regNoHrs'">
          <show-nolist
            title="Registered, No Hours Entered"
            list="hactrl.nonlist.RegNoHrs">
          </show-nolist>
        </div>
      </div>
    </div>

  </div>
</div>
