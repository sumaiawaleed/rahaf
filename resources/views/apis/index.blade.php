<html>
<heade></heade>
<body>
<h1>general</h1>
<p>Send a key with header goods_key=5f58fd92390de</p>

@php
    $base_url = "http://dev-elopers.com/goods/api/";
    $apis[0]['id']="1";
    $apis[0]['method']="get";
    $apis[0]['name']="return all products";
    $apis[0]['url']= $base_url."products";
    $apis[0]['parameters']=" -search<br> -city_id<br> -category_id<br> -user_id<br> ";
    $apis[0]['response']= asset('public/temp_apis/products.png');


    $apis[1]['id']="2";
    $apis[1]['method']="get";
    $apis[1]['name']="return all categories";
    $apis[1]['url']= $base_url."categories";
    $apis[1]['parameters']=" ";
    $apis[1]['response']= asset('public/temp_apis/categories.png');

    $apis[3]['id']="3";
    $apis[3]['method']="get";
    $apis[3]['name']="home";
    $apis[3]['url']= $base_url."home";
    $apis[3]['parameters']=" ";
    $apis[3]['response']= asset('public/temp_apis/home.png');

 $apis[2]['id']="4";
    $apis[2]['method']="get";
    $apis[2]['name']="product details";
    $apis[2]['url']= $base_url."products/{id}";
    $apis[2]['parameters']=" ";
    $apis[2]['response']= asset('public/temp_apis/product_details.png');


 $apis[4]['id']="5";
    $apis[4]['method']="get";
    $apis[4]['name']="product reviews";
    $apis[4]['url']= $base_url."products/{id}/reviews";
    $apis[4]['parameters']=" ";
    $apis[4]['response']= asset('public/temp_apis/reviews.png');

 $apis[5]['id']="6";
    $apis[5]['method']="get";
    $apis[5]['name']="cities";
    $apis[5]['url']= $base_url."cities";
    $apis[5]['parameters']=" ";
    $apis[5]['response']= asset('public/temp_apis/cities.png');


@endphp
<table border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>#</th>
        <th>method</th>
        <th>name</th>
        <th>request url</th>
        <th>parameters</th>
        <th>response</th>
    </tr>

    @foreach($apis as $api)
        <tr>
            <td>{{ $api['id'] }}</td>
            <td>{{ $api['method'] }}</td>
            <td>{{ $api['name'] }}</td>
            <td><a target="_blank" href="{{ $api['url'] }}">{{ $api['url'] }}</a></td>
            <td>{!! $api['parameters'] !!}</td>
            <td><a target="_blank" href="{{ $api['response'] }}">view</a></td>
        </tr>
    @endforeach
</table>
</body>
</html>
