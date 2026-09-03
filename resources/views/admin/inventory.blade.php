@extends('admin/layouts/head-main')
@section('content')
<title>Inventorys</title>
<!-- Page Wrapper -->
<div class="page-wrapper">
   <style>
      .profile-widget .user-name {
      color: #333333;
      margin-top: 30px!important;
      }
   </style>
   <!-- Page Content -->
   <div class="content container-fluid">
      <!-- Page Header -->
      <div class="page-header">
         <div class="row align-items-center">
            <div class="col">
               <h3 class="page-title">Inventory List</h3>
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Inventory List</li>
               </ul>
            </div>
            <div class="col-auto float-end ms-auto">
               <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_Inventory"><i class="fa fa-plus"></i> Add Inventory</a>
            </div>
         </div>
      </div>
      <!-- /Page Header -->
      <div class="row">
         <div class="col-md-12">
            <div class="row staff-grid-row">
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                           <thead class="t-head " style="text-align: center;vertical-align: middle;">
                              <tr class="">
                                 <th>#</th>
                                 <th>CATEGORY</th>
                                 <th>DESTINATION COUNTRY</th>
                                 <th>AIRLINE</th>
                                 <th>SECTOR</th>
                                 <th>PNR.NO</th>
                                 <th>FARE </th>
                                 <th>TAXES</th>
                                 <th>TOTAL SEATS</th>
                                 <th>SEATS SOLD</th>
                                 <th>SEATS AVAILABLE</th>
                              </tr>
                           </thead>
                           <tbody style="text-align: center;vertical-align: middle;">
                              @foreach ($result as $key => $value)
                              <tr>
                                 <td>{{ $loop->iteration }}</td>
                                 <td>{{ $value->infant_id }}</td>
                                 <td>{{ ($value['sector']['city_name']) ?? 'N/A' }} </td>
                                 <td>{{ ucfirst($value['airline']['airline_name']) ?? 'N/A' }}</td>
                                 <td>{{ $value['origin']['city_name'] ?? 'N/A' }}</br><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></br>
                                    {{ $value['destination']['city_name'] ?? 'N/A' }}
                                 </td>
                                 <td>{{ strtoupper($value->p_no) ?? 'N/A' }}</td>
                                 <td>{{ $value['base_fair'] }}</td>
                                 <td>{{ $value['tax'] }}</td>
                                 <td>{{ $value->seat ?? 'N/A' }}</td>
                                 <td>
    @php
    $seat = (int) $value->seat ?? 0;
    $availabilty = (int) $value->availabilty ?? 0;
    $difference = $seat - $availabilty;
    @endphp
    {{ $difference }}
