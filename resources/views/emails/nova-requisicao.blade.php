<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <div>
        <div>
            <h1>Nova Requisição de Livro</h1>
            <p>{{ $requisicao->numero_requisicao }}</p>
        </div>
        
        <div>
            <p>Olá <strong>{{ $requisicao->user->name }}</strong>,</p>
            
            <p>A sua requisição foi registada com sucesso!</p>
            
            <div>
                <h3>Detalhes da Requisição:</h3>
                <p><strong>Livro:</strong> {{ $requisicao->livro->name }}</p>
                <p><strong>ISBN:</strong> {{ $requisicao->livro->isbn }}</p>
                <p><strong>Data de Requisição:</strong> {{ $requisicao->data_requisicao->format('d/m/Y') }}</p>
                <p><strong>Data de Devolução:</strong> {{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</p>
            </div>
            
            <div>
                <strong>Importante:</strong> Tem 5 dias para devolver o livro. 
                Receberá um lembrete por email um dia antes da data de devolução.
            </div>
            
            @if($requisicao->livro->image)
            <div style="text-align: center; margin-top: 20px;">
                <img src="{{ asset('storage/' . $requisicao->livro->image) }}" 
                     alt="Capa do livro" 
                     style="max-width: 200px; height: auto;">
            </div>
            @endif
        </div>

        <p style="margin-top: 20px;">
                <a href="{{ url('/requisicoes') }}" style="background-color: #4299e1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                    Ver Todas as Requisições
                </a>
        </p>
        
        <div>
            <p>Este é um email automático. Por favor não responda.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>