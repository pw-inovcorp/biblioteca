<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

</head>
<body>
    <div>
        <div>
            <h1>Nova Requisição Registada</h1>
            <p>Notificação para Administrador</p>
        </div>
        
        <div>
            <p>Uma nova requisição foi registada no sistema.</p>
            
            <div>
                <h3>Detalhes da Requisição:</h3>
                <table>
                    <tr>
                        <th>Número:</th>
                        <td>{{ $requisicao->numero_requisicao }}</td>
                    </tr>
                    <tr>
                        <th>Cidadão:</th>
                        <td>{{ $requisicao->user->name }} ({{ $requisicao->user->email }})</td>
                    </tr>
                    <tr>
                        <th>Livro:</th>
                        <td>{{ $requisicao->livro->name }}</td>
                    </tr>
                    <tr>
                        <th>ISBN:</th>
                        <td>{{ $requisicao->livro->isbn }}</td>
                    </tr>
                    <tr>
                        <th>Data Requisição:</th>
                        <td>{{ $requisicao->data_requisicao->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Devolução Prevista:</th>
                        <td>{{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
            
            @if($requisicao->foto_cidadao)
            <div>
                <p><strong>Foto do cidadão foi anexada à requisição.</strong></p>
            </div>
            @endif
            
            <p style="margin-top: 20px;">
                <a href="{{ url('/requisicoes') }}" style="background-color: #4299e1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                    Ver Todas as Requisições
                </a>
            </p>
        </div>
        
        <div >
            <p>Este é um email automático do sistema de biblioteca.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>