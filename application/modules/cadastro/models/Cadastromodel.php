<?php

class Cadastromodel extends CI_Model
{

    protected $rotas;

    public function __construct()
    {
        parent::__construct();

        $this->rotas = MinhasRotas();
    }

    public function guidv4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function AddClickLink($sponsor)
    {

        $ip = $this->input->ip_address();
        $link = base_url() . ltrim($_SERVER['REQUEST_URI'], '/');

        $this->db->where('DATE(data_criacao)', date('Y-m-d'));
        $this->db->where('ip', $ip);
        $this->db->where('id_usuario', $sponsor);
        $query = $this->db->get('usuarios_cliques_link');

        if ($query->num_rows() <= 0) {

            $this->db->insert('usuarios_cliques_link', array(
                'id_usuario' => $sponsor,
                'link' => $link,
                'ip' => $ip,
                'data_criacao' => date('Y-m-d H:i:s')
            ));
        }
    }

    public function MeuPatrocinadorRede($id_usuario, $chave_binaria)
    {

        $this->db->where('id_patrocinador_rede', $id_usuario);
        $this->db->where('chave_binaria', $chave_binaria);
        $rede = $this->db->get('rede');

        if ($rede->num_rows() > 0) {

            $row = $rede->row();

            return $this->MeuPatrocinadorRede($row->id_usuario, $chave_binaria);
        }

        return $id_usuario;
    }

    public function MeuPatrocinador()
    {

        $qs = SystemInfo('query_string_patrocinador');

        $sponsor = $this->input->get($qs);

        if (is_null($sponsor) || $sponsor == '') {

            $checkSessionSponsor = $this->session->userdata('sponsor');

            if (!is_null($checkSessionSponsor) && $checkSessionSponsor != '') {

                $sponsor = $checkSessionSponsor;
            }
        }

        if (!is_null($sponsor)) {

            $this->db->where('codigo_patrocinio', $sponsor);
            $queryCheckCode = $this->db->get('usuarios_cadastros');

            if ($queryCheckCode->num_rows() > 0) {

                $this->session->unset_userdata('sponsor');
                $this->session->set_userdata('sponsor', $sponsor);

                $row = $queryCheckCode->row();

                $this->AddClickLink($row->id);

                return array(
                    'id' => $row->id,
                    'codigo_patrocinio' => $sponsor,
                    'nome' => $row->nome,
                    'chave_binaria' => $row->chave_binaria,
                    'link' => base_url() . $this->rotas->cadastro . '?' . $qs . '=' . $sponsor
                );
            }
        }

        /* Caso não exista nenhum patrocinador informado ou seja inválido o código, coloca a empresa como patrocinadora padrão */

        $this->db->where('codigo_patrocinio', SystemInfo('codigo_patrocinio_padrao'));
        $queryCheckDefaultCode = $this->db->get('usuarios_cadastros');

        if ($queryCheckDefaultCode->num_rows() > 0) {

            $row = $queryCheckDefaultCode->row();

            $this->AddClickLink($row->id);

            return array(
                'id' => $row->id,
                'codigo_patrocinio' => $row->codigo_patrocinio,
                'nome' => $row->nome,
                'chave_binaria' => $row->chave_binaria,
                'link' => base_url() . $this->rotas->cadastro
            );
        }

        return false;
    }

