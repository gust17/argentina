<?php

set_time_limit(5000);

class Seeders extends MY_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function populationdb(){

        $usuarios = [];
        $planos = [];
        $planos_valores = [];
        $logs = ['Acessou seu backoffice', 'Atualizou a carteira bitcoin', 'Atualizou a sua BankOn', 'O usuário gerou uma fatura no valor de R$ 300,00', 'Atualizou a chave Pix'];
        $meios = ['BankOn', 'Criptomoedas', 'Boleto', 'NewPay', 'Conta Bancária'];

        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\pt_BR\Person($faker));
        $faker->addProvider(new Faker\Provider\pt_BR\Address($faker));
        $faker->addProvider(new Faker\Provider\pt_BR\PhoneNumber($faker));
        $faker->addProvider(new Faker\Provider\pt_BR\Company($faker));
        $faker->addProvider(new Faker\Provider\Internet($faker));
        $faker->addProvider(new Faker\Provider\DateTime($faker));

        for($i = 1; $i<=1000; $i++){

            $this->db->insert('usuarios_cadastros', array(
                'codigo_patrocinio'=>GenerateCode(4),
                'tipo_cadastro'=>1,
                'nome'=>$faker->firstName.' '.$faker->lastName,
                'email'=>$faker->email,
                'data_nascimento'=>$faker->dateTimeBetween('-30 years', '-20 years')->format('Y-m-d'),
                'ddi'=>$faker->randomDigit,
                'celular'=>$faker->cellphoneNumber,
                'documento'=>$faker->cpf,
                'sexo'=>1,
                'cep'=>$faker->postcode,
                'endereco'=>$faker->streetAddress,
                'bairro'=>'B: '.$faker->city,
                'cidade'=>$faker->city,
                'estado'=>$faker->state,
                'login'=>$faker->userName,
                'senha'=>password_hash('123456', PASSWORD_DEFAULT),
                'status'=>1,
                'exibir'=>1,
                'perfil'=>rand(1,2),
                'saque_liberado'=>1,
                'plano_ativo'=>1,
                'binario_ativo'=>0,
                'chave_binaria'=>1,
                'pontos_carreira'=>$faker->numberBetween(10,9999),
                'carteira_bitcoin'=>json_encode(array('carteira_bitcoin'=>$faker->bankAccountNumber)),
                'bankon'=>json_encode(array('bankon'=>$faker->userName)),
                'newpay'=>json_encode(array('newpay'=>$faker->userName)),
                'pix'=>json_encode(array('pix'=>$faker->cpf)),
                'conta_bancaria'=>json_encode(array('tipo'=>1, 'banco'=>341, 'agencia'=>$faker->numberBetween(1000,9999), 'conta'=>$faker->numberBetween(300000,900000), 'titular'=>$faker->name, 'documento'=>$faker->cpf)),
                'score'=>$faker->numberBetween(200,2000),
                'ultimo_ip'=>$faker->ipv4,
                'ultimo_login'=>$faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'data_cadastro'=>$faker->dateTimeThisDecade()->format('Y-m-d H:i:s'),
                'data_atualizacao'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s')

            ));

            $usuarios[] = $this->db->insert_id();
        }

        $precoAnterior = 50;
        $scoreNecessarioAnterior = 50;
        $scoreGanhoAnterior = 10;

        for($i=0; $i<=10;$i++){

            $preco = rand($precoAnterior, ($precoAnterior*3));
            $scoreNecessario = rand($scoreNecessarioAnterior, ($scoreNecessarioAnterior*2));
            $scoreGanho = rand($scoreGanhoAnterior, ($scoreGanhoAnterior*1.8));

            $this->db->insert('planos', array(
                'nome'=>$faker->numerify('Plano ##'),
                'niveis_indicacao'=>'{ "1": 12, "2": 8, "3": 5, "4": 3, "5": 1 }',
                'preco'=>$preco,
                'pontos'=>0,
                'dia_util'=>1,
                'quantidade_dias'=>15,
                'percentual_pago'=>100,
                'compras_simultaneas'=>100,
                'score_necessario'=>$scoreNecessario,
                'score_ganho'=>$scoreGanho
            ));

            $id_plano = $this->db->insert_id();

            $planos[] = $id_plano;
            $planos_valores[$id_plano] = $preco;

            $precoAnterior = $preco;
            $scoreNecessarioAnterior = $scoreNecessario;
            $scoreGanhoAnterior = $scoreGanho;
        }

        foreach($usuarios as $id_usuario){

            $this->db->insert('rede', array(
                'id_usuario'=>$id_usuario,
                'id_patrocinador_direto'=>$usuarios[rand(0, count($usuarios)-1)],
                'id_patrocinador_rede'=>$usuarios[rand(0, count($usuarios)-1)],
                'chave_binaria'=>rand(1,2)
            ));

            for($i=1;$i<=rand(3,9);$i++){

                $rand_plano = rand(0, count($planos)-1);

                $this->db->insert('faturas', array(
                    'renovacao'=>0,
                    'id_usuario'=>$id_usuario,
                    'id_plano'=>$planos[$rand_plano],
                    'valor'=>$planos_valores[$rand_plano],
                    'niveis_indicacao'=>'{ "1": 12, "2": 8, "3": 5, "4": 3, "5": 1 }',
                    'dia_util'=>1,
                    'percentual_pago'=>100,
                    'quantidade_pagamento_fazer'=>15,
                    'quantidade_pagamentos_realizado'=>rand(0,14),
                    'valor_recebido'=>rand(10,1000),
                    'valor_liberado'=>rand(5,500),
                    'cortesia'=>0,
                    'meio_pagamento'=>$meios[rand(0, count($meios)-1)],
                    'status'=>1,
                    'status_saque_raiz'=>0,
                    'data_criacao'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                    'data_pagamento'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                    'data_primeiro_recebimento'=>$faker->dateTimeThisMonth()->format('Y-m-d')
                ));
            }

            for($i=1; $i<=rand(10,25); $i++){

                $this->db->insert('notificacoes', array(
                    'id_usuario'=>$id_usuario,
                    'notificacao'=>'Uma notificação para preencher o banco de dados',
                    'visualizado'=>rand(0,1),
                    'ip'=>$faker->ipv4,
                    'data_criacao'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
                ));
            }

            for($i=1;$i<=rand(0,14);$i++){

                $this->db->insert('extrato', array(
                    'id_usuario'=>$id_usuario,
                    'descricao'=>'Bonificação diária referente ao seu plano',
                    'valor'=>rand(10,150),
                    'tipo_saldo'=>1,
                    'categoria'=>1,
                    'liberado'=>1,
                    'data_criacao'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
                ));
            }

            for($i=1;$i<=rand(5,30);$i++){

                $this->db->insert('extrato', array(
                    'id_usuario'=>$id_usuario,
                    'descricao'=>'Bonificação de Rede',
                    'valor'=>rand(2,80),
                    'tipo_saldo'=>1,
                    'categoria'=>2,
                    'liberado'=>1,
                    'data_criacao'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
                ));
            }

            for($i=1;$i<=rand(1,7);$i++){

                $valorSolicitado = rand(30,500);

                $this->db->insert('saques', array(
                    'id_usuario'=>$id_usuario,
                    'valor_solicitado'=>$valorSolicitado,
                    'valor_receber'=>$valorSolicitado,
                    'conta_recebimento'=>'{ "bankon": "bankondeteste" }',
                    'tipo_saque'=>1,
                    'status'=>rand(0,2),
                    'data_solicitacao'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
                ));
            }

            for($i=1;$i<=rand(50,100); $i++){

                $this->db->insert('usuarios_cliques_link', array(
                    'id_usuario'=>$id_usuario,
                    'link'=>$faker->url,
                    'ip'=>$faker->ipv4,
                    'data_criacao'=>$faker->dateTimeThisYear()->format('Y-m-d H:i:s')
                ));
            }

            for($i=1;$i<=rand(100,500);$i++){

                $this->db->insert('usuarios_logs', array(
                    'id_usuario'=>$id_usuario,
                    'log'=>$logs[rand(0, count($logs)-1)],
                    'ip'=>$faker->ipv4,
                    'data_criacao'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
                ));
            }
        }
    }
}