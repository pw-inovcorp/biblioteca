<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <div>
        @if($review->status === 'ativo')
            <h1>Review Aprovada!</h1>
            <p>A sua review foi aprovada e já está visível para outros utilizadores.</p>
        @else
            <h1>Review Recusada</h1>
            <p>A sua review foi analisada pelos administradores e foi recusada.</p>
        @endif
    </div>

    <div>
        <h3>Detalhes da Review:</h3>
        <p><strong>Livro:</strong> {{ $review->livro->name }}</p>
        <p><strong>Data da Review:</strong> {{ $review->created_at->format('d/m/Y H:i') }}</p>

        <div>
            <h4>O Seu Comentário:</h4>
            <p><em>{{ $review->comment }}</em></p>
        </div>

        @if($review->status === 'ativo')
            <div>
                <p><strong>Parabéns!</strong> A sua review já está disponível na página do livro para outros leitores verem.</p>
                <p>
                    <a href="{{ route('livros.show', $review->livro->id) }}">
                        Ver o livro e a sua review
                    </a>
                </p>
            </div>
        @else
            <div>
                <h4>Motivo da Recusa:</h4>
                <p><strong>{{ $review->justificacao_recusa }}</strong></p>
            </div>
        @endif
    </div>

    <hr>
    <div>
        <p>Este é um email automático. Por favor não responda.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</div>
</body>
</html>
