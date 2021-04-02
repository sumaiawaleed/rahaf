<html>
<heade></heade>
<body>
<h1>Auth Apis</h1>
<p>Send a key with header goods_key=5f58fd92390de</p>

@php
    $base_url = "http://dev-elopers.com/goods/api/";
    $apis[0]['id']="1";
    $apis[0]['method']="post";
    $apis[0]['name']="Login";
    $apis[0]['url']= $base_url."auth/login";
    $apis[0]['parameters']=" -username<br> -password";
    $apis[0]['error']= asset('public/temp_apis/login_error.png');
    $apis[0]['response']= asset('public/temp_apis/login.png');


    $apis[1]['id']="2";
    $apis[1]['method']="register";
    $apis[1]['name']="create new user";
    $apis[1]['url']= $base_url."auth/signup";
    $apis[1]['parameters']="-name <br> -email <br> -username<br> -password <br> -phone_number <br> -address <br> -type";
    $apis[1]['error']= asset('public/temp_apis/register_error.png');
    $apis[1]['response']= asset('public/temp_apis/login.png');



 $apis[2]['id']="3";
    $apis[2]['method']="post";
    $apis[2]['name']="logout";
    $apis[2]['url']= $base_url."logout";
    $apis[2]['parameters']="-headers <ul> <li>Accept->application/json</li>
    <li>Authorization->{ access_token } take value from login</li></ul>";
    $apis[2]['error']= "code status 401";
    $apis[2]['response']= asset('public/temp_apis/logout.png');


@endphp

<table border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>#</th>
        <th>method</th>
        <th>name</th>
        <th>request url</th>
        <th>parameters</th>
        <th>error</th>
        <th>response</th>
    </tr>

    @foreach($apis as $api)
        <tr>
            <td>{{ $api['id'] }}</td>
            <td>{{ $api['method'] }}</td>
            <td>{{ $api['name'] }}</td>
            <td><a target="_blank" href="{{ $api['url'] }}">{{ $api['url'] }}</a></td>
            <td>{!! $api['parameters'] !!}</td>
            <td><a target="_blank" href="{{ $api['error'] }}">view</a></td>
            <td><a target="_blank" href="{{ $api['response'] }}">view</a></td>
        </tr>
    @endforeach
</table>
</body>
</html>
