<?php

test('factories criam dados corretamente', function () {
    $role = \App\Models\Role::factory()->cidadao()->create();
    expect($role->name)->toBe('cidadao');


    $user = \App\Models\User::factory()->create(['role_id' => $role->id]);
    expect($user)
        ->name->not()->toBeEmpty()
        ->role_id->toBe($role->id);


    $editor = \App\Models\Editor::factory()->create();
    expect($editor->name)->not()->toBeEmpty();


    $autor = \App\Models\Autor::factory()->create();
    expect($autor->name)->not()->toBeEmpty();


    $livro = \App\Models\Livro::factory()->create(['editor_id' => $editor->id]);
    expect($livro)
        ->name->not()->toBeEmpty()
        ->stock->toBeGreaterThan(0);


    $requisicao = \App\Models\Requisicao::factory()->create([
        'user_id' => $user->id,
        'livro_id' => $livro->id
    ]);
    expect($requisicao->status)->toBe('ativa');
});
