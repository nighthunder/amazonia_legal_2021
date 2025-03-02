  // jQuery.noConflict();
  
  function salvarCookie(chave, valor, duracaoEmDias)
  {
    var dataExpiracao = '';

    if(duracaoEmDias)
    {
      var dataAtual = new Date();

      var HORAS_EM_UM_DIA = 24, MINUTOS_EM_UMA_HORA = 60, SEGUNDOS_EM_UM_MINUTO = 60, MILISSEGUNDOS_EM_UM_SEGUNDO = 1000;
      dataAtual.setTime(dataAtual.getTime() + (duracaoEmDias*HORAS_EM_UM_DIA*MINUTOS_EM_UMA_HORA*SEGUNDOS_EM_UM_MINUTO*MILISSEGUNDOS_EM_UM_SEGUNDO));

      dataExpiracao = `; expires=${dataAtual.toUTCString()}`;
    }

    document.cookie = `${chave}=${(valor || '')}${dataExpiracao}; path=/`;
  }

  function recuperarCookie(chave)
  {
    var cookies = document.cookie.split(';');

    for(var i = 0; i < cookies.length; i++)
    {
      var cookie = cookies[i];

      var textoLimpo = cookie.trim();

      if(textoLimpo.indexOf(chave) == 0) return textoLimpo.substring(chave.length+1, textoLimpo.length);
    }

    return null;
  }

  function criaModalContato()
  {
    var chaveCookie = 'MODAL_EXIBIDO';
    if(!recuperarCookie(chaveCookie))
    {
      salvarCookie(chaveCookie, true);
      document.querySelector(".surveyModalWrapper").classList.remove('hiddenSurveyModal');
      document.querySelector(".surveyModal").classList.remove('hiddenSurveyModal');
    }
  }

  function fecharModalContato()
  {
    document.querySelector(".surveyModalWrapper").classList.add('hiddenSurveyModal');
    document.querySelector(".surveyModal").classList.add('hiddenSurveyModal');
  }

  function botaoGestaoPublica(event)
  {
      if(!event.target.classList.contains('inactiveButton'))
      {
        document.querySelector('.sendButton').classList.remove('hiddenButton');
        document.querySelector('.surveyModalPublicManagement').classList.add('activeSection');
        document.querySelector('.surveyModalPublicManagement').classList.remove('hiddenSection');
        document.querySelector('.surveyModalPrivateManagement').classList.add('hiddenSection');
        document.querySelector('.surveyModalPrivateManagement').classList.remove('activeSection');
        document.querySelector('.negateButton').classList.add('inactiveButton');
      } 
  }

  function botaoGestaoPrivada(event)
  {
    if(!event.target.classList.contains('inactiveButton'))
    {
      document.querySelector('.sendButton').classList.remove('hiddenButton');
      document.querySelector('.surveyModalPublicManagement').classList.add('hiddenSection');
      document.querySelector('.surveyModalPublicManagement').classList.remove('activeSection');
      document.querySelector('.surveyModalPrivateManagement').classList.remove('hiddenSection');
      document.querySelector('.surveyModalPrivateManagement').classList.add('activeSection');
      document.querySelector('.confirmButton').classList.add('inactiveButton');
    }
  }

  function mostrarOpcoes(event)
  {
    var container = event.target.parentNode;
    container.parentNode.querySelector('.options').classList.remove('hiddenOptions');
    container.querySelector('.hideOptions').classList.remove('hiddenIcon');
    event.target.classList.add('hiddenIcon');
  }

  function esconderOpcoes(event)
  {
    var container = event.target.parentNode;
    container.parentNode.querySelector('.options').classList.add('hiddenOptions');
    container.querySelector('.showOptions').classList.remove('hiddenIcon');
    event.target.classList.add('hiddenIcon');
  }

  function selecionaOpcao(event) 
  {
    var elemento = event.target;
    if (elemento.checked) 
    {
      var stringBusca = "input[type=checkbox][name='" + elemento.getAttribute("name") + "']";
      
      [...document.querySelectorAll(stringBusca)].forEach(el => el.checked = false);
      elemento.checked = true;
      elemento.parentNode.parentNode.parentNode.querySelector('.sectionValue').innerText = elemento.parentNode.innerText.trim();
    } 
    else 
    {
      elemento.checked = false;
    }

  }

  function coletaDadosFormulario()
  {
    /**
     * TODO: deixar genérico para um número indefinido de secções
     */

    var seccao = document.querySelector('.activeSection');
    
    var ehSeccaoGestaoPublica = ([...seccao.classList].filter(c => c === 'surveyModalPublicManagement').length > 0);

    var seccaoOcupacao = seccao.querySelector('.occupationSelect');
    var seccaoEstado = seccao.querySelector('.stateSelect');

    var ocupacao = [...seccaoOcupacao.querySelectorAll('[type=checkbox]')].filter(o => o.checked)[0];
    var estado = [...seccaoEstado.querySelectorAll('[type=checkbox]')].filter(o => o.checked)[0];

    ocupacao = ocupacao ? ocupacao.value : undefined;
    estado = estado ? estado.value : undefined;    

    if(!estado) seccaoEstado.classList.add('invalidInput');
    else seccaoEstado.classList.remove('invalidInput');
    if(!ocupacao) seccaoOcupacao.classList.add('invalidInput');
    else seccaoOcupacao.classList.remove('invalidInput');

    var tipoGestao = ehSeccaoGestaoPublica ? 'publica' : 'privada';

    return {tipoGestao, ocupacao, estado};
  }

  function enviarFormulario()
  {
    var {tipoGestao, ocupacao, estado} = coletaDadosFormulario();

    if(tipoGestao && ocupacao && estado)
    {
      var URL = `${window.location.protocol}//${window.location.host.split(':')[0]}/app/controllers/contactmodalcontroller.php?tipogestao=${tipoGestao}&ocupacao=${ocupacao}&estado=${estado}`;
 
      var codigoSucesso = 200;

      fetch(URL, {method: 'post'})
      .then(res => res.status)
      .then(statusCode => {
        var mensagemResposta = 'Erro no envio!';
        if(statusCode == codigoSucesso)
        {
          mensagemResposta = 'Enviado. Obrigado por responder!';

          setTimeout(fecharModalContato, 2000);
        }
        var containerMensagem = document.querySelector('.requestResponse');
        containerMensagem.classList.remove('hiddenResponse');
        containerMensagem.textContent = mensagemResposta;
      });
    }
  }

   jQuery(document).ready(function($) {

      // $(".app-container").addClass("closed-sidebar");
      $("body > div.app-container.app-theme-white.body-tabs-shadow.fixed-header.fixed-sidebar").addClass("closed-sidebar");

      setTimeout(criaModalContato, 500);

      $('.confirmButton').click(botaoGestaoPublica);
      $('.negateButton').click(botaoGestaoPrivada);

      $('.surveyModal input:checkbox').prop("checked", false);

      $(".surveyModalCloseIcon").click(fecharModalContato);
      $(".sendButton").click(enviarFormulario);
      $(".surveyModalDisplayIcon").click(mostrarOpcoes);
      $('.hideOptions').click(esconderOpcoes);
      $('.showOptions').click(mostrarOpcoes);
      $('.option').click(selecionaOpcao);
	 });       