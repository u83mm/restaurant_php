import { toggleChat } from "./modules/chat_bot_fns.js";

"use_strict"

document.addEventListener('DOMContentLoaded', () => {
    const btnChatWidget = document.getElementById("chat-widget-button");
    const chatWindow = document.getElementById("chat-window");
    const input = document.getElementById('userMsg');
    const inputArea = document.getElementById('input-area');
    const chatMessages = document.getElementById('chat-messages');

    if(btnChatWidget) {
        btnChatWidget.addEventListener("click", () => {
            if(chatWindow) {
                toggleChat();
                if(input) input.focus();
            }
        });
    }

    if(chatWindow) {
        chatWindow.firstElementChild.querySelector('button').addEventListener('click', toggleChat);
    }
    
    if(input && inputArea) {
        inputArea.querySelector('button').addEventListener('click', sendMessage);        
        input.addEventListener('keypress', (e) => {
            if(e.key === "Enter") sendMessage();
        });
    }

    async function sendMessage() {
        if(input) {
            const text = input.value.trim();
            if(!text) return;

            // 1. Add user message to the screen
            appendMessage(text, 'user');
            input.value = "";

            // 2. Test current URL
            if(window.location.href === "http://localhost/index/showCaptcha") {
                appendMessage("Debes introducir el Captcha primero antes de poder continuar. ", 'bot');
                return;
            }            

            // 3. Send to PHP using AJAX
            try {
                const response = await fetch("/chat/chat/index", {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `msg=${encodeURIComponent(text)}`
            });                              

                const data = await response.json();

                // 3. Add bot response
                appendMessage(data.response, 'bot');

            } catch (error) {
                appendMessage("Error conectando con el servidor", "bot");
            }
        }
    }

    function appendMessage(text, side) {
        const div = document.createElement('div');
        div.className = `message ${side}`;
        div.textContent = text;
        chatMessages.appendChild(div);
        chatMessages.scrollTo({
            top: chatMessages.scrollHeight,
            behavior: 'smooth'
        });

    }
});