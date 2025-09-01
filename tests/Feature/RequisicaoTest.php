<?php


test('um utilizador pode criar uma requisição de livro', function () {

    //ARRANGE
    $role = \App\Models\Role::factory()->cidadao()->create();
    $user = \App\Models\User::factory()->create(['role_id' => $role->id]);

    $editor = \App\Models\Editor::factory()->create();
    $autor = \App\Models\Autor::factory()->create();

    $livro = \App\Models\Livro::factory()->create(['editor_id' => $editor->id]);
    $livro->autores()->attach($autor->id);

    // ACT
    $response = $this->actingAs($user)
        ->post('/requisicoes', [
        'livro_id' => $livro->id,
    ]);

    // ASSERT
    expect(\App\Models\Requisicao::count())->toBe(1);

    $requisicao = \App\Models\Requisicao::first();
    expect($requisicao)
        ->user_id->toBe($user->id)
        ->livro_id->toBe($livro->id)
        ->status->toBe('ativa')
        ->numero_requisicao->toContain('REQ-');

    // Verificar se redireciona com sucesso
    $response->assertRedirect('/requisicoes');
});

test('uma requisição não pode ser criada sem livro válido', function () {

    //INFO: os dados criado nos testes sao independentes.

    // ARRANGE
    $role = \App\Models\Role::factory()->cidadao()->create();
    $user = \App\Models\User::factory()->create(['role_id' => $role->id]);

    // ACT & ASSERT
    $response = $this->actingAs($user)
        ->post('/requisicoes', [
            'livro_id' => 999, // ID que nao existe
        ]);

    // Verificar que nao criou nenhuma requisiçao
    expect(\App\Models\Requisicao::count())->toBe(0);

    // Verificar que retornou erro de validaçao
    $response->assertSessionHasErrors(['livro_id']);
});
