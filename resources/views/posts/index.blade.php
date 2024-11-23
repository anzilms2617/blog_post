<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #343a40;
            color: white;
            position: relative;
        }

        .header h1 {
            font-size: 2rem;
            margin: 0;
        }

        .logout-container {
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .logout-container button {
            background-color: #ff4d4d;
            border-color: #ff4d4d;
            color: white;
            transition: all 0.3s;
        }

        .logout-container button:hover {
            background-color: #e60000;
            border-color: #e60000;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .table th {
            background-color: #343a40;
            color: white;
            text-transform: uppercase;
            font-weight: bold;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .filter-container {
            gap: 15px;
        }

        .table-responsive {
            margin-top: 20px;
        }

        @media (max-width: 576px) {
            .filter-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    
    <div class="header">
        <h1>Welcome, {{ session('admin_name') }}</h1>
        <div class="logout-container">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm">Logout</button>
            </form>
        </div>
    </div>

    
    <div class="container my-5">
       
        <div class="card p-4 mb-4">
            <form class="row filter-container">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search by Post Name</label>
                    <input type="text" id="search" class="form-control" placeholder="Enter post name">
                </div>
                <div class="col-md-4">
                    <label for="authorFilter" class="form-label">Filter by Author</label>
                    <select id="authorFilter" class="form-select">
                        <option value="">All Authors</option>
                        @foreach($authors as $author)
                            <option value="{{ $author }}">{{ $author }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="dateFilter" class="form-label">Filter by Date</label>
                    <input type="date" id="dateFilter" class="form-control">
                </div>
            </form>
        </div>

        
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="m-0">Post List</h4>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="postsList">
                        @foreach($posts as $post)
                            <tr id="post_{{ $post->id }}">
                                <td>{{ $post->name }}</td>
                                <td>{{ $post->author }}</td>
                                <td>{{ $post->date }}</td>
                                <td>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <button class="delete-btn btn btn-danger btn-sm" data-id="{{ $post->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        
        $(document).on('click', '.delete-btn', function() {
            var postId = $(this).data('id');
            if (confirm('Are you sure you want to delete this post?')) {
                $.ajax({
                    url: '/posts/' + postId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#post_' + postId).remove();
                        alert(response.message);
                    },
                    error: function(response) {
                        alert('An error occurred while deleting the post.');
                    }
                });
            }
        });

        
        $('#search').on('keyup', function() {
            var searchQuery = $(this).val();
            filterPosts(searchQuery);
        });

        
        $('#authorFilter, #dateFilter').on('change', function() {
            var searchQuery = $('#search').val();
            var authorFilter = $('#authorFilter').val();
            var dateFilter = $('#dateFilter').val();
            filterPosts(searchQuery, authorFilter, dateFilter);
        });

        
        function filterPosts(searchQuery = '', authorFilter = '', dateFilter = '') {
            $.ajax({
                url: '/posts/filter',
                method: 'GET',
                data: {
                    search: searchQuery,
                    author: authorFilter,
                    date: dateFilter,
                },
                success: function(response) {
                    $('#postsList').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Filter Error:', error);
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
