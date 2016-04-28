<?php
class ModelPaymentMoipAssinatura extends Model {
    
    public function getOrderStatuses() {
        return array(
            array(
                'order_status_id' => 0,
                'name' => $this->language->get('text_transaction_date_added')
            ),
            array(
                'order_status_id' => 1,
                'name' => $this->language->get('text_transaction_payment')
            ),
            array(
                'order_status_id' => 2,
                'name' => $this->language->get('text_transaction_outstanding_payment')
            ),
            array(
                'order_status_id' => 3,
                'name' => $this->language->get('text_transaction_skipped')
            ),
            array(
                'order_status_id' => 4,
                'name' => $this->language->get('text_transaction_failed')
            ),
            array(
                'order_status_id' => 5,
                'name' => $this->language->get('text_transaction_cancelled')
            ),
            array(
                'order_status_id' => 6,
                'name' => $this->language->get('text_transaction_suspended')
            ),
            array(
                'order_status_id' => 7,
                'name' => $this->language->get('text_transaction_suspended_failed')
            ),
            array(
                'order_status_id' => 8,
                'name' => $this->language->get('text_transaction_outstanding_failed')
            ),
            array(
                'order_status_id' => 9,
                'name' => $this->language->get('text_transaction_expired')
            )
        );
    }

    public function updateRetry(array $data) {
        $MoipAssinatura = new MoipAssinatura(
            $this->config->get('moip_assinatura_token'),
            $this->config->get('moip_assinatura_key'),
            $this->config->get('moip_assinatura_sandbox'),
            $this->config->get('moip_assinatura_debug')
        );
        
        $json = array();
        
        try {
            $MoipAssinatura->preferencesRetry(array(
                'first_try' => $data['moip_assinatura_first_try'],
                'second_try' => $data['moip_assinatura_second_try'],
                'third_try' => $data['moip_assinatura_third_try'],
                'finally' => $data['moip_assinatura_last_try']
            ));
            
            return true;
        } catch (Exception $e) {
            $errors = json_decode($e->getMessage(), true);
                
            if (json_last_error()) {
                $json['error'][] = $e->getMessage();
            } else {
                foreach($errors['errors'] as $error) {
                    $json['error'][] = $error['description'];
                }
            }
            
            return $json;
        }
    }
}