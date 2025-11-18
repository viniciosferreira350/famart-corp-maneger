<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Equipe;
use App\Models\Celular;
use App\Models\WhatsappNumero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário master
        $master = User::create([
            'name' => 'Administrador',
            'email' => 'admin@famartcorp.com',
            'password' => Hash::make('password'),
            'cargo' => 'master',
        ]);

        // Criar equipes
        $equipeA = Equipe::create(['nome' => 'Equipe A']);
        $equipeB = Equipe::create(['nome' => 'Equipe B']);
        $equipeC = Equipe::create(['nome' => 'Equipe C']);

        // Criar gestores
        $gestorA = User::create([
            'name' => 'João Silva',
            'email' => 'joao.silva@famartcorp.com',
            'password' => Hash::make('password'),
            'cargo' => 'gestor',
            'equipe_id' => $equipeA->id,
        ]);

        $gestorB = User::create([
            'name' => 'Maria Santos',
            'email' => 'maria.santos@famartcorp.com',
            'password' => Hash::make('password'),
            'cargo' => 'gestor',
            'equipe_id' => $equipeB->id,
        ]);

        // Atualizar equipes com gestores
        $equipeA->update(['gestor_id' => $gestorA->id]);
        $equipeB->update(['gestor_id' => $gestorB->id]);

        // Criar consultores para Equipe A
        $consultoresA = [];
        $consultoresA[] = User::create([
            'name' => 'Pedro Oliveira',
            'email' => 'pedro.oliveira@famartcorp.com',
            'password' => Hash::make('password'),
            'cargo' => 'consultor',
            'equipe_id' => $equipeA->id,
        ]);

        $consultoresA[] = User::create([
            'name' => 'Ana Costa',
            'email' => 'ana.costa@famartcorp.com',
            'password' => Hash::make('password'),
            'cargo' => 'consultor',
            'equipe_id' => $equipeA->id,
        ]);

        $consultoresA[] = User::create([
            'name' => 'Carlos Souza',
            'email' => 'carlos.souza@famartcorp.com',
            'password' => Hash::make('password'),
            'cargo' => 'consultor',
            'equipe_id' => $equipeA->id,
        ]);

        // Criar consultores para Equipe B
        $consultoresB = [];
        $consultoresB[] = User::create([
            'name' => 'Fernanda Lima',
            'email' => 'fernanda.lima@famartcorp.com',
            'password' => Hash::make('password'),
            'cargo' => 'consultor',
            'equipe_id' => $equipeB->id,
        ]);

        $consultoresB[] = User::create([
            'name' => 'Roberto Alves',
            'email' => 'roberto.alves@famartcorp.com',
            'password' => Hash::make('password'),
            'cargo' => 'consultor',
            'equipe_id' => $equipeB->id,
        ]);

        // Criar celulares para consultores da Equipe A
        foreach ($consultoresA as $index => $consultor) {
            $celular = Celular::create([
                'marca' => ['Samsung', 'Xiaomi', 'Motorola'][$index % 3],
                'modelo' => ['Galaxy A54', 'Redmi Note 12', 'Moto G84'][$index % 3],
                'imei' => '35' . str_pad((string)($index + 1000), 13, '0', STR_PAD_LEFT),
                'observacao' => 'Celular em bom estado',
                'consultor_id' => $consultor->id,
                'equipe_id' => $equipeA->id,
            ]);

            // Criar 2 números WhatsApp para cada celular
            WhatsappNumero::create([
                'numero' => '+5511' . str_pad((string)(90000 + $index * 10), 8, '0', STR_PAD_LEFT),
                'status' => 'ativo',
                'celular_id' => $celular->id,
                'consultor_id' => $consultor->id,
                'equipe_id' => $equipeA->id,
            ]);

            WhatsappNumero::create([
                'numero' => '+5511' . str_pad((string)(90001 + $index * 10), 8, '0', STR_PAD_LEFT),
                'status' => 'ativo',
                'celular_id' => $celular->id,
                'consultor_id' => $consultor->id,
                'equipe_id' => $equipeA->id,
            ]);
        }

        // Criar celulares para consultores da Equipe B
        foreach ($consultoresB as $index => $consultor) {
            $celular = Celular::create([
                'marca' => ['Samsung', 'iPhone'][$index % 2],
                'modelo' => ['Galaxy S23', 'iPhone 14'][$index % 2],
                'imei' => '35' . str_pad((string)($index + 2000), 13, '0', STR_PAD_LEFT),
                'observacao' => 'Aparelho novo',
                'consultor_id' => $consultor->id,
                'equipe_id' => $equipeB->id,
            ]);

            // Criar números WhatsApp
            WhatsappNumero::create([
                'numero' => '+5521' . str_pad((string)(90000 + $index * 10), 8, '0', STR_PAD_LEFT),
                'status' => 'ativo',
                'celular_id' => $celular->id,
                'consultor_id' => $consultor->id,
                'equipe_id' => $equipeB->id,
            ]);

            WhatsappNumero::create([
                'numero' => '+5521' . str_pad((string)(90001 + $index * 10), 8, '0', STR_PAD_LEFT),
                'status' => ['ativo', 'restrito'][$index % 2],
                'celular_id' => $celular->id,
                'consultor_id' => $consultor->id,
                'equipe_id' => $equipeB->id,
            ]);
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('👤 Master: admin@famartcorp.com / password');
        $this->command->info('👥 Gestores: joao.silva@famartcorp.com, maria.santos@famartcorp.com / password');
        $this->command->info('👥 Consultores: pedro.oliveira@famartcorp.com, ana.costa@famartcorp.com, etc. / password');
    }
}
