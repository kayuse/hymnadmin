@extends('portal.layout.layout_content')
@section('headers')
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('body')
    <div class="header pb-6 d-flex align-items-center"
         style="min-height: 500px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-12 col-md-10">
                    <h1 class="display-2 text-white">{{$hymn->title}}</h1>
                    <p class="text-white mt-0 mb-5">{{$hymn->extra}}</p>
                    <a href="#!" class="btn btn-neutral">Hymn Number: {{$hymn->number}}</a>
                    <a href="#!" class="btn btn-info">Language: {{$hymn->language}}</a>
                    <a href="{{route('portal.hymns.edit.get',['id'=>$hymn->id])}}" class="btn btn-primary">Edit Hymn</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Upload Hymn </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('portal.hymns.upload.post',['id'=>$hymn->id])}}"
                          enctype="multipart/form-data">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Hymn Details</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Select File</label>
                                        <input type="file" id="input-username" class="form-control" name="media">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr class="my-4"/>
                        <!-- Address -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" style="float: right !important;">
                                    <a href="{{route('portal.hymns.details',['id'=>$hymn->id])}}"
                                       class="btn btn-danger">Cancel</a>
                                    <input type="submit" class="btn btn-primary"
                                           value="Submit">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer -->

    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@endsection

@section('styles')
    <style>
        .ck-content {
            height: 200px !important;
        }
    </style>
@endsection
