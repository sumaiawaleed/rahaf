@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if (Session::has('failure'))
    @if(Session::get('failure') !='')
        <div class="alert alert-danger">
            <p><?php echo Session::get('failure');?></p>
        </div>
        <br />
    @endif
@endif