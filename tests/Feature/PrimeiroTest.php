<?php

test('página inicial redireciona para dashboard', function () {
    // Arrange - Criar um utilizador
    $user = \App\Models\User::factory()->create();

    // Act - Fazer login e aceder à página inicial
    $response = $this->actingAs($user)->get('/');

    // Assert - Verificar se redireciona
    $response->assertRedirect('/dashboard');
});

test('utilizador consegue aceder ao dashboard', function () {
    // Arrange
    $user = \App\Models\User::factory()->create();

    // Act
    $response = $this->actingAs($user)->get('/dashboard');

    // Assert
    $response->assertStatus(200);
    $response->assertSee('Dashboard'); // Verifica se a palavra "Dashboard" aparece na página
});

test('utilizador não autenticado é redirecionado para login', function () {
    // Act - Tentar aceder sem estar logado
    $response = $this->get('/dashboard');

    // Assert
    $response->assertRedirect('/login');
});
