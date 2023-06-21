@extends('app')
@section('content')
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
                        <!-- <img src="{{ asset('images/' . $image->name) }}" alt="Image" style="width: 100px;"> -->
                        <img src="{{ asset('images/' . $image->name . '/s_' . $image->name . '.jpg') }}" alt="Image" style="width: 400px;background-color: yellow;">

                    </td>
                    <td>
                        <button  class=" btn btn-info view-m">View M</button>&nbsp;
                        <button class=" btn btn-info">View L</button>&nbsp;
                        <button class=" btn btn-info">View Original</button>
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
                $(this).siblings(".image-m").toggle();
            });
        });
    
    </script>
@endsection
