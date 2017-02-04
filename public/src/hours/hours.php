<div class="row">
  <div class="col-md-6" >
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-body" ng-if="hctrl.addhrs">
            <div ng-if="!hctrl.entered && !hctrl.edited && !hctrl.deleted">
              <h3 class="text-center">Hours Entry Form</h3>
            </div>
            <div ng-if="hctrl.entered" class="alert alert-success" role="alert">
              Your hours were added successfully!</div>
            <div ng-if="hctrl.edited" class="alert alert-success" role="alert">
              Edits were successful</div>
            <div ng-if="hctrl.deleted" class="alert alert-success" role="alert">
              That entry was deleted</div>
              <div ng-show="hctrl.dateGone" class="alert alert-warning" role="alert">
                The date entered is either past 91 days or has yet to occur.</div>
            <br />
            <form name='hrsForm' novalidate>
            <div class="form-group">
              <label class="col-sm-2 control-label text-left"
              for="inputEmail">Date:</label>
              <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
              <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

              <!--Font Awesome (added because you use icons in your prepend/append)-->
              <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

              <div class="bootstrap-iso">
               <div class="container-fluid">
                <div class="row">
                 <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                     <input class="form-control" id="date"
                     placeholder="MM/DD/YYYY"
                     type="text" name="date"
                     ng-model="hctrl.hdate" ng-click="hctrl.backToAdd()"
                     required/>
                     <div class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                     </div>
                    </div>
                 </div>
                </div>
               </div>
               <span class="input_warning"
                 ng-if="hrsForm.date.$error.required && hrsForm.date.$touched">
                 Please enter a date for your hours.
               </span><br>
            </div>
              <!-- Extra JavaScript/CSS added manually in "Settings" tab -->
              <!-- Include Date Range Picker -->
              <script type="text/javascript"
              src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js">
              </script>
              <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
              <script>
                  $(document).ready(function(){
                      var date_input=$('input[name="date"]'); //our date input has the name "date"
                      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                      date_input.datepicker({
                          format: 'mm/dd/yyyy',
                          container: container,
                          todayHighlight: true,
                          autoclose: true,
                      })
                  })
              </script>

              <label class="col-sm-2 control-label text-left"
              for="inputEmail">Type of Hrs: </label>
              <div class="col-sm-4">
                <select class="custom-select form-control" ng-model="hctrl.hrstype"
                        name="hrstype" ng-click="hctrl.backToAdd()"
                        required>
                  <option value="Mercer County">Mercer County</option>
                  <option value="Helpline">Helpline</option>
                  <option ng-show="hctrl.mgstatus!='A - Trainee'"
                          value="Continuing Ed">Continuing Ed</option>
                  <option ng-show="hctrl.mgstatus=='A - Trainee'"
                          value="Compost (Trainee)">Compost (Trainee)</option>

                </select>
                <span class="input_warning"
                  ng-if="hrsForm.hrstype.$error.required && hrsForm.hrstype.$touched">
                  Please select type of hours.
                </span><br>
             </div>


              <label class="col-sm-2 control-label text-right"
              for="inputEmail"> # of Hrs: </label>
              <div class="col-sm-4">
              <input class="form-control" type="text" name="numhrs"
               placeholder="Number of Hours" ng-model="hctrl.numhrs"
               ng-click="hctrl.backToAdd()" required>
               <span class="input_warning"
                 ng-if="hrsForm.numhrs.$error.required && hrsForm.numhrs.$touched">
                 Please enter number of hours.
               </span><br>
            </div>
            <div ng-if="!hctrl.ishelpline">
              <label class="col-sm-2 control-label text-left"
              for="inputEmail">Description: </label>
              <div class="col-sm-10">
              <input class="form-control" type="text" name="description"
               placeholder="Description" ng-model="hctrl.description"
               ng-click="hctrl.backToAdd()" required>
               <span class="input_warning"
                 ng-if="hrsForm.description.$error.required && hrsForm.description.$touched">
                 Please provide a description.
               </span><br>
              </div>
            </div>

              <button class='btn btn-lg btn-success' ng-click="hctrl.submit(hrsForm)"
                      ng-disabled="hrsForm.$invalid">SUBMIT</button>
            </div>

          </div>
        </form>
          <div class="panel-body" ng-if="!hctrl.addhrs">
              <div class="col-sm-12 text-center">
                <h3 ng-if="!hctrl.entered && !hctrl.dateGone" >
                  Edit or Delete This Entry</h3>

                  <div ng-show="hctrl.dateGone" class="alert alert-warning" role="alert">
                    The date entered is either past 91 days or has yet to occur.</div><br>
              </div>



              <form name='hedForm' novalidate>
              <div class="form-group">
              <label class="col-sm-2 control-label text-left"
              for="inputEmail">Date:</label>
              <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
              <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

              <!--Font Awesome (added because you use icons in your prepend/append)-->
              <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

              <div class="bootstrap-iso">
               <div class="container-fluid">
                <div class="row">
                 <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                     <input class="form-control" id="date"
                     placeholder={{hctrl.edItems.hdate}}
                     type="text"
                     ng-model="hctrl.edItems.hdate" name="date" required/>
                     <div class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                     </div>
                    </div>
                 </div>

                </div>
               </div>
               <span class="input_warning"
                 ng-if="hedForm.date.$error.required && hedForm.date.$touched">
                 Please enter a date for your hours.
               </span><br>
            </div>
              <!-- Extra JavaScript/CSS added manually in "Settings" tab -->
              <!-- Include Date Range Picker -->
              <script type="text/javascript"
              src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js">
              </script>
              <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
              <script>
                  $(document).ready(function(){
                      var date_input=$('input[name="date"]'); //our date input has the name "date"
                      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                      date_input.datepicker({
                          format: 'mm/dd/yyyy',
                          container: container,
                          todayHighlight: true,
                          autoclose: true,
                      })
                  })
              </script>

              <label class="col-sm-2 control-label text-left"
              for="inputEmail">Type Hrs: </label>
              <div class="col-sm-4">
                <select class="custom-select form-control"
                        ng-model="hctrl.edItems.hrstype"
                        name="hrstype"
                        required>
                  <option value="Mercer County">Mercer County</option>
                  <option value="Helpline">Helpline</option>
                  <option ng-show="hctrl.mgstatus!='A - Trainee'"
                          value="Continuing Ed">Continuing Ed</option>
                  <option ng-show="hctrl.mgstatus=='A - Trainee'"
                          value="Compost (Trainee)">Compost (Trainee)</option>
                </select>
                <span class="input_warning"
                  ng-if="hedForm.hrstype.$error.required && hedForm.hrstype.$touched">
                  Please select type of hours.
                </span><br>
             </div>


              <label class="col-sm-2 control-label text-right"
              for="inputEmail"> # of Hrs: </label>
              <div class="col-sm-4">
              <input class="form-control" type="text" name="numhrs"
               placeholder={{hctrl.edItems.numhrs}}
               ng-model="hctrl.edItems.numhrs" required>
               <span class="input_warning"
                 ng-if="hedForm.numhrs.$error.required && hedForm.numhrs.$touched">
                 Please enter number of hours.
               </span><br>
             </div>

            <div ng-if="!hctrl.ishelpline">
              <label class="col-sm-2 control-label text-left"
              for="inputEmail">Description: </label>
              <div class="col-sm-10">
              <input class="form-control" type="text" name="description"
               placeholder={{hctrl.edItems.description}}
               ng-model="hctrl.edItems.description" required>
               <span class="input_warning"
                 ng-if="hedForm.description.$error.required && hedForm.description.$touched">
                 Please provide a description.
               </span><br>
              </div>
            </div>
              <div class="col-sm-3">
                <button class='btn btn-lg btn-success' ng-click="hctrl.hedit()"
                        ng-disabled="hedForm.$invalid">UPDATE</button>
              </div>

              <div class="col-sm-3 text-left">
                <button class='btn btn-lg btn-danger' ng-click="hctrl.hdelete()">DELETE</button>
              </div>

              <div class="col-sm-6 text-right">
                <button class='btn btn-lg btn-primary' ng-click="hctrl.backToAdd()">BACK TO ADD HOURS FORM</button>
              </div>

            </div>

          </div>
        </form>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <h3 class="text-center">ANNUAL HOURS</h3><br>
            <h5 class="text-left">Edit or Delete Entries by clicking on date</h5>
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Type of Hours</th>
                  <th># of Hours</th>
                  <th>Description</th>
                </tr>
              </thead>
              <tr ng-repeat="items in hctrl.items">
                <td>
                  <button class='btn btn-sm btn-info' ng-click="hctrl.gomodul($index)">{{items.hdate}}</button>
                </td>
                <td>
                  {{items.hrstype}}
                </td>
                <td>
                  {{items.numhrs}}
                </td>
                <td>
                  {{items.description}}
                </td>
              </tr>
            </table>

          </div>
        </div>
      </div>
    </div>
 </div>
 <div class="col-md-6">

   <div class="panel panel-default">
     <div class="panel-body text-center">
       <h3>Yearly Hour Totals for <? echo date('Y'); ?> </h3><br>
       <div ng-show="hctrl.congrats" class="alert alert-success" role="alert">
         You just got your 1000hrs. Congrats. Please note that your requirements have changed.</div><br>
       <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th></th>
              <th class ="text-center">Requirement</th>
              <th class ="text-center">Annual</th>
              <th class ="text-center">Historical</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Volunteer Hours:</th>
                <td ng-if="hctrl.mgstatus=='A - Trainee'">60</td>
                <td ng-if="hctrl.mgstatus=='A'">30</td>
                <td ng-if="hctrl.mgstatus=='Active 1000hrs'">25</td>
              <td>{{hctrl.totals[12]['Total']}}</td>
              <td> {{hctrl.ototals['Total']}}</td>
            </tr>
            <tr>
              <th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;Mercer County</th>
              <td ng-if="hctrl.mgstatus=='A - Trainee' ||
                         hctrl.mgstatus=='Active 1000hrs'">25</td>
              <td ng-if="hctrl.mgstatus=='A'">15</td>
              <td>{{hctrl.totals[12]['Mercer County']}}</td>
              <td>{{hctrl.ototals['Mercer County']}}</td>
            </tr>
            <tr>
              <th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;Helpline</th>
              <td ng-if="hctrl.mgstatus=='A - Trainee'">30</td>
              <td ng-if="hctrl.mgstatus=='A'">15</td>
              <td ng-if="hctrl.mgstatus=='Active 1000hrs'"> </td>
              <td>{{hctrl.totals[12]['Helpline']}}</td>
              <td> {{hctrl.ototals['Helpline']}}</td>
            </tr>
            <tr ng-show="hctrl.mgstatus!='A - Trainee'">
                <th scope="row">Continuing Ed (CE)</th>
                <td>10</td>
                <td>{{hctrl.totals[12]['Continuing Ed']}}</td>
                <td> {{hctrl.ototals['Continuing Ed']}}</td>
            </tr>
            <tr ng-show="hctrl.mgstatus=='A - Trainee'">
                <th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;Compost</th>
                <td>5</td>
                <td>{{hctrl.totals[12]['Continuing Ed']}}</td>
                <td> --- </td>
            </tr>
          </tbody>
        </table>
        <br>

       <h3 class="text-center"><? echo date('Y'); ?> Monthly Hour Totals</h3><br>
       <table class="table table-condensed table-striped">
         <thead>
          <tr>
            <th></th>
            <th class="text-center">Mercer County</th>
            <th class="text-center">Helpline</th>

              <th class="text-center"
                  ng-show="hctrl.mgstatus=='A - Trainee'">Compost</th>
              <th class="text-center"
                  ng-show="hctrl.mgstatus!='A - Trainee'">CE</th>
            <th class="text-center">Total Hours</th>
          </tr>
        </thead>
         <tr>
           <td class="text-left">January:</td>
           <td>{{hctrl.totals[0]['Mercer County']}}</td>
           <td>{{hctrl.totals[0]['Helpline']}}</td>
             <td ng-show="hctrl.mgstatus=='A - Trainee'">
               {{hctrl.totals[0]['Compost']}}</td>
             <td ng-show="hctrl.mgstatus!='A - Trainee'">
               {{hctrl.totals[0]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[0]['Total']}}</td>
         </tr>
         <tr><td class="text-left">February:</td>
           <td>{{hctrl.totals[1]['Mercer County']}}</td>
           <td>{{hctrl.totals[1]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[1]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[1]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[1]['Total']}}</td>
         </tr>
         <tr><td class="text-left">March:</td>
           <td>{{hctrl.totals[2]['Mercer County']}}</td>
           <td>{{hctrl.totals[2]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[2]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[2]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[2]['Total']}}</td>
         </tr>
         <tr><td class="text-left">April:</td>
           <td>{{hctrl.totals[3]['Mercer County']}}</td>
           <td>{{hctrl.totals[3]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[3]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[3]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[3]['Total']}}</td>
         </tr>
         <tr><td class="text-left">May:</td>
           <td>{{hctrl.totals[4]['Mercer County']}}</td>
           <td>{{hctrl.totals[4]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[4]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[4]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[4]['Total']}}</td>
         </tr>
         <tr><td class="text-left">June:</td>
           <td>{{hctrl.totals[5]['Mercer County']}}</td>
           <td>{{hctrl.totals[5]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[5]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[5]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[5]['Total']}}</td>
         </tr>
         <tr><td class="text-left">July:</td>
           <td>{{hctrl.totals[6]['Mercer County']}}</td>
           <td>{{hctrl.totals[6]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[6]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[6]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[6]['Total']}}</td>
         </tr>
         <tr><td class="text-left">August:</td>
           <td>{{hctrl.totals[7]['Mercer County']}}</td>
           <td>{{hctrl.totals[7]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[7]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[7]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[7]['Total']}}</td>
         </tr>
         <tr><td class="text-left">September:</td>
           <td>{{hctrl.totals[8]['Mercer County']}}</td>
           <td>{{hctrl.totals[8]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[8]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[8]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[8]['Total']}}</td>
         </tr>
         <tr><td class="text-left">October:</td>
           <td>{{hctrl.totals[9]['Mercer County']}}</td>
           <td>{{hctrl.totals[9]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[9]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[9]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[9]['Total']}}</td>
         </tr>
         <tr><td class="text-left">November:</td>
           <td>{{hctrl.totals[10]['Mercer County']}}</td>
           <td>{{hctrl.totals[10]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[10]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[10]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[10]['Total']}}</td>
         </tr>
         <tr><td class="text-left">December:</td>
           <td>{{hctrl.totals[11]['Mercer County']}}</td>
           <td>{{hctrl.totals[11]['Helpline']}}</td>
           <td ng-show="hctrl.mgstatus=='A - Trainee'">
             {{hctrl.totals[11]['Compost']}}</td>
           <td ng-show="hctrl.mgstatus!='A - Trainee'">
             {{hctrl.totals[11]['Continuing Ed']}}</td>
           <td>{{hctrl.totals[11]['Total']}}</td>
         </tr>
       </table>

     </div>
   </div>
 </div>

</div>
