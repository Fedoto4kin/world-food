@extends('food::layouts.master')

@section('content')

<nav class="navbar navbar-light bg-light justify-content-between">
    <div class="container">
       <a class="navbar-brand" href="#">Word&#039;s Food</a>
    </div>
</nav>

<div class="container">
    <form>
        <div class="input-group mb-3">
            <input action='/search' class="form-control col-4"
             type="search"
             name="search"
             placeholder="Type here product name and click search"
             aria-label="Search"
             required="required"
             value="{{$search}}">
            <div class="input-group-append">
                   <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>

        </div>

    </form>
  </div>
    <div class="container">

        <div class="flash-message">
          @if(Session::has('alert'))
          <p class="alert alert-dark">{{ Session::get('alert') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
          @endif
      </div>

    @if(!empty($data))
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>IMAGE</th>
                <th>NAME</th>
                <th>CATEGORIES</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{$item['_id']}}</td>
                <td>
                    @if(isset($item['image_url']) && isset($item['image_thumb_url']))
                        <a href="{{$item['image_url']}}">
                            <img src="{{$item['image_thumb_url']}}">
                        </a>
                    @endif
                </td>
                <td>{{$item['product_name']}}</td>
                <td>{{$item['categories']}}</td>
                <td><button
                        data-ex-id="{{$item['_id']}}"
                        data-product-name="{{$item['product_name']}}"
                        data-categories="{{$item['categories']}}"
                        data-image-url="{{$item['image_url']}}"
                        data-image-thumb-url="{{$item['image_thumb_url'] ?? '' }}"
                        class="btn-primary btn add-to-db"

                        >
                        Save</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
         {{ $pagination->links() }}
    @endif
    </div>
<script>

$(".add-to-db").click(function() {

    let _token   = $('meta[name="csrf-token"]').attr('content');
    let el = this;
    const data = {
        ex_id: $(this).data('ex-id'),
        product_name:  $(this).data('product-name'),
        categories: $(this).data('categories'),
        image_url:  $(this).data('image-url'),
        image_thumb_url: $(this).data('image-thumb-url')
    }

    $.ajax({
        url: "/",
        type:"POST",
        dataType: 'json',
        data:{
           data: data,
          _token: _token
        },
        success: function(response){
          if (response.success) {
            $(el).html('Done').removeClass('add-to-db').addClass('btn-success disabled').blur();
          }
        },
    });
});

</script>
@endsection
