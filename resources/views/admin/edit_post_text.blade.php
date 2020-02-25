@extends('admin.layouts.master')

@section('style')
<link href="{{ asset('frontend-assets/css/dropzone.css') }}" rel="stylesheet">

@endsection
@section('content')
<div class="wrapper">
  <div class="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
      <div class="container-fluid">
        <div class="navbar-wrapper">
          <div class="navbar-toggle">
            <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
            </button>
          </div>
          <a class="navbar-brand" href="#pablo" style="text-transform:uppercase;"><strong>Edit Post</strong></a><br>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
          <ul class="navbar-nav">
            <li class="nav-item btn-rotate dropdown">
              <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <p>
                  <span class="d-lg-none d-md-block">Some Actions</span>
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ url('dashboard/logout') }}">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- <div class="panel-header panel-header-sm">
    </div> -->
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card"  style="width:70%;">
            <!-- <div class="card-header">
              <h4 class="card-title"> Add User</h4>
            </div> -->
            <div class="row" style="margin: 0;">
              <div class="col-md-12">

                <div role="tabpanel">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="active">
                      <a href="#text" aria-controls="home" role="tab" data-toggle="tab"><i class="material-icons">post_add</i><span>Text</span></a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="text">
                      <form method="post" action="" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                          <select name="team" id="" class="form-control" required="required">

                              @foreach(Feed::teams() as $team)
                              <option value="{{$team->id}}"<?php if(!empty($post->t_name)) echo ($team->name == $post->t_name) ? 'Selected' : '' ?> >{{$team->name}}</option>
                              @endforeach
                          </select>

                      </div>
                       <div class="form-group">
                          <select name="role" id="input1/(\w+)/\u\1/g" class="form-control" required="required">
                            @foreach(Feed::roles() as $role)
                            <option value="{{$role->id}}"<?php if(!empty($post->p_name)) echo ($post->p_name == $role->name) ? 'Selected' : '' ?> >{{$role->name}}</option>
                            @endforeach
                          </select>

                      </div>

                        <div class="form-group">
                          <input type="text" name="post_title" class="form-control" placeholder="Title" value="{{$post->title}}" required>
                        </div>
                        <div class="form-group">
                          <textarea rows="100" cols="70" class="tex-editor" id="editor" name="post_description" placeholder="Description...." required>{{ $post->content }}</textarea>
                        </div>
                        <div class="form-group pull-left">
                            <input type="text" name="" id="file_name" class="select-img" placeholder="Insert a cover image (optional)">
                            <label for="insert-cover">
                              <button class="btn btn-default  image-btn">Insert</button>
                            <input type="file" name="cover_image" id="insert-cover" onchange="document.getElementById('file_name').value = this.value.split('\\').pop().split('/').pop()">
                            </label>
                        </div>
                        <div class="form-group pull-right">
                          <input type="submit" class="btn btn-primary  background-blue" name="PUBLISH">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script src="{{ asset('/frontend-assets/js/dropzone.js') }}"></script>
  <script src="{{asset('frontend-assets/dashboard/ckeditor/ckeditor.js')}}"></script>
  <script src="{{asset('frontend-assets/dashboard/ckeditor/js/sample.js')}}"></script>
  <script src="{{asset('frontend-assets/dashboard/ckeditor/js/sf.js')}}"></script>
  <script src="{{ asset('frontend-assets/tinymce/tinymce.min.js') }}"></script>

<script>

tinymce.init({
  selector: '.tex-editor',
  statusbar: true,
  setup: function (editor) {
    editor.on('change', function () {
      editor.save();
    });
  },
  height: 200,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code',
    'charactercount'
  ],
    formats: {
    // Changes the default format for h1 to have a class of heading
    h1: { block: 'h1', classes: 'heading' },
	h2: { block: 'h2', classes: 'heading' },
	h3: { block: 'h3', classes: 'heading' },
	h4: { block: 'h4', classes: 'heading' },
	h5: { block: 'h5', classes: 'heading' }
  },
  style_formats: [
    // Adds the h1 format defined above to style_formats
    { title: 'Heading 1', format: 'h1' },
	{ title: 'Heading 2', format: 'h2' },
	{ title: 'Heading 3', format: 'h3' },
	{ title: 'Heading 4', format: 'h4' },
	{ title: 'Heading 5', format: 'h5' }
  ],
  toolbar: 'styleselect | bold italic | bullist numlist | link'
});
tinymce.PluginManager.add('charactercount', function (editor) {
  var self = this;
  function update() {
    editor.theme.panel.find('#charactercount').text(['Characters: {0}', self.getCount()]);
  }
  editor.on('init', function () {
    var statusbar = editor.theme.panel && editor.theme.panel.find('#statusbar')[0];
    if (statusbar) {
      window.setTimeout(function () {
        statusbar.insert({
          type: 'label',
          name: 'charactercount',
          text: ['Characters: {0}', self.getCount()],
          classes: 'charactercount',
          disabled: editor.settings.readonly
        }, 0);
        editor.on('setcontent beforeaddundo', update);
        editor.on('keyup', function (e) {
            update();
        });
      }, 0);
    }
  });
  self.getCount = function () {
    var tx = editor.getContent({ format: 'raw' });
    var decoded = decodeHtml(tx);
    // here we strip all HTML tags
    var decodedStripped = decoded.replace(/(<([^>]+)>)/ig, "").trim();
    var tc = decodedStripped.length;
    return tc;
  };
  function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
  }
});


  $('.nav-tabs').on('click', 'li', function() {
      $('.nav-tabs li.active').removeClass('active');
      $(this).addClass('active');
  });
</script>
@endsection
