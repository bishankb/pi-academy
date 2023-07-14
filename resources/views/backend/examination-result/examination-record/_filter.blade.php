<div class="filter">
  <label>&nbsp Filters: </label>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('set') != null)
        {{ request('set') }}
      @else
        Question Set
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('examination-results.index', $student->id) }}">
              All
            </a>
        </li>

        @foreach($question_sets as $set)
          <li>
            <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'filter_by' => 'set', 'set' => $set->name ])) }}">
              {{ $set->name }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>
</div>

<div class="show-search">
  <div class="show-records">
    <li class="dropdown dropdown-inline">
      <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
        @if(request('show-items') != null)
          {{ request('show-items') }}
        @else
          10
        @endif
        <span class="caret"></span>
      </button>
      records
      <ul class="dropdown-menu">
          <li>
              <a href="{{ route('examination-results.index', $student->id) }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'show-items' =>  $total_examination_result])) }}">
                All
              </a>
          </li>
      </ul>
    </li>
  </div>
</div>
