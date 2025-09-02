<?php

test('não é possível adicionar livro sem stock ao carrinho', function () {
    // ARRANGE
    $role = \App\Models\Role::factory()->cidadao()->create();
    $user = \App\Models\User::factory()->create(['role_id' => $role->id]);

    $editor = \App\Models\Editor::factory()->create();
    $autor = \App\Models\Autor::factory()->create();

    $livro = \App\Models\Livro::factory()->semStock()->create(['editor_id' => $editor->id]);
    $livro->autores()->attach($autor->id);

    // ACT
    $response = $this->actingAs($user)
        ->post('/carrinho', [
            'livro_id' => $livro->id,
            'quantidade' => 1
        ]);

    // ASSERT
    expect(\App\Models\CarrinhoItem::count())->toBe(0);

    $response->assertRedirect();
    $response->assertSessionHas('error');
});
