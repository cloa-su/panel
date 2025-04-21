@extends('layouts.admin')
<?php 
    // Define extension information.
    $EXTENSION_ID = "simplefavicons";
    $EXTENSION_NAME = stripslashes("Simple Favicons");
    $EXTENSION_VERSION = "v1.0.1";
    $EXTENSION_DESCRIPTION = stripslashes("A simple way to allow you to change your panel's favicon");
    $EXTENSION_ICON = "/assets/extensions/simplefavicons/icon.png";
    $EXTENSION_WEBSITE = "[website]";
    $EXTENSION_WEBICON = "[webicon]";
?>
@include('blueprint.admin.template')

@section('title')
    {{ $EXTENSION_NAME }}
@endsection

@section('content-header')
    @yield('extension.header')
@endsection

@section('content')
    @yield('extension.config')
    @yield('extension.description')<?php $file_path = $blueprint->dbGet('simplefavicons', 'file_path');?>



<div class="row">
  <div class="col-xs-12">
    <p>Version: <code>v1.0.1</code><br/>
    Author: <code>PatrickYu17</code><br/>
    Discord: <code>pyuwu17</code><br/>
    Identifier: <code>simplefavicons</code></p>
  </div>
  <form action="" method="POST">
  @method('PATCH')
    <!-- Toggle status -->
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Toggle Status</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-xs-12">
              <label class="control-label">Status</label>
              <select class="form-control" name="status">
                <option value="true" @if($db_status == "true") selected @endif>Enabled</option>
                <option value="false" @if($db_status == "false") selected @endif>Disabled</option>
              </select>
            
              <br/>

            {{ csrf_field() }}
            <button type="submit" class="btn btn-gray-alt btn-sm">Apply</button> 
            </div>
          </div>
        </div>
      </div>
    </div>
</form>

    <form action="" method="POST" enctype="multipart/form-data">

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Favicon Icon</h3>
        </div>
        <div class="box-body">
          <div class="row">
              <div class="col-xs-12">
              <label class="control-label">Link/path to favicon file</label>
              <input type="text" required="" name="file_path" id="file_path" value="{{ $file_path }}" class="form-control" readonly>

              <label class="control-label">Upload favicon file</label>
              <input name="file" type="file"/>

              <br/>

              {{ csrf_field() }}
              <button type="submit" class="btn btn-gray-alt btn-sm">Upload</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </form> 
</div>
@endsection
