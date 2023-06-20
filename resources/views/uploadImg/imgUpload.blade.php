@extends('app')
@section('content')
<center>
	<h1>Upload Img</h1></center>
	<div>
		<form action="{{ route('imageUploadSave') }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('HEAD')
			<div class="container" id="imageController" style="color:red;">
				<div class="row">
					<div class="col-md-6">
						<input type="file" name="image" class="form-control">
					</div>
					<input type="text" name="textIm" class="form-control">

					<div class="col-md-6">
						<button type="submit" class="btn btn-success">Upload</button>
					</div>
				</div>
			</div>
		</form>
	</div>
<style>
   
</style>
@endsection
