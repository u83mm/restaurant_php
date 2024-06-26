<!-- CONFIGURE COOKIES BANNER -->

<section id="cookies_config_consent" class="cookies_config_consent">
    <div id="cookies_consent_banner" class="col-12 cookies_consent_banner">
        <p>
            <?php echo ucfirst($this->language['cookies_consent']); ?> <a id="cookies_policy" href="#"><?php echo ucfirst($this->language['cookies policy']); ?></a>.
        </p>
        <div class="cookies_consent_buttons">
            <button id="accept_cookies"><?php echo ucfirst($this->language['accept']); ?></button>
            <button id="reject_cookies"><?php echo ucfirst($this->language['reject']); ?></button>
            <button id="configure_cookies"><?php echo ucfirst($this->language['configure']); ?></button>
        </div> 
    </div>
</section>


<!-- CONFIGURE COOKIES MODAL -->

<section id="cookies_config_modal" class="cookies_config_modal">
    <div class="cookies_config_content">
        <h2><strong><?php echo ucfirst($this->language['cookies_config']); ?></strong></h2>
        <p><?php echo ucfirst($this->language['cookies_config_description']); ?></p>
        <h3><strong><?php echo ucfirst($this->language['cookies_config_options']); ?></strong></h3>
        <div class="row shadow rounded bg-white p-2 mb-3">
            <p class="col-12 mb-3">
                <strong><?php echo ucfirst($this->language['session']); ?>: PHPSESSID, phpMyAdmin, pma_lang, pmaAuth-1, pmaUser-1</strong>
            </p>
            <p class="col-12 mb-3"><?php echo ucfirst($this->language['cookies_config_notice']); ?></p>
        </div>
        <div class="row shadow rounded bg-white p-2 mb-3">
            <p class="col-12 mb-3">
                <strong>Técnicas: cookies_consent, analitycs, marketing, necessary</strong>
            </p>
            <p class="col-12 mb-3">Guarda la configuración de cookies seleccionada por el usuario.</p>
        </div>
        <div class="row">
            <label class="col-12 col-lg-5 text-start" for="necessary_cookies">
                <input class="form-check-input" type="checkbox" id="necessary_cookies" name="necessary_cookies" value="necessary_cookies">            
                <?php echo ucfirst($this->language['necessary_cookies']); ?>
            </label>
            <label class="col-12 col-lg-5 text-start" for="analytics_cookies">
                <input class="form-check-input" type="checkbox" id="analytics_cookies" name="analytics_cookies" value="analytics_cookies">            
                <?php echo ucfirst($this->language['analitics_cookies']); ?>
            </label>
            <label class="col-12 col-lg-5 text-start" for="marketing_cookies">
                <input class="form-check-input" type="checkbox" id="marketing_cookies" name="marketing_cookies" value="marketing_cookies">            
                <?php echo ucfirst($this->language['marketing_cookies']); ?>
            </label>
        </div>        
        <div class="cookies_config_buttons">
            <button id="save_config"><?php echo ucfirst($this->language['save']); ?></button>
            <button id="cancel_config"><?php echo ucfirst($this->language['cancel']); ?></button>
        </div>
    </div>
</section>


<!-- COOKIES POLICY MODAL -->

