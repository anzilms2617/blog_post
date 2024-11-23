<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .post-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .post-title {
            color: #0d6efd;
            font-weight: bold;
        }

        .post-detail {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .post-content {
            line-height: 1.7;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<div class="container">
    
    <h1 class="post-title">{{ $post->name }}</h1>

    
    <p class="post-detail">
        <strong>Author:</strong> {{ $post->author }} | 
        <strong>Date:</strong> {{ $post->date }}
    </p>

    
    @if($post->image)
        <img src="{{ asset($post->image) }}" alt="{{ $post->name }}" class="post-image">
    @endif

    
    <div class="post-content">
        {!! $post->content !!}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
