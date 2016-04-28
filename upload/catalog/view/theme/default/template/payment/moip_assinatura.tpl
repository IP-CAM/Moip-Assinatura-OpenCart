<style type="text/css">
.overlay {height: 30px;width: 68px;background: #FFF;position: absolute;opacity: 0.7;}
.overlay:hover {opacity: 0;}
.vhide, .vlhide, .titular {display:none}
</style>

<?php if (!$customer_registed_moip) { ?>
  <style type="text/css">
  #check .checkbox {
    padding-left: 20px;
    zoom:1.2 }
    #check .checkbox label {
      display: inline-block;
      position: relative;
      padding-left: 5px; }
      #check .checkbox label::before {
        content: "";
        display: inline-block;
        position: absolute;
        width: 17px;
        height: 17px;
        left: 0;
        margin-left: -20px;
        border: 1px solid #cccccc;
        border-radius: 3px;
        background-color: #fff;
        -webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
        -o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
        transition: border 0.15s ease-in-out, color 0.15s ease-in-out; }
      #check .checkbox label::after {
        display: inline-block;
        position: absolute;
        width: 16px;
        height: 16px;
        left: 0;
        top: 0;
        margin-left: -20px;
        padding-left: 3px;
        padding-top: 1px;
        font-size: 11px;
        color: #555555; }
    #check .checkbox input[type="checkbox"] {
      opacity: 0; }
      #check .checkbox input[type="checkbox"]:focus + label::before {
        outline: thin dotted;
        outline: 5px auto -webkit-focus-ring-color;
        outline-offset: -2px; }
      #check .checkbox input[type="checkbox"]:checked + label::after {
        font-family: 'FontAwesome';
        content: "\f00c"; }
      #check .checkbox input[type="checkbox"]:disabled + label {
        opacity: 0.65; }
        #check .checkbox input[type="checkbox"]:disabled + label::before {
          background-color: #eeeeee;
          cursor: not-allowed; }
    #check .checkbox#check .checkbox-circle label::before {
      border-radius: 50%; }
    #check .checkbox#check .checkbox-inline {
      margin-top: 0; }

  #check .checkbox-primary input[type="checkbox"]:checked + label::before {
    background-color: #428bca;
    border-color: #428bca; }
  #check .checkbox-primary input[type="checkbox"]:checked + label::after {
    color: #fff; }

  #check .checkbox-danger input[type="checkbox"]:checked + label::before {
    background-color: #d9534f;
    border-color: #d9534f; }
  #check .checkbox-danger input[type="checkbox"]:checked + label::after {
    color: #fff; }

  #check .checkbox-info input[type="checkbox"]:checked + label::before {
    background-color: #5bc0de;
    border-color: #5bc0de; }
  #check .checkbox-info input[type="checkbox"]:checked + label::after {
    color: #fff; }

  #check .checkbox-warning input[type="checkbox"]:checked + label::before {
    background-color: #f0ad4e;
    border-color: #f0ad4e; }
  #check .checkbox-warning input[type="checkbox"]:checked + label::after {
    color: #fff; }

  #check .checkbox-success input[type="checkbox"]:checked + label::before {
    background-color: #5cb85c;
    border-color: #5cb85c; }
  #check .checkbox-success input[type="checkbox"]:checked + label::after {
    color: #fff; }
  </style>
  <style type="text/css">
    /* entire container, keeps perspective */
  .flip-container {
    perspective: 1000;
    transform-style: preserve-3d;
    height:180px
  }
    /*  UPDATED! flip the pane when hovered */
    .flip-container-hover .back {
      transform: rotateY(0deg);
    }
    .flip-container-hover .front {
        transform: rotateY(180deg);
    }

  .flip-container, .front, .back {
    height: 180px;
  }

  /* flip speed goes here */
  .flipper {
    transition: 0.6s;
    transform-style: preserve-3d;

    position: relative;
  }

  /* hide back of pane during swap */
  .front, .back {
    backface-visibility: hidden;
    transition: 0.6s;
    transform-style: preserve-3d;

    position: absolute;
    top: 0;
    left: 0;
  }

  /*  UPDATED! front pane, placed above back */
  .front {
    z-index: 2;
    transform: rotateY(0deg);
  }

  /* back, initially hidden pane */
  .back {
    transform: rotateY(-180deg);
  }

  .logo-iugu {
    position: absolute;
    bottom: -200px;
    right: 27px;
  }
  </style>

  <div class="container-fluid">
    <div class="row-fluid">
    
      <div class="form-horizontal">
        <div class="form-group">
          <div id="bandeiras" class="col-sm-7 col-sm-offset-2"></div>
        </div>

        <div id="form" class="col-sm-offset-1 col-sm-6">
          <div class="form-group col-sm-12">
            <label class="col-sm-4 control-label">Nome:</label>
            <div class="col-sm-8">
              <input class="form-control" type="text" id="nome" name="name" placeholder="Ex: Valdeir Santana" value="<?php echo $customer_name ?>" />
            </div>
          </div>
          
          <div class="form-group col-sm-12">
            <label class="col-sm-4 control-label">Número do Cartão:</label>
            <div class="col-sm-8">
              <input class="form-control" type="text" id="numero-cartao" name="credit_card" placeholder="4111 1111 1111 1111" />
            </div>
          </div>

          <div class="form-group col-sm-12">
            <label class="col-sm-4 control-label">Validade:</label>
            <div class="col-sm-8">
              <input class="form-control" type="text" id="validade" name="validade" placeholder="Ex: <?php echo date('m/y') ?>" />
            </div>
          </div>
          
          <div class="form-group col-sm-12">
            <div class="col-sm-5 col-sm-offset-4" id="check">
              <div class="checkbox">
                <input type="checkbox" name="check-titular" id="check-titular" <?php echo ($customer_birth_date && $customer_cpf && $customer_telephone) ? 'checked' : '' ?>>
                <label for="check-titular">
                  Eu sou o títular do cartão
                </label>
              </div>
            </div>
          </div>

          <div class="form-group col-sm-12 titular">
            <label class="col-sm-4 control-label">Data de Nascimento:</label>
            <div class="col-sm-8">
              <input class="form-control" type="date" id="data-nascimento" name="birth_date" placeholder="Ex: 13/07/1993" value="<?php echo $customer_birth_date ?>" />
            </div>
          </div>

          <div class="form-group col-sm-12 titular">
            <label class="col-sm-4 control-label">CPF:</label>
            <div class="col-sm-8">
              <input class="form-control" type="text" id="cpf" name="cpf" placeholder="Ex: 222.222.222-22" value="<?php echo $customer_cpf ?>" />
            </div>
          </div>

          <div class="form-group col-sm-12 titular">
            <label class="col-sm-4 control-label">Telefone:</label>
            <div class="col-sm-8">
              <input class="form-control" type="text" id="telefone" name="telephone" placeholder="Ex: (11)98765-4321" value="<?php echo $customer_telephone ?>" />
            </div>
          </div>
          
          <div class="form-group col-sm-12">
            <div class="col-sm-5 col-sm-offset-4">
              <button type="button" id="button-confirm" class="btn btn-primaty" data-loading-text="<?php echo $text_loading ?>">Pagar</button>
            </div>
          </div>
        </div>
        
        <div class="flip-container col-sm-5">
          <div class="flipper">
            <div class="front">
              <div id="credit-card-example-number" style="border: 3px solid #F00;position: absolute;height: 27px;width: 207px;top: 90px;left: 20px;opacity: 0;z-index:1"></div>
              <div id="credit-card-example-validate" style="border: 3px solid #F00;position: absolute;height: 32px;width: 67px;top: 111px;left: 122px;opacity: 0"></div>
              <div id="credit-card-example-customer" style="border: 3px solid #F00;position: absolute;height: 27px;width: 130px;top: 141px;left: 20px;opacity: 0"></div>
              <div id="credit-card-example-logo" style="background: #FFF url(catalog/view/theme/default/image/pg_credit_card_brands.png) center 8px no-repeat;position: absolute;height: 43px;width: 63px;top: 114px;left: 208px;border-radius: 8px;opacity: 0"></div>
              <img src="catalog/view/theme/default/image/CreditCardFront.gif" style="height:180px" />
            </div>
            <div class="back">
              <div id="credit-card-example-ccv" style="border: 3px solid #F00;position: absolute;height: 37px;width: 50px;top: 60px;left: 225px;opacity: 0"></div>
              <img src="catalog/view/theme/default/image/CreditCardBack.gif" style="height:180px" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $('#check-titular').change(function(){
      if ($(this).is(':checked')) {
        $('.titular').slideUp('show');
      } else {
        $('.titular').slideDown('show');
      }
    });
    
    $('#cvv').focus(function(){
      $('.flip-container').toggleClass('flip-container-hover');
    });
    
    $('input:not(#cvv)').focus(function(){
      $('.flip-container').removeClass('flip-container-hover');
    });
    
    $('#cvv').blur(function(){
      $('.flip-container').removeClass('flip-container-hover');
    });
    
    $('#numero-cartao').focus(function(){
      $('#credit-card-example-number').stop().animate({
        opacity:1
      }, 1000);
    });
    
    $('#nome').focus(function(){
      $('#credit-card-example-customer').stop().animate({
        opacity:1
      }, 1000);
    });
    
    $('#validade').focus(function(){
      $('#credit-card-example-validate').stop().animate({
        opacity:1
      }, 1000);
    });
    
    $('#cvv').focus(function(){
      $('#credit-card-example-ccv').stop().animate({
        opacity:1
      }, 1500);
    });
    
    $('input').blur(function(){
      $('.flip-container .front div:not(#credit-card-example-logo), .flip-container .back div').stop().animate({
        opacity:0
      }, 1000);
    });
    
    $('#check-titular').trigger('change');
  </script>

  <script type="text/javascript">
  $('#button-confirm').click(function(){
    $.ajax({
      url: 'index.php?route=payment/moip_assinatura/transition',
      data: $('.form-horizontal input'),
      type: 'POST',
      dataType: 'JSON',
      beforeSend: function(){
        $('#button-confirm').button('loading');
      },
      success: function(json){
      
        var html = '';
        
        $.map(json, function(recurring){
          if (recurring.hasOwnProperty('error')) {
            $('#warning').empty();
            html += '<b>' + recurring['message'] + '</b><br/>';
            html += '<i>Código da Assinatura:</i> ' + recurring['code'] + '<br />';
            html += '<i>Código do Plano:</i> ' + recurring['plan']['code'] + '<br />';
            html += '<i>Nome do Plano:</i> ' + recurring['plan']['name'] + '<br />';
            html += '<i>Erros:</i> <br/>';
            $.map(recurring['errors'], function(error){
              html += '<i> - </i>' + error['description'] + ' <br/>';
            })
            html += '<hr style="border: 1px dashed;">';
            
            $('#warning').html(html).slideDown('slow');
          } else {
            html += '<b>' + recurring['message'] + '</b><br/>';
            html += '<i>Código da Assinatura:</i> ' + recurring['code'] + '<br />';
            html += '<i>Código do Plano:</i> ' + recurring['plan']['code'] + '<br />';
            html += '<i>Nome do Plano:</i> ' + recurring['plan']['name'] + '<br />';
            html += '<i>Situação:</i> ' + recurring['invoice']['status']['description'] + '<br />';
            html += '<i>Próxima Fatura:</i> ' + recurring['next_invoice_date']['day'] + '/' + recurring['next_invoice_date']['month'] + '/' + recurring['next_invoice_date']['year'] + '<br />';
            html += '<hr style="border: 1px dashed;">';
            
            $('#button-confirm').remove();
            $('#success').html(html).slideDown('slow');
        
            setTimeout(function(){
              location.href = '<?php echo $redirect ?>'
            }, 5000);
          }
        });
      },
      complete: function(){
        $('#button-confirm').button('reset');
      }
    });
  });
  </script>
