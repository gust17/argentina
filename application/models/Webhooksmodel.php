<?php
class Webhooksmodel extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

        $this->load->library('coinpayments');
    }

    public function ActiveAccountCoinPayments()
    {

        if ($this->input->post('merchant') && $this->input->post('merchant') == SystemInfo('coinpayments_merchant')) {

            $id_transaction = $this->input->post('txn_id');
            $criptomoeda = $this->input->post('currency2');
            $status = $this->input->post('status');

            $this->db->where('id_transacao', $id_transaction);
            $query = $this->db->get('transacoes_criptomoedas');

            if ($query->num_rows() > 0) {

                $rowCoinpayments = $query->row();

                if ($rowCoinpayments->currency2 == $criptomoeda) {

                    if ($status >= 100 || $status == 2) {

                        $active = $this->SystemModel->AtivarFatura($rowCoinpayments->id_fatura, $criptomoeda, 'Pagamento recebido via coinpayments', false, 4);

                        if ($active) {

                            $this->db->where('id_transacao', $id_transaction);
                            $this->db->update('transacoes_criptomoedas', array(
                                'status' => 1,
                                'data_atualizacao' => date('Y-m-d H:i:s')
                            ));

                            CreateLog($rowCoinpayments->id_usuario, 'Ativou a fatura ID #' . $rowCoinpayments->id_fatura . ' com ' . $criptomoeda . ' via CoinPayments');
                        }
                    }
                }
            }
        }
    }

    public function ActiveAccountAsaas()
    {

        $input = file_get_contents('php://input');
        $data = json_decode($input);

        if ($data->event == 'PAYMENT_RECEIVED') {

            $idBilling = $data->payment->id;
            $billingType = $data->payment->billingType;

            if ($billingType == 'BOLETO') {
                $this->db->where('id_boleto', $idBilling);
                $query = $this->db->get('transacoes_asaas');
                echo 'BOLETO';
            } else {
                $this->db->where('txid', $idBilling);
                $query = $this->db->get('transacoes_pix');
                echo 'PIX';
            }

            if ($query->num_rows() > 0) {

                echo '<br />Retornou resultdo';

                $row = $query->row();

                if ($billingType == 'BOLETO') {
                    $this->db->where('id_boleto', $idBilling);
                    $this->db->update('transacoes_asaas', array(
                        'status' => 1,
                        'data_atualizacao' => date('Y-m-d H:i:s')
                    ));

                    echo '<br />Atualizou boleto';
                } else {
                    $this->db->where('txid', $idBilling);
                    $this->db->update('transacoes_pix', array(
                        'status' => 1
                    ));

                    echo '<br />Atualizou pix';
                }

                $this->db->where('id', $row->id_fatura);
                $this->db->where('status', 0);
                $queryInvoice = $this->db->get('faturas');

                if ($queryInvoice->num_rows() > 0) {

                    $this->SystemModel->AtivarFatura($row->id_fatura, $billingType, 'Pagamento via ' . $billingType . ' Asaas');

                    echo '<br />Ativou fatura';
                } else {
                    echo '<br />Fatura já ativada';
                }
            } else {
                echo 'Transação ' . $idBilling . ' não encontrada';
            }
        }
    }
}
