<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Throttle
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * throttles multiple connections attempts to prevent abuse
     * @param int $type type of throttle to perform.
     *
     */
    public function throttle($type = 0, $limit = 10, $timeout = 30)
    {
        //clean up login attempts older than specified time
        $this->throttle_cleanup($timeout, $type);

        $data['ip'] = $this->CI->input->ip_address();
        $data['type'] = $type;
        $data['created_at'] = date('Y-m-d H:i:s');

        $this->CI->db->insert('throttles', $data);

        $attempts = $this->CI->db->get_where('throttles', ['ip' => $this->CI->input->ip_address(), 'type' => $type])->num_rows();

        if ($attempts > $limit) {
            show_error('O número de tentativas foi excedida, por favor, volte em ' . $timeout . ' minutos.', 503, 'error_general', 'Tentativas Excedidas!');
        }

        return $attempts; // return current number of attempted logins
    }

    /**
     * Cleans up old throttling attempts based on throttle timeout
     *
     * @param $timeout
     * @return result of query
     */
    public function throttle_cleanup($timeout, $type)
    {
        $formatted_current_time = date("Y-m-d H:i:s", strtotime('-' . (int)$timeout . ' minutes'));

        $this->CI->db->where('created_at <= ', $formatted_current_time);
        $this->CI->db->where('type', $type);
        $this->CI->db->delete('throttles');
    }


}