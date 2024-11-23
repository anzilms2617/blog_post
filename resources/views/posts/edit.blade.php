<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }

        .form-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
            color: #343a40;
        }

        .form-control, .form-select, .btn {
            border-radius: 5px;
        }

        #editor {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            background: #ffffff;
            height: 200px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <div class="form-container">
            <h1>Edit Post</h1>
            <form id="editPostForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                
                <div class="mb-3">
                    <label for="name" class="form-label">Post Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $post->name }}" required>
                </div>

                
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ $post->date }}" required>
                </div>

                
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" name="author" id="author" class="form-control" value="{{ $post->author }}" required>
                </div>

               
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <div id="editor"></div>
                    <textarea name="content" id="content" style="display:none;">{{ $post->content }}</textarea>
                </div>

                
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    @if($post->image)
                        <div class="mb-2">
                            <img src="{{ asset($post->image) }}" alt="Current Image" class="img-thumbnail" width="150">
                            <p><strong>Current Image</strong></p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5">Update Post</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write your post content here...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'], 
                    ['link'], 
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }]
                ],
            }
        });

        
        quill.root.innerHTML = $('#content').val();

        
        $('#editPostForm').submit(function(e) {
            e.preventDefault();

            
            var content = quill.root.innerHTML;
            $('#content').val(content);

            
            var formData = new FormData(this);

            
            var postId = {{ $post->id }};

            $.ajax({
                url: '/posts/' + postId,  
                method: 'POST',  
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Post updated successfully!');
                    window.location.href = '/posts';  
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while updating the post.');
                    console.error('Error:', error);
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
