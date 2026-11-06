
<<<<<<< HEAD:database/migrations/2014_10_12_000000_create_users_table.php
=======
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('UserID');
            $table->string('nome', 35);
            $table->string('email', 55)->unique();
            $table->string('cpf_cnpj', 18)->unique();
            $table->dateTime('data_nascimento');
            $table->string('telefone', 14)->unique();
            $table->enum('tipo', ['Técnico', 'Administrador', 'Usuário']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
>>>>>>> 59ead3d2f29f2e0a75a7166028e157fab4ab9ed1:database/migrations/2014_10_12_000000_create_usuario_table.php
