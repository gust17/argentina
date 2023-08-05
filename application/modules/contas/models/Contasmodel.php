<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contasmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    public function MinhaContaBancaria()
    {

        $conta = UserInfo('conta_bancaria');
        $conta = json_decode($conta, true);

        return $conta;
    }

    public function AtualizarContaBancaria()
    {

        $banco = $this->input->post('banco', true);
        $agencia = $this->input->post('agencia', true);
        $conta = $this->input->post('conta', true);
        $tipo = $this->input->post('tipo', true);
        $titular = $this->input->post('titular', true);
        $documento = $this->input->post('documento', true);

        $contaInJson = json_encode(array(
            'banco' => $banco,
            'agencia' => $agencia,
            'conta' => $conta,
            'tipo' => $tipo,
            'titular' => $titular,
            'documento' => $documento
        ));

        $this->db->where('id', $this->userid);
        $update = $this->db->update('usuarios_cadastros', array(
            'conta_bancaria' => $contaInJson
        ));

        if ($update) {

            CreateLog($this->userid, 'Atualizou a conta bancária');

            return alerts($this->lang->line('con_bancaria_ok'), 'success');
        }

        return alerts($this->lang->line('con_bancaria_error'), 'danger');
    }

    public function MinhaChavePix()
    {

        $pix = UserInfo('pix');
        $pix = json_decode($pix, true);

        return $pix;
    }

    public function AtualizarPix()
    {


        $nombre = $this->input->post('nombre', true);
        $cuenta = $this->input->post('cuenta', true);
        $dni = $this->input->post('dni', true);
        $tipo = $this->input->post('tipo', true);
        $cci = $this->input->post('cci', true);

        $pixInJson = json_encode(array(
            'cuenta' => $cuenta,
            'nombre' => $nombre,
            'dni' => $dni,
            'cci' => $cci
        ));

        $this->db->where('id', $this->userid);
        $update = $this->db->update('usuarios_cadastros', array(
            'pix' => $pixInJson
        ));

        if ($update) {

            CreateLog($this->userid, 'Atualizou a chave Pix');

            return alerts($this->lang->line('con_pix_ok'), 'success');
        }

        return alerts($this->lang->line('con_pix_error'), 'danger');
    }

    public function MinhaCarteiraBitcoin()
    {

        $bitcoin = UserInfo('carteira_bitcoin');
        $bitcoin = json_decode($bitcoin, true);

        return $bitcoin;
    }

    public function AtualizarCarteiraBitcoin()
    {

        $bitcoin = $this->input->post('bitcoin', true);

        $bitcoinInJson = json_encode(array(
            'carteira_bitcoin' => $bitcoin
        ));

        $this->db->where('id', $this->userid);
        $update = $this->db->update('usuarios_cadastros', array(
            'carteira_bitcoin' => $bitcoinInJson
        ));

        if ($update) {

            CreateLog($this->userid, 'Atualizou a carteira bitcoin');

            return alerts($this->lang->line('con_bitcoin_ok'), 'success');
        }

        return alerts($this->lang->line('con_bitcoin_error'), 'danger');
    }

    public function MinhaBankOn()
    {

        $bankon = UserInfo('bankon');
        $bankon = json_decode($bankon, true);

        return $bankon;
    }

    public function AtualizarBankOn()
    {

        $bankon = $this->input->post('bankon', true);

        $bankonInJson = json_encode(array(
            'bankon' => $bankon
        ));

        $this->db->where('id', $this->userid);
        $update = $this->db->update('usuarios_cadastros', array(
            'bankon' => $bankonInJson
        ));

        if ($update) {

            CreateLog($this->userid, 'Atualizou a sua BankOn');

            return alerts($this->lang->line('con_bankon_ok'), 'success');
        }

        return alerts($this->lang->line('con_bankon_error'), 'danger');
    }

    public function MinhaSimplePay()
    {

        $simplepay = UserInfo('simplepay');
        $simplepay = json_decode($simplepay, true);

        return $simplepay;
    }

    public function AtualizarSimplePay()
    {

        $simplepay = $this->input->post('simplepay', true);

        $simplepayInJson = json_encode(array(
            'simplepay' => $simplepay
        ));

        $this->db->where('id', $this->userid);
        $update = $this->db->update('usuarios_cadastros', array(
            'simplepay' => $simplepayInJson
        ));

        if ($update) {

            CreateLog($this->userid, 'Atualizou a sua SimplePay');

            return alerts($this->lang->line('con_simplepay_ok'), 'success');
        }

        return alerts($this->lang->line('con_simplepay_error'), 'danger');
    }

    public function MinhaNewpay()
    {

        $newpay = UserInfo('newpay');
        $newpay = json_decode($newpay, true);

        return $newpay;
    }

    public function AtualizarNewpay()
    {

        $newpay = $this->input->post('newpay', true);

        $newpayInJson = json_encode(array(
            'newpay' => $newpay
        ));

        $this->db->where('id', $this->userid);
        $update = $this->db->update('usuarios_cadastros', array(
            'newpay' => $newpayInJson
        ));

        if ($update) {

            CreateLog($this->userid, 'Atualizou a sua Newpay');

            return alerts($this->lang->line('con_newpay_ok'), 'success');
        }

        return alerts($this->lang->line('con_newpay_error'), 'danger');
    }
}
