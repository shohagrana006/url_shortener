@extends('admin.app')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            {{-- detail list parent div --}}
            <div class="analytics_list">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-primary">Analytics details</h6>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4"> 
                                <table class="table table-bordered table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th>Serial no.</th>
                                            <th>user IP</th>
                                            <th>Location</th>
                                            <th>Clicked At
                                                <br>(showing db default timezone)
                                            </th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        @forelse ($details as $detail)
                                            <tr>
                                                <td>{{ ($details->currentPage() - 1) * $details->perPage() + $loop->iteration }}</td>
                                                <td>{{$detail->user_ip}}</td>
                                                <td>{{$detail->location}}</td>
                                                <td>{{$detail->clicked_at}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="50" class="text-danger text-center">No Analytics details data found</td>
                                            </tr>
                                        @endforelse
                                        
                                    </tbody>
                                </table>
                                {{ $details->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
