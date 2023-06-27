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
                        <div class="zoom">
                            <img class="imageA zoom-image" src="{{ asset('images/' . $image->folderName . '/s_' . $image->name) }}" alt="Image" style="width: 100px; background-color: yellow;">
                        </div>

                    </td>
                    <td>
                        <!-- <button  class=" btn btn-info view-m" data-image="{{ asset('images/' . $image->name . '/m_' . $image->name) }}">View M</button>&nbsp; -->

                        <!-- <button class="btn btn-info view-m" data-folder="{{ $image->folderName }}" data-image="{{ $image->name }}" onclick="viewImage('{{ asset('images/' . $image->folderName . '/m_' . $image->name) }}')">View M</button>
                        <button class="btn btn-info view-l" data-folder="{{ $image->folderName }}" data-image="{{ $image->name }}" onclick="viewImage('{{ asset('images/' . $image->folderName . '/l_' . $image->name) }}')">View L</button>
                        <button class="btn btn-info view-o" data-folder="{{ $image->folderName }}" data-image="{{ $image->name }}" onclick="viewImage('{{ asset('images/' . $image->folderName . '/' . $image->name) }}')">View Original</button> -->

                        <button  class=" btn btn-info view-m" data-folder="{{ $image->folderName }}" data-image="{{ $image->name }}">View M</button>&nbsp;

                        <button class=" btn btn-info view-l" data-folder="{{ $image->folderName }}" data-image="{{ $image->name }}">View L</button>&nbsp;

                        <button class=" btn btn-info view-o" data-folder="{{ $image->folderName }}" data-image="{{ $image->name }}">View Original</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" alt="Image" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
    <style>
       
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

       /* .image-container {
    overflow: hidden;
    display: inline-block;
}

.image {
    transition: transform 0.3s;
}

.image:hover {
    transform: scale(1.2);
}*/

.zoom {
  padding: 0px;
  background-color: white;
  transition: transform .2s; 
  width: auto;
  height: auto;
  margin: 0 auto;
}

.zoom:hover {
  transform: scale(2.5); 
}

    </style>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        
        $(document).ready(function() {
            // $('.zoom-image').elevateZoom({
            //     zoomType: 'inner',
            //     cursor: 'crosshair'
            // });

            $("button.view-m").click(function() {
                var imageData = {
                    folder: $(this).data("folder"),
                    image: $(this).data("image")
                };

                var folderName = imageData.folder;
                var imageName = imageData.image;
                var imagePath = "{{ asset('images/') }}" +"/"+ folderName + "/m_" + imageName;

                viewImage(imagePath);
            });

            $("button.view-l").click(function() {
                var imageData = {
                    folder: $(this).data("folder"),
                    image: $(this).data("image")
                };

                var folderName = imageData.folder;
                var imageName = imageData.image;
                var imagePath = "{{ asset('images/') }}" +"/"+ folderName + "/l_" + imageName;

                viewImage(imagePath);
            });

            $("button.view-o").click(function() {
                var imageData = {
                    folder: $(this).data("folder"),
                    image: $(this).data("image")
                };
                var folderName = imageData.folder;
                var imageName = imageData.image;
                var imagePath = "{{ asset('images/') }}" +"/"+ folderName + "/" + imageName;
                viewImage(imagePath);
            });
        });

        function viewImage(imagePath) {
            
            console.log(imagePath);
            var imageWindow = window.open("", "_blank");
            imageWindow.document.write('<img src="' + imagePath + '" alt="Image" style="width: auto; height: auto; max-width: 100%; max-height: 100%;">');

            // $('#imageModal').find('.modal-body img').attr('src', imagePath);
            // $('#imageModal').modal('show');


        }

        // function viewImageL(imagePath) {
            
        //     console.log('large',imagePath);
        //     var imageWindow = window.open("", "_blank");
        //     imageWindow.document.write('<img src="' + imagePath + '" alt="Image" style="width: auto; height: auto; max-width: 100%; max-height: 100%;">');
        // }

        // function viewImageO(imagePath) {
            
        //     console.log('original',imagePath);
        //     var imageWindow = window.open("", "_blank");
        //     imageWindow.document.write('<img src="' + imagePath + '" alt="Image" style="width: auto; height: auto; max-width: 100%; max-height: 100%;">');
        // }

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
