@extends('layouts.backend')

@section('title')
  Edit Student
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Student
                    <small class="font-green sbold">Edit</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model($student_registration, ['method' => 'PUT', 'route' => ['student-registration.update',  $student_registration->id ], 'files' => 'true']) !!}
        <div class="portlet-body">
           
            @include('backend.student-registration._form')

        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('student-registration.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('backend-script')
    <script type="text/javascript">
        @if($student_registration->image1)
            $('#deleteImage1').click(function () {
                dataId = $('#deleteImage1').attr('data-target-id');
                dataType = $('#deleteImage1').attr('data-target-type');
                deleteImage(dataId, dataType);
            });
        @endif

        @if($student_registration->image2)
            $('#deleteImage2').click(function () {
                dataId = $('#deleteImage2').attr('data-target-id');
                dataType = $('#deleteImage2').attr('data-target-type');
                deleteImage(dataId, dataType);
            });
        @endif

        @if($student_registration->characterCertificate)
            $('#deleteCharacterCertificate').click(function () {
                dataId = $('#deleteCharacterCertificate').attr('data-target-id');
                dataType = $('#deleteCharacterCertificate').attr('data-target-type');
                deleteImage(dataId, dataType);
            });
        @endif

        @if($student_registration->scholarshipRecommendation)
            $('#deleteScholarshipRecommendation').click(function () {
                dataId = $('#deleteScholarshipRecommendation').attr('data-target-id');
                dataType = $('#deleteScholarshipRecommendation').attr('data-target-type');
                deleteImage(dataId, dataType);
            });
        @endif

        @if($student_registration->marksheetData)
            $('#deleteMarksheet').click(function () {
                dataId = $('#deleteMarksheet').attr('data-target-id');
                dataType = $('#deleteMarksheet').attr('data-target-type');
                deleteImage(dataId, dataType);
            });
        @endif

        function deleteImage(dataId, dataType) {
            $.ajax({
                type     : "POST",
                headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url      : "{{route('student-registration.destroyImage', '')}}/"+dataId,
                data     : {fileType: dataType},
                success: function(response){
                    if (response.success) {
                    }
                },
                error: function(data){
                    alert("There was some internal error while updating the status.");
                },
            });
        }

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
            @if(isset($student_registration->known_from) && \App\StudentRegistration::KnownFrom[$student_registration->known_from] == 'Others')
                $('#knownFromOther_div').show();
            @else 
                $('#knownFromOther_div').hide();                
            @endif

            var knownFroms = {!! json_encode(\App\StudentRegistration::KnownFrom, JSON_HEX_TAG) !!};
            var knownFromId = '{{ old('known_from') }}';
            var knownFrom = knownFroms[knownFromId];
            if(knownFrom && knownFrom == 'Others') {
                $('#knownFromOther_div').show();
            }
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