<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuariosmodel extends CI_Model {

    protected $dados;
    protected $retorno;
    protected $rotas;

    public function __construct(){
        parent::__construct();

        $this->rotas = MinhasRotas();

        $this->userid = $this->session->userdata('admin_myuserid_92310');
    }

    public function QuantidadeUsuarios(){

        $this->db->where('data_exclusao IS NULL', null, false);
        $query = $this->db->get('usuarios_cadastros');

        return $query->num_rows();
    }

    public function QuantidadeUsuariosStatus($status = 1){

        $this->db->where('plano_ativo', $status);
        $this->db->where('data_exclusao IS NULL', null, false);
        $query = $this->db->get('usuarios_cadastros');

        return $query->num_rows();
    }

    public function TopLideres($limit = 99999999){

        $queryRede = $this->db->get('rede');
        
        if($queryRede->num_rows() > 0){
            
            foreach($queryRede->result() as $resultRede){
                
                $this->db->where('plano_ativo', 1);
                $this->db->where('id', $resultRede->id_usuario);
                $this->db->where('data_exclusao IS NULL', null, false);
                $queryUsuarios = $this->db->get('usuarios_cadastros');
                
                if($queryUsuarios->num_rows() > 0){
                    
                    if(isset($this->dados[$resultRede->id_patrocinador_direto])){
                        
                        $this->dados[$resultRede->id_patrocinador_direto] = $this->dados[$resultRede->id_patrocinador_direto] + 1;
                    }else{
                        $this->dados[$resultRede->id_patrocinador_direto] = 1;
                    }
                }
            }
            

            if(!empty($this->dados)){

                arsort($this->dados);

                $i = 0;
                
                foreach($this->dados as $patrocinador=>$quantidade){
                    
                    if($i <= $limit){
                        
                        $this->retorno[$patrocinador] = $quantidade;
                        $i++;
                    }
                }
            }
        }
        
        return $this->retorno;
    }

    public function TodosUsuarios($status = false, $admin = false){

        if($status !== false){
            $this->db->where('plano_ativo', $status);
        }

        if($admin !== false){
            $this->db->where('is_admin', 1);
        }

        $this->db->where('exibir', 1);
        $this->db->where('data_exclusao IS NULL', null, false);
        $query = $this->db->get('usuarios_cadastros');

        if($query->num_rows() > 0){

            return $query->result();
        }

        return false;
    }

    public function DadosUsuario($id){

        $this->db->where('id', $id);
        $query = $this->db->get('usuarios_cadastros');

        return $query->row();
    }

    public function RedeUsuario($id){

        $this->db->where('id_usuario', $id);
        $query = $this->db->get('rede');

        return $query->row() ?? false;
    }

    public function ExtratoUsuario($id){

        $this->db->where('id_usuario', $id);
        $query = $this->db->get('extrato');

        if($query->num_rows() > 0){
            return $query->result();
        }

        return false;
    }

    public function FaturasUsuario($id){

        $this->db->where('id_usuario', $id);
        $query = $this->db->get('faturas');

        if($query->num_rows() > 0){
            return $query->result();
        }

        return false;
    }

    public function SaquesUsuario($id){

        $this->db->where('id_usuario', $id);
        $query = $this->db->get('saques');

        if($query->num_rows() > 0){
            return $query->result();
        }

        return false;
    }

    public function NotificacoesUsuario($id){

        $this->db->where('id_usuario', $id);
        $query = $this->db->get('notificacoes');

        if($query->num_rows() > 0){
            return $query->result();
        }

        return false;
    }

    public function CodigosBankonUsuario($id){

        $this->db->select('c.*, p.nome');
        $this->db->from('transacoes_bankon AS c');
        $this->db->join('faturas AS f', 'f.id = c.id_fatura', 'inner');
        $this->db->join('planos AS p', 'p.id = f.id_plano', 'inner');
        $this->db->where('c.id_usuario', $id);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }

        return false;
    }

    public function LogsUsuario($id){

        $this->db->where('id_usuario', $id);
        $query = $this->db->get('usuarios_logs');

        if($query->num_rows() > 0){
            return $query->result();
        }

        return false;
    }

    public function ExcluirUsuario($id){

        $this->db->update('extrato', array('data_exclusao'=>date('Y-m-d H:i:s')));

        $this->db->where('id_usuario', $id);
        $this->db->update('extrato', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('extrato');

        $this->db->where('id_usuario', $id);
        $this->db->update('faturas', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('faturas');

        $this->db->where('id_usuario', $id);
        $this->db->update('faturas_comprovantes', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('faturas_comprovantes');

        $this->db->where('id_usuario', $id);
        $this->db->update('notificacoes', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('notificacoes');

        $this->db->where('id_usuario', $id);
        $this->db->update('rede', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('rede');

        $this->db->where('id_usuario', $id);
        $this->db->update('saques', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('saques');

        $this->db->where('id_usuario', $id);
        $this->db->update('transacoes_criptomoedas', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('transacoes_criptomoedas');

        $this->db->where('id', $id);
        $this->db->update('usuarios_cadastros', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('usuarios_cadastros');

        $this->db->where('id_usuario', $id);
        $this->db->update('usuarios_cliques_link', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('usuarios_cliques_link');

        $this->db->where('id_usuario', $id);
        $this->db->update('usuarios_codigos_recuperacao', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('usuarios_codigos_recuperacao');

        $this->db->where('id_usuario', $id);
        $this->db->update('usuarios_logs', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('usuarios_logs');

        $this->session->set_flashdata('usuarios_message', alerts('Usuário excluido com sucesso!'));

        CreateLog($this->userid, 'Excluiu o usuário <strong>'.UserInfo('login', $id).'</strong> do sistema.', true);

        redirect($this->rotas->admin_usuarios_todos);
    }

    public function Backoffice($id){

        $this->session->set_userdata('myuserid', $id);

        CreateLog($this->userid, 'Acesso o backoffice do usuário <strong>'.UserInfo('login', $id).'</strong>', true);

        redirect($this->rotas->backoffice);
    }

    public function AtualizarDados($id){

        $login = trim($this->input->post('login', true));
        $senha = trim($this->input->post('senha', true));
        $nome = $this->input->post('nome', true);
        $email = $this->input->post('email', true);
        $documento = $this->input->post('documento', true);
        $ddi = $this->input->post('ddi', true);
        $celular = $this->input->post('celular', true);
        $data_nascimento = $this->input->post('data_nascimento', true);
        $sexo = $this->input->post('sexo', true);
        $cep = $this->input->post('cep', true);
        $endereco = $this->input->post('endereco', true);
        $bairro = $this->input->post('bairro', true);
        $cidade = $this->input->post('cidade', true);
        $estado = $this->input->post('estado', true);
        $saque_liberado = $this->input->post('saque_liberado', true);
        $status = $this->input->post('status', true);
        $status_mensagem = $this->input->post('status_mensagem', true);
        $score = $this->input->post('score', true);

        if(!empty($data_nascimento)){

            $data_nascimento = InverseDate($data_nascimento);
        }

        $this->db->where('id != ', $id);
        $this->db->where('login', $login);
        $queryUsuarios = $this->db->get('usuarios_cadastros');

        if($queryUsuarios->num_rows() > 0){

            return alerts('O login informado já está em uso. Use outro para continuar.');
        }

        $this->db->where('id != ', $id);
        $this->db->where('email', $email);
        $queryEmail = $this->db->get('usuarios_cadastros');

        if($queryEmail->num_rows() > 0){

            return alerts('O Email informado já está em uso. Use outro para continuar.');
        }

        $this->db->where('id != ', $id);
        $this->db->where('documento', $documento);
        $queryDocumento = $this->db->get('usuarios_cadastros');

        if($queryDocumento->num_rows() > 0){

            return alerts('O Documento informado já está em uso. Use outro para continuar.');
        }

        $dados = array(
            'nome'=>$nome,
            'email'=>$email,
            'documento'=>$documento,
            'ddi'=>$ddi,
            'celular'=>$celular,
            'data_nascimento'=>$data_nascimento,
            'sexo'=>$sexo,
            'cep'=>$cep,
            'endereco'=>$endereco,
            'bairro'=>$bairro,
            'cidade'=>$cidade,
            'estado'=>$estado,
            'saque_liberado'=>$saque_liberado,
            'status'=>$status,
            'status_mensagem'=>$status_mensagem,
            'score'=>$score
        );

        if(!empty($senha)){
            $dados['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        }

        $this->db->where('id', $id);
        $update = $this->db->update('usuarios_cadastros', $dados);

        if($update){

            CreateLog($this->userid, 'Atualizou os dados pessoais do usuário: <strong>'.UserInfo('login', $id).'</strong>', true);

            return alerts('Dados atualizados com sucesso!', 'success');
        }

        return alert('Ocorreu um erro ao atualizar os dados do usuário.', 'danger');
    }

    public function AtualizarRede($id){

        $patrocinador_direto = $this->input->post('patrocinador_direto');
        $patrocinador_rede = $this->input->post('patrocinador_rede');

        $this->db->where('login', $patrocinador_direto);
        $queryPatrocinadorDireto = $this->db->get('usuarios_cadastros');

        if($queryPatrocinadorDireto->num_rows() <= 0){

            return alerts('Não foi possível encontrar o Patrocinador Direto informado. Tente novamente.', 'danger');
        }

        $this->db->where('login', $patrocinador_rede);
        $queryPatrocinadorRede = $this->db->get('usuarios_cadastros');

        if($queryPatrocinadorRede->num_rows() <= 0){

            return alerts('Não foi possível encontrar o Patrocinador de Rede informado. Tente novamente.', 'danger');
        }

        $rowPatrocinadorDireto = $queryPatrocinadorDireto->row();
        $rowPatrocinadorRede = $queryPatrocinadorRede->row();

        $this->db->where('id_usuario', $id);
        $update = $this->db->update('rede', array(
            'id_patrocinador_direto'=>$rowPatrocinadorDireto->id,
            'id_patrocinador_rede'=>$rowPatrocinadorRede->id
        ));

        if($update){

            CreateLog($this->userid, 'Atualizou a rede do usuário: <strong>'.UserInfo('login', $id).'</strong>', true);

            return alerts('Rede atualizada com sucesso!', 'success');
        }

        return alert('Ocorreu um erro ao atualizar a Rede do usuário.', 'danger');
    }

    public function AtualizarContas($id){

        $carteira_bitcoin = $this->input->post('carteira_bitcoin', true);
        $bankon = $this->input->post('bankon', true);
        $newpay = $this->input->post('newpay', true);

        $banco = $this->input->post('banco', true);
        $agencia = $this->input->post('agencia', true);
        $conta = $this->input->post('conta', true);
        $conta_tipo = $this->input->post('conta_tipo', true);
        $titular = $this->input->post('titular', true);
        $documento = $this->input->post('documento', true);
        $pix = $this->input->post('pix', true);
        $pix_banco = $this->input->post('pix_banco', true);

        $jEncodeBTC = json_encode(
            array('carteira_bitcoin'=>$carteira_bitcoin)
        );
        $jEncodeBankon = json_encode(
            array('bankon'=>$bankon)
        );
        $jEncodeNewPay = json_encode(
            array('newpay'=>$newpay)
        );
        $jEncodeCB = json_encode(array(
                'banco'=>$banco,
                'agencia'=>$agencia,
                'conta'=>$conta,
                'tipo'=>$conta_tipo,
                'titular'=>$titular,
                'documento'=>$documento
        ));
        $jEncodePix = json_encode(
            array('pix'=>$pix, 'banco'=>$pix_banco)
        );

        $this->db->where('id', $id);
        $update = $this->db->update('usuarios_cadastros', array(
            'carteira_bitcoin'=>$jEncodeBTC,
            'bankon'=>$jEncodeBankon,
            'newpay'=>$jEncodeNewPay,
            'pix'=>$jEncodePix,
            'conta_bancaria'=>$jEncodeCB
        ));

        if($update){

            CreateLog($this->userid, 'Atualizou as contas de depósito do usuário: <strong>'.UserInfo('login', $id).'</strong>', true);

            return alerts('Contas atualizadas com sucesso!', 'success');
        }

        return alert('Ocorreu um erro ao atualizar as Contas de depósito do usuário.', 'danger');
    }

    public function AtualizarAdmin($id){

        $admin = $this->input->post('admin', true);
        $permissoes_blocks = $this->input->post('permissoes_blocks', true);

        $this->db->where('id', $id);
        $update = $this->db->update('usuarios_cadastros', array(
            'is_admin'=>$admin
        ));

        $this->db->where('id_usuario', $id);
        $this->db->delete('configuracoes_permissoes');

        if(!empty($permissoes_blocks)){

            foreach($permissoes_blocks as $permissoes){

                $this->db->insert('configuracoes_permissoes', array(
                    'id_usuario'=>$id,
                    'page_block'=>$permissoes,
                    'status'=>0
                ));
            }
        }

        if($update){

            CreateLog($this->userid, 'Atualizou as permissões administrativas do login: <strong>'.UserInfo('login', $id).'</strong>', true);

            return alerts('Configurações atualizadas com sucesso!', 'success');
        }

        return alert('Ocorreu um erro ao atualizar as configurações. Tente novamente.', 'danger');
    }
}