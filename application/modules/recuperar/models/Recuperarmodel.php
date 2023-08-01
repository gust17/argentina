<?php
class Recuperarmodel extends CI_Model{

    protected $rotas;

    public function __construct(){
        parent::__construct();

        $this->rotas = MinhasRotas();
    }

    public function CheckValidCode($codigo){

        $this->db->where('codigo', $codigo);
        $query = $this->db->get('usuarios_codigos_recuperacao');

        if($query->num_rows() > 0){

            $row = $query->row();

            if($row->utilizado == 0){

                return array('success'=>1);
            }

            return array('success'=>0, 'error'=>alerts($this->lang->line('recuperar_m_link_utilizado'), 'danger'));
        }

        return array('success'=>0, 'error'=>alerts($this->lang->line('recuperar_m_link_invalido'), 'danger'));
    }

    public function EnviarLink(){

        $email = $this->input->post('email', true);

        $this->db->where('email', $email);
        $this->db->where('data_exclusao IS NULL', null, false);
        $query = $this->db->get('usuarios_cadastros');

        if($query->num_rows() > 0){

            $row = $query->row();
            
            $code = GenerateCode(20);

            $rota = str_replace(array('(:num)', '(:any)'), array($code, $code), $this->rotas->recuperar_senha_codigo);
            $link = base_url($rota);

            $message = $this->load->view('emails/recuperar_senha', array(
                'nome'=>$row->nome,
                'link'=>$link
            ), TRUE);

            $enviar = EnviarEmail($row->email, $this->lang->line('recuperar_m_email_titulo'), $message);

            $this->db->insert('usuarios_codigos_recuperacao', array(
                'id_usuario'=>$row->id,
                'codigo'=>$code,
                'utilizado'=>0,
                'data_criacao'=>date('Y-m-d H:i:s')
            ));

            if($enviar){

                CreateLog($row->id, 'O usuário '.$row->login.' acabou de solicitar a troca de senha através da recuperação de senha do site.');

                return alerts($this->lang->line('recuperar_m_email_enviado_ok'), 'success');
            }

            return alerts($this->lang->line('recuperar_m_email_enviado_error'), 'danger');
        }

        return alerts($this->lang->line('recuperar_m_email_nao_existe'), 'danger');
    }

    public function TrocarSenha($codigo){
        
        $senha = $this->input->post('senha');
        $senha_confirmar = $this->input->post('senha_confirmar');

        $checkValidCode = $this->CheckValidCode($codigo);

        if($checkValidCode['success'] == 1){

            if($senha == $senha_confirmar){

                $this->db->where('codigo', $codigo);
                $queryCode = $this->db->get('usuarios_codigos_recuperacao');

                if($queryCode->num_rows() > 0){

                    $rowCode = $queryCode->row();

                    $this->db->where('id', $rowCode->id_usuario);
                    $this->db->update('usuarios_cadastros', array(
                        'senha'=>password_hash($senha, PASSWORD_DEFAULT)
                    ));

                    $this->db->where('codigo', $codigo);
                    $this->db->update('usuarios_codigos_recuperacao', array(
                        'utilizado'=>1,
                        'data_utilizacao'=>date('Y-m-d H:i:s')
                    ));

                    CreateLog($rowCode->id_usuario, 'O usuário acabou de trocar sua senha através da recuperação de senha.');
                    CreateNotification($rowCode->id_usuario, $this->lang->line('recuperar_m_notificacao_senha_alterada'));

                    return alerts($this->lang->line('recuperar_m_senha_alterada_ok'), 'success');
                }

                return alerts($this->lang->line('recuperar_m_senha_alterada_error'), 'danger');
            }

            return alerts($this->lang->line('recuperar_m_senha_nao_iguais'), 'danger');
        }

        return $checkValidCode['error'];
    }
}