<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validarmodel extends CI_Model
{

    protected $rotas;

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');

        $this->load->library('upload');
    }

    public function EnviarDocumentos()
    {

        $config['allowed_types'] = 'png|jpeg|jpg|pdf';
        $config['encrypt_name'] = true;
        $config['upload_path'] = 'uploads';

        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto_frente')) {

            $dataFrente = $this->upload->data();
            $frenteFilename = $dataFrente['file_name'];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_verso')) {

                $dataVerso = $this->upload->data();
                $versoFilename = $dataVerso['file_name'];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto_seflie')) {

                    $dataSelfie = $this->upload->data();
                    $selfieFilename = $dataSelfie['file_name'];

                    $login = UserInfo('login');

                    $result1 = UploadS3($login . '/' . $frenteFilename, 'uploads/' . $frenteFilename, 'starkpix-documentos');
                    $result2 = UploadS3($login . '/' . $versoFilename, 'uploads/' . $versoFilename, 'starkpix-documentos');
                    $result3 = UploadS3($login . '/' . $selfieFilename, 'uploads/' . $selfieFilename, 'starkpix-documentos');

                    $this->db->insert('usuarios_validacoes', array(
                        'id_usuario' => $this->userid,
                        'foto_frente' => $result1['ObjectURL'],
                        'foto_verso' => $result2['ObjectURL'],
                        'foto_selfie' => $result3['ObjectURL'],
                        'data_criacao' => date('Y-m-d H:i:s')
                    ));

                    @unlink('uploads/' . $frenteFilename);
                    @unlink('uploads/' . $versoFilename);
                    @unlink('uploads/' . $selfieFilename);

                    return alerts('Pronto, documentos enviados com sucesso. Em breve daremos notícias sobre sua conta!', 'success');
                } else {

                    @unlink('uploads/' . $frenteFilename);
                    @unlink('uploads/' . $versoFilename);

                    return alerts('Ocorreu um erro ao fazer upload da selfie: ' . $this->upload->display_errors(), 'danger');
                }
            } else {

                @unlink('uploads/' . $frenteFilename);

                return alerts('Ocorreu um erro ao fazer upload da foto do verso do documento: ' . $this->upload->display_errors(), 'danger');
            }
        } else {

            return alerts('Ocorreu um erro ao fazer upload da foto da frente do documento: ' . $this->upload->display_errors(), 'danger');
        }
    }

    public function StatusDocumento()
    {

        $this->db->limit(1);
        $this->db->order_by('id', 'DESC');
        $this->db->where('id_usuario', $this->userid);
        $this->db->where('status != ', 1);
        $queryValidacao = $this->db->get('usuarios_validacoes');

        if ($queryValidacao->num_rows() > 0) {

            $row = $queryValidacao->row();

            if ($row->status == 0) {

                return array(
                    'status' => 0,
                );
            } else {

                return array(
                    'status' => 2,
                    'mensagem' => $row->status_motivo
                );
            }
        } else {

            return array(
                'status' => 3
            );
        }
    }
}
