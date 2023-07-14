<div class="filter">
  <label>&nbsp Filters: </label>
  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('deleted-items') != null)
        {{ request('deleted-items') }}
      @else
        Filter by Deleted Items
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('examination-questions.index', $set->slug) }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('examination-questions.index', array_merge(Request::all(), ['set_type' => $set->slug, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('examination-questions.index', array_merge(Request::all(), ['set_type' => $set->slug, 'filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('subject') != null)
        {{ request('subject') }}
      @else
        Subject
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('examination-questions.index', $set->slug) }}">
              All
            </a>
        </li>

        @foreach($subjects as $subject)
          <li>
            <a href="{{ route('examination-questions.index', array_merge(Request::all(), ['set_type' => $set->slug, 'filter_by' => 'subject', 'subject' => $subject ])) }}">
              {{ $subject }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('marks') != null)
        {{ request('marks') }}
      @else
        Marks
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('scholarship-test.index', $set->slug) }}">
              All
            </a>
        </li>

        @foreach($marks as $mark)
          <li>
            <a href="{{ route('examination-questions.index', array_merge(Request::all(), ['set_type' => $set->slug, 'filter_by' => 'marks', 'marks' => $mark ])) }}">
              {{ $mark }}
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
              <a href="{{ route('examination-questions.index', $set->slug) }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-questions.index', array_merge(Request::all(), ['set_type' => $set->slug, 'show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-questions.index', array_merge(Request::all(), ['set_type' => $set->slug, 'show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-questions.index', array_merge(Request::all(), ['set_type' => $set->slug, 'show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-questions.index', array_merge(Request::all(), ['set_type' => $set->slug, 'show-items' => $total_examination_question])) }}">
                All
              </a>
          </li>
      </ul>
    </li>
  </div>

  <div class="search">
   <form>
      <div class="input-group input-group-sm">
        <input type="text" name="search-item" value="{{ request('search-item') }}" class="form-control pull-right" placeholder="Search">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
  </div>
</div>