
@extends('admin.app')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            {{-- analyticsData list parent div --}}
            <div class="analytics_list">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-primary">Analytics list</h6>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4"> 
                                <table class="table table-bordered table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th>Serial no.</th>
                                            <th>Long URL</th>
                                            <th>Shorten URl</th>
                                            <th>Clicks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        @forelse ($analyticsDatas as $analyticsData)
                                            <tr>
                                                <td>{{ ($analyticsDatas->currentPage() - 1) * $analyticsDatas->perPage() + $loop->iteration }}</td>
                                                <td>{{$analyticsData->long_url}}</td>
                                                <td>{{url($analyticsData->short_code)}}</td>
                                                <td>{{$analyticsData->clicks}}</td>
                                                <td>
                                                    <a href="{{route('admin.details', $analyticsData->id)}}" class="btn btn-primary btn-sm">Details</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="50" class="text-danger text-center">No Analytics data found</td>
                                            </tr>
                                        @endforelse
                                        
                                    </tbody>
                                </table>
                                {{ $analyticsDatas->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
