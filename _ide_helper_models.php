<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Livro> $livros
 * @property-read int|null $livros_count
 * @method static \Database\Factories\AutorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereUpdatedAt($value)
 */
	class Autor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $logotipo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Livro> $livros
 * @property-read int|null $livros_count
 * @method static \Database\Factories\EditorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereLogotipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereUpdatedAt($value)
 */
	class Editor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $isbn
 * @property string $name
 * @property int $editor_id
 * @property string $bibliography
 * @property string|null $image
 * @property string|null $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Autor> $autores
 * @property-read int|null $autores_count
 * @property-read \App\Models\Editor|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Requisicao> $requisicoes
 * @property-read int|null $requisicoes_count
 * @method static \Database\Factories\LivroFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereBibliography($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereEditorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereUpdatedAt($value)
 */
	class Livro extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $numero_requisicao
 * @property int $user_id
 * @property int $livro_id
 * @property \Illuminate\Support\Carbon $data_requisicao
 * @property \Illuminate\Support\Carbon $data_prevista_entrega
 * @property \Illuminate\Support\Carbon|null $data_real_entrega
 * @property string $status
 * @property int|null $dias_decorridos
 * @property string|null $foto_cidadao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Livro|null $livro
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao ativas()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao doUsuario($userId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereDataPrevistaEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereDataRealEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereDataRequisicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereDiasDecorridos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereFotoCidadao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereLivroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereNumeroRequisicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereUserId($value)
 */
	class Requisicao extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property int|null $role_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Requisicao> $requisicoes
 * @property-read int|null $requisicoes_count
 * @property-read \App\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

