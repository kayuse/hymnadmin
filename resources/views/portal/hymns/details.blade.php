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
                <div class="col-lg-12 col-md-10 pb-2">
                    <h1 class="display-2 text-white">{{$hymn->title}}</h1>
                    <p class="text-white mt-0 mb-5">{{$hymn->extra}}</p>
                    <span href="#!" class="badge badge-primary">Hymn Number: {{$hymn->number}}</span>
                    <a href="#!" class="badge badge-dark">Language: {{$hymn->language}}</a>
                    <br/><br/>
                    <a href="{{route('portal.hymns.upload.get',['id'=>$hymn->id])}}" class="btn btn-neutral">Upload
                        Hymn</a>
                <!--<a href="#!" class="btn btn-info">Language: {{$hymn->language}}</a>-->
                    <a href="{{route('portal.hymns.edit.get',['id'=>$hymn->id])}}" class="btn btn-primary">Edit Hymn</a>
                </div>
                <div class="col-lg-12 col-md-10 pt-2">
                    @foreach($hymn->media as $index => $media)
                        <a class="badge badge-info" target="_blank"
                           href="{{route('portal.download',['file'=>base64_encode($media->media)])}}"> <i
                                class="ni ni-cloud-download-95"></i> Audio File {{$index+1}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            @if($hymn->chorus != '')
                <div class="col-xl-4 order-xl-2">
                    <div class="card card-profile">

                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">

                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            <div class="d-flex justify-content-center">
                                <a href="#" class="btn btn-sm btn-info  mr-4 ml-4">Chorus</a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="text-center">
                                <div>
                                    <i class="ni education_hat mr-2"></i> {!! $hymn->chorus !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @foreach($hymn->verses as $index=>$verse)
                <div class="col-xl-4 order-xl-2">
                    <div class="card card-profile">

                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">

                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            <div class="d-flex justify-content-center">
                                <a href="#" class="btn btn-sm btn-primary  mr-4 ml-4">Verse {{$index + 1}}</a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="text-center">
                                <div>
                                    <i class="ni education_hat mr-2"></i> {!! $verse->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