<section id="cookies_policy_modal" class="cookies_policy_modal">
    <div class="cookies_policy_content">
        <h2><strong><?php echo ucfirst($this->language['cookies_policy']); ?></strong></h2>
        <p>Se informa que este sitio web usa cookies para:</p>

        <ol>
            <li>Personalizar y mejorar la experiencia de usuario.</li>
            <li>Recibir notificaciones de actualizaciones y correcciones.</li>
        </ol>

        <h3><strong>¿Que son las cookies?</strong></h3>
        <p>Las cookies son archivos que los sitios web o las aplicaciones instalan en el navegador o en el dispositivo 
            (smartphone, tablet o televisión conectada) de la persona usuaria durante su recorrido por las páginas del 
            sitio o por la aplicación, y sirven para almacenar información sobre su visita.</p>

        <h3><strong>¿Que tipos de cookies utiliza este sitio web?</strong></h3>
        <p>Las cookies, en función de su permanencia, pueden dividirse en cookies de sesión o permanentes. Las primeras 
            expiran cuando la persona usuaria cierra el navegador. Las segundas expiran cuando se cumple el objetivo para 
            el que sirven (por ejemplo, para que la persona usuaria se mantenga identificada en el sitio web) o bien cuando 
            se borran manualmente. </p>        
        <ul>
            <li>
                <strong>Necesarias:</strong> Son las cookies que se utilizan para la gestión de la sesión del usuario.
            </li>
            <li>
                <strong>Analíticas:</strong> Recopilan información sobre la experiencia de navegación de la persona usuaria en el sitio web, 
                normalmente de forma anónima, aunque en ocasiones también permiten identificar de manera única e inequívoca 
                a la persona usuaria con el fin de obtener informes sobre los intereses de la persona usuaria en los servicios 
                que ofrece el sitio web.
            </li>
            <li>
                <strong>Marketing:</strong> Son las cookies que se utilizan para publicidad.
            </li>            
        </ul>

        <p>Para más información puedes consultar la guía sobre el uso de las cookies elaborada por la Agencia Española 
                de Protección de Datos en <a href="https://www.aepd.es/sites/default/files/2020-07/guia-cookies.pdf" target="_blank">
                https://www.aepd.es/sites/default/files/2020-07/guia-cookies.pdf</a></p>
        
        <h3><strong>Este sitio web utiliza las siguientes cookies:</strong></h3>
        <p>A continuación, se muestra una tabla con las cookies utilizadas en este sitio web, incorporando un criterio de "nivel 
            de intrusividad" apoyado en una escala del 1 al 2, en la que: </p>
        
        <p><strong>Nivel 1:</strong> se corresponde con cookies estrictamente necesarias para la prestación del propio servicio 
            solicitado por la persona usuaria. </p>

        <p><strong>Nivel 2:</strong> se corresponde con cookies de rendimiento (anónimas) necesarias para el mantenimiento de 
            contenidos y navegación, de las que solo es necesario informar sobre su existencia.</p>
        
        <h3><strong>Listado de Cookies Utilizadas</strong></h3>
        <ul>
            <li>
                <strong>Cookie: </strong>PHPSESSID, phpMyAdmin, pma_lang, pmaAuth-1, pmaUser-1 <br>
                <strong>Duración:</strong> Sesión <br>
                <strong>Tipo: </strong>Imprescindibles <br>
                <strong>Propósito:</strong> Mantener la coherencia de la navegación y optimizar el rendimiento del sitio web <br>
                <strong>intrusividad:</strong> 1
            </li>
            <li>
                <strong>Cookie: </strong>cookies_consent, analitycs, marketing, necessary <br>
                <strong>Duración:</strong> 1 año <br>
                <strong>Tipo: </strong>Imprescindibles <br>
                <strong>Propósito:</strong> Guardar la configuración de cookies seleccionada por el usuario <br>
                <strong>intrusividad:</strong> 2
            </li>
        </ul>

        <h3><strong>Deshabilitar el uso de cookies</strong></h3>
        <p>La persona usuaria en el momento de iniciar la navegación de la web, configuró la preferencia de cookies. </p>
        <p>Si en un momento posterior desea cambiarla, puede hacerlo a través de la configuración del navegador.</p>
        <p>Si la persona usuaria así lo desea, es posible dejar de aceptar las cookies del navegador, o dejar de aceptar las 
            cookies de un servicio en particular. </p>
        <p>Todos los navegadores modernos permiten cambiar la configuración de cookies. Estos ajustes normalmente se encuentran 
            en las Opciones o Preferencias del menú del navegador. </p>
        <p>La persona usuaria podrá, en cualquier momento, deshabilitar el uso de cookies en este sitio web utilizando su 
            navegador. Hay que tener en cuenta que la configuración de cada navegador es diferente. Puede consultar el botón 
            de ayuda o bien visitar los siguientes enlaces de cada navegador donde le indicará como hacerlo: 
            <strong>
                <a href="http://windows.microsoft.com/es-xl/internet-explorer/delete-manage-cookies#ie=ie-10" target="_blank">Internet Explorer,</a>
                <a href="https://support.mozilla.org/es/kb/Borrar%20cookies" target="_blank">Mozilla Firefox,</a>
                <a href="https://support.google.com/chrome/answer/95647?hl=es" target="_blank">Chrome,</a>
                <a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank">Safari.</a>                
            </strong>
        </p>

        <h3><strong>¿Qué ocurre al deshabilitar las cookies?</strong></h3>
        <p>Algunas funcionalidades y servicios pueden quedar deshabilitados, tener un comportamiento diferente al esperado 
            o incluso que se degrade notablemente la experiencia de navegación de la persona usuaria. </p>

        <h3><strong>Actualización de la Política de cookies</strong></h3>
        <p>El administrador del sitio web puede modificar esta política de cookies en función de exigencias legislativas, 
            reglamentarias, o con la finalidad de adaptar dicha política a las instrucciones dictadas por la Agencia 
            Española de Protección de Datos, por ello se aconseja a la persona usuaria que la visite periódicamente.</p>
        <p>Cuando se produzcan cambios significativos en esta política de cookies, se comunicará a través de la web.</p>

        <h3><strong>Política de privacidad</strong></h3>
        <p>Esta Política de Cookies se complementa con la Política de Privacidad, a la que podrá acceder para conocer la 
            información necesaria adicional sobre protección de datos personales. </p>

        <p>Al utilizar este sitio web, usted acepta nuestra Política de Cookies.</p>
        <div class="cookies_policy_buttons sticky-bottom">
            <button id="accept_cookies_policy"><?php echo ucfirst($this->language['accept']); ?></button>       
            <button id="configure_cookies_policy"><?php echo ucfirst($this->language['configure']); ?></button>
        </div>      
    </div>     
</section>