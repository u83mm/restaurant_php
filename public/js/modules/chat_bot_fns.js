"use_strict"

const chatWindow = document.getElementById("chat-window");
const chatMessages = document.getElementById('chat-messages');

function toggleChat() {
    chatWindow.classList.toggle('hidden');    
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

export { toggleChat, appendMessage };