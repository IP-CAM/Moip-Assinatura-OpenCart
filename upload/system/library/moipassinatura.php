<?php
/*
    Author: Valdeir Santana
    Site: http://www.valdeirsantana.com.br
*/
class MoipAssinatura
{
    protected $curl = null;
    
    public function __construct($token, $key, $sandbox = false, $debug = true)
    {
        if (is_null($this->curl)) {
            $this->curl = new MoipRequest($token, $key, $sandbox, $debug);
        }
    }
    
    /*
        Listar todos os clientes ou Consultar detalhes de um cliente
        http://moiplabs.github.io/assinaturas-docs/api.html#listar_clientes
    */
    public function listCustomers($customer_code = '')
    {        
        return $this->curl->get('customers/' . $customer_code);
    }
    
    /*
        Criar um cliente
        http://moiplabs.github.io/assinaturas-docs/api.html#criar_cliente
    */
    public function createCustomer($data, $new_valt = false)
    {        
        return $this->curl->post('customers?new_valt=' . ($new_valt) ? 'true' : 'false', $data);
    }
    
    /*
        Alterar um cliente
        http://moiplabs.github.io/assinaturas-docs/api.html#alterar_cliente
    */
    public function updateCustomer($customer_code = '', $data= array())
    {        
        return $this->curl->put('customers/' . $customer_code, $data);
    }
    
    /*
        Atualizar cartão do cliente
        http://moiplabs.github.io/assinaturas-docs/api.html#atualizar_cartao
    */
    public function updateBillingInfo($customer_code = '', $data= array())
    {        
        return $this->curl->put('customers/' . $customer_code . '/billing_infos', $data);
    }

    /*
        Criar um plano
        http://moiplabs.github.io/assinaturas-docs/api.html#criar_plano
    */
    public function createPlan($data = array())
    {
        return $this->curl->post('plans', $data);
    }
    
    /*
        Listar todos os planos ou Consultar detalhes de um plano
        http://moiplabs.github.io/assinaturas-docs/api.html#listar_plano
    */
    public function listPlans($plan_code = '')
    {
        return $this->curl->get('plans/' . $plan_code);
    }
    
    /*
        Ativar um plano
        http://moiplabs.github.io/assinaturas-docs/api.html#ativar_desativar_plano
    */
    public function activePlan($plan_code)
    {
        return $this->curl->put('plans/' . $plan_code . '/activate');
    }
    
    /*
        Desativar um plano
        http://moiplabs.github.io/assinaturas-docs/api.html#ativar_desativar_plano
    */
    public function inactivatePlan($plan_code)
    {
        return $this->curl->put('plans/' . $plan_code . '/inactivate');
    }
    
    /*
        Alterar um plano
        http://moiplabs.github.io/assinaturas-docs/api.html#alterar_plano
    */
    public function updatePlan($plan_code, $data)
    {
        return $this->curl->put('plans/' . $plan_code, $data);
    }

    /*
        Criar Assinaturas
        http://moiplabs.github.io/assinaturas-docs/api.html#criar_assinatura
    */
    public function createSubscriptions($data = array(), $new_customer = false)
    {
        $new_customer = ($new_customer) ? 'true' : 'false';
        return $this->curl->post('subscriptions?new_customer=' . $new_customer, $data);
    }
    
    /*
        Listar todas assinaturas ou Consultar detalhes de uma assinatura
        http://moiplabs.github.io/assinaturas-docs/api.html#listar_assinaturas
    */
    public function listSubscriptions($subscription_code = '')
    {
        return $this->curl->get('subscriptions/' . $subscription_code);
    }
    
    /*
        Suspender uma Assinatura
        http://moiplabs.github.io/assinaturas-docs/api.html#suspender_reativar_assinatura
    */
    public function suspendSubscriptions($subscription_code)
    {
        return $this->curl->put('subscriptions/' . $subscription_code . '/suspend');
    }
    
    /*
        Reativar uma Assinatura
        http://moiplabs.github.io/assinaturas-docs/api.html#suspender_reativar_assinatura
    */
    public function activateSubscriptions($subscription_code)
    {
        return $this->curl->put('subscriptions/' . $subscription_code . '/activate');
    }
    
    /*
        Cancelar uma Assinatura
        http://moiplabs.github.io/assinaturas-docs/api.html#suspender_reativar_assinatura
    */
    public function cancelSubscriptions($subscription_code)
    {
        return $this->curl->put('subscriptions/' . $subscription_code . '/cancel');
    }
    
    /*
        Alterar uma assinatura
        http://moiplabs.github.io/assinaturas-docs/api.html#alterar_assinatura
    */
    public function updateSubscriptions($subscription_code, $data = array())
    {
        return $this->curl->put('subscriptions/' . $subscription_code, $data);
    }
    
    /*
        Listar todas as faturas de uma assinatura ou Consultar detalhes de uma fatura
        http://moiplabs.github.io/assinaturas-docs/api.html#listar_faturas
    */
    public function listInvoices($subscription_code)
    {
        return $this->curl->get('subscriptions/' . $subscription_code . '/invoices');
    }
    
    /*
        Consultar detalhes de uma fatura ou Consultar detalhes de uma fatura
        http://moiplabs.github.io/assinaturas-docs/api.html#consultar_fatura
    */
    public function infoInvoice($invoice_id)
    {
        return $this->curl->get('invoices/' . $invoice_id);
    }
    
    /*
        Listar todos os pagamentos de uma fatura ou Consultar detalhes de um pagamento
        http://moiplabs.github.io/assinaturas-docs/api.html#listar_pagamentos
    */
    public function listPayments($invoice_id)
    {
        return $this->curl->get('invoices/' . $invoice_id . '/payments');
    }
    
    /*
        Consultar detalhes de um pagamento
        http://moiplabs.github.io/assinaturas-docs/api.html#consultar_pagamento
    */
    public function infoPayments($info_id)
    {
        return $this->curl->get('payments/' . $info_id);
    }
    
    /*
        Retentar um pagamento
        http://moiplabs.github.io/assinaturas-docs/api.html#retentar_pagamento
    */
    public function retryPayment($invoice_id)
    {
        return $this->curl->post('invoices/' . $invoice_id . '/retry');
    }
    
    /*
        Configurar retentativas
        http://moiplabs.github.io/assinaturas-docs/api.html#retentar_pagamento
    */
    public function preferencesRetry($data = array())
    {
        return $this->curl->post('users/preferences/retry', $data);
    }
}