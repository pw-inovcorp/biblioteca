<?php

test('um admin pode devolver um livro', function () {
    // ARRANGE
    $adminRole = \App\Models\Role::factory()->admin()->create();
    $cidadaoRole = \App\Models\Role::factory()->cidadao()->create();

    $admin = \App\Models\User::factory()->create(['role_id' => $adminRole->id]);
    $cidadao = \App\Models\User::factory()->create(['role_id' => $cidadaoRole->id]);

    $editor = \App\Models\Editor::factory()->create();
    $autor = \App\Models\Autor::factory()->create();
    $livro = \App\Models\Livro::factory()->create(['editor_id' => $editor->id]);
    $livro->autores()->attach($autor->id);

    $requisicao = \App\Models\Requisicao::factory()->create([
        'user_id' => $cidadao->id,
        'livro_id' => $livro->id,
    ]);

    // ACT
    $response = $this->actingAs($admin)
        ->patch("/requisicoes/{$requisicao->id}/devolver");

    // ASSERT
    $requisicao->refresh();

    expect($requisicao)
        ->status->toBe('devolvida')
        ->data_real_entrega->not->toBeNull()
        ->dias_decorridos->toBeGreaterThan(0);


    $response->assertRedirect('/requisicoes');
});
