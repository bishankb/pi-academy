@extends('layouts.backend')

@section('title')
  Create Student
@endsection

@section('backend-style')
    <style>
        #knownFromOther_div {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Student
                    <small class="font-green sbold">Create</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model(null, ['method' => 'post', 'route' => ['student-registration.store'], 'files' => 'true']) !!}
        <div class="portlet-body">
    
            @include('backend.student-registration._form')
        
        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('student-registration.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Save
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('backend-script')
    <script type="text/javascript">
        $("#total_fee").keyup(function(){
            var totalFee = $(this).val();
            $("#fee_after_scholarship").val(Math.round(totalFee));

            var scholarship = $("#scholarship").val();
            if(scholarship) {
                var feeAfterScholarship = totalFee - ( scholarship / 100 * totalFee);
                $("#fee_after_scholarship").val(Math.round(feeAfterScholarship));
            }
            var feeAfterScholarship = $("#fee_after_scholarship").val();
            if(scholarship) {
                var scholarship = ((totalFee - feeAfterScholarship) / totalFee ) * 100;
                $("#scholarship").val((Math.round((scholarship * 1000)/10)/100).toFixed(2));
            }
        });

        $("#scholarship").keyup(function(){
            var scholarship = $(this).val();
            var totalFee = $("#total_fee").val();
            var feeAfterScholarship = totalFee - ( scholarship / 100 * totalFee);
            $("#fee_after_scholarship").val(Math.round(feeAfterScholarship));
        });

        $("#fee_after_scholarship").keyup(function(){
            var feeAfterScholarship = $(this).val();
            var totalFee = $("#total_fee").val();
            var scholarship = ((totalFee - feeAfterScholarship) / totalFee ) * 100;
            $("#scholarship").val((Math.round((scholarship * 1000)/10)/100).toFixed(2));
        });

        $(document).ready(function() {
            @if(!empty(old('known_from')) && \App\StudentRegistration::KnownFrom[old('known_from')] == 'Others')
                $('#knownFromOther_div').show();
            @else
                $('#knownFromOther_div').hide();
            @endif
        });

        $('#known_from').change(function (event) {
            var knownFrom = event.target.value;
            var knownFroms = {!! json_encode(\App\StudentRegistration::KnownFrom, JSON_HEX_TAG) !!};
            if(knownFroms[event.target.value] == 'Others') {
                $('#knownFromOther_div').show();
            } else {
                $('#knownFromOther_div').hide();
                $('#known_from_other').val('');
            }
        });

        $("#english_dob").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        }).on("changeDate", function (e) {
            var selectedEnglishDate = $('#english_dob').val();
            var conversionType = $('#english_dob').attr('data-conversion-type');
            var newNepaliDate = $('#nepali_dob');
            englishToNepaliDate(selectedEnglishDate, conversionType, newNepaliDate);
            
        });

        $("#nepali_dob").nepaliDatePicker({
            dateFormat: "%y-%m-%d",
            closeOnDateSelect: true,
            npdMonth: true,
            npdYear: true,
            onChange: function(){
                var selectedNepaliDate = $('#nepali_dob').val();
                var conversionType = $('#nepali_dob').attr('data-conversion-type');
                var newEnglishDate = $('#english_dob');
                nepaliToEnglishDate(selectedNepaliDate, conversionType, newEnglishDate);                
            }
        });

        $("#english_due_clearance_date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        }).on("changeDate", function (e) {
            var selectedEnglishDate = $('#english_due_clearance_date').val();
            var conversionType = $('#english_due_clearance_date').attr('data-conversion-type');
            var newNepaliDate = $('#nepali_due_clearance_date');
            englishToNepaliDate(selectedEnglishDate, conversionType, newNepaliDate);
            
        });

        $("#nepali_due_clearance_date").nepaliDatePicker({
            dateFormat: "%y-%m-%d",
            closeOnDateSelect: true,
            npdMonth: true,
            npdYear: true,
            onChange: function(){
                var selectedNepaliDate = $('#nepali_due_clearance_date').val();
                var conversionType = $('#nepali_due_clearance_date').attr('data-conversion-type');
                var newEnglishDate = $('#english_due_clearance_date');
                nepaliToEnglishDate(selectedNepaliDate, conversionType, newEnglishDate);                
            }
        });

        $("#english_final_admission_date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        }).on("changeDate", function (e) {
            var selectedEnglishDate = $('#english_final_admission_date').val();
            var conversionType = $('#english_final_admission_date').attr('data-conversion-type');
            var newNepaliDate = $('#nepali_final_admission_date');
            englishToNepaliDate(selectedEnglishDate, conversionType, newNepaliDate);
            
        });

        $("#nepali_final_admission_date").nepaliDatePicker({
            dateFormat: "%y-%m-%d",
            closeOnDateSelect: true,
            npdMonth: true,
            npdYear: true,
            onChange: function(){
                var selectedNepaliDate = $('#nepali_final_admission_date').val();
                var conversionType = $('#nepali_final_admission_date').attr('data-conversion-type');
                var newEnglishDate = $('#english_final_admission_date');
                nepaliToEnglishDate(selectedNepaliDate, conversionType, newEnglishDate);                
            }
        });

        function englishToNepaliDate (selectedEnglishDate, conversionType, newNepaliDate) {
            $.ajax({
                type     : "GET",
                headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url      : "{{route('scholarship-test.date-converstion', '')}}/"+selectedEnglishDate,
                data     : {conversion_type: conversionType},
                success: function(response){
                  if (response.success) {
                    newNepaliDate.val(response.converted_date);
                  }
                },
                error: function(response){
                    alert("There was some internal error.");
                    window.location.reload();
                },
            });
        }

        function nepaliToEnglishDate (selectedNepaliDate, conversionType, newEnglishDate) {
            $.ajax({
                type     : "GET",
                headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url      : "{{route('scholarship-test.date-converstion', '')}}/"+selectedNepaliDate,
                data     : {conversion_type: conversionType},
                success: function(response){
                  if (response.success) {
                    newEnglishDate.val(response.converted_date);
                  }
                },
                error: function(response){
                  alert("There was some internal error.");
                  window.location.reload();
                },
            });
        }
    </script>
@endsection