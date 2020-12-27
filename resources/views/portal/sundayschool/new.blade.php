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
                    <h1 class="display-2 text-white">Add Hymn</h1>
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
                            <h3 class="mb-0">Add Hymn</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#!" class="btn btn-sm btn-primary" id="addVerse">Add Verse</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('portal.hymns.new.post')}}">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Hymn Details</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Title</label>
                                        <input type="text" id="input-username" class="form-control" name="title"
                                               placeholder="Title">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Number</label>
                                        <input type="number" id="input-email" class="form-control" name="number"
                                               placeholder="Hymn Number">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">Language</label>
                                        <input type="text" id="input-first-name" class="form-control" name="language"
                                               placeholder="Language">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Extra</label>
                                        <input type="text" id="input-username" class="form-control" name="extra"
                                               placeholder="Extra">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr class="my-4"/>
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Chorus</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">Chorus</label>
                                        <textarea name="chorus" id="choruseditor" style="height: 200px;"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr class="my-4"/>
                        <!-- Description -->
                        <h6 class="heading-small text-muted mb-4">Verses</h6>
                        <div id="versesCtn">
                            <div class="pl-lg-4" id="verseCtn0">
                                <div class="form-group">
                                    <label class="form-control-label">Verse </label>
                                    <textarea name="verses[]" id="verseeditor0" class="verses"
                                              style="height: 200px;"></textarea>
                                </div>
                                <div>
                                    <a href="#!" class="btn btn-sm btn-primary removeVerse" data-id="0">Remove Verse</a>
                                </div>
                            </div>
                            <hr/>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" style="float: right !important;">
                                    <a href="{{route('portal.hymns.all')}}"
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
    <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>
    <script>
        verseEditorCount = 0
        var editors = []
        ClassicEditor
            .create(document.querySelector('#choruseditor')).then(editor => {
            editor.setData('')
        }).catch(error => {
            console.error(error);
        });
        indexeditor = ClassicEditor
            .create(document.querySelector('#verseeditor0')).then(editor => {
                editor.setData('')
            }).catch(error => {
                console.error(error);
            });
        editors.push({
            key: `editor${verseEditorCount}`,
            editor: indexeditor
        })
        $(function () {
            $("#addVerse").click(function () {
                verseEditorCount++;
                verseHtml = `<div class="pl-lg-4" id="verseCtn${verseEditorCount}">
                <div class="form-group">
                <label class="form-control-label">New Verse </label>
                <textarea name="verses[]" id="verseeditor${verseEditorCount}" class="verses"
            style="height: 200px;"></textarea>
                </div>
                <div>
                <a href="#!" class="btn btn-sm btn-primary removeVerse" data-id='${verseEditorCount}'>Remove Verse</a>
            </div>
             <hr/>
            </div>`;
                $("#versesCtn").append(verseHtml)
                var ceditor = ClassicEditor
                    .create(document.querySelector(`#verseeditor${verseEditorCount}`)).then(editor => {
                        editor.setData('');
                        var currentEditor = {
                            key: `editor${verseEditorCount}`,
                            editor: editor
                        }
                        editors.push(currentEditor)
                    }).catch(error => {
                        console.error(error);
                    });


            })

            $(document).on('click', '.removeVerse', function () {
                let id = $(this).data('id');
                if (verseEditorCount <= 0) {
                    alert('You must have at least one verse')
                    return;
                }
                $(`#verseCtn${id}`).remove();
                let aneditor = editors.find(editor => editor.key == `editor${id}`)
                aneditor.editor.destroy()
                editors = editors.filter(editor => editor.key != `editor${id}`)
                verseEditorCount--;
            })
        })

    </script>
@endsection

@section('styles')
    <style>
        .ck-content {
            height: 200px !important;
        }
    </style>
@endsection
