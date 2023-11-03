function sendMessage() {
    var userInput = document.getElementById("user-input").value;

    // Clear the input field
    document.getElementById("user-input").value = "";

    // Display user's message in the chat log
    appendMessage("You", userInput);

    // Send user's message to the chatbot and get a response
    fetch("chatbot.php?user_input=" + userInput)
        .then(response => response.text())
        .then(data => {
            // Display the chatbot's response in the chat log
            appendMessage("Chatbot", data);
        });
}

function appendMessage(sender, message) {
    var chatLog = document.getElementById("chat-log");
    var messageElement = document.createElement("div");
    messageElement.innerText = sender + ": " + message;
    chatLog.appendChild(messageElement);
}
