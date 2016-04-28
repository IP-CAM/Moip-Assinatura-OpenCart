<?php
class ControllerEventMoipAssinatura extends Controller {
    
    public function preAdminRecurringAdd($recurring) {
        $MoipAssinatura = new MoipAssinatura(
            $this->config->get('moip_assinatura_token'),
            $this->config->get('moip_assinatura_key'),
            $this->config->get('moip_assinatura_sandbox'),
            $this->config->get('moip_assinatura_debug')
        );
        
        $json = array();
        
        try {
            $MoipAssinatura->createPlan(array(
                'code' => 'plano' . $recurring['recurring_id'],
                'name' => $recurring['name'],
                'description' => $recurring['name'],
                'amount' => ($recurring['price']*100),
                'payment_method' => 'CREDIT_CARD',
                'interval' => array(
                    'length' => $recurring['cycle'],
                    'unit' => (
                        $recurring['frequency'] == 'DAY' ||
                        $recurring['frequency'] == 'MONTH' ||
                        $recurring['frequency'] == 'YEAR'
                    ) ? strtoupper($recurring['frequency']) : 'MONTH',
                ),
                'billing_cycles' => $recurring['duration'],
                'trial' => array(
                    'days' => $recurring['trial_duration'],
                    'enabled' => ($recurring['trial_status']) ? true : false,
                ),
            ));
            
            $json['success'][$recurring['recurring_id']] = 'Plano ' . $recurring['name'] . ' exportada.';
        } catch (Exception $e) {
            $error = json_decode($e->getMessage(), true);
            
            $json['error'][$recurring['recurring_id']] = $e->getMessage();
            
            if (json_last_error()) {
                $json['error'][$recurring['recurring_id']] = array(
                    array(
                        'description' => $e->getMessage()
                    )
                );
            } else {
                $json['error'][$recurring['recurring_id']] = $error['errors'];
            }
        }
        
        $this->log->write($json);
    }
    
    public function postAdminRecurringEdit($recurring_id) {
        $MoipAssinatura = new MoipAssinatura(
            $this->config->get('moip_assinatura_token'),
            $this->config->get('moip_assinatura_key'),
            $this->config->get('moip_assinatura_sandbox'),
            $this->config->get('moip_assinatura_debug')
        );
        
        $this->load->model('catalog/recurring');
        
        $recurring = $this->model_catalog_recurring->getRecurring($recurring_id);
        
        $json = array();
        
        try {
            $MoipAssinatura->updatePlan('plano' . $recurring['recurring_id'], array(
                'name' => $recurring['name'],
                'description' => $recurring['name'],
                'amount' => ($recurring['price']*100),
                'payment_method' => 'CREDIT_CARD',
                'interval' => array(
                    'length' => $recurring['cycle'],
                    'unit' => (
                        $recurring['frequency'] == 'DAY' ||
                        $recurring['frequency'] == 'MONTH' ||
                        $recurring['frequency'] == 'YEAR'
                    ) ? strtoupper($recurring['frequency']) : 'MONTH',
                ),
                'billing_cycles' => $recurring['duration'],
                'trial' => array(
                    'days' => $recurring['trial_duration'],
                    'enabled' => ($recurring['trial_status']) ? true : false,
                ),
            ));
            
            $json['success'][$recurring['recurring_id']] = 'Plano ' . $recurring['name'] . ' exportada.';
        } catch (Exception $e) {
            $error = json_decode($e->getMessage(), true);
            
            $json['error'][$recurring['recurring_id']] = $e->getMessage();
            
            if (json_last_error()) {
                $json['error'][$recurring['recurring_id']] = array(
                    array(
                        'description' => $e->getMessage()
                    )
                );
            } else {
                $json['error'][$recurring['recurring_id']] = $error['errors'];
            }
        }
        
        $this->log->write($json);
    }
}