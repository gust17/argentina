<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Indicadosmodel extends CI_Model
{

    public $rotas;
    public $UsersUnilevel = array();
    public $encontradoRede;
    public $UsersBinary;

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
        $this->rotas = MinhasRotas();
    }

    public function createUnilevel($id_usuario, $nivel, $limite)
    {

        if ($nivel <= $limite) {

            $this->db->select('u.*, r.id_patrocinador_direto');
            $this->db->from('rede AS r');
            $this->db->join('usuarios_cadastros AS u', 'u.id = r.id_usuario', 'inner');
            $this->db->where('r.id_patrocinador_direto', $id_usuario);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                foreach ($query->result() as $result) {

                    $this->UsersUnilevel[$nivel][] = array(
                        'id_usuario' => $result->id,
                        'id_patrocinador_direto' => $result->id_patrocinador_direto,
                        'nome' => $result->nome,
                        'celular' => $result->celular,
                        'login' => $result->login,
                        'ativo' => $result->plano_ativo,
                        'data_cadastro' => $result->data_cadastro
                    );

                    $this->createUnilevel($result->id, $nivel + 1, $limite);
                }
            }
        }
    }

    public function GerarHTMLBinario($id_usuario, $nivel, $limite)
    {

        if ($nivel < $limite) {

            $this->db->select('r.id_usuario, r.chave_binaria, u.nome, u.login');
            $this->db->from('rede AS r');
            $this->db->join('usuarios_cadastros AS u', 'u.id = r.id_usuario', 'inner');
            $this->db->where('r.id_patrocinador_rede', $id_usuario);
            $this->db->order_by('r.chave_binaria', 'ASC');
            $query = $this->db->get();

            $quantityReturn = $query->num_rows();

            if ($quantityReturn > 0) {

                $this->UsersBinary .= '<ul>';

                if ($quantityReturn == 1 && $query->row()->chave_binaria == 2) {

                    $this->UsersBinary .= '<li>';
                    $this->UsersBinary .= '<a href="javascript:void(0);">';
                    $this->UsersBinary .= '<img src="' . base_url('assets/pages/img/icon-network.png') . '" style="opacity:0.2;width:40px;" /> <br />';
                    $this->UsersBinary .= '&nbsp;';
                    $this->UsersBinary .= '</a>';
                    $this->GerarHTMLBinario(false, $nivel + 1, $limite);
                    $this->UsersBinary .= '</li>';
                }

                foreach ($query->result() as $k => $result) {

                    $this->UsersBinary .= '<li>';
                    $this->UsersBinary .= '<a href="javascript:void(0);" class="showAffiliate" data-toggle="modal" data-target="#modalAffiliate" data-sponsor="' . $result->id_usuario . '">';
                    $this->UsersBinary .= '<img src="' . AvatarLoad($result->id_usuario) . '" style="opacity:' . ((UserInfo('plano_ativo', $result->id_usuario) == 1) ? '1' : '0.2') . ';width:40px;" /> <br />';
                    $this->UsersBinary .= $result->login;
                    $this->UsersBinary .= '</a>';
                    $this->GerarHTMLBinario($result->id_usuario, $nivel + 1, $limite);
                    $this->UsersBinary .= '</li>';
                }

                if ($quantityReturn == 1 && $query->row()->chave_binaria == 1) {

                    $this->UsersBinary .= '<li>';
                    $this->UsersBinary .= '<a href="javascript:void(0);">';
                    $this->UsersBinary .= '<img src="' . base_url('assets/pages/img/icon-network.png') . '" style="opacity:0.2;width:40px;" /> <br />';
                    $this->UsersBinary .= '&nbsp;';
                    $this->UsersBinary .= '</a>';
                    $this->GerarHTMLBinario(false, $nivel + 1, $limite);
                    $this->UsersBinary .= '</li>';
                }

                $this->UsersBinary .= '</ul>';
            } else {

                $this->UsersBinary .= '<ul>';

                for ($y = 1; $y <= 2; $y++) {

                    $this->UsersBinary .= '<li>';
                    $this->UsersBinary .= '<a href="javascript:void(0);">';
                    $this->UsersBinary .= '<img src="' . base_url('assets/pages/img/icon-network.png') . '" style="opacity:0.2;width:40px;" /> <br />';
                    $this->UsersBinary .= '&nbsp;';
                    $this->UsersBinary .= '</a>';
                    $this->GerarHTMLBinario(false, $nivel + 1, $limite);
                    $this->UsersBinary .= '</li>';
                }

                $this->UsersBinary .= '</ul>';
            }
        }
    }

    public function MyBinaryNetwork()
    {

        $this->UsersBinary = '';

        $id_sponsor = $this->input->get('patrocinador') ?? $this->userid;

        if ($id_sponsor == $this->userid) {
            $nameTop = 'Você';
        } else {

            if (!$this->ProcuraUsuarioNaRede($id_sponsor)) {
                echo '<script>alert("' . $this->lang->line('ind_binario_nao_pertence_rede') . '");window.location.href="' . base_url($this->rotas->rede_binaria) . '"</script>';
                exit;
            }

            $nameTop = UserInfo('login', $id_sponsor);
        }

        $this->GerarHTMLBinario($id_sponsor, 1, 4);

        $networking = $this->UsersBinary;

        $html  = '<div class="tree" style="display: inline-block">';
        $html .= '<ul>';
        $html .= '<li>';
        $html .= '<a href="#">';
        $html .= '<img src="' . AvatarLoad($id_sponsor) . '" style="width:40px" /> <br />';
        $html .= $nameTop;
        $html .= '</a>';
        $html .= $networking;
        $html .= '</li>';
        $html .= '</div>';

        return $html;
    }

    public function ProcuraUsuarioNaRede($id)
    {

        $this->db->where('id_usuario', $id);
        $query = $this->db->get('rede');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            if ($row->id_patrocinador_rede ==  $this->userid) {

                $this->encontradoRede = true;
                return true;
            }

            if ($row->id_patrocinador_rede == 1) {

                $this->encontradoRede = false;
                return false;
            }

            $this->ProcuraUsuarioNaRede($row->id_patrocinador_rede);
        } else {

            $this->encontradoRede = false;
            return false;
        }
    }

    public function checkIsSearch()
    {

        if ($this->input->get('search')) {

            $this->db->like('login', $this->input->get('search', true));
            $query = $this->db->get('usuarios_cadastros');

            if ($query->num_rows() > 0) {

                $row = $query->row();

                $link = base_url() . $this->rotas->rede_binaria . '?patrocinador=' . $row->id;

                redirect($link);

                exit;
            } else {

                return true;
            }
        } else {

            return false;
        }
    }

    public function infoUnilevel()
    {

        $contagemTotal = 0;
        $contagemAtivos = 0;
        $contagemPendentes = 0;
        $contagemDiretos = 0;

        $this->createUnilevel($this->userid, 1, SystemInfo('niveis_unilevel'));
        $unilevel = $this->UsersUnilevel;

        if (is_array($unilevel)) {
            foreach ($unilevel as $nivel => $indicados) {
                foreach ($indicados as $info) {

                    if ($info['id_patrocinador_direto'] == $this->userid) {
                        $contagemDiretos++;
                    }

                    if ($info['ativo'] == 1) {
                        $contagemAtivos++;
                    } else {
                        $contagemPendentes++;
                    }

                    $contagemTotal++;
                }
            }
        }

        return array(
            'total' => $contagemTotal,
            'ativos' => $contagemAtivos,
            'pendentes' => $contagemPendentes,
            'diretos' => $contagemDiretos
        );
    }

    public function getUsersUnilevel()
    {

        return $this->UsersUnilevel;
    }

    public function MyUnilevel()
    {

        $this->createUnilevel($this->userid, 1, SystemInfo('niveis_unilevel'));

        return $this->UsersUnilevel;
    }

    public function clicksLink()
    {

        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('usuarios_cliques_link');

        return $query->num_rows();
    }

    public function ListarIndicados($status = 1)
    {

        $this->db->select('u.*');
        $this->db->from('rede AS r');
        $this->db->join('usuarios_cadastros AS u', 'u.id = r.id_usuario', 'inner');
        $this->db->where('u.plano_ativo', $status);
        $this->db->where('r.id_patrocinador_direto', $this->userid);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function ListarUltimosCadastrados($limit = 10)
    {

        $this->db->select('u.*');
        $this->db->from('rede AS r');
        $this->db->join('usuarios_cadastros AS u', 'u.id = r.id_usuario', 'inner');
        $this->db->where('r.id_patrocinador_direto', $this->userid);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result();
        }

        return false;
    }

    public function quantidadeIndicados($status = 1)
    {

        $this->db->select('r.*');
        $this->db->from('rede AS r');
        $this->db->join('usuarios_cadastros AS u', 'u.id = r.id_usuario', 'inner');
        $this->db->where('r.id_patrocinador_direto', $this->userid);
        $this->db->where('u.plano_ativo', $status);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function MySponsorInfo()
    {

        $this->db->select('u.*');
        $this->db->from('rede AS r');
        $this->db->join('usuarios_cadastros AS u', 'u.id = r.id_patrocinador_direto', 'inner');
        $this->db->where('r.id_usuario', $this->userid);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->row();
        }

        return false;
    }

    public function PesquisaPatrocinadorEnviada()
    {

        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('pesquisas_patrocinador');

        if ($query->num_rows() > 0) {

            return true;
        }

        return false;
    }

    public function EnviarPesquisaPatrocinador()
    {

        $sponsor = $this->MySponsorInfo();

        $contato = $this->input->post('contato', true);
        $ajuda = $this->input->post('ajuda', true);
        $investir = $this->input->post('investir', true);
        $nota = $this->input->post('nota', true);
        $comentario = $this->input->post('comentario', true);

        $this->db->insert('pesquisas_patrocinador', array(
            'id_usuario' => $this->userid,
            'id_patrocinador' => $sponsor->id,
            'contato' => $contato,
            'ajuda' => $ajuda,
            'investir' => $investir,
            'nota' => $nota,
            'comentario' => $comentario,
            'data_criacao' => date('Y-m-d H:i:s')
        ));

        $scoreAtual = UserInfo('score');

        $this->db->where('id', $this->userid);
        $this->db->update('usuarios_cadastros', array(
            'score' => ($scoreAtual + 5)
        ));

        CreateNotification($this->userid, 'Seu score subiu +5 pontos pelo preenchimento de uma pesquisa de patrocinador.');

        return alerts('Pesquisa enviada com sucesso! Você ganhou +5 de score pela colaboração.', 'success');
    }
}
