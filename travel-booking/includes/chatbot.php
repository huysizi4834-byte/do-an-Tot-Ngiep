<!-- Chatbot Widget -->
<style>
#chatbot-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: 'Inter', sans-serif;
}

#chat-button {
    width: 60px;
    height: 60px;
    background-color: #0d6efd;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: transform 0.3s ease;
}

#chat-button:hover {
    transform: scale(1.1);
}

#chat-window {
    display: none;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.2);
    position: absolute;
    bottom: 80px;
    right: 0;
    flex-direction: column;
    overflow: hidden;
}

.chat-header {
    background: #0d6efd;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
}

.chat-header .close-btn {
    cursor: pointer;
    font-size: 20px;
}

.chat-body {
    flex-grow: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.chat-msg {
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.4;
    word-wrap: break-word;
}

.msg-bot {
    background: #e9ecef;
    color: #333;
    align-self: flex-start;
    border-bottom-left-radius: 5px;
}

.msg-user {
    background: #0d6efd;
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 5px;
}

.chat-input-area {
    padding: 15px;
    background: white;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
}

.chat-input-area input {
    flex-grow: 1;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 8px 15px;
    outline: none;
}

.chat-input-area button {
    background: #0d6efd;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
</style>

<div id="chatbot-container">
    <div id="chat-window">
        <div class="chat-header">
            <div><i class="fa-solid fa-robot me-2"></i> AI Hỗ Trợ THEGIOI</div>
            <div class="close-btn" id="chat-close"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="chat-body" id="chat-body">
            <div class="chat-msg msg-bot">Xin chào! Tôi là trợ lý AI của THEGIOI Travel. Tôi có thể giúp gì cho bạn hôm nay? (Ví dụ: Đặt tour thế nào?, Chính sách hoàn tiền)</div>
        </div>
        <div class="chat-input-area">
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." autocomplete="off">
            <button id="chat-send"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
    </div>
    <div id="chat-button">
        <i class="fa-solid fa-comment-dots"></i>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatBtn = document.getElementById('chat-button');
    const chatWindow = document.getElementById('chat-window');
    const chatClose = document.getElementById('chat-close');
    const chatInput = document.getElementById('chat-input');
    const chatSend = document.getElementById('chat-send');
    const chatBody = document.getElementById('chat-body');

    // Toggle window
    chatBtn.addEventListener('click', () => {
        chatWindow.style.display = chatWindow.style.display === 'flex' ? 'none' : 'flex';
        if(chatWindow.style.display === 'flex') chatInput.focus();
    });

    chatClose.addEventListener('click', () => {
        chatWindow.style.display = 'none';
    });

    // Send message
    function sendMessage() {
        const text = chatInput.value.trim();
        if(!text) return;

        // Append user msg
        appendMessage(text, 'user');
        chatInput.value = '';

        // Typing indicator
        const typingId = 'typing-' + Date.now();
        appendMessage('<i class="fa-solid fa-ellipsis"></i>', 'bot', typingId);

        // API Call
        const formData = new URLSearchParams();
        formData.append('message', text);

        // Adjust path in case included in subdirectories like admin
        const isRoot = window.location.pathname.indexOf('/admin/') === -1;
        const apiPath = isRoot ? 'chat_api.php' : '../chat_api.php';

        fetch(apiPath, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById(typingId).remove();
            appendMessage(data.reply, 'bot');
        })
        .catch(err => {
            document.getElementById(typingId).remove();
            appendMessage("Xin lỗi, hệ thống đang bận. Vui lòng thử lại sau.", 'bot');
        });
    }

    function appendMessage(text, sender, id = null) {
        const div = document.createElement('div');
        div.className = 'chat-msg msg-' + sender;
        if(id) div.id = id;
        div.innerHTML = text;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    chatSend.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if(e.key === 'Enter') sendMessage();
    });
});
</script>
