<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<h1>Pagamento Confirmado!</h1>

<p>Olá <strong>{{ $encomenda->user->name }}</strong>,</p>

<p>O pagamento da sua encomenda foi confirmado com sucesso!</p>

<h3>📦 Detalhes da Encomenda</h3>
<p><strong>Número:</strong> {{ $encomenda->numero_encomenda }}</p>
<p><strong>Data:</strong> {{ $encomenda->created_at->format('d/m/Y H:i') }}</p>
<p><strong>Pagamento:</strong> {{ $encomenda->data_pagamento->format('d/m/Y H:i') }}</p>

<h3>📚 Livros Encomendados</h3>
@foreach($encomenda->items as $item)
    <p>
        <strong>{{ $item->livro->name }}</strong><br>
        Autor(es): {{ $item->livro->autores->pluck('name')->join(', ') }}<br>
        Quantidade: {{ $item->quantidade }} × €{{ $item->preco_unitario }} = €{{ $item->subtotal }}
    </p>
    <hr>
@endforeach

<p><strong>Total Pago: €{{ $encomenda->total }}</strong></p>

<h3>Morada de Entrega</h3>
<p>
    {{ $encomenda->morada_entrega['nome_completo'] }}<br>
    {{ $encomenda->morada_entrega['endereco'] }}<br>
    {{ $encomenda->morada_entrega['cidade'] }}, {{ $encomenda->morada_entrega['codigo_postal'] }}
        <br>Tel: {{ $encomenda->morada_entrega['telefone'] }}
</p>

<p><strong>Próximos Passos:</strong> Os seus livros serão preparados e enviados em breve.</p>

<p>
    <a href="{{ route('encomendas.show', $encomenda->id) }}">Ver Detalhes da Encomenda</a>
</p>

<hr>
<p><small>Este é um email automático do sistema de biblioteca.<br>
        © {{ date('Y') }} {{ config('app.name') }}</small></p>
</body>
</html>
