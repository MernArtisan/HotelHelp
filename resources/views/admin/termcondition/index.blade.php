@extends('admin.layouts.master')

@section('title', 'Privacy Policy')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-1 col-10 offset-1">
                <div class="main--container">
                    <h4 class="mb-4 text-dark">{{ $termCondition->name ?? '' }}</h4>
                    <form method="post" action="{{ route('admin.updateTermCondition') }}">
                        @csrf
                        <!-- Summernote Editor -->
                        <textarea id="summernote" name="description" class="form-control">
                            {!! old('description', $termCondition->description ?? '') !!}
                        </textarea>
                        <br>
                        <button type="submit" class="btn btn-info px-5">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include Summernote CSS/JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Summernote with full toolbar
        $('#summernote').summernote({
            height: 300, // Set editor height
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
            placeholder: 'Write the privacy policy here...',
        });
    });
</script>
@endsection

