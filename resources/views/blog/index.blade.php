<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar .navbar-brand, .navbar-nav .nav-link {
            color: white;
        }

        .navbar .navbar-brand:hover, .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }

        .container {
            max-width: 900px;
        }

        .post-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .post-card h5 {
            margin-bottom: 10px;
            color: #212529;
        }

        .post-card p {
            margin-bottom: 0;
        }

        .read-more {
            color: #0d6efd;
            text-decoration: none;
        }

        .read-more:hover {
            text-decoration: underline;
        }

        .page-title {
            font-size: 2rem;
            font-weight: bold;
            color: #212529;
        }

        .login-link {
            text-decoration: none;
            color: #f8f9fa;
            background-color: #007bff;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .login-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Blog</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.login') }}">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <h1 class="page-title text-center mb-4 text-primary">Latest Blog Posts</h1>

    @if($posts->count())
        @foreach($posts as $post)
            <div class="post-card">
                <h5 class="fw-bold">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-dark">{{ $post->name }}</a>
                </h5>
                <p class="text-muted">
                    <strong>Author:</strong> {{ $post->author }} | <strong>Date:</strong> {{ $post->date }}
                </p>
                <p class="mt-2">
                    {!! Str::limit($post->content, 220) !!}
                    <a href="{{ route('posts.show', $post->id) }}" class="read-more">Read More</a>
                </p>
            </div>
        @endforeach

        
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    @else
        <p class="text-center">No posts found.</p>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
