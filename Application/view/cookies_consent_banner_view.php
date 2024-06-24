<section id="cookies_consent_banner" class="col-12 cookies_consent_banner">
    <p>
        <?php echo ucfirst($this->language['cookies_consent']); ?> <a href="/cookies"><?php echo ucfirst($this->language['cookies policy']); ?></a> 
        or visit <a href="/cookies">here</a>.
    </p>
    <div class="cookies_consent_buttons">
        <button id="accept_cookies"><?php echo ucfirst($this->language['accept']); ?></button>
        <button id="reject_cookies"><?php echo ucfirst($this->language['reject']); ?></button>
        <button id="configure_cookies"><?php echo ucfirst($this->language['configure']); ?></button>
    </div> 
</section>

<section id="cookies_config_modal" class="cookies_config_modal">
    <div class="cookies_config_content">
        <h3><?php echo ucfirst($this->language['cookies_config']); ?></h3>
        <div class="row">
            <label class="col" for="necessary_cookies">
                <input type="checkbox" id="necessary_cookies" name="necessary_cookies" value="necessary_cookies">            
                <?php echo ucfirst($this->language['necessary_cookies']); ?>
            </label>
            <label class="col" for="analytics_cookies">
                <input type="checkbox" id="analytics_cookies" name="analytics_cookies" value="analytics_cookies">            
                <?php echo ucfirst($this->language['analitics_cookies']); ?>
            </label>
            <label class="col" for="marketing_cookies">
                <input type="checkbox" id="marketing_cookies" name="marketing_cookies" value="marketing_cookies">            
                <?php echo ucfirst($this->language['marketing_cookies']); ?>
            </label>
        </div>        
        <div class="cookies_config_buttons">
            <button id="save_config"><?php echo ucfirst($this->language['save']); ?></button>
            <button id="cancel_config"><?php echo ucfirst($this->language['cancel']); ?></button>
        </div>
    </div>
</section>