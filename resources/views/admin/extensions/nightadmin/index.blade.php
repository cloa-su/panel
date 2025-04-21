@extends('layouts.admin')
<?php 
    // Define extension information.
    $EXTENSION_ID = "nightadmin";
    $EXTENSION_NAME = stripslashes("Night");
    $EXTENSION_VERSION = "1.0";
    $EXTENSION_DESCRIPTION = stripslashes("A dark theme for your admin panel!");
    $EXTENSION_ICON = "/assets/extensions/nightadmin/icon.";
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
    @yield('extension.description')<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Information</h3>
  </div>
  <div class="box-body">
    <p>
      This extension is called <b>Night</b>. <br>
      <code>nightadmin</code> is the identifier of this extension. <br>
      The current version is <i>1.0</i>. <br>
    </p>
  </div>
</div>
@endsection
