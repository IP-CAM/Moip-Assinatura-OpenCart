<?php
class ControllerPaymentMoipAssinatura extends Controller {
    
    private $error = array();
    
    public function index() {
        
        $data = $this->language->load('payment/moip_assinatura');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $first_time = $this->config->get('moip_assinatura_first_time');
            
            $this->load->model('setting/setting');
            
            $this->model_setting_setting->editSetting('moip_assinatura', $this->request->post);
            
            $this->load->model('payment/moip_assinatura');
            
            $updateRetry = $this->model_payment_moip_assinatura->updateRetry($this->request->post);
            
            if (isset($updateRetry['error'])) {
                $this->error['update_retry'] = $updateRetry['error'];
            }
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            if ($first_time) {
                $data['first_time'] = true;
            } elseif (!isset($updateRetry['error'])) {
                $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], true));
            }
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = false;
        }
        
        if (isset($this->error['token'])) {
            $data['error_token'] = $this->error['token'];
        } else {
            $data['error_token'] = false;
        }
        
        if (isset($this->error['key'])) {
            $data['error_key'] = $this->error['key'];
        } else {
            $data['error_key'] = false;
        }
        
        if (isset($this->error['authorization'])) {
            $data['error_authorization'] = $this->error['authorization'];
        } else {
            $data['error_authorization'] = false;
        }
        
        if (isset($this->error['cpf'])) {
            $data['error_cpf'] = $this->error['cpf'];
        } else {
            $data['error_cpf'] = false;
        }
        
        if (isset($this->error['birth_date'])) {
            $data['error_birth_date'] = $this->error['birth_date'];
        } else {
            $data['error_birth_date'] = false;
        }
        
        if (isset($this->error['address_number'])) {
            $data['error_address_number'] = $this->error['address_number'];
        } else {
            $data['error_address_number'] = false;
        }
        
        if (isset($this->error['update_retry'])) {
            $data['error_update_retry'] = $this->error['update_retry'];
        } else {
            $data['error_update_retry'] = false;
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
            'name' => $this->language->get('text_home')
        );
        
        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true),
            'name' => $this->language->get('text_payment')
        );
        
        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('payment/moip_assinatura', 'token=' . $this->session->data['token'], true),
            'name' => $this->language->get('heading_title')
        );
        
        if (isset($this->request->post['moip_assinatura_status'])) {
            $data['moip_assinatura_status'] = $this->request->post['moip_assinatura_status'];
        } else {
            $data['moip_assinatura_status'] = $this->config->get('moip_assinatura_status');
        }
        
        if (isset($this->request->post['moip_assinatura_token'])) {
            $data['moip_assinatura_token'] = $this->request->post['moip_assinatura_token'];
        } else {
            $data['moip_assinatura_token'] = $this->config->get('moip_assinatura_token');
        }
        
        if (isset($this->request->post['moip_assinatura_key'])) {
            $data['moip_assinatura_key'] = $this->request->post['moip_assinatura_key'];
        } else {
            $data['moip_assinatura_key'] = $this->config->get('moip_assinatura_key');
        }
        
        if (isset($this->request->post['moip_assinatura_authorization'])) {
            $data['moip_assinatura_authorization'] = $this->request->post['moip_assinatura_authorization'];
        } elseif ($this->config->get('moip_assinatura_authorization')) {
            $data['moip_assinatura_authorization'] = $this->config->get('moip_assinatura_authorization');
        } else {
            $data['moip_assinatura_authorization'] = uniqid();
        }
        
        if (isset($this->request->post['moip_assinatura_sandbox'])) {
            $data['moip_assinatura_sandbox'] = $this->request->post['moip_assinatura_sandbox'];
        } else {
            $data['moip_assinatura_sandbox'] = $this->config->get('moip_assinatura_sandbox');
        }
        
        if (isset($this->request->post['moip_assinatura_debug'])) {
            $data['moip_assinatura_debug'] = $this->request->post['moip_assinatura_debug'];
        } else {
            $data['moip_assinatura_debug'] = $this->config->get('moip_assinatura_debug');
        }
        
        if (isset($this->request->post['moip_assinatura_geo_zone_id'])) {
            $data['moip_assinatura_geo_zone_id'] = $this->request->post['moip_assinatura_geo_zone_id'];
        } else {
            $data['moip_assinatura_geo_zone_id'] = $this->config->get('moip_assinatura_geo_zone_id');
        }
        
        if (isset($this->request->post['moip_assinatura_sort_order'])) {
            $data['moip_assinatura_sort_order'] = $this->request->post['moip_assinatura_sort_order'];
        } else {
            $data['moip_assinatura_sort_order'] = $this->config->get('moip_assinatura_sort_order');
        }
        
        if (isset($this->request->post['moip_assinatura_recurring_status_active'])) {
          $data['moip_assinatura_recurring_status_active'] = $this->request->post['moip_assinatura_recurring_status_active'];
        } else {
          $data['moip_assinatura_recurring_status_active'] = $this->config->get('moip_assinatura_recurring_status_active');
        }

        if (isset($this->request->post['moip_assinatura_recurring_status_suspended'])) {
          $data['moip_assinatura_recurring_status_suspended'] = $this->request->post['moip_assinatura_recurring_status_suspended'];
        } else {
          $data['moip_assinatura_recurring_status_suspended'] = $this->config->get('moip_assinatura_recurring_status_suspended');
        }

        if (isset($this->request->post['moip_assinatura_recurring_status_expired'])) {
          $data['moip_assinatura_recurring_status_expired'] = $this->request->post['moip_assinatura_recurring_status_expired'];
        } else {
          $data['moip_assinatura_recurring_status_expired'] = $this->config->get('moip_assinatura_recurring_status_expired');
        }

        if (isset($this->request->post['moip_assinatura_recurring_status_overdue'])) {
          $data['moip_assinatura_recurring_status_overdue'] = $this->request->post['moip_assinatura_recurring_status_overdue'];
        } else {
          $data['moip_assinatura_recurring_status_overdue'] = $this->config->get('moip_assinatura_recurring_status_overdue');
        }

        if (isset($this->request->post['moip_assinatura_recurring_status_canceled'])) {
          $data['moip_assinatura_recurring_status_canceled'] = $this->request->post['moip_assinatura_recurring_status_canceled'];
        } else {
          $data['moip_assinatura_recurring_status_canceled'] = $this->config->get('moip_assinatura_recurring_status_canceled');
        }

        if (isset($this->request->post['moip_assinatura_recurring_status_trial'])) {
          $data['moip_assinatura_recurring_status_trial'] = $this->request->post['moip_assinatura_recurring_status_trial'];
        } else {
          $data['moip_assinatura_recurring_status_trial'] = $this->config->get('moip_assinatura_recurring_status_trial');
        }
        
        if (isset($this->request->post['moip_assinatura_active'])) {
            $data['moip_assinatura_active'] = $this->request->post['moip_assinatura_active'];
        } else {
            $data['moip_assinatura_active'] = $this->config->get('moip_assinatura_active');
        }
        
        if (isset($this->request->post['moip_assinatura_suspended'])) {
            $data['moip_assinatura_suspended'] = $this->request->post['moip_assinatura_suspended'];
        } else {
            $data['moip_assinatura_suspended'] = $this->config->get('moip_assinatura_suspended');
        }
        
        if (isset($this->request->post['moip_assinatura_expired'])) {
            $data['moip_assinatura_expired'] = $this->request->post['moip_assinatura_expired'];
        } else {
            $data['moip_assinatura_expired'] = $this->config->get('moip_assinatura_expired');
        }
        
        if (isset($this->request->post['moip_assinatura_overdue'])) {
            $data['moip_assinatura_overdue'] = $this->request->post['moip_assinatura_overdue'];
        } else {
            $data['moip_assinatura_overdue'] = $this->config->get('moip_assinatura_overdue');
        }
        
        if (isset($this->request->post['moip_assinatura_canceled'])) {
            $data['moip_assinatura_canceled'] = $this->request->post['moip_assinatura_canceled'];
        } else {
            $data['moip_assinatura_canceled'] = $this->config->get('moip_assinatura_canceled');
        }
        
        if (isset($this->request->post['moip_assinatura_trial'])) {
            $data['moip_assinatura_trial'] = $this->request->post['moip_assinatura_trial'];
        } else {
            $data['moip_assinatura_trial'] = $this->config->get('moip_assinatura_trial');
        }
        
        if (isset($this->request->post['moip_assinatura_first_try'])) {
            $data['moip_assinatura_first_try'] = $this->request->post['moip_assinatura_first_try'];
        } elseif ($this->config->get('moip_assinatura_first_try')) {
            $data['moip_assinatura_first_try'] = $this->config->get('moip_assinatura_first_try');
        } else {
            $data['moip_assinatura_first_try'] = 1;
        }
        
        if (isset($this->request->post['moip_assinatura_second_try'])) {
            $data['moip_assinatura_second_try'] = $this->request->post['moip_assinatura_second_try'];
        } elseif ($this->config->get('moip_assinatura_second_try')) {
            $data['moip_assinatura_second_try'] = $this->config->get('moip_assinatura_second_try');
        } else {
            $data['moip_assinatura_second_try'] = 3;
        }
        
        if (isset($this->request->post['moip_assinatura_third_try'])) {
            $data['moip_assinatura_third_try'] = $this->request->post['moip_assinatura_third_try'];
        } elseif ($this->config->get('moip_assinatura_third_try')) {
            $data['moip_assinatura_third_try'] = $this->config->get('moip_assinatura_third_try');
        } else {
            $data['moip_assinatura_third_try'] = 5;
        }
        
        if (isset($this->request->post['moip_assinatura_last_try'])) {
            $data['moip_assinatura_last_try'] = $this->request->post['moip_assinatura_last_try'];
        } elseif ($this->config->get('moip_assinatura_last_try')) {
            $data['moip_assinatura_last_try'] = $this->config->get('moip_assinatura_last_try');
        } else {
            $data['moip_assinatura_last_try'] = 7;
        }
        
        if (isset($this->request->post['moip_assinatura_cpf'])) {
            $data['moip_assinatura_cpf'] = $this->request->post['moip_assinatura_cpf'];
        } else {
            $data['moip_assinatura_cpf'] = $this->config->get('moip_assinatura_cpf');
        }
        
        if (isset($this->request->post['moip_assinatura_birth_date'])) {
            $data['moip_assinatura_birth_date'] = $this->request->post['moip_assinatura_birth_date'];
        } else {
            $data['moip_assinatura_birth_date'] = $this->config->get('moip_assinatura_birth_date');
        }
        
        if (isset($this->request->post['moip_assinatura_address_number'])) {
            $data['moip_assinatura_address_number'] = $this->request->post['moip_assinatura_address_number'];
        } else {
            $data['moip_assinatura_address_number'] = $this->config->get('moip_assinatura_address_number');
        }
        
        if (isset($this->request->post['moip_assinatura_credit_card_status'])) {
            $data['moip_assinatura_credit_card_status'] = $this->request->post['moip_assinatura_credit_card_status'];
        } else {
            $data['moip_assinatura_credit_card_status'] = $this->config->get('moip_assinatura_credit_card_status');
        }
        
        if (isset($this->request->post['moip_assinatura_billet_status'])) {
            $data['moip_assinatura_billet_status'] = $this->request->post['moip_assinatura_billet_status'];
        } else {
            $data['moip_assinatura_billet_status'] = $this->config->get('moip_assinatura_billet_status');
        }
        
        if (isset($this->request->post['moip_assinatura_payment_default'])) {
            $data['moip_assinatura_payment_default'] = $this->request->post['moip_assinatura_payment_default'];
        } else {
            $data['moip_assinatura_payment_default'] = $this->config->get('moip_assinatura_payment_default');
        }
        
        $data['notify_url'] = HTTPS_SERVER . 'index.php?route=payment/moip_assinatura/notify&authorization=' . $data['moip_assinatura_authorization'];
        
        $this->load->model('localisation/geo_zone');
        
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
        
        $this->load->model('localisation/order_status');
        
        $data['recurring_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        
        $this->load->model('payment/moip_assinatura');
        
        $data['transiction_statuses'] = $this->model_payment_moip_assinatura->getOrderStatuses();
        
        $this->load->model('customer/custom_field');
        
        $data['custom_fields'] = $this->model_customer_custom_field->getCustomFields();
        
        $data['action'] = $this->url->link('payment/moip_assinatura', 'token=' . $this->session->data['token'], true);
        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true);
        $data['custom_field_add'] = $this->url->link('customer/custom_field/add', 'token=' . $this->session->data['token'], true);
        $data['export_plan'] = (!$this->config->get('moip_assinatura_first_time')) ? $this->url->link('payment/moip_assinatura/export_plan', 'token=' . $this->session->data['token'], true) : false;
        
        $data['token'] = $this->session->data['token'];
        
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('payment/moip_assinatura.tpl', $data));
    }
    
    public function export_plan() {
        $MoipAssinatura = new MoipAssinatura(
            $this->config->get('moip_assinatura_token'),
            $this->config->get('moip_assinatura_key'),
            $this->config->get('moip_assinatura_sandbox'),
            $this->config->get('moip_assinatura_debug')
        );
        
        $this->load->model('catalog/recurring');
        
        $recurrings = $this->model_catalog_recurring->getRecurrings();
        
        $json = array();
        
        foreach($recurrings as $recurring) {
            
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
        }
        
        $this->response->addHeader('content-type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function install() {
        $this->load->model('setting/setting');
        
        $this->model_setting_setting->editSetting('moip_assinatura', array('moip_assinatura_first_time' => 1));
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/moip_assinatura')) {
            $this->error['warning'] = $this->language->get('error_warning');
        }
        
        if (strlen(trim($this->request->post['moip_assinatura_token'])) < 32) {
            $this->error['token'] = $this->language->get('error_token');
        }
        
        if (strlen(trim($this->request->post['moip_assinatura_key'])) < 32) {
            $this->error['key'] = $this->language->get('error_key');
        }
        
        if (strlen(trim($this->request->post['moip_assinatura_authorization'])) < 32) {
            $this->error['authorization'] = $this->language->get('error_authorization');
        }
        
        if (!isset($this->request->post['moip_assinatura_cpf'])) {
            $this->error['cpf'] = $this->language->get('error_cpf');
        }
        
        if (!isset($this->request->post['moip_assinatura_birth_date'])) {
            $this->error['birth_date'] = $this->language->get('error_birth_date');
        }
        
        if (!isset($this->request->post['moip_assinatura_address_number'])) {
            $this->error['address_number'] = $this->language->get('error_address_number');
        }
        
        return !$this->error;
    }
}