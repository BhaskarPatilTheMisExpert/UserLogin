@extends('app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4" >
                <div class="col-md-12" style="background-color: #85929E; padding-bottom:5px; padding-top:5px">
                    <h1 align="center">
                        <img src="{{ asset('images/p-logo.svg') }}">
                    </h1>
                </div>
                <div class="clearfix" style="padding-top:20px;">

                </div>
                <div id="loader" class="loader">
                    <div class="loader-text">

                    </div>
                </div>

                
                @if($message)
                <div id = "error-message" class="alert alert-info text-center" role="alert">
                    {{ $message }}
                </div>
                @endif
                <span class="justify-content-center center " style="display:flex;"id="otp-message"></span>
                <form method="POST" action="{{ url('userLogin') }}">
                    @csrf
                    @method('GET')
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                        <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="Email" value="" autocomplete="">

                        @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                        
                    </div>
                    <span  id="error-msg" style="color:red;"></span>

                    <div class="input-group mb-3" style="display: inline-flex;">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>

                            <input id="password" name="password" type="password" class="form-control  d-inline" required placeholder="Password">  
                            <div class="input-group-append">
                                <button type="button" id="withOtp" href="" class="btn btn-sm btn-info px-4 " onclick="changePlaceholder();" value="">With OTP</button>
                            </div>
                        </div>

                        @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>

                    <div class="input-group mb-4">
                        <div class="form-check checkbox">
                            <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                            <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                Remember me
                            </label>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary px-4">
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    #loader {
      border: 16px solid #f3f3f3; /* light grey border */
      border-top: 16px solid #3498db; /* blue border on top */
      border-radius: 50%; /* make it circular */
      width: 120px;
      height: 120px;
      animation: spin 2s linear infinite; /* spin animation */
      margin: auto; /* center it horizontally */
      z-index: 9999;
      display: none;
  }

  @keyframes spin {
      0% { transform: rotate(0deg); } /* starting position */
      100% { transform: rotate(360deg); } /* ending position */
  }

  .loader {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 99999;
      background-color: rgba(0, 0, 0, 0.5);
      cursor: progress;
  }

  .loader-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
  }


</style>

<script type="text/javascript">
    function changePlaceholder(event) {
        var buttonVal = $('#withOtp').text();
        // console.log(buttonVal);

        var inputVal = $('#email').val();
        if (inputVal === '') {
            $('#error-msg').text('Email cannot be blank');

            return false;
        } else {
         if (buttonVal == 'With OTP') {
            $('#password').attr('placeholder', 'Enter OTP');
            $('#withOtp').text('Password');
            $("#password").attr("name", "otp");
            getOtp();
            $('#withOtp').prop('disabled', true);
        } else {
            $('#password').attr('placeholder', 'Password');
            $('#withOtp').text('With OTP');
            $("#password").attr("name", "password");
            withPassword();
        }

        $('#error-msg').text('');
        return true;
    }
}

function getOtp() {
  let email = $('#email').val();
  let loader = $('#loader'); 

  $('body').addClass('loading');

  $.ajax({
        url: '/getOtp',
        data: {
            'email': email,
        },
        type: 'GET',
        cache: false,
        dataType: 'json',
        beforeSend: function() {
          loader.show();
        },
        success: function(result) {
            console.log(result.message);
                // setTimeout(function(){

                // },3000);
            $('#otp-message').html(result.message).addClass('alert alert-info ').fadeOut(3000);
            $('#withOtp').prop('disabled', false);

        },
        complete: function() {
          loader.hide();
          $('body').removeClass('loading');
        }
    });
}


function withPassword()
{
    var userPassword = $('#email').val();
    console.log(userPassword);
}

setTimeout(function() {
    document.getElementById('error-message').style.display = 'none';
    document.getElementById('otp-message').style.display = 'none';

}, 5000);


</script>
@endsection