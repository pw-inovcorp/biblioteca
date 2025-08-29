<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<h1>Esqueceu-se de algo?</h1>

<p>Olá <strong>{{ $user->name }}</strong>,</p>

<p>Notámos que adicionou alguns livros ao seu carrinho mas não finalizou a compra.</p>

<p><strong>Precisa de ajuda?</strong></p>

<h3>Livros no seu Carrinho ({{ $user->countItensCarrinho() }} items)</h3>

@foreach($user->carrinhoItems()->with('livro.autores')->get() as $item)
    <p>
        <strong>{{ $item->livro->name }}</strong><br>
        Autor(es): {{ $item->livro->autores->pluck('name')->join(', ') }}<br>
        Quantidade: {{ $item->quantidade }} × €{{ $item->livro->price }}
    </p>
    <hr>
@endforeach

<p><strong>Total: €{{ $user->calcTotalCarrinho() }}</strong></p>

<h3>Como podemos ajudar?</h3>
<ul>
    <li>Tem dúvidas sobre algum livro?</li>
    <li>Precisa de mais informações sobre a entrega?</li>
    <li>Encontrou algum problema no checkout?</li>
</ul>

<p>
    <a href="{{ route('carrinho.index') }}">Finalizar Compra</a> |
    <a href="{{ route('livros.index') }}">Continuar Comprando</a>
</p>

<p>Se precisar de ajuda, pode sempre contactar-nos respondendo a este email.</p>

<hr>
<p><small>Este email foi enviado porque tem livros no carrinho há mais de 1 hora.<br>
        Se não deseja receber estes lembretes, pode remover os items do carrinho.<br>
        © {{ date('Y') }} {{ config('app.name') }}</small></p>
</body>
</html>
