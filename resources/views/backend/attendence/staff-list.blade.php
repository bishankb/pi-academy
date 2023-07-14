@extends('layouts.backend')

@section('title')
  Staff List
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Staff
          <small class="font-green sbold">List</small>
        </h1>
      </div>

      @include('backend.attendence._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('attendence.staff-list', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('attendence.staff-list', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Designation</th>
          <th class="text-center">Total hr/week</th>
          <th class="text-center">Total hr/month</th>
          <th class="text-center">Total hr/year</th>
          @can('view_attendences')
            <th>Attendence</th>
          @endcan
        </tr>
      </thead>
      <tbody>
        @php
          use Carbon\Carbon;

          Carbon::setWeekStartsAt(Carbon::SUNDAY);
          Carbon::setWeekEndsAt(Carbon::SATURDAY);

          if(request('select_date') != null) {
            $startDay_week = Carbon::parse(request('select_date'))->startOfWeek();
            $endDay_week = Carbon::parse(request('select_date'))->endOfWeek();
            
            $startDay_month = Carbon::parse(request('select_date'))->startOfMonth();
            $endDay_month = Carbon::parse(request('select_date'))->endOfMonth();

            $startDay_year = Carbon::parse(request('select_date'))->startOfYear();
            $endDay_year = Carbon::parse(request('select_date'))->endOfYear();
          } else {
            $startDay_week = Carbon::parse($current_nepali_date)->startOfWeek();
            $endDay_week = Carbon::parse($current_nepali_date)->endOfWeek();
            
            $startDay_month = Carbon::parse($current_nepali_date)->startOfMonth();
            $endDay_month = Carbon::parse($current_nepali_date)->endOfMonth();

            $startDay_year = Carbon::parse($current_nepali_date)->startOfYear();
            $endDay_year = Carbon::parse($current_nepali_date)->endOfYear();
          }
        @endphp
        @forelse($staffs as $staff)
          <tr>
            <td>{{ pagination($staffs, $loop) }}</td>                      
            <td>
              {{ $staff->name }}
            </td>
            <td>
              {{ $staff->role->display_name }}
            </td>
            <td class="text-center">
              {{ $staff->attendences()->whereBetween('nepali_attendence_date', [$startDay_week, $endDay_week])->sum('worked_hour')}}  hr
            </td>
            <td class="text-center">
              {{ $staff->attendences()->whereBetween('nepali_attendence_date', [$startDay_month, $endDay_month])->sum('worked_hour')}}  hr
            </td>
            <td class="text-center">
              {{ $staff->attendences()->whereBetween('nepali_attendence_date', [$startDay_year, $endDay_year])->sum('worked_hour')}}  hr
            </td>

            @if(auth()->user()->can('view_attendences'))
              <td>
                <a href="{{ route('attendence.index', $staff->id) }}">Manage</a>
              </td>
            @endif
          </tr>
        @empty
          <tr class="text-center">
            <td colspan="6">No data available in table</td>
          </tr>
        @endforelse
      </tbody>
      </table>
    </div>
  </div>
  <div class="portlet-footer text-center">
    {{ $staffs->appends(request()->input())->links() }}    
  </div>
@endsection