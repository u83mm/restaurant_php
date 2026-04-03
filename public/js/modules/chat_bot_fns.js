"use_strict"

const chatWindow = document.getElementById("chat-window");

function toggleChat() {
    chatWindow.classList.toggle('hidden');    
}

export { toggleChat };