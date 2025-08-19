<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <div>
        <h1>Nova Review Pendente de Moderação</h1>
        <p>Um cidadão fez uma nova review que precisa da sua análise.</p>
    </div>

    <div>
        <h3>Detalhes da Review:</h3>
        <table>
            <tr>
                <th>Livro:</th>
                <td>{{ $review->livro->name }}</td>
            </tr>
            <tr>
                <th>ISBN:</th>
                <td>{{ $review->livro->isbn }}</td>
            </tr>
            <tr>
                <th>Cidadão:</th>
                <td>{{ $review->user->name }} ({{ $review->user->email }})</td>
            </tr>
            <tr>
                <th>Data da Review:</th>
                <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Requisição:</th>
                <td>{{ $review->requisicao->numero_requisicao }}</td>
            </tr>
        </table>

        <div class="mt-2">
            <h4>Comentário:</h4>
            <div style="background-color: #f5f5f5; padding: 10px; border-radius: 5px;">
                {{ $review->comment }}
            </div>
        </div>

        <p class="mt-2">
            <a href="{{ route('reviews.show', $review->id) }}"
               style="background-color: skyblue; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Gerir Review
            </a>
        </p>
    </div>

    <div>
        <p>Este é um email automático do sistema de biblioteca.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</div>
</body>
</html>
