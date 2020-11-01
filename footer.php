<link rel="stylesheet" href="footer.css">
<div class="flex-footer">
  <div class="flex-footer-element">
    <form id="contact" class="contact" action="contact.php" method="post">
      <fieldset class="contact">
        <legend>Contactar</legend>
        <label for="c-email">E-mail:</label>
        <input type="text" name="c-email" class="contact-text">
        <label for="c-subject">Questão:<br></label>
        <input type="radio" name="c-subject" value="Questao Tecnica">Técnica &nbsp&nbsp&nbsp&nbsp&nbsp
        <input type="radio" name="c-subject" value="Questao Informativa">Informativa<br>
        <label for="c-content">Corpo:</label>
        <textarea name="c-content" class="contact-text" cols="21" rows="5"></textarea>
        <button type="submit" class="wbtn rect">Enviar</button>
      </fieldset>
    </form>
  </div>
  <div class="flex-footer-element" style="font-size:11pt">
    Brevemente após o preenchimento do formulário de suporte irá ser notificado(a) via e-mail com o esclarecimento da questão do tipo "informativa" ou com estado de resolução do problema técnico.
  <br>
    Esta aplicação web (<strong>open source</strong>) foi especialmente desenvolvida para o auxilio dos profissionais na realização de inquéritos, formulários, estudos e testes de avaliação durante o decorrer da pandemia <a href="https://pt.wikipedia.org/wiki/COVID-19" class="site-map">Covid-19</a>. <br>O código fonte está disponível no <a href="https://github.com/Tiao04/WebForms" class="site-map">GitHub</a>.
  </div>
  <div class="vertical-line"></div>
  <div class="flex-footer-element">
    <h3 class="footer-title">Translate:	&#160;&#160;</h3>
    <div id="google_translate_element"></div><br>
    <h3>Mapa do site</h3>
    <a href="/" class="site-map">Página inicial</a><br>
    <a href="/explore.php" class="site-map">Explorar</a><br><br>
    <a href="/login.html" class="site-map">Registrar</a><br>
    <a href="login.html" class="site-map">Entrar</a><br><br>
    <a href="privacyPolicy.html" class="site-map">Política de privacidade</a><br>
    <a href="termsOfService.html" class="site-map">Termos e Condições</a><br><br><br>
    <div id="copyright" class="site-map">©Sebastião Teixeira 2020
      <?php
      if (date("Y") > 2020) {
        echo "-" . date("Y");
      }
      ?></div>
  </div>
</div>