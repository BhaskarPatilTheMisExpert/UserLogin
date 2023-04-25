<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>

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
                
                @if($message)
                <div id = "error-message" class="alert alert-info" role="alert">
                    {{ $message }}
                </div>
                @endif
                <form method="GET" action="{{ url('userLogin') }}">
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

                        <input id="password" name="password" type="password" class="form-control  d-inline" placeholder="Password">
                        <button type="button" id="withOtp" href="" class="btn btn-xs btn-info mt-2 col-sm-3 d-inline" onclick="changePlaceholder();" value="">with OTP</button>
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

<script type="text/javascript">
function changePlaceholder(event) {
        var buttonVal = $('#withOtp').text();
        // console.log(buttonVal);

        var inputVal = $('#email').val();
        if (inputVal === '') {
            $('#error-msg').text('Email cannot be blank');

            return false;
        } else {
           if (buttonVal == 'with OTP') {
            $('#password').attr('placeholder', 'Enter OTP');
            $('#withOtp').text('Password');
            getOtp();
        } else {
            $('#password').attr('placeholder', 'Password');
            $('#withOtp').text('with OTP');
            withPassword();
        }

        $('#error-msg').text('');
        return true;
    }
}


function getOtp() {
  let email = $('#email').val();
  
  $.ajax({
    url: '/getOtp',
    data: {
        'email': email,
    },
    type: 'GET',
    cache: false,
    dataType: 'json',
    success: function(result) {
        console.log(result.message);
        alert(result.message);
    },

  });
}

function withPassword()
{
    var userPassword = $('#email').val();
    console.log(userPassword);
}

 setTimeout(function() {
        document.getElementById('error-message').style.display = 'none';
    }, 5000);


</script>
@endsection