<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Servico;
use App\Models\Tecnicos;
use App\Models\Equipamentos;
use App\Models\Enderecos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_landing_page_navigation_only_links_to_existing_sections()
    {
        $response = $this->get('/');

        $response->assertSee('href="#inicio"', false);
        $response->assertSee('href="#servicos"', false);
        $response->assertSee('href="#como-funciona"', false);
        $response->assertSee('href="#profissionais"', false);
        $response->assertSee('href="#sobre"', false);
        $response->assertSee('id="como-funciona"', false);
        $response->assertSee('id="sobre"', false);
    }

    public function test_logout_is_not_available_over_get()
    {
        $this->get('/logout')->assertStatus(405);
    }

    public function test_management_pages_and_forms_render()
    {
        foreach ([
            'usuario.index',
            'equipamentos.index',
            'tecnicos.index',
            'enderecos.index',
            'servicos.index',
            'agendamentos.index',
            'itens-servico.index',
            'pagamentos.index',
            'locacoes-equipamentos.index',
            'dados-bancarios.index',
            'habilidades.index',
            'usuario.create',
            'equipamentos.create',
            'tecnicos.create',
            'enderecos.create',
            'servicos.create',
            'agendamentos.create',
            'itens-servico.create',
            'pagamentos.create',
            'locacoes-equipamentos.create',
            'dados-bancarios.create',
            'habilidades.create',
            'tecnico.dashboard',
            'dashboard.graficos',
            'relatorios.index',
            'modulos.index',
        ] as $route) {
            $this->get(route($route))->assertOk();
        }
        $cliente = Usuario::create([
            'nome_razao' => 'Cliente do painel',
            'email' => 'painel@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678910',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999990',
            'tipo' => 'Usuário',
        ]);
        $this->actingAs($cliente)->get(route('cliente.dashboard'))->assertOk();
        $this->get(route('equipamentos.search', ['valor' => 'furadeira', 'tipo' => 'nome']))->assertOk();
        $this->get(route('enderecos.search', ['valor' => 'Centro', 'tipo' => 'bairro']))->assertOk();
        $this->get(route('modulos.show', 'cadastros'))->assertOk();
    }

    public function test_csv_and_printable_reports_render_for_each_listing()
    {
        foreach ([
            'usuarios',
            'tecnicos',
            'equipamentos',
            'enderecos',
            'servicos',
            'agendamentos',
            'itens-servico',
            'pagamentos',
            'locacoes',
            'dados-bancarios',
            'habilidades',
        ] as $tipo) {
            $this->get(route('relatorios.listagem', $tipo))->assertOk();
            $this->get(route('relatorios.csv', $tipo))->assertOk();
        }
    }

    public function test_public_user_signup_creates_user_and_primary_address()
    {
        Storage::fake('public');

        $this->post(route('register.usuario.submit'), [
            'nome_razao' => 'Cliente novo',
            'email' => 'novo-cliente@example.test',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'cpf_cnpj' => '123.456.789-11',
            'telefone' => '(11)99999-9999',
            'data_nascimento' => '1990-01-01',
            'foto' => UploadedFile::fake()->image('cliente.png'),
            'apelido' => 'Casa',
            'rua' => 'Rua Principal',
            'numero' => 25,
            'bairro' => 'Centro',
            'cep' => '01000-000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'pais' => 'Brasil',
        ])->assertRedirect(route('cliente.dashboard'));

        $cliente = Usuario::where('email', 'novo-cliente@example.test')->firstOrFail();
        $this->assertSame('Usuário', $cliente->tipo);
        Storage::disk('public')->assertExists($cliente->foto);
        $this->get(route('usuario.foto', $cliente->UserID))->assertOk();
        $this->assertDatabaseHas('enderecos', [
            'userID' => $cliente->UserID,
            'apelido' => 'Casa',
            'rua' => 'Rua Principal',
        ]);
    }

    public function test_public_technician_signup_creates_bank_details()
    {
        Storage::fake('public');

        $this->post(route('register.tecnico.submit'), [
            'nome_razao' => 'Técnico novo',
            'email' => 'novo-tecnico@example.test',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'cpf_cnpj' => '123.456.789-12',
            'telefone' => '(11)99999-9998',
            'data_nascimento' => '1990-01-01',
            'foto' => UploadedFile::fake()->image('tecnico.png'),
            'habilidades' => "Elétrica\nHidráulica",
            'banco' => 'Banco de Teste',
            'agencia' => '1234',
            'numero_conta' => '123456-7',
            'tipo_conta' => '1',
            'titular' => 'Técnico novo',
            'cpf_cnpj_titular' => '529.982.247-25',
            'documento' => UploadedFile::fake()->create('certificado-publico.pdf', 10, 'application/pdf'),
        ])->assertRedirect(route('tecnico.dashboard'));

        $usuario = Usuario::where('email', 'novo-tecnico@example.test')->firstOrFail();
        $tecnico = Tecnicos::where('UserID', $usuario->UserID)->firstOrFail();
        $this->assertNotEmpty($tecnico->documento);
        Storage::disk('public')->assertExists($usuario->foto);
        $this->get(route('usuario.foto', $usuario->UserID))->assertOk();
        Storage::disk('public')->assertExists($tecnico->documento);
        $this->assertDatabaseHas('habilidade', [
            'TecnicoID' => $tecnico->TecnicoID,
            'descricao' => 'Hidráulica',
        ]);
        $this->get(route('tecnicos.certificado', $tecnico->TecnicoID))->assertOk();
        $this->assertDatabaseHas('dados_bancarios', [
            'TecnicoID' => $tecnico->TecnicoID,
            'banco' => 'Banco de Teste',
            'agencia' => '1234',
            'numero_conta' => '123456-7',
            'tipo_conta' => 1,
        ]);

        $this->put(route('usuario.update', $usuario->UserID), [
            'nome_razao' => $usuario->nome_razao,
            'email' => $usuario->email,
            'telefone' => $usuario->telefone,
            'cpf_cnpj' => $usuario->cpf_cnpj,
            'data_nascimento' => '1990-01-01',
        ])->assertRedirect(route('usuario.index'));

        $this->assertDatabaseHas('usuario', [
            'UserID' => $usuario->UserID,
            'tipo' => 'Técnico',
        ]);
    }

    public function test_admin_technician_form_saves_bank_details_and_certificate()
    {
        Storage::fake('public');

        $this->post(route('tecnicos.store'), [
            'nome_razao' => 'Técnico administrativo',
            'email' => 'tecnico-admin@example.test',
            'cpf_cnpj' => '12345678916',
            'telefone' => '11999999916',
            'data_nascimento' => '1990-01-01',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'habilidades' => "Elétrica\nHidráulica",
            'banco' => 'Banco Inicial',
            'agencia' => '1234',
            'numero_conta' => '123456-7',
            'tipo_conta' => '1',
            'titular' => 'Técnico administrativo',
            'cpf_cnpj_titular' => '52998224725',
            'documento' => UploadedFile::fake()->create('certificado.pdf', 10, 'application/pdf'),
        ])->assertRedirect(route('tecnicos.index'));

        $usuario = Usuario::where('email', 'tecnico-admin@example.test')->firstOrFail();
        $tecnico = Tecnicos::where('UserID', $usuario->UserID)->firstOrFail();
        $this->assertNotEmpty($tecnico->documento);
        Storage::disk('public')->assertExists($tecnico->documento);
        $this->assertDatabaseHas('dados_bancarios', [
            'TecnicoID' => $tecnico->TecnicoID,
            'banco' => 'Banco Inicial',
            'numero_conta' => '123456-7',
        ]);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('senha123', $usuario->password));
        $this->assertDatabaseHas('habilidade', [
            'TecnicoID' => $tecnico->TecnicoID,
            'descricao' => 'Elétrica',
        ]);
        $this->get(route('tecnicos.certificado', $tecnico->TecnicoID))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');

        $certificadoAnterior = $tecnico->documento;
        $this->post(route('tecnicos.update', $tecnico->TecnicoID), [
            '_method' => 'PUT',
            'nome_razao' => $usuario->nome_razao,
            'email' => $usuario->email,
            'cpf_cnpj' => $usuario->cpf_cnpj,
            'telefone' => $usuario->telefone,
            'data_nascimento' => '1990-01-01',
            'habilidades' => "Elétrica\nMecânica",
            'banco' => 'Banco Atualizado',
            'agencia' => '4321',
            'numero_conta' => '765432-1',
            'tipo_conta' => '2',
            'titular' => 'Técnico administrativo',
            'cpf_cnpj_titular' => '52998224725',
            'documento' => UploadedFile::fake()->create('novo-certificado.pdf', 20, 'application/pdf'),
        ])->assertRedirect(route('tecnicos.index'));

        $tecnico->refresh();
        Storage::disk('public')->assertMissing($certificadoAnterior);
        Storage::disk('public')->assertExists($tecnico->documento);
        $this->assertDatabaseHas('dados_bancarios', [
            'TecnicoID' => $tecnico->TecnicoID,
            'banco' => 'Banco Atualizado',
            'tipo_conta' => 2,
        ]);
    }

    public function test_user_list_excludes_technicians_from_results_and_search()
    {
        Usuario::create([
            'nome_razao' => 'Admin visível',
            'email' => 'admin-visivel@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678917',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999917',
            'tipo' => 'Administrador',
        ]);
        Usuario::create([
            'nome_razao' => 'Cliente visível',
            'email' => 'cliente-visivel@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678918',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999918',
            'tipo' => 'Usuário',
        ]);
        Usuario::create([
            'nome_razao' => 'Técnico oculto',
            'email' => 'tecnico-oculto@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678919',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999919',
            'tipo' => 'Técnico',
        ]);

        $this->get(route('usuario.index'))
            ->assertOk()
            ->assertSee('Admin visível')
            ->assertSee('Cliente visível')
            ->assertDontSee('Técnico oculto')
            ->assertSee('Lista de endereços')
            ->assertSee('Cadastrar endereço');

        $this->get(route('usuario.search', ['termo' => 'Técnico oculto']))
            ->assertOk()
            ->assertDontSee('Técnico oculto');
    }

    public function test_user_address_list_and_create_are_scoped_to_the_selected_user()
    {
        $cliente = Usuario::create([
            'nome_razao' => 'Cliente com endereço',
            'email' => 'cliente-endereco@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678920',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999920',
            'tipo' => 'Usuário',
        ]);
        $outroCliente = Usuario::create([
            'nome_razao' => 'Outro usuário',
            'email' => 'outro-endereco@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678921',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999921',
            'tipo' => 'Usuário',
        ]);
        Enderecos::create([
            'userID' => $cliente->UserID,
            'apelido' => 'Casa do cliente',
            'rua' => 'Rua do cliente selecionado',
            'numero' => 1,
            'bairro' => 'Centro',
            'cep' => '01000000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'pais' => 'Brasil',
        ]);
        Enderecos::create([
            'userID' => $outroCliente->UserID,
            'apelido' => 'Casa alheia',
            'rua' => 'Rua de outro usuário',
            'numero' => 2,
            'bairro' => 'Centro',
            'cep' => '01000000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'pais' => 'Brasil',
        ]);

        $this->get(route('usuario.enderecos.index', $cliente->UserID))
            ->assertOk()
            ->assertSee('Rua do cliente selecionado')
            ->assertDontSee('Rua de outro usuário');
        $this->get(route('usuario.enderecos.create', $cliente->UserID))
            ->assertOk()
            ->assertSee('Cliente com endereço')
            ->assertSee('action="' . route('usuario.enderecos.store', $cliente->UserID) . '"', false);

        $this->post(route('usuario.enderecos.store', $cliente->UserID), [
            'UserID' => $outroCliente->UserID,
            'apelido' => 'Trabalho',
            'rua' => 'Novo endereço',
            'numero' => 3,
            'bairro' => 'Centro',
            'cep' => '01000000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'pais' => 'Brasil',
        ])->assertRedirect(route('usuario.enderecos.index', $cliente->UserID));

        $this->assertDatabaseHas('enderecos', [
            'userID' => $cliente->UserID,
            'rua' => 'Novo endereço',
        ]);
        $this->assertDatabaseMissing('enderecos', [
            'userID' => $outroCliente->UserID,
            'rua' => 'Novo endereço',
        ]);
    }

    public function test_customers_can_only_manage_their_own_addresses()
    {
        $cliente = Usuario::create([
            'nome_razao' => 'Cliente dono',
            'email' => 'dono@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678913',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999993',
            'tipo' => 'Usuário',
        ]);
        $outroCliente = Usuario::create([
            'nome_razao' => 'Outro cliente',
            'email' => 'outro@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678914',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999992',
            'tipo' => 'Usuário',
        ]);
        $enderecoAlheio = Enderecos::create([
            'userID' => $outroCliente->UserID,
            'apelido' => 'Privado',
            'rua' => 'Rua privada',
            'numero' => 10,
            'bairro' => 'Centro',
            'cep' => '01000000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'pais' => 'Brasil',
        ]);

        $this->actingAs($cliente)
            ->get(route('cliente.dashboard'))
            ->assertOk()
            ->assertDontSee('Rua privada');
        $this->get(route('cliente.enderecos.index'))->assertOk()->assertDontSee('Rua privada');
        $this->get(route('cliente.enderecos.edit', $enderecoAlheio->EnderecosID))->assertNotFound();
        $this->delete(route('cliente.enderecos.destroy', $enderecoAlheio->EnderecosID))->assertNotFound();

        $this->post(route('cliente.enderecos.store'), [
            'UserID' => $outroCliente->UserID,
            'apelido' => 'Trabalho',
            'rua' => 'Rua do cliente',
            'numero' => 20,
            'bairro' => 'Centro',
            'cep' => '01000000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'pais' => 'Brasil',
        ])->assertRedirect(route('cliente.enderecos.index'));

        $enderecoDoCliente = Enderecos::where('rua', 'Rua do cliente')->firstOrFail();
        $this->assertSame($cliente->UserID, $enderecoDoCliente->userID);
        $this->get(route('cliente.enderecos.index'))->assertSee('Rua do cliente');

        $this->put(route('cliente.enderecos.update', $enderecoDoCliente->EnderecosID), [
            'apelido' => 'Escritório',
            'rua' => 'Rua atualizada',
            'numero' => 21,
            'bairro' => 'Centro',
            'cep' => '01000000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'pais' => 'Brasil',
        ])->assertRedirect(route('cliente.enderecos.index'));
        $this->assertDatabaseHas('enderecos', [
            'EnderecosID' => $enderecoDoCliente->EnderecosID,
            'userID' => $cliente->UserID,
            'rua' => 'Rua atualizada',
        ]);

        $this->delete(route('cliente.enderecos.destroy', $enderecoDoCliente->EnderecosID))
            ->assertRedirect(route('cliente.enderecos.index'));
        $this->assertDatabaseMissing('enderecos', ['EnderecosID' => $enderecoDoCliente->EnderecosID]);
    }

    public function test_technician_is_not_an_option_in_user_registration()
    {
        $this->get(route('usuario.create'))
            ->assertOk()
            ->assertDontSee('value="Técnico"', false);

        $this->post(route('usuario.store'), [
            'nome_razao' => 'Cadastro inválido',
            'email' => 'perfil-invalido@example.test',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'cpf_cnpj' => '12345678915',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999991',
            'tipo' => 'Técnico',
        ])->assertSessionHasErrors('tipo');

        $this->assertDatabaseMissing('usuario', ['email' => 'perfil-invalido@example.test']);
    }

    public function test_creating_an_address_uses_the_users_real_primary_key()
    {
        $usuario = Usuario::create([
            'nome_razao' => 'Cliente de teste',
            'email' => 'cliente@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678901',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999999',
            'tipo' => 'Usuário',
        ]);

        $response = $this->post(route('enderecos.store'), [
            'UserID' => $usuario->UserID,
            'apelido' => 'Casa',
            'rua' => 'Rua Central',
            'numero' => 10,
            'bairro' => 'Centro',
            'cep' => '01000000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'pais' => 'Brasil',
        ]);

        $response->assertRedirect(route('enderecos.index'));
        $this->assertDatabaseHas('enderecos', [
            'userID' => $usuario->UserID,
            'apelido' => 'Casa',
        ]);
    }

    public function test_service_and_booking_forms_save_enum_values_and_foreign_keys()
    {
        $tecnicoUsuario = Usuario::create([
            'nome_razao' => 'Técnico de teste',
            'email' => 'tecnico@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678902',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999998',
            'tipo' => 'Técnico',
        ]);
        $tecnico = Tecnicos::create(['UserID' => $tecnicoUsuario->UserID]);
        $cliente = Usuario::create([
            'nome_razao' => 'Cliente de teste',
            'email' => 'cliente2@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678903',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999997',
            'tipo' => 'Usuário',
        ]);

        $this->post(route('servicos.store'), [
            'TecnicoID' => $tecnico->TecnicoID,
            'titulo' => 'Reparo de teste',
            'categoria' => 'Eletrônica',
            'descricao' => 'Atendimento de teste',
            'preco_base' => 120,
            'tipo_preco' => 'Hora',
        ])->assertRedirect(route('servicos.index'));

        $servico = Servico::firstOrFail();
        $this->post(route('agendamentos.store'), [
            'UserID' => $cliente->UserID,
            'TecnicoID' => $tecnico->TecnicoID,
            'ServicoID' => $servico->ServicoID,
            'data_hora_inicio' => '2026-12-01 10:00:00',
            'data_hora_fim' => '2026-12-01 11:00:00',
            'status_servico' => 'Concluido',
        ])->assertRedirect(route('agendamentos.index'));

        $agendamento = \App\Models\Agendamento::firstOrFail();
        $this->get(route('agendamentos.show', $agendamento->AgendamentoID))
            ->assertOk()
            ->assertSee('Detalhes do agendamento');

        $this->assertDatabaseHas('agendamento', [
            'UserID' => $cliente->UserID,
            'TecnicoID' => $tecnico->TecnicoID,
            'ServicoID' => $servico->ServicoID,
            'status_servico' => 'Concluido',
        ]);
        $this->get(route('agendamentos.index'))->assertOk();
    }

    public function test_equipment_rental_and_payment_save_the_selected_equipment()
    {
        $usuario = Usuario::create([
            'nome_razao' => 'Cliente locação',
            'email' => 'locacao@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678904',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999996',
            'tipo' => 'Usuário',
        ]);
        $equipamento = Equipamentos::create([
            'UserID' => $usuario->UserID,
            'nome' => 'Furadeira',
            'modelo' => 'F-100',
            'descricao_tecnica' => 'Equipamento de teste',
            'data_compra' => '2025-01-01 10:00:00',
            'valor_aluguel' => 80,
            'status' => 'Disponível',
        ]);
        $this->assertSame($equipamento->EquipID, $equipamento->getKey());

        $this->post(route('locacoes-equipamentos.store'), [
            'UserID' => $usuario->UserID,
            'EquipID' => $equipamento->EquipID,
            'data_retirada' => '2026-12-01 09:00:00',
            'data_devolucao' => '2026-12-02 09:00:00',
        ])->assertRedirect(route('locacoes-equipamentos.index'));

        $locacao = \App\Models\LocacaoEquip::firstOrFail();
        $this->post(route('pagamentos.store'), [
            'LocEquipID' => $locacao->LocEquipID,
            'metodo' => 'PIX',
            'valor_total' => 80,
            'taxa_site' => 8,
            'status_pagamento' => '1',
            'data_pagamento' => '2026-12-01 09:00:00',
        ])->assertRedirect(route('pagamentos.index'));

        $this->assertDatabaseHas('locacao_equips', [
            'LocEquipID' => $locacao->LocEquipID,
            'EquipID' => $equipamento->EquipID,
        ]);
        $this->assertDatabaseHas('pagamentos', [
            'LocEquipID' => $locacao->LocEquipID,
            'status_pagamento' => 1,
        ]);
    }

    public function test_admin_user_creation_stores_a_hashed_password()
    {
        $this->post(route('usuario.store'), [
            'nome_razao' => 'Novo usuário',
            'email' => 'novo@example.test',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'cpf_cnpj' => '12345678905',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999995',
            'tipo' => 'Usuário',
        ])->assertRedirect(route('usuario.index'));

        $usuario = Usuario::where('email', 'novo@example.test')->firstOrFail();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('senha123', $usuario->password));
    }

    public function test_equipment_store_saves_daily_rate_and_condition()
    {
        Storage::fake('public');
        $usuario = Usuario::create([
            'nome_razao' => 'Proprietário',
            'email' => 'proprietario@example.test',
            'password' => bcrypt('senha123'),
            'cpf_cnpj' => '12345678906',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11999999994',
            'tipo' => 'Usuário',
        ]);

        $this->post(route('equipamentos.store'), [
            'UserID' => $usuario->UserID,
            'nome' => 'Furadeira profissional',
            'modelo' => 'F-200',
            'descricao_tecnica' => 'Furadeira em ótimo estado.',
            'estado_conservacao' => 'Muito Bom',
            'valor_diaria' => '45.50',
            'imagem' => UploadedFile::fake()->image('furadeira.png'),
            'status' => 'Disponível',
        ])->assertRedirect(route('equipamentos.index'));

        $equipamento = Equipamentos::where('nome', 'Furadeira profissional')->firstOrFail();
        $this->assertDatabaseHas('equipamentos', [
            'EquipID' => $equipamento->EquipID,
            'nome' => 'Furadeira profissional',
            'estado_conservacao' => 'Muito Bom',
            'valor_diaria' => 45.50,
            'valor_aluguel' => 45.50,
        ]);
        Storage::disk('public')->assertExists($equipamento->imagem);
        $this->get(route('equipamentos.imagem', $equipamento->EquipID))->assertOk();
    }

    public function test_invalid_bank_document_is_rejected()
    {
        $this->post(route('tecnicos.store'), [
            'nome_razao' => 'Técnico inválido',
            'email' => 'tecnico-invalido@example.test',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'cpf_cnpj' => '12345678916',
            'telefone' => '11999999916',
            'data_nascimento' => '1990-01-01',
            'habilidades' => 'Elétrica',
            'banco' => 'Banco de Teste',
            'agencia' => '1234',
            'numero_conta' => '123456-7',
            'tipo_conta' => '1',
            'titular' => 'Técnico inválido',
            'cpf_cnpj_titular' => '11111111111',
        ])->assertSessionHasErrors('cpf_cnpj_titular');

        $this->assertDatabaseMissing('usuario', ['email' => 'tecnico-invalido@example.test']);
    }
}
