@foreach($data['categories'] as $c)
    <option {{ $id == $c->id ? "selected" : "" }} value="{{ $c->id }}">{{ $c->name }}</option>
@endforeach
