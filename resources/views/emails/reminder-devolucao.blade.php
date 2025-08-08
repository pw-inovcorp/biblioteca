<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <div>
        <h1>⚠️ Reminder de Devolução</h1>
        <p>O seu livro deve ser devolvido amanhã!</p>
    </div>

    <div>
        <p>Olá <strong>{{ $requisicao->user->name }}</strong>,</p>

        <p>Este é um lembrete de que o prazo para devolução do livro termina <strong>AMANHÃ</strong>.</p>

        <div>
            <h3 style="margin-top: 0;">📅 Prazo de Devolução: {{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</h3>
            <p style="margin-bottom: 0;">Por favor, devolva o livro até amanhã para evitar atrasos.</p>
        </div>

        <div>
            <h3>Detalhes da Requisição:</h3>
            <p><strong>Número:</strong> {{ $requisicao->numero_requisicao }}</p>
            <p><strong>Livro:</strong> {{ $requisicao->livro->name }}</p>
            <p><strong>Data de Requisição:</strong> {{ $requisicao->data_requisicao->format('d/m/Y') }}</p>
            <p><strong>Dias em sua posse:</strong> {{ $requisicao->data_requisicao->diffInDays(now()) }} dias</p>
        </div>

        <p>Se já devolveu o livro, pode ignorar este email.</p>

        <center>
            <a href="{{ url('/requisicoes') }}" class="btn">
                Ver Minhas Requisições
            </a>
        </center>
    </div>

    <div>
        <p>Este é um lembrete automático do sistema de biblioteca.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</div>
</body>
</html>
