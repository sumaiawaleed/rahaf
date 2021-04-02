@foreach($data['products'] as $row)
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
        <div class="card">
            <img class="card-img-top" src="{{ $row->image_path }}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </p>
            </div>
        </div>
    </div>

@endforeach
