@extends('front-side.layout.mainlayout')
@section('content')
<!-- end row -->

   <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li>
                            <a href="javascript:void(0);">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('crm.index') }}">Crm</a>
                        </li>
                        <li class="active">
                            Add New Crm
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Add New Crm</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card-box">
                <form action="{{ route('roles.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" placeholder="Enter Client Name" class="form-control " value="{{ old('name') }}" autocomplete="off">
                                @if ($errors->has('name')) <p style="color:red;">{{ $errors->first('name') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Email<span class="text-danger">*</span></label>
                                <input type="text" name="email" placeholder="Enter Email" class="form-control " value="{{ old('email') }}" autocomplete="off">
                                @if ($errors->has('email')) <p style="color:red;">{{ $errors->first('email') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Place<span class="text-danger">*</span></label>
                                <input type="text" name="place" placeholder="Enter Place" class="form-control " value="{{ old('place') }}" autocomplete="off">
                                @if ($errors->has('place')) <p style="color:red;">{{ $errors->first('place') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="con_coun_code">Country Code<span class="text-danger">*</span></label>
                                <select name="phone_coun_code" class="form-control  select2">
                                    <option value="">Select Country Code</option>
                                    <option value="91">+91</option>
                                </select>
                                @if ($errors->has('phone_coun_code')) <p style="color:red;">{{ $errors->first('phone_coun_code') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Phone number<span class="text-danger">*</span></label>
                                <input type="text" name="phone_number" placeholder="Enter Phone Number" class="form-control  " value="{{ old('phone_number') }}" autocomplete="off">
                                @if ($errors->has('phone_number')) <p style="color:red;">{{ $errors->first('phone_number') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="con_coun_code">Country Code<span class="text-danger">*</span></label>
                                <select name="whatsapp_coun_code" class="form-control select2">
                                    <option value="">Select Country Code</option>
                                    <option value="91">91</option>
                                </select>
                                @if ($errors->has('whatsapp_coun_code')) <p style="color:red;">{{ $errors->first('whatsapp_coun_code') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Whatsapp Number<span class="text-danger">*</span></label>
                                <input type="text" name="whatsapp_number" placeholder="Enter Whatsapp Number" class="form-control " value="{{ old('whatsapp_number') }}" autocomplete="off">
                                @if ($errors->has('whatsapp_number')) <p style="color:red;">{{ $errors->first('whatsapp_number') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="service">Service<span class="text-danger">*</span></label>
                                <select name="service" class="form-control select2">
                                    <option value="">Select Service</option>
                                     @if (!(empty($services)))
                                        @foreach($services as $service)
                                              <option value="{{ $service['id'] }}">{{ $service['name'] }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('service')) <p style="color:red;">{{ $errors->first('service') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="air_tkt_flds"></div>
                            <div class="intr_air_tkt_flds"></div>
                        </div>
                    </div>

                    <div class="form-group text-right m-b-0">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">SAVE</button>
                        <button type="reset" class="btn btn-danger waves-effect m-l-5">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-box -->
        </div><!-- end col-->
    </div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function () {
            $(".select2").select2();

            $(document).on('change','select[name="service"]',function(){
                var id = $(this).val();
                $('.sim_card_field,.insurance_flds,.air_tkt_flds,.intr_air_tkt_flds,.visa_flds,.hotel_flds,.memberProgram_flds').html('');
                if(id == 25){ // INTERNATION SIM CARD
                    var field = sim_card_flds();
                    $('.sim_card_field').html(field).find('input').first().focus();
                } else if(id == 10){ // INSURANCE
                    var field = insurance_flds();
                    $('.insurance_flds').html(field).find('select').selectpicker();
                    $('.insurance_flds').find('input').first().focus();
                } else if(id == 4){ // DOMESTIC AIR TICKET
                    var field = air_tkt_flds();
                    $('.air_tkt_flds').html(field).find('select').selectpicker();
                    $('.air_tkt_flds').find('input').first().focus();
                } else if(id == 1){// INTERNATIONAL AIR TICKET
                    var field = air_tkt_flds('intr_air');
                    $('.intr_air_tkt_flds').html(field).find('select');
                    $('.intr_air_tkt_flds').find('input').first().focus();
                } else if(id == 19){ // VISA
                    var field = visa_flds();
                    set_selectbox('visa_country');
                    $('.visa_flds').html(field);
                    ticketNameSelect2('visa_applicant_name','#frm-crm');
                    countryNameSelect2('visa_country','#frm-crm');
                    $('.visa_flds').find('input').first().focus();
                } else if(id == 9){ // HOTEL
                    var field = hotel_flds();
                    // set_selectbox('visa_country');
                    $('.hotel_flds').html(field).find('select').selectpicker();
                    $('.hotel_flds').find('input').first().focus();
                } else if(id == 12){ // MEMBERSHIP PROGRAMS
                    var field = membershipProgram_flds();
                    // set_selectbox('airline_name');
                    $('.memberProgram_flds').html(field);
                    ticketNameSelect2('client_name_select','#frm-crm');
                    airlineNameSelect2('airline_name_select','#frm-crm');
                    $('.memberProgram_flds').find('input').first().focus();
                }
            });
        });

        function air_tkt_flds(service = '')
        {
            var fld = '';
            fld +='<div class="row">';
                fld +='<div class="col-md-12">';
                    fld +='<div class="form-group">';
                        fld +='<label>SECTORE</label>';
                        fld +='<input type="text" class="form-control" name="'+service+'sectore[]" placeholder="Enter Sectore">';
                    fld +='</div>';
                fld +='</div>';
            fld +='</div>';
            fld +='<div class="air_tkt_sctor"></div>';
            return fld;
        }

        $('body').on('blur','input[name="sectore[]"],input[name="intr_airsectore[]"]',function(){
            var val = $(this).val().trim();
            var flds = '';

            if(val != ''){
                var service = '';
                if($(this).attr('name') == 'intr_airsectore[]'){
                    service = 'intr_';
                }
                $('.air_tkt_sctor').html('');
                var sctor = val.split(',');
                $.each(sctor,function(i,v){
                    $('.air_tkt_sctor').append('<div class="panel panel-default"><div class="panel-heading"><b>'+v+'</b></div><div class="panel-body air_sctor_bdy'+i+'">');
                    /*AMD BOM AMD,AMD BOM--BOM DEL--DEL AMD,AMD BOM*/
                    if(v != ''){
                        flds = air_tkt_sactor_flds(v.toUpperCase(),i,service);
                        $('.air_sctor_bdy'+i).append(flds).find('.pick-date').datepicker({
                            // maxDate: new Date(),
                            startDate: new Date(),
                            format: 'dd-mm-yyyy',
                            todayBtn:  1,
                            autoclose: 1,
                        });
                        set_selectbox('air_tktinquiry'+i+'[]');
                        $('.air_tkt_sctor').append('</div></div>');
                    }
                });
                getclassboooking();
            } else {
                $('.air_tkt_sctor').html('');
            }
            $('.air_tkt_sctor').find('.air_sctor_bdy0').find('.sctor-list').find('input[name="intr_route_date0[]"]').first().focus();
        });

        function air_tkt_sactor_flds(route,i,service)
        {
            var fld = '';
            fld +='<div class="sctor-list">';
                fld +='<div class="row">';
                    var totSctor = route.split(' ');
                    if(totSctor.length == 3 && totSctor[1].length == 3){ /*AMD BOM AMD*/
                        fld +='<div class="route-3">';
                            fld += get_air_date(totSctor[0].toUpperCase()+' '+totSctor[1].toUpperCase(),i,service,i);
                            fld += get_air_date(totSctor[1].toUpperCase()+' '+totSctor[2].toUpperCase(),i,service,parseInt(i)+1);
                        fld +='</div>';
                    } else if(totSctor.length == 2){ /*AMD BOM*/
                        fld += get_air_date(totSctor[0].toUpperCase()+' '+totSctor[1].toUpperCase(),i,service);
                    } else { /*AMD BOM--BOM DEL--DEL AMD*/
                        totSctor = route.split('--');
                        $.each(totSctor,function(a,k){
                            fld +='<div class="route-3">';
                                fld += get_air_date(k.toUpperCase(),i,service,a);
                                /*fld += get_to_air_date(k.toUpperCase(),i,service);*/
                            fld +='</div>';
                        });
                    }
                    if(route.length > 20){
                        var route = route.substring(0,20)+'...';
                    }
                fld +='</div>';
                fld +='<div class="row">';
                    fld +='<div class="col-md-4">';
                        fld +='<div class="form-group">';
                            fld +='<label> PREFERABLE AIRLINE:</label>';
                            fld +='<input type="text" class="form-control airline_name srch-input" name="'+service+'air_prfble[]" ng-model="airlineName" ng-keyup="AirlineComplete(airlineName)" placeholder="Enter Preferable Airline" autocomplete="off">';
                            fld +='<ul class="list-group airline-list wrapper-select" style="width: 400px;"></ul>';
                        fld +='</div>';
                    fld +='</div>';
                    fld +='<div class="col-md-4">';
                        fld +='<div class="form-group">';
                            fld +='<label> CLASS OF BOOKING:</label>';
                            fld +='<div class="hero-select" >';
                                fld +='<select class="form-control class_of_booking" name="'+service+'air_class[]" title="Select Class"></select>';
                            fld +='</div>';
                        fld +='</div>';
                    fld +='</div>';
                    fld +='<div class="col-md-3">';
                        fld +='<div class="form-group">';
                            fld +='<label>BILLING:</label>';
                            fld +='<input type="hidden" name="'+service+'billing_id[]" class="form-control billing-id">';
                            fld +='<input type="text" name="'+service+'billing[]" class="form-control open-account srch-input" data-type="SUNDRY DEBTORS" placeholder="ENTER BILLING NAME">';
                            fld += '<ul class="list-group open-account-list wrapper-select" style="width:96%; display: none;"></ul>';
                        fld +='</div>';
                    fld +='</div>';
                    fld +='<div class="col-md-1" style="margin-top: 35px;">';
                        fld +='<div class="form-group">';
                            fld +='<label></label>';
                            fld +='<a class="btn btn-default othr-domestic"><span class="glyphicon glyphicon-plus"></span></a>';
                        fld +='</div>';
                    fld +='</div>';
                fld +='</div>';
                fld +='<div class="sctionothr-domestic" style="display:none">';
                    fld +='<div class="row">';
                        fld +='<div class="col-md-12">';
                            fld +='<div class="form-group">';
                                fld +='<label>Other:</label>';
                                fld +='<textarea class="form-control" name="domestic_other[]" placeholder="Enter other"></textarea>';
                            fld +='</div>';
                        fld +='</div>';
                    fld +='</div>';
                fld +='</div>';
                fld +='<div class="row">';
                    fld +='<div class="col-md-4">';
                        fld +='<div class="form-group">';
                            fld +='<label> Adults (Above 12 years):</label>';
                            fld +='<input type="text" class="form-control" name="'+service+'air_adult[]" placeholder="Enter No Of Persons">';
                        fld +='</div>';
                    fld +='</div>';
                    fld +='<div class="col-md-4">';
                        fld +='<div class="form-group">';
                            fld +='<label> Childs (Between 3 to 12 years):</label>';
                            fld +='<input type="text" class="form-control" name="'+service+'air_child[]" id="ticket_no_of_persons" placeholder="Enter No Of Persons">';
                        fld +='</div>';
                    fld +='</div>';
                    fld +='<div class="col-md-4">';
                        fld +='<div class="form-group">';
                            fld +='<input type="hidden" name="rcord" value="'+i+'">';
                            fld +='<label> Infant (Below 2 years):</label>';
                            fld +='<input type="text" class="form-control" name="'+service+'air_infnit[]" id="ticket_no_of_persons" placeholder="Enter No Of Persons">';
                        fld +='</div>';
                    fld +='</div>';
                fld +='</div>';
                fld +='<div class="infant-dob">';
                fld +='</div>';
                fld += get_remark_fld(route,service+'air_tkt_remark');
                fld += get_attchmnt_fld(route,i,service+'air_tkt_file'+i+'[]');
                fld +='<div class="row">';
                    fld += get_inquiry_fld(route,i,'air_tkt');
                fld +='</div>';
            fld +='</div>';
            return fld;
        }

        function get_air_date(route,i,service,position = 0)
        {
            fld ='<div class="col-md-6">';
                fld +='<div class="form-group">';
                    fld +='<label><b>'+route+'</b> DATE:</label>';
                    fld +='<input type="hidden" name="'+service+'route_'+i+'[]" value="'+route+'">';
                    fld +='<input type="text" data-id="'+position+'" id="rutett'+position+'" class="form-control pick-date route_date"  name="'+service+'route_date'+i+'[]" placeholder="Enter Date">';
                fld +='</div>';
            fld +='</div>';
            return fld;
        }

        function get_remark_fld(name,textareaName)
        {
            var fld = '';
            fld +='<div class="row">';
                fld +='<div class="col-md-12">';
                    fld +='<div class="form-group">';
                        fld +='<label>REMARK</label>';
                        fld +='<textarea class="form-control" rows="4" name="'+textareaName+'[]" placeholder="ENTER REMARK"></textarea>';
                    fld +='</div>';
                fld +='</div>';
            fld +='</div>';
            return fld;
        }

        function get_attchmnt_fld(name,i,fileName)
        {
            var fld = '';
            fld +='<div class="row">';
                fld +='<div class="col-md-12">';
                    fld +='<div class="form-group">';
                        fld +='<div class="pview">';
                        fld +='</div>';
                        fld +='<label>Attachment :</label>';
                        fld +='<input type="file" class="form-control" name="'+fileName+'" multiple>';
                    fld +='</div>';
                fld +='</div>';
            fld +='</div>';

            return fld;
        }

        function get_inquiry_fld(name,i,fldname = '')
        {
            //var fld = '<div class="row">';
                fld ='<div class="col-md-12">';
                    fld +='<div class="form-group inquiry">';
                        fld +='<label>INQUIRY GIVEN TO</label>';
                        fld +='<select class="form-control inquiry_given" multiple="true" name="'+fldname+'inquiry'+i+'[]" style="width:100%">';
                            // fld += empOption;
                        fld +='</select>';
                    fld +='</div>';
                fld +='</div>';
            //fld +='</div>';
            return fld;
        }
    </script>
@endpush