</td>
                                 <td>{{ $value->availabilty ?? 'N/A' }}</td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Page Content -->
      </div>
   </div>
   <div id="add_Inventory" class="modal custom-modal fade" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Add Inventory</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="d-flex  align-items-center">
                  <span class="font-weight-bold" style="font-size: 20px;"> TRIP TYPE :</span>
                  <button  style="margin-left:50px;" class="btn btn-primary" onclick="oneWay()" id="one_way">
                  <i class="mdi mdi-arrow-left-bold"></i> ONE WAY
                  </button>
                  <button  style="margin-left:50px;" class="btn btn-primary" onclick="twoWay()" id="two_way">
                  <i class="mdi mdi-arrow-left-bold"></i> TWO WAY
                  </button>
                  <input type="hidden" id="chkWay" value="">
               </div>
               <hr>
               <form action="{{ route('admin.inventory.store') }}" class="forms-sample" method="POST" enctype="multipart/form-data" autocomplete="on">
                  @csrf
                  <div class="row">
                     <div class="col-12 p-2">
                        <span class="font-weight-bold" style="font-size: 20px;"> BASIC
                        DETAILS</span>
                     </div>
                     <div class="col-4 p-2">
                        <div class="form-group">
                           <label for="exampleInputName1">CATEGORY<span
                              class="text-danger"></span></label>
                           <select name="infant_id" class="form-control" id="select_company">
                              <option value="">Select Category</option>
                              <option value="International">International</option>
                              <option value="Domestic">Domestic</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-4 p-2">
                        <div class="form-group">
                           <label for="exampleInputName1">SELECT AN ORIGIN<span
                              class="text-danger"></span></label>
                           <select name="origin_id" class="form-control" id="select_origin">
                              <option value="">Select Origin</option>
                              @foreach($sectors as $sector)
                              <option value="{{ $sector->id }}"                                                 >
                                 {{ $sector->airport_code }}  ({{ $sector->city_name }})
                              </option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-4 p-2">
                        <div class="form-group">
                           <label for="exampleInputName1">SELECT AN DESTINATION<span
                              class="text-danger"></span></label>
                           <select name="destination_id" class="form-control" id="select_des">
                              <option value="">Select Destination</option>
                              @foreach($sectors as $sector)
                              <option value="{{ $sector->id }}"                                                 >
                                 {{ $sector->airport_code }}  ({{ $sector->city_name }})
                              </option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-4 p-2">
                        <div class="form-group">
                           <label for="exampleInputName1">DEPARTURE AIRLINE<span
                              class="text-danger"></span></label>
                           <select name="airline_id" class="form-control" id="select_company">
                              <option value="">Select Airline</option>
                              @foreach($airlines as $airline_data)
                              <option value="{{ $airline_data->id }}"                                                 >
                                 {{ $airline_data->airline_code }}
                              </option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-4 p-2">
                        <div class="form-group">
                           <label for="exampleInputName1">PNR NO<span
                              class="text-danger">*</span></label>
                           <input type="text" name="p_no" class="form-control"
                              placeholder="PNR NO" value="">
                        </div>
                     </div>
                     <div class="col-4 p-2">
                        <div class="form-group">
                           <label for="exampleInputName1">Country/City Name<span
                              class="text-danger">*</span></label>
                           <input type="text" name="name" class="form-control"
                              placeholder="Country/City Name" value="">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-12 p-2">
                        <span class="font-weight-bold" style="font-size: 20px;">FLIGHT
                        DETAILS</span>
                     </div>
                  </div>
                  <div class="row mt-2" id="input-fields-container">
                     <div class="row">
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">DEPARTURE DATE<span
                                 class="text-danger">*</span></label>
                              <input type="date" name="departure_date_from"
                                 class="form-control" placeholder="DEPATURE TIME"
                                 value="" oninput="validateYear(this)">
                           </div>
                        </div>
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">DEPARTURE TIME<span
                                 class="text-danger">*</span></label>
                              <input type="time" name="departure_time"
                                 class="form-control" placeholder="DEPATURE TIME"
                                 value="">
                           </div>
                        </div>
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">SELECT AN ORIGIN<span
                                 class="text-danger"></span></label>
                              <select class="form-control" id="select_origin_a">
                                 <option value="">Select ORIGIN</option>
                                 @foreach($sectors as $sector)
                                 <option value="{{ $sector->id }}" >
                                    {{ $sector->airport_code }}  ({{ $sector->city_name }})
                                 </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">TERMINAL<span
                                 class="text-danger">*</span></label>
                              <input type="text" name="terminal" class="form-control"
                                 placeholder="TERMINAL" value="">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">ArrivalDATE<span
                                 class="text-danger">*</span></label>
                              <input type="date" name="departure_date_to"
                                 class="form-control" placeholder="DEPATURE TIME"
                                 value="" oninput="validateYear(this)">
                           </div>
                        </div>
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">ARRIVAL TIME<span
                                 class="text-danger">*</span></label>
                              <input type="time" name="arrival_time"
                                 class="form-control" placeholder="ARRIVAL TIME"
                                 value="">
                           </div>
                        </div>
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">SELECT AN DESTINATION<span
                                 class="text-danger"></span></label>
                              <select class="form-control" id="select_des_a">
                                 <option value="">Select Destination</option>
                                 @foreach($sectors as $sector)
                                 <option value="{{ $sector->id }}"                                                 >
                                    {{ $sector->airport_code }}  ({{ $sector->city_name }})
                                 </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">TERMINAL<span
                                 class="text-danger">*</span></label>
                              <input type="text" name="arrival_terminal"
                                 class="form-control" placeholder="TERMINAL"
                                 value="">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div id="return_date_section" style="display: none;">
                     <div class="row" id="ret_D">
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">RETURN DATE<span
                                 class="text-danger">*</span></label>
                              <input type="date" name="return_date" class="form-control"
                                 placeholder="RETURN DATE" value="" oninput="validateYear(this)">
                           </div>
                        </div>
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">RETURN TIME<span
                                 class="text-danger">*</span></label>
                              <input type="time" name="return_time" class="form-control"
                                 placeholder="RETURN TIME" value="">
                           </div>
                        </div>
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">TERMINAL<span
                                 class="text-danger">*</span></label>
                              <input type="text" name="ret_terminal"
                                 class="form-control" placeholder="TERMINAL"
                                 value="">
                           </div>
                        </div>
                        <div class="col-3 p-2">
                           <div class="form-group">
                              <label for="exampleInputName1">	RETUR FLIGHT NO.<span
                                 class="text-danger">*</span></label>
                              <input type="text" name="ret_flight_no"
                                 class="form-control" placeholder="Return PNR "
                                 value="">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-6 p-2">
                        <div class="form-group">
                           <label for="exampleInputName1">FLIGHT NO<span
                              class="text-danger">*</span></label>
                           <input type="text" name="flight_no" class="form-control"
                              placeholder="FLIGHT NO" value="">
                        </div>
                     </div>
                     <div class="col-6 p-2">
                        <div class="form-group">
                           <label for="exampleInputName1">AVAILABILTY<span
                              class="text-danger">*</span></label>
                           <input type="text" name="availabilty" class="form-control"
                              placeholder="P.NO" value="">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-6 p-2">
                        <div class="form-group">
                           <label for="exampleInputName1">No. OF SEAT<span
                              class="text-danger">*</span></label>
                           <input type="text" name="seat" class="form-control"
                              placeholder="NO. OF SEAT" value="">
                        </div>
                     </div>
                     <div class="col-6 p-2">
                        <div class="form-group">
                           <label for="salesStopDate">Sales Stop Date <span class="text-danger">*</span></label>
                           <input type="date" id="salesStopDate" name="sales_stop_date"
                              class="form-control"
                              value="" oninput="validateYear(this)">
                        </div>
                     </div>
                  </div>

                  <div class="row">
                                                <div class="col-12">
                                                    <label for="rate-type">Select Rate Type:</label>
                                                    <select class="form-control" name="rate_type" id="rate-type" onchange="showFields()">
                                                        <option value="">--Select--</option>
                                                        <option value="adult">Adult</option>
                                                        <option value="child">Child</option>
                                                        <option value="infant">Infant</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="rate-fields" class="rate-fields">
                                                <div class="row">
                                                    <div class="col-12 p-2">
                                                        <span class="font-weight-bold" style="font-size: 20px;">PURCHASE DETAILS</span>
                                                    </div>
                                                    <div class="col-3 p-2">
                                                        <div class="form-group">
                                                            <label for="base-rate">BASE FAIR<span class="text-danger">*</span></label>
                                                            <input type="text" name="base_fair" id="base-rate" class="form-control" placeholder="BASE FAIR">
                                                        </div>
                                                    </div>
                                                    <div class="col-3 p-2">
                                                        <div class="form-group">
                                                            <label for="tax">PURCHASE TAX<span class="text-danger">*</span></label>
                                                            <input type="text" name="tax" class="form-control" placeholder="PURCHASE TAX">
                                                        </div>
                                                    </div>
                                                    <div class="col-3 p-2">
                                                        <div class="form-group">
                                                            <label for="charges">Our Taxes & Fees / Charges <span class="text-danger">*</span></label>
                                                            <input type="text" name="charges" class="form-control" placeholder="Our Taxes & Fees / Charges">
                                                        </div>
                                                    </div>
                                                    <div class="col-3 p-2">
                                                        <div class="form-group">
                                                            <label for="public-rate">PUB RATE<span class="text-danger">*</span></label>
                                                            <input type="text" name="p_tax" class="form-control" placeholder="PUB RATE">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                  <div class="row">
                     <div class="col-12">
                        <label for="">
                        <span class="font-weight-bold" style="font-size: 20px;">T&C / Cancellaion Policy </span>
                        </label>
                     </div>
                     <div class="col-12 p-2">
                        <div class="form-group">
                           <textarea style="width:100%" name="term" id="" cols="150" rows="8"></textarea>
                        </div>
                     </div>
                  </div>
                  <br><br>
                  &nbsp;
                  <button type="submit" class="btn btn-primary mr-3 ">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   function oneWay() {
       document.getElementById('chkWay').value = 'one_way';
       document.getElementById('return_date_section').style.display = 'none'; // Hide return date section
   }

   function twoWay() {
       document.getElementById('chkWay').value = 'two_way';
       document.getElementById('return_date_section').style.display = 'block'; // Show return date section
   }
</script>
@endsection