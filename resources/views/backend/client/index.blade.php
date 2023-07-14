@extends('layouts.backend')

@section('title')
  Clients
@endsection

@section('content')
  <div class="portlet-title">
    <div class="alert alert-success" id="status-change-alert">
      Status Changed Sucessfully.
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Client
          <small class="font-green sbold">List</small>
        </h1>
      </div>

      @include('backend.client._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('clients.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'username-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('clients.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'username-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Email</th>
          <th class="text-center">View Detail</th>
          <th class="text-center">Verified</th>
          @if(auth()->user()->can('edit_clients') || auth()->user()->can('delete_clients'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($clients as $client)
          <tr>
            <td>{{ reversePagination($clients, $loop) }}</td>                      
            <td>
              {{ $client->username }}
            </td>
            <td>
              {{ $client->email }}
            </td>
            <td class="text-center">
              <a href="{{ route('clients.resultIndex', $client->id) }}">View Detail</a>
            </td>
            @if(auth()->user()->can('edit_clients'))
              <td class="text-center">
                <label class="toggle-switch">
                  <input type="checkbox" class="changeStatus{{$client->id}}" @if($client->verified == 1) checked @endif>
                  <span class="toggle-slider round"></span>
                </label>
              </td>
            @else
              <td class="text-center">
                @if($client->verified == 1)
                  <span style="font-size: 12px;" class="label label-success">Active</span>
                @else
                  <span style="font-size: 12px;" class="label label-danger">Inactive</span>
                @endif
              </td>
            @endif
            @if(auth()->user()->can('view_clients') || auth()->user()->can('edit_clients') || auth()->user()->can('delete_clients'))
              <td class="text-center">
                @can('view_clients')
                  <a href="{{ route('clients.show', $client->id) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_clients')
                  <a href="{{ route('clients.edit', $client->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_clients')
                  @if($client->deleted_at == null)
                    {!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['clients.restore', $client->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['clients.forceDestroy', $client->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-force-delete"
                          title="Force Delete"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    {!! Form::close() !!}
                  @endif
                @endcan
              </td>
            @endif
          </tr>
        @empty
          <tr class="text-center">
            <td colspan="7">No data available in table</td>
          </tr>
        @endforelse
      </tbody>
      </table>
    </div>
  </div>
  <div class="portlet-footer text-center">
    {{ $clients->appends(request()->input())->links() }}
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($clients as $client)
        $('.changeStatus'+'{{$client->id}}').click(function () {
          var clientId = {{$client->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : "{{route('clients.changeStatus', '')}}/"+clientId,
            data     : {status: val},
            success: function(response){
              if (response.success) {
                $("#status-change-alert").show();
                $('#status-change-alert').delay(3000).fadeOut(1000);
              }
            },
            error: function(response){
              alert("There was some internal error while updating the status.");
              window.location.reload(); 
            },
          });
        });
      @endforeach
    });
  </script>
@endsection
