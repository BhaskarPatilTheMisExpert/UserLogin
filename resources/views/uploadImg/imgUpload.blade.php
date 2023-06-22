@extends('app')
@section('content')
	<div>
		<form action="{{ route('imageUploadSave') }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('HEAD')
			<div class="container" id="imageController" style="color:black;">
				<div class="row">
					<div class="col-md-2">

					</div>
					<div class="col-md-4">
						<center>
							<h1>Upload Img</h1>
						</center>
					</div>
					<div class="col-md-4">

					</div>
					<div class="col-md-2">
					</div>

				</div><br>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<input type="file" name="image" class="form-control">
					</div>
					<!-- <input type="text" name="textIm" class="form-control"> -->
					<div class="col-md-4">
						<button type="submit" class="btn btn-success">Upload</button>
					</div>
					<div class="col-md-2">
						<a href="{{ route('showImg') }}" class="btn btn-info"></a>
					</div>
				</div>
			</div>
		</form>
	</div>
<style>
   
</style>
@endsection
