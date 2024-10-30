@extends('layouts.master')
@php $title = 'جستجو';
@endphp
@section('style')
#search-wrapper{
display: flex;
border: 1px solid rgba(0, 0, 0, 0.276);
align-items: stretch;
border-radius: 50px;
background-color: #fff;
overflow: hidden;
max-width: 400px;
box-shadow: 2px 1px 5px 1px rgba(0, 0, 0, 0.273);

}
#search{
border:none;
width:350px;
font-size: 15px;
}
#search:focus{
outline: none;
}
.search-icon{
margin: 10px;
color:rgba(0, 0, 0, 0.564);
}
#search-button{
border:none;
cursor: pointer;
color:#fff;
background-color:#1dbf73;
padding:0px 10px;
}

.user-profile{
border-radius: 20px ;
margin-left:3px;
width: 40px !important;
height: 40px !important;
}
.users{
margin-top: 20px;
display: flex;
position: absolute;
flex-direction: column;
padding: 20px;
flex-wrap: wrap;
}
.user{
display: flex;
align-item:center;
margin-top:20px;
padding:5px;
}
@endsection
@section('content')
<div style="display:flex;justify-content:center;margin-top:70px">
    <div id="search-wrapper">
        <i class="search-icon fas fa-search"></i>
        <input type="text" onkeyup="search()" id="search" placeholder="نام کاربری">
    </div>
<div id="users" class="users">
</div>
<script>
    var search = document.getElementById('search');
    search.addEventListener('focus', (event) => {

        document.getElementById('search-wrapper').style.border = "1px solid #1dbf73";

    });

    search.addEventListener('focusout', (event) => {

        document.getElementById('search-wrapper').style.border = "1px solid rgba(0, 0, 0, 0.276)";

    });
</script>
<script>
    function search() {
        var search = document.getElementById('search');
        data = $.ajax({
            url:  "/search?s=" + search.value,
            type: 'get',
            success: function() {
                var users = JSON.parse(data.responseText);
                document.getElementById('users').innerHTML = "";
                users.forEach(user => {
                    document.getElementById('users').innerHTML += `<div class="user">
                        <img class="user-profile" src="${user.avatar}">
                        <a href="/profile/${user.id}">${user.name}</a>
                    </div>`;
                });
            }
        });
    }
</script>
@endsection