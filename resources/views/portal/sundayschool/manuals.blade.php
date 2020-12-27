@extends('portal.layout.layout_content')
@section('headers')
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('body')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Sunday School</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Manuals</a></li>

                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{route('portal.sundayschool.manuals.new.get')}}" class="btn btn-sm btn-neutral">New</a>
                        <a href="#" class="btn btn-sm btn-neutral">Filters</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Registered Hymns</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="hymns_table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="status">Name</th>
                                <th scope="col" class="sort" data-sort="budget">Language</th>
                                <th scope="col" class="sort" data-sort="status">Year</th>
                                <th scope="col" class="sort" data-sort="status">Topics</th>
                                <th scope="col" class="sort" data-sort="status">Action</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($manuals as $manual)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="#" class="avatar rounded-circle mr-3">
                                                {{$manual->id}}
                                            </a>
                                            <div class="media-body">
                                                <a href="{{route('portal.sundayschool.manuals.all',['id'=>$manual->id])}}"> <span
                                                        class="name mb-0 text-sm">{{$manual->name}}</span></a>
                                            </div>
                                        </div>
                                    </th>

                                    <td>
                                        {{$manual->language}}
                                    </td>
                                    <td>
                                        {{$manual->year}}
                                    </td>
                                    <td>
                                        <span class="badge badge-primary"> {{$manual->topics->count()}}</span>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->

    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#hymns_table').DataTable({
                pageLength: 100,
                bPaginate: false,
            });
        });
    </script>
@endsection
