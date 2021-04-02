<html>
<heade></heade>
<body>
<h1>User's Apis</h1>
<p>Send a following parameters  with header:</p>
<ul>
    <li>goods_key->5f58fd92390de</li>
    <li>Accept->application/json</li>
    <li>Authorization->{ access_token } take value from login</li>
</ul>

@php
    $base_url = "http://dev-elopers.com/api/";
    $apis[0]['id']="1";
    $apis[0]['method']="get";
    $apis[0]['name']="get user profile data";
    $apis[0]['url']= $base_url."users";
    $apis[0]['parameters']="";
    $apis[0]['error']= asset('public/temp_apis/users/error.png');
    $apis[0]['response']= asset('public/temp_apis/users/profile.png');


    $apis[1]['id']="2";
    $apis[1]['method']="put";
    $apis[1]['name']="update user data";
    $apis[1]['url']= $base_url."users";
    $apis[1]['parameters']="-name <br> -email <br> -username <br> -phone_number <br> -address ";
    $apis[1]['error']= asset('public/temp_apis/register_error.png');
    $apis[1]['response']= asset('public/temp_apis/update.png');

    $apis[2]['id']="3";
    $apis[2]['method']="post";
    $apis[2]['name']="change user password";
    $apis[2]['url']= $base_url."users";
    $apis[2]['parameters']="-password <br> -password_confirmation <br> -old_password";
    $apis[2]['error']= asset('public/temp_apis/users/password_error.png');
    $apis[2]['response']= asset('public/temp_apis/users/change_password.png');


    $apis[3]['id']="4";
    $apis[3]['method']="get";
    $apis[3]['name']="user's products";
    $apis[3]['url']= $base_url."users/products";
    $apis[3]['parameters']="";
    $apis[3]['error']= asset('public/temp_apis/users/password_error.png');
    $apis[3]['response']= asset('public/temp_apis/users/change_password.png');

$apis[4]['id']="5";
    $apis[4]['method']="post";
    $apis[4]['name']="add product";
    $apis[4]['url']= $base_url."users/products";
    $apis[4]['parameters']="-name <br> -details <br> - main_image (file or base 64) - <br> category_id (integer) - <br> price (double) <br> discount_price (double) <br> city_id (integer) <br> address <br> extra_images[] ('','')";
    $apis[4]['error']= asset('public/temp_apis/404.png');
    $apis[4]['response']= asset('public/temp_apis/add.png');


$apis[5]['id']="6";
    $apis[5]['method']="post";
    $apis[5]['name']="edit product";
    $apis[5]['url']= $base_url."users/products";
    $apis[5]['parameters']="-name <br> -details <br> - main_image (file or base 64) - <br> category_id (integer) - <br> price (double) <br> discount_price (double) <br> city_id (integer) <br> address <br> product_id (integer - belong to products)";
    $apis[5]['error']= asset('public/temp_apis/404.png');
    $apis[5]['response']= asset('public/temp_apis/update.png');


$apis[6]['id']="7";
    $apis[6]['method']="post";
    $apis[6]['name']="add extra image to product";
    $apis[6]['url']= $base_url."users/products/images";
    $apis[6]['parameters']="-product_id <br> extra_images[] ('',''))";
    $apis[6]['error']= asset('public/temp_apis/404.png');
    $apis[6]['response']= asset('public/temp_apis/add.png');



$apis[7]['id']="8";
    $apis[7]['method']="get";
    $apis[7]['name']="get hidden products";
    $apis[7]['url']= $base_url."users/products/archive";
    $apis[7]['parameters']="";
    $apis[7]['error']= asset('public/temp_apis/no_data.png');
    $apis[7]['response']= "";

$apis[8]['id']="9";
    $apis[8]['method']="post";
    $apis[8]['name']="hide  product";
    $apis[8]['url']= $base_url."users/products/archive";
    $apis[8]['parameters']="product_id";
    $apis[8]['error']= asset('public/temp_apis/no_data.png');
    $apis[8]['response']= asset('public/temp_apis/add.png');





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
