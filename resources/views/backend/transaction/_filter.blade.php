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
            <a href="{{ route('transactions.index') }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('transactions.index', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('transactions.index', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('transaction-type') != null)
        {{ request('transaction-type') }}
      @else
        Transaction Type
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('transactions.index') }}">
              All
            </a>
        </li>
        @foreach($transaction_types as $transaction_type)
          <li>
            <a href="{{ route('transactions.index', array_merge(Request::all(), ['filter_by' => 'transaction-type', 'transaction-type' => $transaction_type ])) }}">
              {{ $transaction_type }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('payment-type') != null)
        {{ request('payment-type') }}
      @else
        Payment Type
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('transactions.index') }}">
              All
            </a>
        </li>
        @foreach($payment_types as $payment_type)
          <li>
            <a href="{{ route('transactions.index', array_merge(Request::all(), ['filter_by' => 'payment-type', 'payment-type' => $payment_type ])) }}">
              {{ $payment_type }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>
</div>

<div class="row">
  <div class="range-filter col-md-6">
      <span class="filter-span">Nepali Date: </span>
      <form>
        <div class="input-group input-group-sm">

            <input type="text" name="from_transactionPeriod" value="{{ request('from_transactionPeriod') }}" class="form-control" id="from-nepali-date" placeholder="From Date"  style="width: 50%">

            <input type="text" name="till_transactionPeriod" value="{{ request('till_transactionPeriod') }}" class="form-control" id="to-nepali-date" placeholder="Till Date"  style="width: 50%">

            <span class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
      </form>
  </div>

  <div class="range-filter col-md-6">
      <span class="filter-span">Payment Amount: </span>
      <form>
        <div class="input-group input-group-sm">

            <input type="number" name="min_paymentAmount" value="{{ request('min_paymentAmount') }}"
                   class="form-control" placeholder="Min Amount"  style="width: 50%">

            <input type="number" name="max_paymentAmount" value="{{ request('max_paymentAmount') }}"
                   class="form-control" placeholder="Max Amount"  style="width: 50%">

            <span class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>

      </form>
  </div>
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
              <a href="{{ route('transactions.index') }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('transactions.index', array_merge(Request::all(), ['show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('transactions.index', array_merge(Request::all(), ['show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('transactions.index', array_merge(Request::all(), ['show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('transactions.index', array_merge(Request::all(), ['show-items' => $total_transaction])) }}">
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