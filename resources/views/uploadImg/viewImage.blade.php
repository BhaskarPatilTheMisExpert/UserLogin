@extends('app')
@section('content')
  <a class="btn btn-info" href="{{ route('uploadImg') }}">Upload</a>
     <h1>Images</h1>
    <table>
        <thead>
            <tr>
                <th>Image Name</th>
                <th>Image</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $image)
                <tr>
                    
                    <td>{{ $image->name }}</td>
                    <td>
                        
                        <!-- <img src="{{ asset('images/' . $image->name . '/' . $image->name . '.jpg') }}" alt="Image" style="width: 100px;background-color: yellow;"> -->
                        <img src="{{ asset('images/' . $image->folderName . '/s_' . $image->name) }}" alt="Image" style="width: 100px; background-color: yellow;">

                    </td>
                    <td>
                        <!-- <button  class=" btn btn-info view-m" data-image="{{ asset('images/' . $image->name . '/m_' . $image->name) }}">View M</button>&nbsp; -->

                        <button  class=" btn btn-info view-m" data-folder="{{ $image->folderName }}" data-image="{{ $image->name }}">View M</button>&nbsp;

                        <!-- <button class="btn btn-info view-m">View M</button> -->

                        <button class=" btn btn-info view-l" data-folder="{{ $image->folderName }}" data-image="{{ $image->name }}">View L</button>&nbsp;

                        <button class=" btn btn-info view-o" data-folder="{{ $image->folderName }}" data-image="{{ $image->name }}">View Original</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <style>
        /* Add your custom CSS styles here */
        .image-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .image-list img {
            width: 200px;
            height: auto;
            margin: 10px;
        }
    </style>
    <script type="text/javascript">
        
        $(document).ready(function() {
            $("button.view-m").click(function() {
                var imageData = {
                    folder: $(this).data("folder"),
                    image: $(this).data("image")
                };

                viewImage(imageData);
            });

            $("button.view-l").click(function() {
                var imageData = {
                    folder: $(this).data("folder"),
                    image: $(this).data("image")
                };
                viewImageL(imageData);
            });

            $("button.view-o").click(function() {
                var imageData = {
                    folder: $(this).data("folder"),
                    image: $(this).data("image")
                };
                viewImageO(imageData);
            });
        });

        function viewImage(imageData) {
            var folderName = imageData.folder;
            var imageName = imageData.image;
            var imagePath = "{{ asset('images/') }}" +"/"+ folderName + "/m_" + imageName;
            console.log(imagePath);
            var imageWindow = window.open("", "_blank");
            imageWindow.document.write('<img src="' + imagePath + '" alt="Image" style="width: 100%;">');
        }

        function viewImageL(imageData) {
            var folderName = imageData.folder;
            var imageName = imageData.image;
            var imagePath = "{{ asset('images/') }}" +"/"+ folderName + "/l_" + imageName;
            console.log(imagePath);
            var imageWindow = window.open("", "_blank");
            imageWindow.document.write('<img src="' + imagePath + '" alt="Image" style="width: 100%;">');
        }

        function viewImageO(imageData) {
            var folderName = imageData.folder;
            var imageName = imageData.image;
            var imagePath = "{{ asset('images/') }}" +"/"+ folderName + "/" + imageName;
            console.log(imagePath);
            var imageWindow = window.open("", "_blank");
            imageWindow.document.write('<img src="' + imagePath + '" alt="Image" style="width: 100%;">');
        }

    // $(document).ready(function() {
    //     $("button.view-m").click(function() {
    //         var imageUrl = $(this).data();
    //         console.log(imageUrl);
    //         viewImage(imageUrl);
    //     });

    //     function viewImage(imageUrl) {
                
    //         $.ajax({
    //             type: 'GET',
    //             url: '{{ route('viewImage') }}',
    //             data: { imageUrl: imageUrl },
    //             success: function(response) {
    //                 console.log(response);
    //                     // Display img
    //                 // $('#imageContainer').html('<img src="' + response + '" alt="Image" style="width: 100%;">');
    //             },
    //             error: function(xhr, status, error) {
    //                 console.log(error);
    //             }
    //         });
    //     }


    // });
    
    </script>
@endsection