
@extends('admin.app')
@push('admin_style')
    <style>
        #urlbox {
            margin: 0 auto 20px auto;
            max-width: 758px;
            box-shadow: 0 1px 4px #ccc;
            border-radius: 6px;
            padding: 10px 30px 5px;
            background: #fff;
            text-align: center;
        }
    </style>
@endpush

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

           <div class="dashboard" id="urlbox">
                <h2>Paste the URL to be shortened</h2>

                <form action="{{route('admin.shorten')}}" method="post">
                    @csrf
                    <div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="long_url" placeholder="Enter the link here" value="{{old('long_url')}}">
                        </div>
                        @error('long_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">Shorten URL</button>
                        </div>
                    </div>
                </form>

                @if(null !== session('message'))
                    <div class="alert alert-danger">
                        {{session('message')}}
                    </div>
                @endif
                @if(null !== session('short_url'))
                    <p>
			            Your Shorten URL: <a href="{{session('short_url')}}" target="_blank">{{session('short_url')}}</a>
                    </p>
                @endif
           </div>
           
        </div>
    </div>
</div>
@endsection