<?php } else { ?>

  <div class="container-fluid">
    <div class="alert alert-danger vhide" id="warning" role="alert"></div>
    <div class="alert alert-success vhide" id="success" role="alert"></div>
  </div>

  <div class="buttons clearfix">
    <div class="pull-right">
        <button type="button" id="button-confirm" class="btn btn-primary">Confirmar</a>
    </div>
  </div>

  <script type="text/javascript">
    $('#button-confirm').click(function(){
      $.ajax({
        url: 'index.php?route=payment/moip_assinatura/transition',
        type: 'POST',
        dataType: 'JSON',
        beforeSend: function(){
          $('#button-confirm').button('loading');
        },
        success: function(json){
        
          var html = '';
          
          $.map(json, function(recurring){
            if (recurring.hasOwnProperty('error')) {
              $('#warning').empty();
              html += '<b>' + recurring['message'] + '</b><br/>';
              html += '<i>Código da Assinatura:</i> ' + recurring['code'] + '<br />';
              html += '<i>Código do Plano:</i> ' + recurring['plan']['code'] + '<br />';
              html += '<i>Nome do Plano:</i> ' + recurring['plan']['name'] + '<br />';
              html += '<i>Erros:</i> <br/>';
              $.map(recurring['errors'], function(error){
                html += '<i> - </i>' + error['description'] + ' <br/>';
              })
              html += '<hr style="border: 1px dashed;">';
              
              $('#warning').html(html).slideDown('slow');
            } else {
              html += '<b>' + recurring['message'] + '</b><br/>';
              html += '<i>Código da Assinatura:</i> ' + recurring['code'] + '<br />';
              html += '<i>Código do Plano:</i> ' + recurring['plan']['code'] + '<br />';
              html += '<i>Nome do Plano:</i> ' + recurring['plan']['name'] + '<br />';
              html += '<i>Situação:</i> ' + recurring['invoice']['status']['description'] + '<br />';
              html += '<i>Próxima Fatura:</i> ' + recurring['next_invoice_date']['day'] + '/' + recurring['next_invoice_date']['month'] + '/' + recurring['next_invoice_date']['year'] + '<br />';
              html += '<hr style="border: 1px dashed;">';
              
              $('#button-confirm').remove();
              $('#success').html(html).slideDown('slow');
          
              setTimeout(function(){
                location.href = '<?php echo $redirect ?>'
              }, 5000);
            }
          });
        },
        complete: function(){
          $('#button-confirm').button('reset');
        }
      });
    });
  </script>
<?php } ?>