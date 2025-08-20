<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<h1>Livro Disponível!</h1>

<p>Olá {{ $user->name }},</p>

<p>O livro <strong>{{ $livro->name }}</strong> já está disponível para requisição!</p>

<p><a href="{{ route('livros.show', $livro->id) }}">Requisitar Agora</a></p>

<p>{{ config('app.name') }}</p>
</body>
</html>
