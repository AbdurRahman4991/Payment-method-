@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post page</div>

                <div class="card-body">
                    <form action="{{route('newLession')}}" method="post" enctype="multipart/form-data">
                        @csrf()
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" id="title" class="form-control" name="title" placeholder="Type your title">
                            @error('title')
                                <span class='danger'>{{message}}</span>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" class="form-control" name="description" placeholder="Type your title">
                            @error('description')
                                <span class='danger'>{{message}}</span>
                            @enderror
                        </div>                       
                        <button class="btn btn-success mt-2 " id='SubmitPost'>Post</button>                           
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<!-- <script>
    $('#SubmitPost').on('click',function(){       
      let title = $('#title').val();
      axios.post('http://127.0.0.1:8000/new/lession/').then(function(response){
        alert('hi');
      })
      .catch(function(error){
        alert('kf');
      })
        
    })
</script> -->

@endsection