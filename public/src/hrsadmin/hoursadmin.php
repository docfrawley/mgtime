<div class="row">
  <div class="col-sm-12 text-center">
    <h1>Hours Administration: Online Registration</h1>
  </div>
  <!-- <div class="col-sm-12 text-center">
    <button ui-sref="reports" class='btn btn-sm btn-info'>REPORTS</button>
    <button ui-sref="memhours" class='btn btn-sm btn-info'>MEMBER HRS</button>
  </div> -->
</div><br>

<div class="row">

  <div class="col-md-6">

    <reg-totals title="Master Gardeners Overall Totals" categories="hactrl.rlist"></reg-totals>
  </div>
  <div class="col-md-6">

    <div class="row text-center">
      <div class="col-sm-12">
        <div ng-if="hactrl.doWhat=='notReg'">
          <show-nolist
            title="Members Not Registered"
            which="REGISTERED, NO HRS"
            list="hactrl.nonlist.nonReg"
            on-list="hactrl.changeLook()">
          </show-nolist>
        </div>
        <div ng-if="hactrl.doWhat=='regNoHrs'">
          <show-nolist
            title="Registered, No Hours Entered"
            which="NOT REGISTERED"
            list="hactrl.nonlist.RegNoHrs"
            on-list="hactrl.changeLook(whichone)">
          </show-nolist>
        </div>
      </div>
    </div>

  </div>
</div>
