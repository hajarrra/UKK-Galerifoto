@extends('layout')
<head>
    <title>Website Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{asset('master/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('master/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('master/css/templatemo-style.css')}}"> -->
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #F8F8FF;">
        <a class="navbar-brand mr-auto" href="#">Galeri Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            arial-controls="navbarNav" arial-expanded="false aria-label=" Toggle navigation>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <p class="btn btn">
                        {{ Auth::user()->name }}
                    </p>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-2" href="{{ route('signout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>Photos</div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                @if($errors->any())
                                @foreach($errors->all() as $error)
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> {{$error}}
                                </div>
                        @endforeach
                        @endif
                    <button data-toggle="collapse"  class="btn btn-success" data-target="#demo">Upload Fhotos</button>
                        <div id="demo" class="collapse">
                        <form action="{{route('image-store')}}" method="POST" id="image_upload_form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                            <label for="caption">Caption</label>
                            <input type="text" name="caption" class="form-control" placeholder="" id="caption">
                            </div>
                <div class="form-group">
                    <label for="sel1">Select Category</label>
                        <select name="category" class="form-control" id="category">
                            <option value="" selected disabled>Select Category</option>
                            <option value="personal">Kucing</option>
                            <option value="friends">Kelinci</option>
                            <option value="family">Panda</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Upload Photos</label>
                        <div class="preview-zone hidden">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                            <div><b>Photos</b></div>
                            <div class="box-tools pull-right" id="demo">
                            </div>
                        </div>
                        <div class="box-body"></div>
                        </div>
                        </div>
                        <div class="dropzone-wrapper">
                        <div class="dropzone-desc">
                            <i class="glyphicon glyphicon-download-alt"></i>
                            <p>Pilih file gambar atau seret ke sini.</p>
                        </div>
                        <input type="file" name="image" class="dropzone">
                        </div>
                        <div id="image_error"></div>
                    </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                        <button type="button" class="btn btn-danger btn-xs remove-preview">
                                <i class="fa fa-times"></i> Batal
                                </button>
                        </form>
                    </div>
                    </div>
                        <div class="col-md-12 mt-4">
                            <div class="row">

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script type="text/javascript">
    $("#image_upload_form").validate({
  rules: {
    caption: {
      required: true,
      maxlength: 255
    },
    category: {
      required: true,
    },
    image:{
        required:true,
        extensions:"png|jpeg|jpg|bmp"
    }

  },
  messages: {
    caption: {
      required: "Please enter an image caption",
      maxlength: "Max. 255 character allowed."
    },
    category: {
      required: "Please select a category.",
    },
    image: {
      required: "Please upload an image.",
      extension: "Only jpeg, jpg, png, bmp image allowed."
    }
    },
    errorPlacement:function(error,element) {
        if(element.attr('name')=="image"){
            error.insertAfter("#image_error");
        }else{
            error.insertAfter(element);
        }
    }

});

    function readFile(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {

        var validImageType=['image/png', 'image/bmp', 'image/jpeg', 'image/jpg'];

        if(!validImageType.includes(input.files[0]['type'])){
            var htmlPreview =
        '<p>Image preview not available</p>' +
        '<p>' + input.files[0].name + '</p>';
        }else{
            var htmlPreview =
        '<img width="70%" height="300;" src="' + e.target.result + '" />' +
        '<p>' + input.files[0].name + '</p>';
        }

      
      var wrapperZone = $(input).parent();
      var previewZone = $(input).parent().parent().find('.preview-zone');
      var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

      wrapperZone.removeClass('dragover');
      previewZone.removeClass('hidden');
      boxZone.empty();
      boxZone.append(htmlPreview);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function reset(e) {
  e.wrap('<form>').closest('form').get(0).reset();
  e.unwrap();
}

$(".dropzone").change(function() {
  readFile(this);
});

$('.dropzone-wrapper').on('dragover', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).addClass('dragover');
});

$('.dropzone-wrapper').on('dragleave', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).removeClass('dragover');
});

$('.remove-preview').on('click', function() {
  var boxZone = $(this).parents('.preview-zone').find('.box-body');
  var previewZone = $(this).parents('.preview-zone');
  var dropzone = $(this).parents('.form-group').find('.dropzone');
  boxZone.empty();
  previewZone.addClass('hidden');
  reset(dropzone);
});

</script>
@endsection