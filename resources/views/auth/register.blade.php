@extends('layouts.app')

@section('content')

    <div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4>Sign Up</h4>
                <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
            </div>
            <div class="panel-body">
                <form id="signupform" class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div id="signupalert" style="display:none" class="alert alert-danger">
                        <p>Error:</p>
                        <span></span>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label form-control-lg">Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name" placeholder="Name" id="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="error">
                                {{ $errors->first('name') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label form-control-lg">Email</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="error">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phonenumber" class="col-md-3 control-label form-control-lg">Phone Number</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="phonenumber" placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label form-control-lg">Password</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            @if ($errors->has('password'))
                                <span class="error">
                                {{ $errors->first('password') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label form-control-lg">Password confirmation</label>
                        <div class="col-md-9">
                            <input type="password" name="password_confirmation" id="password-confirm" placeholder="Confirmation" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 control-label">
                            <label for="birth" class="form-control-lg">
                                Birth Date
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-xs-3 col-md-3">
                                <select class="form-control">
                                    <option value="Month">Month</option>
                                </select>
                            </div>
                            <div class="col-xs-3 col-md-3">
                                <select class="form-control">
                                    <option value="Day">Day</option>
                                </select>
                            </div>
                            <div class="col-xs-3 col-md-3">
                                <select class="form-control">
                                    <option value="Year">Year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <label class="radio-inline form-control-lg">
                        <input type="radio" name="sex" id="inlineCheckbox1" value="male"/>
                        Male
                    </label>
                    <label class="radio-inline form-control-lg">
                        <input type="radio" name="sex" id="inlineCheckbox2" value="female"/>
                        Female
                    </label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 control-label">
                                <label for="input-group" class="form-control-lg">Upload Profile Picture</label>
                            </div>
                            <div class="col col-md-8 upload-box">
                                <div class="input-group upload">
                                    <span class="input-group-btn">
                                        <button id="fake-file-button-browse" type="button" class="btn btn-default">
                                            <span class="glyphicon glyphicon-file"></span>
                                        </button>
                                    </span>
                                    <input type="file" id="files-input-upload" style="display:none">
                                    <input type="text" id="fake-file-input-name" disabled="disabled"
                                           placeholder="File not selected"
                                           class="form-control">
                                    <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" disabled="disabled" id="fake-file-button-upload">
                                        <span class="glyphicon glyphicon-upload"></span>
                                    </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Button -->
                        <div class="col-md-offset-3 col-md-9">
                            <button id="btn-signup" type="submit" class="btn btn-primary"><i class="icon-hand-right"></i> Sign up</button>
                            <span style="margin-left:8px;">or</span>
                            <a class="btn  btn-social-icon btn-google">
                                <span class="fa fa-google"></span> Sign in with Google
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