    public function RealizarCadastro()
    {

        $tipo_cadastro = $this->input->post('tipo_cadastro', true);
        $nome = $this->input->post('nome', true);
        $email = $this->input->post('email', true);
        $data_nascimento = $this->input->post('data_nascimento', true);
        $ddi = $this->input->post('ddi', true);
        $celular = $this->input->post('celular', true);
        $documento = $this->input->post('documento', true);
        $sexo = $this->input->post('sexo', true);
        $login = $this->input->post('login', true);
        $senha = $this->input->post('senha');
        $senha_confirmar = $this->input->post('senha_confirmar');
        $ip = $this->input->ip_address();
        $meuPatrocinador = $this->MeuPatrocinador();
        $token = $this->input->post('token', true);
        $action = $this->input->post('action', true);

        $responseRecaptcha = $this->recaptcha->verifyResponse($token, $action);

        if (isset($responseRecaptcha['success']) && $responseRecaptcha['success'] === true) {

            $this->db->where('login', $login);
            $this->db->where('data_exclusao IS NULL', null, false);
            $queryCheckLogin = $this->db->get('usuarios_cadastros');

            if ($queryCheckLogin->num_rows() <= 0) {

                $this->db->where('email', $email);
                $this->db->where('data_exclusao IS NULL', null, false);
                $queryCheckEmail = $this->db->get('usuarios_cadastros');

                if ($queryCheckEmail->num_rows() <= 0) {

                    // $this->db->where('documento', $documento);
                    // $this->db->where('data_exclusao IS NULL', null, false);
                    // $queryCheckDocumento = $this->db->get('usuarios_cadastros');

                    // if ($queryCheckDocumento->num_rows() <= 0) {

                    if (true) {

                        if ($senha == $senha_confirmar) {

                            do {

                                $codigo_patrocinio = $this->guidv4();

                                $this->db->where('codigo_patrocinio', $codigo_patrocinio);
                                $this->db->where('data_exclusao IS NULL', null, false);
                                $queryCheckCode = $this->db->get('usuarios_cadastros');
                            } while ($queryCheckCode->num_rows() > 0);

                            $this->db->insert('usuarios_cadastros', array(
                                'codigo_patrocinio' => $codigo_patrocinio,
                                'tipo_cadastro' => $tipo_cadastro,
                                'nome' => $nome,
                                'email' => $email,
                                'data_nascimento' => InverseDate($data_nascimento),
                                'ddi' => $ddi,
                                'celular' => $celular,
                                'documento' => $documento,
                                'sexo' => $sexo,
                                'login' => trim($login),
                                'senha' => password_hash($senha, PASSWORD_DEFAULT),
                                'cadastro_validado' => 1,
                                'status' => 1,
                                'ultimo_ip' => $ip,
                                'score' => 300,
                                'data_cadastro' => date('Y-m-d H:i:s')
                            ));

                            $idRegistrado = $this->db->insert_id();

                            if (is_array($meuPatrocinador)) {

                                $idPatrocinadorRede = $this->MeuPatrocinadorRede($meuPatrocinador['id'], $meuPatrocinador['chave_binaria']);

                                // $consultaConta = ConsultarDocumento($documento, $data_nascimento);

                                // if($consultaConta){
                                //     $this->db->where('id', $idRegistrado);
                                //     $this->db->update('usuarios_cadastros', array(
                                //         'cadastro_validado'=>1
                                //     ));
                                // }

                                $this->db->insert('rede', array(
                                    'id_usuario' => $idRegistrado,
                                    'id_patrocinador_direto' => $meuPatrocinador['id'],
                                    'id_patrocinador_rede' => $idPatrocinadorRede,
                                    'chave_binaria' => $meuPatrocinador['chave_binaria']
                                ));

                                CreateNotification(
                                    $idPatrocinadorRede,
                                    sprintf($this->lang->line('c_m_derramamento'), $login)
                                );

                                CreateLog(
                                    $idPatrocinadorRede,
                                    sprintf($this->lang->line('c_m_log_derramamento'), $login)
                                );

                                CreateNotification(
                                    $meuPatrocinador['id'],
                                    sprintf($this->lang->line('c_m_cadastro_direto'), $login)
                                );

                                CreateLog(
                                    $meuPatrocinador['id'],
                                    sprintf($this->lang->line('c_m_log_cadastro_direto'), $login)
                                );
                            }

                            CreateLog(
                                $idRegistrado,
                                sprintf($this->lang->line('c_m_log_cadastro_empresa'), $login)
                            );

                            CreateNotification(
                                $idRegistrado,
                                sprintf($this->lang->line('c_m_bem_vindo'), NOME_SITE)
                            );

                            return alerts(
                                $this->lang->line('c_m_cadastro_sucesso_1') . ' <a href="' . base_url($this->rotas->login) . '">' . $this->lang->line('c_m_cadastro_sucesso_2') . '</a>.',
                                'success'
                            );
                        }

                        return alerts($this->lang->line('c_m_senhas_incompativeis'), 'danger');
                    }

                    return alerts($this->lang->line('c_m_cpf_existente'), 'danger');
                }

                return alerts($this->lang->line('c_m_email_existente'), 'danger');
            }

            return alerts($this->lang->line('c_m_login_existente'), 'danger');
        }

        return alerts($this->lang->line('eu_nao_sou_robo'), 'danger');
    }
}
