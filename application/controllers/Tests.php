<?php

class Tests extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function enviar_email()
    {

        $email = $this->input->get('email');

        EnviarEmail($email, 'assunto teste', 'testeeeeeeee');
    }

    public function enviar_sms_teste()
    {

        EnviarSMS('5511941118632', 'SMS de teste');
    }

    public function send_sms_leads($tipo = 1)
    {

        $adms['5511941118632'] = 'Alisson';
        $adms['5511938002110'] = 'Guilherme';

        $query = $this->db->query("SELECT f1.id_usuario, u.perfil, u.nome, u.login, u.email, u.ddi, u.celular, u.score, f1.valor, f1.data_expiracao, (SELECT COUNT(*) FROM faturas AS f2 WHERE f2.id != f1.id AND f2.id_usuario = f1.id_usuario AND f2.status = 1) AS total_ativados_agora FROM faturas AS f1 INNER JOIN usuarios_cadastros AS u ON u.id = f1.id_usuario WHERE f1.status = 2 AND f1.cortesia = 0 ORDER BY total_ativados_agora ASC, f1.valor DESC");

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                if ($row->total_ativados_agora == 0) {

                    $novo_score = $row->score + 300;

                    $celular = str_replace(array('(', ')', ' ', '-', '.', '+'), array('', '', '', '', '', ''), $row->ddi . $row->celular);

                    if ($tipo == 1) {

                        $this->db->where('id', $row->id_usuario);
                        $this->db->update('usuarios_cadastros', array('score' => $novo_score));

                        EnviarSMS($celular, 'Olá ' . $row->nome . ', você ganhou um presente de 300 pontos de score na starkpix Invest, acesse nosso site starkpix.com e confira!');
                    } elseif ($tipo == 2) {

                        EnviarSMS($celular, 'Olá ' . $row->nome . ', você ganhou um novo nível na starkpix, novos pacotes estão disponíveis para você!!!.');
                    } elseif ($tipo == 3) {

                        EnviarSMS($celular, 'Parabéns, você foi sorteado na sorte da semana starkpix e pode escolher um plano do nível 4 e ganhar 65% de rendimento.');
                        EnviarSMS($celular, ' Solicite ao suporte 11967770008 informando a chave: starkpixSORTE4. Promoção válida por 24h.');
                    }
                }
            }

            foreach ($adms as $telefone => $nome) {

                if ($tipo == 1) {

                    EnviarSMS($telefone, 'Olá ' . $nome . ', você ganhou um presente de 300 pontos de score na starkpix Invest, acesse nosso site starkpix.com e confira!');
                } elseif ($tipo == 2) {

                    EnviarSMS($telefone, 'Olá ' . $nome . ', você ganhou um novo nível na starkpix, novos pacotes estão disponíveis para você!!!.');
                } elseif ($tipo == 3) {


                    EnviarSMS($telefone, 'Parabéns, você foi sorteado na sorte da semana starkpix e pode escolher um plano do nível 4 e ganhar 65% de rendimento.');
                    EnviarSMS($telefone, ' Solicite ao suporte 11967770008 informando a chave: starkpixSORTE4. Promoção válida por 24h.');
                }
            }
        }
    }
}
